<?php
// app/Filament/Resources/TransactionResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\Widgets;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';
    protected static ?string $modelLabel = 'Transaksi';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Penjualan';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('payment_status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('payment_status', 'pending')->count() > 5 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('invoice_id')
                            ->label('Invoice ID')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('user_name')
                            ->label('Nama Customer')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('user_email')
                            ->label('Email Customer')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('user_phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(20),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Menunggu',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'expired' => 'Kadaluarsa',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('payment_reference')
                            ->label('Referensi Pembayaran')
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Tanggal Bayar'),
                    ])->columns(2),

                Forms\Components\Section::make('Data Teknis')
                    ->schema([
                        Forms\Components\TextInput::make('duitku_reference')
                            ->label('Referensi Duitku')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Textarea::make('duitku_response')
                            ->label('Response Duitku')
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state),
                    ])->columns(1)->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_id')
                    ->label('Invoice ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Invoice ID disalin!')
                    ->weight('medium'),

                TextColumn::make('user_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Transaction $record): string => $record->user_email),

                TextColumn::make('user_phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('IDR')
                            ->label('Total'),
                    ]),

                BadgeColumn::make('payment_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'expired',
                    ])
                    ->icons([
                        'pending' => 'heroicon-o-clock',
                        'paid' => 'heroicon-o-check-circle',
                        'failed' => 'heroicon-o-x-circle',
                        'expired' => 'heroicon-o-exclamation-triangle',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                        default => $state
                    }),

                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn (Transaction $record): string => $record->created_at->diffForHumans()),

                TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Belum dibayar'),
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kadaluarsa',
                    ])
                    ->multiple(),

                Filter::make('created_at')
                    ->label('Tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                Filter::make('amount_range')
                    ->label('Rentang Jumlah')
                    ->form([
                        Forms\Components\TextInput::make('amount_from')
                            ->label('Dari')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('amount_to')
                            ->label('Sampai')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn (Builder $query, $amount): Builder => $query->where('amount', '>=', $amount),
                            )
                            ->when(
                                $data['amount_to'],
                                fn (Builder $query, $amount): Builder => $query->where('amount', '<=', $amount),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Action::make('send_access')
                    ->label('Kirim Akses')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Akses Kursus')
                    ->modalDescription('Apakah Anda yakin ingin mengirim email akses kursus ke customer?')
                    ->action(function (Transaction $record) {  // Changed from User to Transaction
                        try {
                            // Find or create user based on transaction email
                            $user = User::firstOrCreate(
                                ['email' => $record->user_email],
                                [
                                    'name' => $record->user_name,
                                    'phone' => $record->user_phone,
                                ]
                            );

                            // Generate temporary password
                            $tempPassword = Str::random(12);

                            // Update user password
                            $user->update([
                                'password' => Hash::make($tempPassword)
                            ]);

                            // Send welcome email
                            Mail::to($user->email)->send(new WelcomeEmail($user, $tempPassword));

                            Notification::make()
                                ->title('Email selamat datang berhasil dikirim!')
                                ->body('Password baru telah dikirim ke ' . $user->email)
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Log::error('Failed to send welcome email', [
                                'error' => $e->getMessage(),
                                'transaction_id' => $record->id  // Changed from user_id
                            ]);

                            Notification::make()
                                ->title('Gagal mengirim email!')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Transaction $record) => $record->payment_status === 'paid'),

                Action::make('refund')
                    ->label('Refund')
                    ->icon('heroicon-o-arrow-left')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Proses Refund')
                    ->modalDescription('Apakah Anda yakin ingin memproses refund untuk transaksi ini?')
                    ->action(function (Transaction $record) {
                        $record->update(['payment_status' => 'refunded']);

                        Notification::make()
                            ->title('Refund berhasil diproses!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Transaction $record) => $record->payment_status === 'paid'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('Tandai Lunas')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (array $records) {
                            Transaction::whereIn('id', $records)->update([
                                'payment_status' => 'paid',
                                'paid_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Transaksi berhasil ditandai lunas!')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Excel')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (array $records) {
                            // TODO: Implement Excel export
                            Notification::make()
                                ->title('Export sedang diproses...')
                                ->info()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession()
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh every 30 seconds
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\TransactionStatsWidget::class,
            Widgets\TransactionChartWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
