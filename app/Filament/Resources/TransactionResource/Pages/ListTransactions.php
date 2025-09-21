<?php
// app/Filament/Resources/TransactionResource/Pages/ListTransactions.php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Resources\TransactionResource\Widgets;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Transaksi')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\TransactionStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            Widgets\TransactionChartWidget::class,
        ];
    }
}
