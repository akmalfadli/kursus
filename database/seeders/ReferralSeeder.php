<?php

namespace Database\Seeders;

use App\Models\Referral;
use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    public function run(): void
    {
        $referrals = [
            [
                'code' => 'KANDAR2026',
                'label' => 'Referral Kandar 2026',
                'referrer_name' => 'Kandar',
                'referrer_contact' => '+6281234567890',
                'discount_percentage' => 10,
                'commission_percentage' => 10,
                'max_usage' => null,
                'notes' => 'Diskon 10% untuk jaringan Kandar',
            ],
            [
                'code' => 'ARIS2026',
                'label' => 'Referral Aris 2026',
                'referrer_name' => 'Aris',
                'referrer_contact' => '+6289876543210',
                'discount_percentage' => 20,
                'commission_percentage' => 20,
                'max_usage' => null,
                'notes' => 'Diskon 20% untuk jaringan Aris',
            ],
        ];

        foreach ($referrals as $referral) {
            Referral::updateOrCreate(
                ['code' => $referral['code']],
                $referral
            );
        }
    }
}
