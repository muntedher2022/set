<?php

namespace App\Filament\Resources\PerformanceImprovementPlans\Pages;

use App\Filament\Resources\PerformanceImprovementPlans\PerformanceImprovementPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerformanceImprovementPlan extends CreateRecord
{
    protected static string $resource = PerformanceImprovementPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
