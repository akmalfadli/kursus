<?php
// app/Filament/Resources/TransactionResource/Pages/CreateTransaction.php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['invoice_id'] = 'MANUAL-' . now()->format('YmdHis') . '-' . Str::random(6);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
