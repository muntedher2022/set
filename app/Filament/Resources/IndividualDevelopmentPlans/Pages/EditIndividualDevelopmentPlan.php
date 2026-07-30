<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans\Pages;

use App\Filament\Resources\IndividualDevelopmentPlans\IndividualDevelopmentPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIndividualDevelopmentPlan extends EditRecord
{
    protected static string $resource = IndividualDevelopmentPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

}
