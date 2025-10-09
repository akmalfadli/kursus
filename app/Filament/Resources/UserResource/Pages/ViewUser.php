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
                            ->copyable()
                            ->placeholder('Tidak ada'),
                        Infolists\Components\TextEntry::make('class')
                            ->label('Kelas')
                            ->badge()
                            ->color('info')
                            ->placeholder('Belum ditentukan'),
                        Infolists\Components\TextEntry::make('role')
                            ->label('Role')
                            ->badge(),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean(),
                        Infolists\Components\TextEntry::make('email_verified_at')
                            ->label('Email Diverifikasi')
                            ->dateTime()
                            ->placeholder('Belum diverifikasi'),
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

                Infolists\Components\Section::make('Riwayat API Integration')
                    ->schema([
                        Infolists\Components\View::make('filament.components.api-integration-history')
                            ->viewData([
                                'notes' => fn ($record) => $record->notes
                            ])
                    ])
                    ->visible(fn ($record) => !empty($record->notes) && str_contains($record->notes, 'API Integration'))
                    ->collapsible(),

                Infolists\Components\Section::make('Catatan')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('Tidak ada catatan')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => !empty($record->notes))
                    ->collapsible(),
            ]);
    }
}
