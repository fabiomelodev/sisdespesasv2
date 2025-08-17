<?php

namespace App\Filament\Widgets;

use App\Models\Bank;
use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BankControlOverview extends Widget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.bank-control-overview';

    // public $banks;

    public function getViewData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;

        $endDate = $this->pageFilters['endDate'] ?? null;

        return [
            'banks' => Bank::getTotalBankValueCurrentMonth($startDate, $endDate),
        ];
    }
}
