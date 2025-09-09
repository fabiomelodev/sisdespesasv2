<?php

namespace App\Filament\Resources\MeanPayments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MeanPaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpan('full'),
            ]);
    }
}
