<?php

namespace App\Filament\Resources\CardCredits\Pages;

use App\Filament\Resources\CardCredits\CardCreditResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCardCredit extends EditRecord
{
    protected static string $resource = CardCreditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
