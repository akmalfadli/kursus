<?php

namespace App\Services;

use App\Models\ContentBlock;
use App\Models\Referral;
use App\Models\Transaction;

class PricingService
{
    public function getBasePrice(): int
    {
        $price = ContentBlock::getNumberValue('course_price', config('course.price', 299000));
        $price = (int) $price;

        return $price > 0 ? $price : (int) config('course.price', 299000);
    }

    public function resolveReferral(?string $code): ?Referral
    {
        if (!$code) {
            return null;
        }

        $referral = Referral::where('code', strtoupper($code))->first();

        if (!$referral || !$referral->isActive()) {
            return null;
        }

        return $referral;
    }

    public function calculatePricing(?string $code = null): array
    {
        $baseAmount = $this->getBasePrice();
        $referral = $this->resolveReferral($code);

        $discountAmount = $referral
            ? (int) round($baseAmount * ($referral->discount_percentage / 100))
            : 0;

        $finalAmount = max($baseAmount - $discountAmount, 0);
        $commissionAmount = $this->calculateCommission($referral, $finalAmount, $discountAmount);

        return [
            'base_amount' => $baseAmount,
            'final_amount' => $finalAmount,
            'discount_amount' => $discountAmount,
            'commission_amount' => $commissionAmount,
            'referral' => $referral,
        ];
    }

    public function recordReferralUsage(?Transaction $transaction): void
    {
        if (!$transaction || !$transaction->referral_id) {
            return;
        }

        if ($transaction->referral_usage_recorded_at) {
            return;
        }

        $referral = $transaction->referral;

        if (!$referral) {
            return;
        }

        $referral->increment('usage_count');

        $transaction->update([
            'referral_usage_recorded_at' => now(),
            'referral_commission_status' => $transaction->referral_commission_status ?? 'pending',
        ]);
    }

    private function calculateCommission(?Referral $referral, int $finalAmount, int $discountAmount): int
    {
        if (!$referral) {
            return 0;
        }

        if ($referral->commission_flat !== null) {
            return (int) $referral->commission_flat;
        }

        if ($referral->commission_percentage !== null) {
            return (int) round($finalAmount * ($referral->commission_percentage / 100));
        }

        return $discountAmount;
    }
}
