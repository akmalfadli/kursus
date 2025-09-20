<?php
// app/Filament/Resources/ContentBlockResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentBlockResource\Pages;
use App\Models\ContentBlock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContentBlockResource extends Resource
{
    protected static ?string $model = ContentBlock::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Konten Website';
    protected static ?string $pluralModelLabel = 'Konten Website';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'text' => 'Teks',
                        'textarea' => 'Teks Panjang',
                        'json' => 'JSON',
                        'image' => 'Gambar',
                    ])
                    ->required()
                    ->default('text')
                    ->reactive(),
                Forms\Components\Textarea::make('content')
                    ->label('Konten')
                    ->required()
                    ->rows(5)
                    ->visible(fn ($get) => in_array($get('type'), ['text', 'textarea', 'json'])),
                Forms\Components\FileUpload::make('content')
                    ->label('Upload Gambar')
                    ->image()
                    ->directory('content-images')
                    ->visible(fn ($get) => $get('type') === 'image'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'text',
                        'success' => 'textarea',
                        'warning' => 'json',
                        'danger' => 'image',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContentBlocks::route('/'),
            'create' => Pages\CreateContentBlock::route('/create'),
            'edit' => Pages\EditContentBlock::route('/{record}/edit'),
        ];
    }
}
