<?php

namespace App\Filament\Resources\Credits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CreditInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('value')
                    ->numeric(),
                TextEntry::make('pay_day')
                    ->dateTime(),
                TextEntry::make('invoice.title')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('category.title')
                    ->numeric(),
            ]);
    }
}
