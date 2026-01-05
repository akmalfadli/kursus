<?php
// app/Filament/Resources/ContentBlockResource/Pages/ViewContentBlock.php

namespace App\Filament\Resources\ContentBlockResource\Pages;

use App\Filament\Resources\ContentBlockResource;
use App\Models\ContentBlock;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewContentBlock extends ViewRecord
{
    protected static string $resource = ContentBlockResource::class;

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
                Infolists\Components\Section::make('Informasi Konten')
                    ->schema([
                        Infolists\Components\TextEntry::make('key')
                            ->label('Key')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('title')
                            ->label('Judul'),
                        Infolists\Components\TextEntry::make('type')
                            ->label('Tipe')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'text' => 'Teks Pendek',
                                'textarea' => 'Teks Panjang',
                                'json' => 'Data JSON',
                                'image' => 'Gambar',
                                'url' => 'URL/Link',
                                'number' => 'Angka',
                                'boolean' => 'Ya/Tidak',
                                default => $state,
                            }),
                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-bolt')
                            ->falseIcon('heroicon-o-no-symbol'),
                    ])->columns(4),

                Infolists\Components\Section::make('Konten')
                    ->schema([
                        Infolists\Components\TextEntry::make('content')
                            ->label('Konten')
                            ->visible(fn (ContentBlock $record) => in_array($record->type, ['text', 'textarea', 'url', 'number']))
                            ->columnSpanFull()
                            ->copyable(),

                        Infolists\Components\TextEntry::make('content_json')
                            ->label('Data JSON')
                            ->state(function (ContentBlock $record) {
                                $decoded = json_decode($record->content, true);
                                return $decoded === null
                                    ? $record->content
                                    : json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            })
                            ->visible(fn (ContentBlock $record) => $record->type === 'json')
                            ->columnSpanFull()
                            ->copyable()
                            ->hint('Klik untuk menyalin seluruh data JSON'),

                        Infolists\Components\ImageEntry::make('content')
                            ->label('Gambar')
                            ->visible(fn (ContentBlock $record) => $record->type === 'image')
                            ->columnSpanFull()
                            ->height('20rem'),

                        Infolists\Components\IconEntry::make('content')
                            ->label('Nilai Boolean')
                            ->boolean()
                            ->visible(fn (ContentBlock $record) => $record->type === 'boolean'),
                    ])->columns(1),

                Infolists\Components\Section::make('Deskripsi')
                    ->schema([
                        Infolists\Components\TextEntry::make('description')
                            ->label('Catatan')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime(),
                    ])->columns(2),
            ]);
    }
}
