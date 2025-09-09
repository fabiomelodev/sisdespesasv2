<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 9
                    ])
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->disabled()
                            ->hiddenOn('create'),
                        DatePicker::make('referential_date')
                            ->label('Data de referência')
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Data de vencimento')
                            ->required()
                    ]),
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3
                    ])
                    ->schema([
                        Select::make('card_credit_id')
                            ->label('Cartão')
                            ->required()
                            ->relationship('cardCredit', 'title', fn(Builder $query) => $query->where('user_id', Auth::user()->id)->where('status', 1)),
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->disabled(),
                        Select::make('status')
                            ->required()
                            ->options([
                                'pendente' => 'Pendente',
                                'pago'     => 'Pago'
                            ]),
                        DatePicker::make('created_at')
                            ->label('Criado em')
                            ->disabled()
                            ->hiddenOn('create'),

                    ])
            ]);
    }
}
