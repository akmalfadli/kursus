<?php
// app/Filament/Resources/ContentBlockResource/Pages/ViewContentBlock.php

namespace App\Filament\Resources\ContentBlockResource\Pages;

use App\Filament\Resources\ContentBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

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
}
