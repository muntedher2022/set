<?php

namespace App\Filament\Resources\GoalAndKpis\Pages;

use App\Filament\Resources\GoalAndKpis\GoalAndKpiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGoalAndKpis extends ListRecords
{
    protected static string $resource = GoalAndKpiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
