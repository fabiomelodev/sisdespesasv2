<?php

namespace App\Filament\Resources\CardCredits\Pages;

use App\Filament\Resources\CardCredits\CardCreditResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCardCredits extends ListRecords
{
    protected static string $resource = CardCreditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
