<?php

namespace App\Filament\Resources\Deposits\Tables;

use App\Helpers\DateHelper;
use App\Helpers\FormatCurrency;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\Width;

class DepositsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo'),
                TextColumn::make('bank.title')
                    ->label('Banco')
                    ->badge(),
                TextColumn::make('entry_date')
                    ->label('Data de entrada')
                    ->dateTime('d/m/y'),
                TextColumn::make('wage')
                    ->label('Salário')
                    ->formatStateUsing(fn(string $state): string => FormatCurrency::getFormatCurrency($state)),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'pago'     => 'success'
                    }),
            ])
            ->defaultSort('entry_date', 'desc')
            ->filters([
                Filter::make('month')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->options(DateHelper::getMonths())
                            ->default(date('m')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['month'],
                                fn(Builder $query, $date): Builder => $query->whereMonth('entry_date', $date),
                            );
                    }),
                Filter::make('year')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->schema([
                        Select::make('year')
                            ->label('Ano')
                            ->options(DateHelper::getYears())
                            ->default(date('Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['year'],
                                fn(Builder $query, $date): Builder => $query->whereYear('entry_date', $date),
                            );
                    }),
                SelectFilter::make('bank_id')
                    ->label('Banco')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->relationship('bank', 'title'),
                SelectFilter::make('status')
                    ->label('Status')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->options([
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago',
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
