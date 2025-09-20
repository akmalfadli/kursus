<?php
// app/Filament/Pages/Dashboard.php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardStatsWidget::class,
            \App\Filament\Widgets\RecentTransactionsWidget::class,
            \App\Filament\Widgets\RevenueChartWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 4,
        ];
    }
}
