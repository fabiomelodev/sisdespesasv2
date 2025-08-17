<?php

namespace App\Filament\Resources\ImmediateExpenses\Pages;

use App\Filament\Resources\ImmediateExpenses\ImmediateExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImmediateExpenses extends ListRecords
{
    protected static string $resource = ImmediateExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
