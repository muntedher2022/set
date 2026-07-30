<?php

namespace App\Filament\Resources\CriticalIncidentLogs\Pages;

use App\Filament\Resources\CriticalIncidentLogs\CriticalIncidentLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCriticalIncidentLogs extends ListRecords
{
    protected static string $resource = CriticalIncidentLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
