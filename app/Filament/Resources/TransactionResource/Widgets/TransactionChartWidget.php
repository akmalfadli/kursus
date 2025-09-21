<?php
// app/Filament/Resources/TransactionResource/Widgets/TransactionChartWidget.php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TransactionChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Revenue 7 Hari Terakhir';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m');

            $revenue = Transaction::where('payment_status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('amount');

            $data[] = $revenue / 1000; // Dalam ribuan
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (Ribu)',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#1d4ed8',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
