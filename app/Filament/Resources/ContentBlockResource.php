<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentBlockResource\Pages;
use App\Models\ContentBlock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ContentBlockResource extends Resource
{
    protected static ?string $model = ContentBlock::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Konten Website';
    protected static ?string $pluralModelLabel = 'Konten Website';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Konten')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Gunakan format snake_case, contoh: hero_title'),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Nama yang mudah diingat untuk konten ini'),

                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->options([
                                'text' => 'Teks Pendek',
                                'textarea' => 'Teks Panjang',
                                'json' => 'Data JSON',
                                'image' => 'Gambar',
                                'url' => 'URL/Link',
                                'number' => 'Angka',
                                'boolean' => 'Ya/Tidak',
                            ])
                            ->required()
                            ->default('text')
                            ->reactive()
                            ->afterStateUpdated(fn (Set $set) => $set('content', null)),
                    ])->columns(2),

                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\Hidden::make('content'),

                        Forms\Components\TextInput::make('content_text')
                            ->label('Konten Teks Pendek')
                            ->maxLength(500)
                            ->visible(fn (Get $get) => $get('type') === 'text')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'text') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state))
                            ->required(fn (Get $get) => $get('type') === 'text'),

                        Forms\Components\RichEditor::make('content_rich')
                            ->label('Konten Teks Panjang')
                            ->visible(fn (Get $get) => $get('type') === 'textarea')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\RichEditor $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'textarea') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state))
                            ->required(fn (Get $get) => $get('type') === 'textarea'),

                        Forms\Components\Textarea::make('content_json')
                            ->label('Data JSON')
                            ->rows(10)
                            ->helperText('Masukkan data dalam format JSON yang valid')
                            ->visible(fn (Get $get) => $get('type') === 'json')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\Textarea $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'json') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state))
                            ->required(fn (Get $get) => $get('type') === 'json'),

                        Forms\Components\FileUpload::make('content_image')
                            ->label('Upload Gambar')
                            ->image()
                            ->directory('content-images')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->visible(fn (Get $get) => $get('type') === 'image')
                            ->dehydrated(false)
                            ->reactive()
                            ->getUploadedFileNameForStorageUsing(fn (TemporaryUploadedFile $file) => $file->hashName())
                            ->afterStateHydrated(function (Forms\Components\FileUpload $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'image') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                $set('content', is_array($state) ? ($state[0] ?? null) : $state);
                            })
                            ->required(fn (Get $get) => $get('type') === 'image'),

                        Forms\Components\TextInput::make('content_url')
                            ->label('URL')
                            ->url()
                            ->prefix('https://')
                            ->visible(fn (Get $get) => $get('type') === 'url')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'url') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state))
                            ->required(fn (Get $get) => $get('type') === 'url'),

                        Forms\Components\TextInput::make('content_number')
                            ->label('Angka')
                            ->numeric()
                            ->visible(fn (Get $get) => $get('type') === 'number')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'number') {
                                    $component->state($record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state))
                            ->required(fn (Get $get) => $get('type') === 'number'),

                        Forms\Components\Toggle::make('content_boolean')
                            ->label('Status')
                            ->visible(fn (Get $get) => $get('type') === 'boolean')
                            ->dehydrated(false)
                            ->reactive()
                            ->afterStateHydrated(function (Forms\Components\Toggle $component, ?ContentBlock $record) {
                                if ($record && $record->type === 'boolean') {
                                    $component->state((bool) $record->content);
                                }
                            })
                            ->afterStateUpdated(fn ($state, Set $set) => $set('content', $state ? '1' : '0'))
                            ->required(fn (Get $get) => $get('type') === 'boolean'),
                    ])->columnSpanFull(),

                Forms\Components\Section::make('Pengaturan Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->helperText('Jelaskan kegunaan konten ini'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan jika konten tidak digunakan'),
                    ])->columns(2)->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->description(fn (?ContentBlock $record): ?string => $record?->description),

                BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'text',
                        'success' => 'textarea',
                        'warning' => 'json',
                        'danger' => 'image',
                        'info' => 'url',
                        'gray' => 'number',
                        'purple' => 'boolean',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'text' => 'Teks Pendek',
                        'textarea' => 'Teks Panjang',
                        'json' => 'Data JSON',
                        'image' => 'Gambar',
                        'url' => 'URL/Link',
                        'number' => 'Angka',
                        'boolean' => 'Ya/Tidak',
                        default => $state
                    }),

                ImageColumn::make('content')
                    ->label('Preview')
                    ->circular()
                    ->size(40)
                    ->visible(fn (?ContentBlock $record) => $record && $record->type === 'image'),

                TextColumn::make('content')
                    ->label('Konten')
                    ->limit(50)
                    ->tooltip(function (?ContentBlock $record): string {
                        if (!$record) return '';
                        if ($record->type === 'json') {
                            return 'Data JSON';
                        }
                        return $record->content ?? '';
                    })
                    ->visible(fn (?ContentBlock $record) => !$record || $record->type !== 'image'),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'text' => 'Teks Pendek',
                        'textarea' => 'Teks Panjang',
                        'json' => 'Data JSON',
                        'image' => 'Gambar',
                        'url' => 'URL/Link',
                        'number' => 'Angka',
                        'boolean' => 'Ya/Tidak',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                Tables\Actions\ReplicateAction::make()
                    ->label('Duplikasi'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (array $records) {
                            ContentBlock::whereIn('id', $records)->update(['is_active' => true]);
                        }),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (array $records) {
                            ContentBlock::whereIn('id', $records)->update(['is_active' => false]);
                        }),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContentBlocks::route('/'),
            'create' => Pages\CreateContentBlock::route('/create'),
            'view' => Pages\ViewContentBlock::route('/{record}'),
            'edit' => Pages\EditContentBlock::route('/{record}/edit'),
        ];
    }
}
