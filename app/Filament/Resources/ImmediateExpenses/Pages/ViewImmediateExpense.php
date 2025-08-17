<?php

namespace App\Filament\Resources\ImmediateExpenses\Pages;

use App\Filament\Resources\ImmediateExpenses\ImmediateExpenseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImmediateExpense extends ViewRecord
{
    protected static string $resource = ImmediateExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
