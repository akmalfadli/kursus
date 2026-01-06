<?php

namespace App\Filament\Resources\ReferralResource\Pages;

use App\Filament\Resources\ReferralResource;
use App\Models\Referral;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class ListReferrals extends ListRecords
{
    protected static string $resource = ReferralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Manual'),
            Actions\Action::make('quick_referrer')
                ->label('Tambah Referrer')
                ->icon('heroicon-o-user-plus')
                ->color('primary')
                ->modalHeading('Tambah Referrer Baru')
                ->form([
                    Forms\Components\TextInput::make('referrer_name')
                        ->label('Nama Referrer')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('referrer_contact')
                        ->label('Kontak (WhatsApp/Email)')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('code')
                        ->label('Kode Referral')
                        ->required()
                        ->maxLength(50)
                        ->helperText('Contoh: KOMUNITAS2026'),
                    Forms\Components\TextInput::make('discount_percentage')
                        ->label('Diskon (%)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(90)
                        ->default(10)
                        ->required(),
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $code = Str::upper(Str::slug($data['code'], ''));

                    if (Referral::where('code', $code)->exists()) {
                        Notification::make()
                            ->title('Kode referral sudah digunakan')
                            ->danger()
                            ->send();

                        return;
                    }

                    Referral::create([
                        'code' => $code,
                        'label' => $data['referrer_name'] . ' Referral',
                        'referrer_name' => $data['referrer_name'],
                        'referrer_contact' => $data['referrer_contact'],
                        'discount_percentage' => $data['discount_percentage'],
                        'commission_percentage' => $data['discount_percentage'],
                        'notes' => $data['notes'] ?? null,
                        'is_active' => true,
                    ]);

                    Notification::make()
                        ->title('Referrer baru berhasil ditambahkan')
                        ->success()
                        ->send();
                }),
        ];
    }
}
