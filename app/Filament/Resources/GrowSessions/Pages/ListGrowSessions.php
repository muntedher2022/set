<?php

namespace App\Filament\Resources\GrowSessions\Pages;

use App\Filament\Resources\GrowSessions\GrowSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGrowSessions extends ListRecords
{
    protected static string $resource = GrowSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
