<?php

namespace App\Filament\Resources\ImmediateExpenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ImmediateExpenseInfolist
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
                TextEntry::make('status'),
                TextEntry::make('type'),
                TextEntry::make('bank_id')
                    ->numeric(),
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('mean_payment_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('due_date')
                    ->dateTime(),
            ]);
    }
}
