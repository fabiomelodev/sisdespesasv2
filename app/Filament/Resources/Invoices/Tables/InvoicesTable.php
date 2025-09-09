<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Helpers\DateHelper;
use App\Helpers\FormatCurrency;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('cardCredit.title')
                    ->label('Cartão de crédito')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->dateTime('d/m/y')
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn(string $state): string => FormatCurrency::getFormatCurrency($state))
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago'
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'pago'     => 'success'
                    })
            ])
            ->filters([
                Filter::make('month')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 6
                    ])
                    ->columns([
                        'default' => 2
                    ])
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->columnSpan(1)
                            ->options(DateHelper::getMonths())
                            ->default(Carbon::now()->addMonth()->format('m')),
                        Select::make('year')
                            ->label('Ano')
                            ->columnSpan(1)
                            ->options(DateHelper::getYears())
                            ->default(date('Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['month'],
                                fn(Builder $query, $month): Builder => $query->whereMonth('due_date', $month),
                            )
                            ->when(
                                $data['year'],
                                fn(Builder $query, $year): Builder => $query->whereYear('due_date', $year),
                            );
                    }),
                SelectFilter::make('card_credit_id')
                    ->label('Cartão')
                    ->relationship('cardCredit', 'title', fn(Builder $query) => $query->where('user_id', Auth::user()->id)->where('status', 1))
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'pago'     => 'Pago',
                    ])
                    ->columnSpan([
                        'default' => 'full',
                        'md' => 3
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
