<?php

namespace App\Filament\Resources\GrowSessions\Pages;

use App\Filament\Resources\GrowSessions\GrowSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGrowSession extends EditRecord
{
    protected static string $resource = GrowSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
