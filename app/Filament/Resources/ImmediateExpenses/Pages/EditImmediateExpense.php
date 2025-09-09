<?php

namespace App\Filament\Resources\ImmediateExpenses\Pages;

use App\Filament\Resources\ImmediateExpenses\ImmediateExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditImmediateExpense extends EditRecord
{
    protected static string $resource = ImmediateExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
