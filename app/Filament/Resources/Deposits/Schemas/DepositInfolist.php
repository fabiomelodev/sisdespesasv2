<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DepositInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type'),
                TextEntry::make('wage')
                    ->numeric(),
                TextEntry::make('description'),
                TextEntry::make('entry_date')
                    ->dateTime(),
                TextEntry::make('status'),
                TextEntry::make('bank.title')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('user_id')
                    ->numeric(),
            ]);
    }
}
