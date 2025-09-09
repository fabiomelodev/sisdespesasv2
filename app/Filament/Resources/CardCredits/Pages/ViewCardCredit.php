<?php

namespace App\Filament\Resources\CardCredits\Pages;

use App\Filament\Resources\CardCredits\CardCreditResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCardCredit extends ViewRecord
{
    protected static string $resource = CardCreditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
