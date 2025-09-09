<?php

namespace App\Filament\Resources\MeanPayments\Pages;

use App\Filament\Resources\MeanPayments\MeanPaymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeanPayment extends ViewRecord
{
    protected static string $resource = MeanPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
