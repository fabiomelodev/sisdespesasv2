<?php

namespace App\Filament\Resources\MeanPayments\Pages;

use App\Filament\Resources\MeanPayments\MeanPaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMeanPayment extends EditRecord
{
    protected static string $resource = MeanPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
