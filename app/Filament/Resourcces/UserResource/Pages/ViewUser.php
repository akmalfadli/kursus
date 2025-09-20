<?php
// app/Filament/Resources/UserResource/Pages/ViewUser.php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

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
                Infolists\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nama'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('phone')
                            ->label('Telepon')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('role')
                            ->label('Role')
                            ->badge(),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('email_verified_at')
                            ->label('Email Diverifikasi')
                            ->dateTime(),
                    ])->columns(3),

                Infolists\Components\Section::make('Statistik Transaksi')
                    ->schema([
                        Infolists\Components\TextEntry::make('transactions_count')
                            ->label('Total Transaksi')
                            ->getStateUsing(fn ($record) => $record->transactions()->count()),
                        Infolists\Components\TextEntry::make('total_spent')
                            ->label('Total Pembelian')
                            ->money('IDR')
                            ->getStateUsing(fn ($record) => $record->transactions()->where('payment_status', 'paid')->sum('amount')),
                        Infolists\Components\TextEntry::make('last_transaction')
                            ->label('Transaksi Terakhir')
                            ->getStateUsing(fn ($record) => $record->transactions()->latest()->first()?->created_at?->format('d/m/Y H:i') ?? 'Belum ada'),
                    ])->columns(3),

                Infolists\Components\Section::make('Catatan')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('Tidak ada catatan'),
                    ])
                    ->visible(fn ($record) => !empty($record->notes)),
            ]);
    }
}
