<?php

namespace App\Filament\Resources\ImmediateExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ImmediateExpenseForm
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
                    ->columns(12)
                    ->schema([
                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'inscontante' => 'Inscontante',
                                'fixo'        => 'Fixo',
                            ])
                            ->default('inscontante')
                            ->reactive()
                            ->required()
                            ->columnSpan('full'),
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Select::make('mean_payment_id')
                            ->label('Meio de pagamento')
                            ->relationship('meanPayment', 'title')
                            ->placeholder('Selecionar')
                            ->required(fn(Get $get): bool => $get('type') === 'inscontante')
                            ->columnSpan('full'),
                        DatePicker::make('due_date')
                            ->label('Data de vencimento')
                            ->displayFormat('d/m/Y')
                            ->hidden(fn(Get $get): bool => $get('type') === 'inscontante')
                            ->required()
                            ->columnSpan([
                                'default' => 'full',
                                'md'      => 6,
                            ]),
                        DatePicker::make('pay_day')
                            ->label('Data de pagamento')
                            ->displayFormat('d/m/Y')
                            ->required(fn(Get $get): bool => $get('type') === 'inscontante')
                            ->columnSpan([
                                'default' => 'full',
                                'md'      => 6,
                            ]),
                    ]),
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 3,
                    ])
                    ->schema([
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->required(),
                        Select::make('bank_id')
                            ->label('Banco')
                            ->relationship('bank', 'title')
                            ->required(fn(Get $get): bool => $get('type') === 'inscontante'),
                        Select::make('category_id')
                            ->label('Categoria')
                            ->placeholder('Selecionar')
                            ->relationship('category', 'title')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'pago'     => 'Pago',
                            ])
                            ->required()
                            ->hidden(fn(Get $get): bool => $get('type') === 'inscontante')
                            ->columnSpan('full'),
                    ])

            ]);
    }
}
