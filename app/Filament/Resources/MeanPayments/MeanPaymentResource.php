<?php

namespace App\Filament\Resources\MeanPayments;

use App\Filament\Resources\MeanPayments\Pages\CreateMeanPayment;
use App\Filament\Resources\MeanPayments\Pages\EditMeanPayment;
use App\Filament\Resources\MeanPayments\Pages\ListMeanPayments;
use App\Filament\Resources\MeanPayments\Pages\ViewMeanPayment;
use App\Filament\Resources\MeanPayments\Schemas\MeanPaymentForm;
use App\Filament\Resources\MeanPayments\Schemas\MeanPaymentInfolist;
use App\Filament\Resources\MeanPayments\Tables\MeanPaymentsTable;
use App\Models\MeanPayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeanPaymentResource extends Resource
{
    protected static ?string $model = MeanPayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $label = 'Meio de Pagamento';

    protected static ?string $pluralLabel = 'Meios de Pagamentos';

    protected static ?string $recordTitleAttribute = 'MeanPayment';

    protected static string | UnitEnum | null $navigationGroup = 'Configurações';

    public static function form(Schema $schema): Schema
    {
        return MeanPaymentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeanPaymentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeanPaymentsTable::configure($table);
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
            'index' => ListMeanPayments::route('/'),
            'create' => CreateMeanPayment::route('/create'),
            'view' => ViewMeanPayment::route('/{record}'),
            'edit' => EditMeanPayment::route('/{record}/edit'),
        ];
    }
}
