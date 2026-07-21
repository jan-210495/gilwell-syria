<?php

namespace App\Filament\Resources\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

abstract class ManageCmsRecords extends ManageRecords
{
    /**
     * @return array<int, CreateAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
