<?php

namespace App\Filament\Resources\Metas\Schemas;

use App\Helpers\MonthHelper;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MetaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->schema([
                Section::make()
                    ->columns(2)
                    ->columnSpan(9)
                    ->schema([
                        Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'title', fn(Builder $query) => $query->where('user_id', Auth::user()->id))
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('value')
                            ->label('Valor')
                            ->prefix('R$')
                            ->columnSpan(1)
                            ->required()
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        DatePicker::make('date')
                            ->label('Data')
                            ->required(),
                    ])
            ]);
    }
}
