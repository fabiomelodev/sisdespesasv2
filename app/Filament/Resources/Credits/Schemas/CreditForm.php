<?php

namespace App\Filament\Resources\Credits\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CreditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan([
                        'default' => 'full',
                        'md'      => 9,
                    ])
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required(),
                        DatePicker::make('pay_day')
                            ->label('Data do pagamento')
                            ->displayFormat('d/m/Y')
                            ->required()
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
                        Select::make('category_id')
                            ->label('Categoria')
                            ->placeholder('Selecionar')
                            ->relationship('category', 'title')
                            ->required(),
                        Select::make('invoice_id')
                            ->label('Fatura')
                            ->required()
                            ->relationship(
                                'invoice',
                                'title',
                                fn(Builder $query) => $query->where('user_id', Auth::user()->id)
                            )
                    ])
            ]);
    }
}
