<?php
// app/Filament/Resources/UserResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna Terdaftar';
    protected static ?string $pluralModelLabel = 'Pengguna Terdaftar';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Manajemen User';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(8),

                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Admin',
                                'customer' => 'Customer',
                                'instructor' => 'Instruktur',
                            ])
                            ->default('customer')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Diverifikasi'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->description(fn (User $record): string => $record->email),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email disalin!')
                    ->icon('heroicon-o-envelope'),

                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable()
                    ->icon('heroicon-o-phone'),

                BadgeColumn::make('role')
                    ->label('Role')
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'customer',
                        'warning' => 'instructor',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                        'instructor' => 'Instruktur',
                        default => $state
                    }),

                BadgeColumn::make('email_verified_at')
                    ->label('Status Email')
                    ->formatStateUsing(fn ($state): string => $state ? 'Terverifikasi' : 'Belum Verifikasi')
                    ->colors([
                        'success' => fn ($state): bool => $state !== null,
                        'danger' => fn ($state): bool => $state === null,
                    ]),

                TextColumn::make('transactions_count')
                    ->label('Total Transaksi')
                    ->counts('transactions')
                    ->badge()
                    ->color('info'),

                TextColumn::make('total_spent')
                    ->label('Total Pembelian')
                    ->money('IDR')
                    ->getStateUsing(function (User $record) {
                        return $record->transactions()->where('payment_status', 'paid')->sum('amount');
                    }),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->since()
                    ->description(fn (User $record): string => $record->created_at->diffForHumans()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'customer' => 'Customer',
                        'instructor' => 'Instruktur',
                    ]),

                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Terverifikasi')
                    ->nullable(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),

                Tables\Filters\Filter::make('has_transactions')
                    ->label('Punya Transaksi')
                    ->query(fn (Builder $query): Builder => $query->whereHas('transactions')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Action::make('send_welcome_email')
                    ->label('Kirim Email Selamat Datang')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Email Selamat Datang')
                    ->modalDescription('Email akan dikirim dengan password sementara baru. Apakah Anda yakin?')
                    ->action(function (User $record) {
                        try {
                            // Generate temporary password
                            $tempPassword = Str::random(12);

                            // Update user password
                            $record->update([
                                'password' => Hash::make($tempPassword)
                            ]);

                            // Send welcome email
                            Mail::to($record->email)->send(new WelcomeEmail($record, $tempPassword));

                            Notification::make()
                                ->title('Email selamat datang berhasil dikirim!')
                                ->body('Password baru telah dikirim ke ' . $record->email)
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Log::error('Failed to send welcome email', [
                                'error' => $e->getMessage(),
                                'user_id' => $record->id
                            ]);

                            Notification::make()
                                ->title('Gagal mengirim email!')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Action::make('reset_password')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Reset Password')
                    ->modalDescription('Password akan direset dan dikirim ke email pengguna.')
                    ->action(function (User $record) {
                        $newPassword = Str::random(10);
                        $record->update(['password' => Hash::make($newPassword)]);

                        // TODO: Send new password via email

                        Notification::make()
                            ->title('Password berhasil direset!')
                            ->body('Password baru telah dikirim ke email pengguna.')
                            ->success()
                            ->send();
                    }),

                Action::make('toggle_status')
                    ->label(fn (User $record) => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn (User $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (User $record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->update(['is_active' => !$record->is_active]);

                        Notification::make()
                            ->title('Status berhasil diubah!')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('verify_email')
                        ->label('Verifikasi Email')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->action(function (array $records) {
                            User::whereIn('id', $records)->update([
                                'email_verified_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Email berhasil diverifikasi!')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (array $records) {
                            User::whereIn('id', $records)->update(['is_active' => false]);

                            Notification::make()
                                ->title('Pengguna berhasil dinonaktifkan!')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
