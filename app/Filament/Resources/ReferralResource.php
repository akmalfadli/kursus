<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferralResource\Pages;
use App\Filament\Resources\ReferralResource\RelationManagers\TransactionsRelationManager;
use App\Models\Referral;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Penjualan';
    protected static ?string $navigationLabel = 'Referral';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kode')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Referral')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->helperText('Contoh: KANDAR2026')
                            ->dehydrateStateUsing(fn (string $state) => Str::upper($state)),
                        Forms\Components\TextInput::make('label')
                            ->label('Nama Promo')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Diskon & Komisi')
                    ->schema([
                        Forms\Components\TextInput::make('discount_percentage')
                            ->label('Diskon (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->required(),
                        Forms\Components\TextInput::make('commission_percentage')
                            ->label('Komisi Referral (%)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->helperText('Kosongkan jika komisi mengikuti nilai diskon'),
                        Forms\Components\TextInput::make('commission_flat')
                            ->label('Komisi Flat')
                            ->numeric()
                            ->prefix('Rp')
                            ->helperText('Prioritas lebih tinggi dari persen komisi'),
                        Forms\Components\TextInput::make('max_usage')
                            ->label('Maks. Penggunaan')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Kosongkan jika tanpa batas'),
                    ])->columns(2),

                Forms\Components\Section::make('Periode & Narahubung')
                    ->schema([
                        Forms\Components\DateTimePicker::make('valid_from')
                            ->label('Mulai Berlaku'),
                        Forms\Components\DateTimePicker::make('valid_until')
                            ->label('Berakhir'),
                        Forms\Components\TextInput::make('referrer_name')
                            ->label('Nama Referrer'),
                        Forms\Components\TextInput::make('referrer_contact')
                            ->label('Kontak Referrer')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Internal')
                            ->rows(3),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Diskon')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Pemakaian')
                    ->sortable()
                    ->formatStateUsing(fn ($state, Referral $record) => $record->max_usage ? "$state / {$record->max_usage}" : $state),
                Tables\Columns\BadgeColumn::make('is_active')
                    ->label('Status')
                    ->color(fn (bool $state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state) => $state ? 'Aktif' : 'Nonaktif'),
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Berlaku Hingga')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('referrer_name')
                    ->label('Referrer')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
                Tables\Filters\Filter::make('valid_period')
                    ->label('Sedang Berlaku')
                    ->query(fn ($query) => $query
                        ->where(function ($sub) {
                            $now = now();
                            $sub->whereNull('valid_from')->orWhere('valid_from', '<=', $now);
                        })
                        ->where(function ($sub) {
                            $now = now();
                            $sub->whereNull('valid_until')->orWhere('valid_until', '>=', $now);
                        })),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_all_paid')
                    ->label('Tandai Komisi Dibayar')
                    ->icon('heroicon-o-currency-dollar')
                    ->requiresConfirmation()
                    ->visible(fn (Referral $record) => $record->transactions()
                        ->where('payment_status', 'paid')
                        ->where('referral_commission_status', 'pending')
                        ->exists())
                    ->action(function (Referral $record) {
                        $record->transactions()
                            ->where('referral_commission_status', 'pending')
                            ->update([
                                'referral_commission_status' => 'paid',
                                'referral_commission_paid_at' => now(),
                            ]);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }
}
