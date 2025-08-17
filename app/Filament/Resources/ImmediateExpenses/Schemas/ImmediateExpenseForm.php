<?php

namespace App\Filament\Resources\ImmediateExpenses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ImmediateExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('pay_day'),
                TextInput::make('status')
                    ->required()
                    ->default('pendente'),
                TextInput::make('type')
                    ->required()
                    ->default('inscontante'),
                TextInput::make('bank_id')
                    ->numeric(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('mean_payment_id')
                    ->numeric(),
                DateTimePicker::make('due_date'),
            ]);
    }
}
