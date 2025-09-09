<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class TotalExpensesByCategoriesWidget extends TableWidget
{

    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? null;

        $endDate = $this->pageFilters['endDate'] ?? null;

        $query = Category::orderBy('title', 'asc')
            ->select('categories.*')
            ->selectSub(function ($q) use ($startDate, $endDate) {
                $q->from('immediate_expenses')
                    ->selectRaw('COALESCE(SUM(value),0)')
                    ->whereColumn('immediate_expenses.category_id', 'categories.id')
                    ->where('status', 'pago')
                    ->when($startDate, fn($q) => $q->whereDate('pay_day', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('pay_day', '<=', $endDate));
            }, 'totalExpenses')
            ->having('totalExpenses', '>', 0);

        $valueTotal = FormatCurrency::getFormatCurrency($query->get()->sum('totalExpenses'));

        return $table
            ->query(fn(): Builder => $query)
            ->heading('Categorias')
            ->description('Total: ' . ($valueTotal))
            ->paginated(false)
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->label('Título'),
                    TextColumn::make('totalExpenses')
                        ->label('Total')
                        ->formatStateUsing(fn($state) => FormatCurrency::getFormatCurrency($state))
                ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
