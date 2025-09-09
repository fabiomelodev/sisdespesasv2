<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\BankControlOverview;
use App\Filament\Widgets\CategoriesChartLineWidget;
use App\Filament\Widgets\DepositsChartLineWidget;
use App\Filament\Widgets\ImmediateExpensesFixedPaidWidget;
use App\Filament\Widgets\ImmediateExpensesFixedPedingWidget;
use App\Filament\Widgets\MetasWidget;
use App\Filament\Widgets\TotalExpensesByCategoriesWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function persistsFiltersInSession(): bool
    {
        return false;
    }

    public function getColumns(): int | array
    {
        return 6;
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Data inicial')
                            ->native(false)
                            // ->placeholder(now()->startOfMonth())
                            ->defaultFocusedDate(now()->startOfMonth())
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('endDate')
                            ->label('Data final')
                            ->native(false)
                            // ->placeholder(now()->endOfMonth())
                            ->defaultFocusedDate(now()->endOfMonth())
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columnSpanFull()
                    ->columns(),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            BankControlOverview::class,
            DepositsChartLineWidget::class,
            ImmediateExpensesFixedPedingWidget::class,
            ImmediateExpensesFixedPaidWidget::class,
            TotalExpensesByCategoriesWidget::class,
            CategoriesChartLineWidget::class,
            MetasWidget::class
        ];
    }
}
