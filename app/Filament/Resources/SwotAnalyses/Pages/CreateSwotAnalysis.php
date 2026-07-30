<?php

namespace App\Filament\Resources\SwotAnalyses\Pages;

use App\Filament\Resources\SwotAnalyses\SwotAnalysisResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSwotAnalysis extends CreateRecord
{
    protected static string $resource = SwotAnalysisResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
