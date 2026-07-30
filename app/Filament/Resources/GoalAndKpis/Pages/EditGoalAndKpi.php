<?php

namespace App\Filament\Resources\GoalAndKpis\Pages;

use App\Filament\Resources\GoalAndKpis\GoalAndKpiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGoalAndKpi extends EditRecord
{
    protected static string $resource = GoalAndKpiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
