<?php
// app/Filament/Resources/TransactionResource/Pages/ListTransactions.php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Transactions are created via payment flow, not manually
        ];
    }
}
