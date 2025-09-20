<?php
// database/seeders/DemoTransactionSeeder.php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [
            [
                'invoice_id' => 'KPD-' . now()->format('Ymd') . '-DEMO001',
                'user_name' => 'Ahmad Rizki',
                'user_email' => 'customer1@example.com',
                'user_phone' => '+6281234567890',
                'amount' => 299000,
                'payment_status' => 'paid',
                'payment_method' => 'BCA Virtual Account',
                'payment_reference' => 'BCA12345678',
                'paid_at' => now()->subDays(2),
                'created_at' => now()->subDays(2),
            ],
            [
                'invoice_id' => 'KPD-' . now()->format('Ymd') . '-DEMO002',
                'user_name' => 'Siti Nurhaliza',
                'user_email' => 'customer2@example.com',
                'user_phone' => '+6281234567891',
                'amount' => 299000,
                'payment_status' => 'paid',
                'payment_method' => 'OVO',
                'payment_reference' => 'OVO98765432',
                'paid_at' => now()->subDay(),
                'created_at' => now()->subDay(),
            ],
            [
                'invoice_id' => 'KPD-' . now()->format('Ymd') . '-DEMO003',
                'user_name' => 'Budi Santoso',
                'user_email' => 'budi@example.com',
                'user_phone' => '+6281234567892',
                'amount' => 299000,
                'payment_status' => 'pending',
                'created_at' => now()->subHours(2),
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::updateOrCreate(
                ['invoice_id' => $transaction['invoice_id']],
                $transaction
            );
        }
    }
}
