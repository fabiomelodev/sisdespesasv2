<?php

namespace App\Filament\Resources\Metas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MetaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('value'),
                TextEntry::make('user.name')
                    ->numeric(),
                TextEntry::make('category.title')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('date')
                    ->dateTime(),
            ]);
    }
}
