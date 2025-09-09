<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\ImmediateExpense;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;

class CategoriesChartLineWidget extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected ?string $heading = 'Despesas por Categoria | Gráfico Line';

    public ?string $filter = 'conta';

    protected function getFilters(): ?array
    {
        return Category::orderBy('title', 'asc')->pluck('title', 'slug')->toArray();
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $data = Trend::query(ImmediateExpense::when($activeFilter, function (Builder $query) use ($activeFilter) {
            $query->whereRelation('category', 'slug', $activeFilter);
        }))
            ->dateColumn('pay_day')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('value');


        $category = Category::where('slug', $activeFilter)->first();

        return [
            'datasets' => [
                [
                    'label' => $category ? $category->title : 'Categorias',
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
