<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('icon_bank'),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('description'),
                TextInput::make('color'),
            ]);
    }
}
