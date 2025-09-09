<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DepositForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->schema([
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 9,
                    ])
                    ->schema([
                        TextInput::make('type')
                            ->label('Tipo')
                            ->required()
                            ->columnSpan('full'),
                        Textarea::make('description')
                            ->label('Descrição')
                            ->rows(5)
                            ->required()
                            ->columnSpan('full'),
                    ]),
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->schema([
                        Select::make('bank_id')
                            ->label('Banco')
                            ->relationship('bank', 'title', function (Builder $query) {
                                $query->where('user_id', Auth::user()->id);
                            })
                            ->required(),
                        TextInput::make('wage')
                            ->label('Valor')
                            ->prefix('R$')
                            ->required()
                            ->columnSpan('full'),
                        DatePicker::make('entry_date')
                            ->label('Data de entrada')
                            ->displayFormat('d/m/Y')
                            ->required()
                            ->columnSpan('full'),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'pago'     => 'Pago',
                            ])
                            ->required()
                            ->columnSpan('full'),
                    ])
            ]);
    }
}
