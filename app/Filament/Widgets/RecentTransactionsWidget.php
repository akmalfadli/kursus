<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Filament\Resources\TransactionResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()
                    ->latest()
                    ->limit(10)
            )
            ->heading('Transaksi Terbaru')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_id')
                    ->label('Invoice ID')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('user_name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn (Transaction $record): string => $record->user_email),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR'),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'expired',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                        default => $state
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Transaction $record): string => TransactionResource::getUrl('view', ['record' => $record])),
            ])
            ->poll('30s');
    }
}
