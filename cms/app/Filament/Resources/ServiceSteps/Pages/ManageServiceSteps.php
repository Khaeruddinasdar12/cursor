<?php

namespace App\Filament\Resources\ServiceSteps\Pages;

use App\Filament\Resources\ServiceSteps\ServiceStepResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageServiceSteps extends ManageRecords
{
    protected static string $resource = ServiceStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
