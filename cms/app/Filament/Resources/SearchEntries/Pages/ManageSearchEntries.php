<?php

namespace App\Filament\Resources\SearchEntries\Pages;

use App\Filament\Resources\SearchEntries\SearchEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSearchEntries extends ManageRecords
{
    protected static string $resource = SearchEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
