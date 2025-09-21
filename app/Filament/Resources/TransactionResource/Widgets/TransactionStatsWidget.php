<?php
// app/Filament/Resources/TransactionResource/Widgets/TransactionStatsWidget.php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('amount');
        $totalTransactions = Transaction::count();
        $pendingTransactions = Transaction::where('payment_status', 'pending')->count();
        $todayRevenue = Transaction::where('payment_status', 'paid')
            ->whereDate('paid_at', today())
            ->sum('amount');

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan keseluruhan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Total Transaksi', number_format($totalTransactions))
                ->description('Semua transaksi')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),

            Stat::make('Menunggu Pembayaran', number_format($pendingTransactions))
                ->description('Transaksi pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Revenue Hari Ini', 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->description('Pendapatan hari ini')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),
        ];
    }
}
