<?php

namespace App\Filament\Resources\OfficeHours\Pages;

use App\Filament\Resources\OfficeHours\OfficeHourResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageOfficeHours extends ManageRecords
{
    protected static string $resource = OfficeHourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
