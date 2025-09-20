<?php
// app/Filament/Pages/Settings.php

namespace App\Filament\Pages;

use App\Models\ContentBlock;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Situs';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // Site settings
            'hero_title' => ContentBlock::getValue('hero_title'),
            'hero_subtitle' => ContentBlock::getValue('hero_subtitle'),
            'course_price' => ContentBlock::getNumberValue('course_price'),
            'contact_email' => ContentBlock::getValue('contact_email'),
            'contact_phone' => ContentBlock::getValue('contact_phone'),
            'site_maintenance' => ContentBlock::getBooleanValue('site_maintenance'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        Tabs\Tab::make('Umum')
                            ->schema([
                                Section::make('Informasi Situs')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Judul Utama')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('hero_subtitle')
                                            ->label('Subjudul')
                                            ->required()
                                            ->rows(3),
                                        TextInput::make('course_price')
                                            ->label('Harga Kursus')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required(),
                                    ])->columns(1),
                            ]),

                        Tabs\Tab::make('Kontak')
                            ->schema([
                                Section::make('Informasi Kontak')
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Email Support')
                                            ->email()
                                            ->required(),
                                        TextInput::make('contact_phone')
                                            ->label('Nomor WhatsApp')
                                            ->tel()
                                            ->required(),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Sistem')
                            ->schema([
                                Section::make('Pengaturan Sistem')
                                    ->schema([
                                        Toggle::make('site_maintenance')
                                            ->label('Mode Maintenance')
                                            ->helperText('Aktifkan untuk menonaktifkan sementara akses ke situs'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        ContentBlock::setValue('hero_title', 'Hero Title', $data['hero_title'], 'text');
        ContentBlock::setValue('hero_subtitle', 'Hero Subtitle', $data['hero_subtitle'], 'textarea');
        ContentBlock::setValue('course_price', 'Harga Kursus', $data['course_price'], 'number');
        ContentBlock::setValue('contact_email', 'Email Support', $data['contact_email'], 'text');
        ContentBlock::setValue('contact_phone', 'Nomor WhatsApp', $data['contact_phone'], 'text');
        ContentBlock::setValue('site_maintenance', 'Mode Maintenance', $data['site_maintenance'], 'boolean');

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Simpan Pengaturan')
                ->action('save')
                ->color('primary'),
        ];
    }
}
