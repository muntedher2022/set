<?php

namespace App\Filament\Resources\GrowSessions\Pages;

use App\Filament\Resources\GrowSessions\GrowSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGrowSession extends CreateRecord
{
    protected static string $resource = GrowSessionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
