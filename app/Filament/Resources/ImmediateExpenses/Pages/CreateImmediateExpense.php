<?php

namespace App\Filament\Resources\ImmediateExpenses\Pages;

use App\Filament\Resources\ImmediateExpenses\ImmediateExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImmediateExpense extends CreateRecord
{
    protected static string $resource = ImmediateExpenseResource::class;
}
