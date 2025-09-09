<?php

namespace App\Filament\Resources\Credits;

use App\Filament\Resources\Credits\Pages\CreateCredit;
use App\Filament\Resources\Credits\Pages\EditCredit;
use App\Filament\Resources\Credits\Pages\ListCredits;
use App\Filament\Resources\Credits\Pages\ViewCredit;
use App\Filament\Resources\Credits\Schemas\CreditForm;
use App\Filament\Resources\Credits\Schemas\CreditInfolist;
use App\Filament\Resources\Credits\Tables\CreditsTable;
use App\Models\Credit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CreditResource extends Resource
{
    protected static ?string $model = Credit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = 'Crédito';

    protected static ?string $pluralLabel = 'Créditos';

    protected static ?string $recordTitleAttribute = 'Credit';

    protected static string | UnitEnum | null $navigationGroup = 'Créditos';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CreditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CreditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CreditsTable::configure($table);
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
            'index' => ListCredits::route('/'),
            'create' => CreateCredit::route('/create'),
            'view' => ViewCredit::route('/{record}'),
            'edit' => EditCredit::route('/{record}/edit'),
        ];
    }
}
