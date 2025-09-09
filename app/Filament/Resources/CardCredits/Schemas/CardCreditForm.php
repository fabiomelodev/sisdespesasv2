<?php

namespace App\Filament\Resources\CardCredits\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CardCreditForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required(),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->required(),
                        Select::make('bank_id')
                            ->label('Banco')
                            ->required()
                            ->relationship('bank', 'title', fn(Builder $query) => $query->where('user_id', Auth::user()->id)),
                        Select::make('status')
                            ->required()
                            ->options([
                                '0' => 'Inativo',
                                '1' => 'Ativo'
                            ]),
                    ])
            ]);;
    }
}
