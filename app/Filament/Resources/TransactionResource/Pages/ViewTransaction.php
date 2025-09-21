<?php
// app/Filament/Resources/TransactionResource/Pages/ViewTransaction.php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Infolists\Components\TextEntry::make('invoice_id')
                            ->label('Invoice ID')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('payment_status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'failed' => 'danger',
                                'expired' => 'gray',
                            }),
                    ])->columns(3),

                Infolists\Components\Section::make('Informasi Customer')
                    ->schema([
                        Infolists\Components\TextEntry::make('user_name')
                            ->label('Nama'),
                        Infolists\Components\TextEntry::make('user_email')
                            ->label('Email')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('user_phone')
                            ->label('Telepon')
                            ->copyable(),
                    ])->columns(3),

                Infolists\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('amount')
                            ->label('Jumlah')
                            ->money('IDR'),
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Metode Pembayaran'),
                        Infolists\Components\TextEntry::make('payment_reference')
                            ->label('Referensi'),
                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('Tanggal Bayar')
                            ->dateTime(),
                    ])->columns(2),

                Infolists\Components\Section::make('Data Teknis')
                    ->schema([
                        Infolists\Components\TextEntry::make('duitku_reference')
                            ->label('Referensi Duitku'),
                        Infolists\Components\TextEntry::make('duitku_response')
                            ->label('Response Duitku')
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state)
                            ->limit(200),
                    ])->collapsible(),
            ]);
    }
}
