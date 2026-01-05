<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PricingService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __construct(private readonly PricingService $pricingService)
    {
    }

    public function validateCode(Request $request)
    {
        $data = $request->validate([
            'referral_code' => 'required|string|max:50',
        ]);

        $pricing = $this->pricingService->calculatePricing($data['referral_code']);

        if (!$pricing['referral']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode referral tidak ditemukan atau tidak aktif.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'code' => $pricing['referral']->code,
                'discount_percentage' => $pricing['referral']->discount_percentage,
                'base_amount' => $pricing['base_amount'],
                'discount_amount' => $pricing['discount_amount'],
                'final_amount' => $pricing['final_amount'],
                'commission_amount' => $pricing['commission_amount'],
                'formatted' => [
                    'base' => 'Rp ' . number_format($pricing['base_amount'], 0, ',', '.'),
                    'discount' => 'Rp ' . number_format($pricing['discount_amount'], 0, ',', '.'),
                    'final' => 'Rp ' . number_format($pricing['final_amount'], 0, ',', '.'),
                ],
            ],
        ]);
    }
}
