<?php

namespace App\Filament\Resources\GoalAndKpis\Pages;

use App\Filament\Resources\GoalAndKpis\GoalAndKpiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGoalAndKpi extends CreateRecord
{
    protected static string $resource = GoalAndKpiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
