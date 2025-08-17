<?php

namespace App\Filament\Resources\ImmediateExpenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ->numeric()
                    ->sortable(),
                TextColumn::make('meanPayment.title')
                    ->label('Meio de Pagamento')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pay_day')
                    ->label('Data Pago')
                    ->dateTime('d/m/y')
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
                TextColumn::make('value')
                    ->label('Valor')
                    ->numeric()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
