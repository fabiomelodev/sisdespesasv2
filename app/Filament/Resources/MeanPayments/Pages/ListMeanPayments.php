<?php

namespace App\Filament\Resources\MeanPayments\Pages;

use App\Filament\Resources\MeanPayments\MeanPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeanPayments extends ListRecords
{
    protected static string $resource = MeanPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
