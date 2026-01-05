<?php

namespace App\Filament\Resources\ReferralResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\Transaction;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';
    protected static ?string $title = 'Transaksi Referral';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_id')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_id')
                    ->label('Invoice')
                    ->copyable(),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Customer')
                    ->description(fn (Transaction $record) => $record->user_email),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Total Dibayar')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('referral_discount_amount')
                    ->label('Diskon Diberikan')
                    ->money('IDR'),
                Tables\Columns\BadgeColumn::make('referral_commission_status')
                    ->label('Status Komisi')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Belum Dibayar',
                        'paid' => 'Dibayar',
                        default => 'Tidak Ada',
                    }),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Tgl Pembayaran')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_commission_paid')
                    ->label('Tandai Komisi Dibayar')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => $record->referral_commission_status === 'pending')
                    ->action(function (Transaction $record) {
                        $record->update([
                            'referral_commission_status' => 'paid',
                            'referral_commission_paid_at' => now(),
                        ]);
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('referral_commission_status')
                    ->label('Status Komisi')
                    ->options([
                        'pending' => 'Belum Dibayar',
                        'paid' => 'Dibayar',
                    ]),
            ])
            ->headerActions([]);
    }
}
