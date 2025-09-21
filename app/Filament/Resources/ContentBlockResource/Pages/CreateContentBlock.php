<?php
// app/Filament/Resources/ContentBlockResource/Pages/CreateContentBlock.php

namespace App\Filament\Resources\ContentBlockResource\Pages;

use App\Filament\Resources\ContentBlockResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentBlock extends CreateRecord
{
    protected static string $resource = ContentBlockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
