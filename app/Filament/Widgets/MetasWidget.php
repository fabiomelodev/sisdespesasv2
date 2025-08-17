<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Meta;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MetasWidget extends TableWidget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? null;

        $endDate = $this->pageFilters['endDate'] ?? null;

        $query = Meta::query()
            ->with(['category' => function ($q) use ($startDate, $endDate) {
                $q->withSum(['immediateExpenses as total_expenses' => function ($q) use ($startDate, $endDate) {
                    $q->when($startDate, fn($q) => $q->whereDate('pay_day', '>=', $startDate))
                        ->when($endDate, fn($q) => $q->whereDate('pay_day', '<=', $endDate))
                        ->where('status', 'pago');
                }], 'value');
            }])
            ->when($startDate, fn($q) => $q->whereDate('date', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('date', '<=', $endDate));

        return $table
            ->query(fn(): Builder => $query)
            ->columns([
                TextColumn::make('category.title')
                    ->label('Categoria'),
                TextColumn::make('value')
                    ->label('Meta')
                    ->badge()
                    ->formatStateUsing(function ($state, $record) {
                        return FormatCurrency::getFormatCurrency($state) . ' / ' . (FormatCurrency::getFormatCurrency($record->category->total_expenses ?? 0));
                    }),
                TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('m/y'),
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
