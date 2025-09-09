<?php

namespace App\Filament\Resources\Metas\Tables;

use App\Helpers\DateHelper;
use App\Helpers\FormatCurrency;
use App\Models\ImmediateExpense;
use App\Models\Meta;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MetasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.title')
                    ->label('Categoria'),
                TextColumn::make('value')
                    ->label('Meta / Despesa')
                    ->formatStateUsing(function (Meta $record) {
                        $immediateExpensesTotalSum = ImmediateExpense::where('category_id', $record->category_id)
                            ->whereMonth('pay_day', $record->date)
                            ->whereYear('pay_day', $record->date)
                            ->sum('value');

                        return FormatCurrency::getFormatCurrency($record->value) . ' / ' . FormatCurrency::getFormatCurrency($immediateExpensesTotalSum);
                    }),
                TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('d/m/y')
            ])
            ->filters([
                Filter::make('date')
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->options(DateHelper::getMonths())
                            ->default(date('m'))
                            ->columnSpan(1),
                        Select::make('year')
                            ->label('Ano')
                            ->columnSpan(1)
                            ->options(DateHelper::getYears())
                            ->default(date('Y')),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 6
                    ])
                    ->columns([
                        'default' => 2
                    ])

                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['month'],
                                fn(Builder $query, $month): Builder => $query->whereMonth('date', $month),
                            )
                            ->when(
                                $data['year'],
                                fn(Builder $query, $year): Builder => $query->whereYear('date', $year),
                            );
                    }),
            ], FiltersLayout::AboveContentCollapsible)
            ->filtersFormWidth(Width::ExtraLarge)
            ->filtersFormColumns(12)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
