<?php
// app/Filament/Widgets/DashboardStatsWidget.php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('amount');
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingTransactions = Transaction::where('payment_status', 'pending')->count();
        $monthlyRevenue = Transaction::where('payment_status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        // Calculate growth percentages
        $lastMonthRevenue = Transaction::where('payment_status', 'paid')
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->whereYear('paid_at', now()->subMonth()->year)
            ->sum('amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan keseluruhan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart($this->getRevenueChart()),

            Stat::make('Revenue Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description($revenueGrowth >= 0 ? "+{$revenueGrowth}% dari bulan lalu" : "{$revenueGrowth}% dari bulan lalu")
                ->descriptionIcon($revenueGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('Total Customer', number_format($totalCustomers))
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Pending Payments', number_format($pendingTransactions))
                ->description('Menunggu pembayaran')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingTransactions > 5 ? 'warning' : 'success'),
        ];
    }

    private function getRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Transaction::where('payment_status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('amount');
            $data[] = $revenue / 1000; // In thousands
        }
        return $data;
    }
}
