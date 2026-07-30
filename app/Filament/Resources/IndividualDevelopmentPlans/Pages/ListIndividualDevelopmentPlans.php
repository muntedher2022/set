<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans\Pages;

use App\Filament\Resources\IndividualDevelopmentPlans\IndividualDevelopmentPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIndividualDevelopmentPlans extends ListRecords
{
    protected static string $resource = IndividualDevelopmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
