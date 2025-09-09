<?php

namespace App\Filament\Resources\CardCredits;

use App\Filament\Resources\CardCredits\Pages\CreateCardCredit;
use App\Filament\Resources\CardCredits\Pages\EditCardCredit;
use App\Filament\Resources\CardCredits\Pages\ListCardCredits;
use App\Filament\Resources\CardCredits\Pages\ViewCardCredit;
use App\Filament\Resources\CardCredits\Schemas\CardCreditForm;
use App\Filament\Resources\CardCredits\Schemas\CardCreditInfolist;
use App\Filament\Resources\CardCredits\Tables\CardCreditsTable;
use App\Models\CardCredit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CardCreditResource extends Resource
{
    protected static ?string $model = CardCredit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = 'Cartão de Crédito';

    protected static ?string $pluralLabel = 'Cartões de Crédito';

    protected static ?string $recordTitleAttribute = 'CardCredit';

    protected static string | UnitEnum | null $navigationGroup = 'Créditos';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CardCreditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CardCreditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CardCreditsTable::configure($table);
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
            'index' => ListCardCredits::route('/'),
            'create' => CreateCardCredit::route('/create'),
            'view' => ViewCardCredit::route('/{record}'),
            'edit' => EditCardCredit::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
