<?php

namespace App\Filament\Resources\CriticalIncidentLogs\Pages;

use App\Filament\Resources\CriticalIncidentLogs\CriticalIncidentLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCriticalIncidentLog extends EditRecord
{
    protected static string $resource = CriticalIncidentLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
