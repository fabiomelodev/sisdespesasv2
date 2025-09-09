<?php

namespace App\Filament\Resources\ImmediateExpenses;

use App\Filament\Resources\ImmediateExpenses\Pages\CreateImmediateExpense;
use App\Filament\Resources\ImmediateExpenses\Pages\EditImmediateExpense;
use App\Filament\Resources\ImmediateExpenses\Pages\ListImmediateExpenses;
use App\Filament\Resources\ImmediateExpenses\Pages\ViewImmediateExpense;
use App\Filament\Resources\ImmediateExpenses\Schemas\ImmediateExpenseForm;
use App\Filament\Resources\ImmediateExpenses\Schemas\ImmediateExpenseInfolist;
use App\Filament\Resources\ImmediateExpenses\Tables\ImmediateExpensesTable;
use App\Models\ImmediateExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ImmediateExpenseResource extends Resource
{
    protected static ?string $model = ImmediateExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = 'Despesa Imediata';

    protected static ?string $pluralLabel = 'Despesas Imediatas';

    protected static ?string $recordTitleAttribute = 'ImmediateExpense';

    protected static string | UnitEnum | null $navigationGroup = 'Depósitos e Despesas';

    public static function form(Schema $schema): Schema
    {
        return ImmediateExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImmediateExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImmediateExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListImmediateExpenses::route('/'),
            'create' => CreateImmediateExpense::route('/create'),
            'view' => ViewImmediateExpense::route('/{record}'),
            'edit' => EditImmediateExpense::route('/{record}/edit'),
        ];
    }
}
