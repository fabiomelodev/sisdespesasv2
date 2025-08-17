<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->required(),
                TextInput::make('wage')
                    ->numeric(),
                TextInput::make('description')
                    ->required(),
                DateTimePicker::make('entry_date')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                Select::make('bank_id')
                    ->relationship('bank', 'title'),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
