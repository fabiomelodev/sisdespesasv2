<?php

namespace App\Filament\Resources\ImmediateExpenses\Tables;

use App\Helpers\DateHelper;
use App\Helpers\FormatCurrency;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImmediateExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('category.title')
                    ->label('Categoria')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bank.title')
                    ->label('Banco')
                    ->badge()
                    ->sortable(),
                TextColumn::make('meanPayment.title')
                    ->label('Meio de Pagamento')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pay_day')
                    ->label('Data Pago')
                    ->dateTime('d/m/y')
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn(string $state): string => FormatCurrency::getFormatCurrency($state))
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pendente' => 'gray',
                        'pago'     => 'success',
                    }),
            ])
            ->defaultSort('title', 'desc')
            ->filters([
                Filter::make('month')
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->columnSpan(1)
                            ->options(DateHelper::getMonths())
                            ->default(date('m')),
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
                                fn(Builder $query, $month): Builder => $query->whereMonth('pay_day', $month),
                            )
                            ->when(
                                $data['year'],
                                fn(Builder $query, $year): Builder => $query->whereYear('pay_day', $year),
                            );
                    }),
                Filter::make('pay_day')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Pagamento inicial')
                            ->columnSpan(1),
                        DatePicker::make('final_date')
                            ->label('Pagamento final')
                            ->columnSpan(1),
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pay_day', '>=', $date),
                            )
                            ->when(
                                $data['final_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pay_day', '<=', $date),
                            );
                    }),
                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'title')
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6,
                        'lg' => 3,
                    ]),
                SelectFilter::make('bank_id')
                    ->label('Banco')
                    ->relationship('bank', 'title')
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6,
                        'lg' => 3,
                    ]),
                SelectFilter::make('mean_payment_id')
                    ->label('Meio de pagamento')
                    ->relationship('meanPayment', 'title')
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6,
                        'lg' => 3,
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago',
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6,
                        'lg' => 3,
                    ]),
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'inscontante' => 'Inscontante',
                        'fixo'        => 'Fixo',
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 6,
                        'lg' => 3,
                    ]),
            ], FiltersLayout::AboveContentCollapsible)
            ->filtersFormWidth(Width::ExtraLarge)
            ->filtersFormColumns(12)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
