<?php

namespace App\Filament\Resources\QuickLinks\Pages;

use App\Filament\Resources\QuickLinks\QuickLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageQuickLinks extends ManageRecords
{
    protected static string $resource = QuickLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
