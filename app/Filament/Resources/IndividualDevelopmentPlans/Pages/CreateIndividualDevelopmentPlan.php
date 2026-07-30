<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans\Pages;

use App\Filament\Resources\IndividualDevelopmentPlans\IndividualDevelopmentPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIndividualDevelopmentPlan extends CreateRecord
{
    protected static string $resource = IndividualDevelopmentPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
