<?php

namespace App\Filament\Resources\Credits\Tables;

use App\Helpers\DateHelper;
use App\Helpers\FormatCurrency;
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

class CreditsTable
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
                    ->sortable(),
                TextColumn::make('invoice.title')
                    ->label('Fatura')
                    ->sortable(),
                TextColumn::make('pay_day')
                    ->label('Data pagamento')
                    ->dateTime('d/m/y')
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn($state) => FormatCurrency::getFormatCurrency($state))
                    ->sortable(),
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
                            ->default(date('m')),
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
                                fn(Builder $query, $month): Builder => $query->whereMonth('pay_day', $month),
                            )
                            ->when(
                                $data['year'],
                                fn(Builder $query, $year): Builder => $query->whereYear('pay_day', $year),
                            );
                    }),
                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->placeholder('Selecionar')
                    ->relationship('category', 'title')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3
                    ]),
                SelectFilter::make('invoice_id')
                    ->label('Fatura')
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3
                    ])
                    ->relationship(
                        'invoice',
                        'title',
                        fn(Builder $query) => $query->where('user_id', Auth::user()->id)
                    )
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
