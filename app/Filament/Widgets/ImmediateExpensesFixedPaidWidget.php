<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\ImmediateExpense;
use FFI;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ImmediateExpensesFixedPaidWidget extends TableWidget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 3;

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? null;

        $endDate = $this->pageFilters['endDate'] ?? null;

        $query = ImmediateExpense::query()
            ->where('type', 'fixo')
            ->where('status', 'pago')
            ->when($startDate, fn($query) => $query->whereDate('due_date', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('due_date', '<=', $endDate))
            ->orderBy('due_date', 'desc');

        $valueTotal = FormatCurrency::getFormatCurrency($query->sum('value'));

        return $table
            ->query(fn(): Builder => $query)
            ->heading('Pagos')
            ->description('Total: ' . ($valueTotal))
            ->columns([
                TextColumn::make('title')
                    ->label('Título'),
                TextColumn::make('category.title')
                    ->label('Categoria'),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->dateTime('d/m/y'),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn($state) => FormatCurrency::getFormatCurrency($state))
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
