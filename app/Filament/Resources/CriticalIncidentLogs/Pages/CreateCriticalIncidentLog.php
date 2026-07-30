<?php

namespace App\Filament\Resources\CriticalIncidentLogs\Pages;

use App\Filament\Resources\CriticalIncidentLogs\CriticalIncidentLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCriticalIncidentLog extends CreateRecord
{
    protected static string $resource = CriticalIncidentLogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
