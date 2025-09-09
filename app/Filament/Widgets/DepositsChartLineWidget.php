<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\Bank;
use App\Models\Deposit;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;

class DepositsChartLineWidget extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Depósitos | Gráfico Line';

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        $banks = Bank::orderBy('title', 'asc')->pluck('title', 'slug')->toArray();

        $filters = array_merge(['all' => 'Todos'], $banks);

        return $filters;
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $data = Trend::query(Deposit::when($activeFilter != 'all', function (Builder $query) use ($activeFilter) {
            $query->whereRelation('bank', 'slug', $activeFilter);
        }))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('wage');

        return [
            'datasets' => [
                [
                    'label' => 'Depósitos',
                    'data'  => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
