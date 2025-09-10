<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\ImmediateExpense;
use FFI;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ImmediateExpensesFixedPaidWidget extends TableWidget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = 3;

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? null;

        $endDate = $this->pageFilters['endDate'] ?? null;

        $query = ImmediateExpense::query()
            ->where('type', 'fixo')
            ->where('status', 'pago')
            ->when($startDate, fn($query) => $query->whereDate('pay_day', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('pay_day', '<=', $endDate))
            ->orderBy('pay_day', 'desc');

        $valueTotal = FormatCurrency::getFormatCurrency($query->sum('value'));

        return $table
            ->query(fn(): Builder => $query)
            ->heading('Pagos')
            ->description('Total: ' . ($valueTotal))
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Título'),
                TextColumn::make('category.title')
                    ->label('Categoria'),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->dateTime('d/m/y'),
                TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(fn($state) => FormatCurrency::getFormatCurrency($state))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required(),
                        Select::make('bank_id')
                            ->relationship('bank', 'title')
                            ->label('Banco')
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Vencimento')
                            ->displayFormat('d/m/y')
                            ->required(),
                        DatePicker::make('pay_day')
                            ->label('Data de pagamento')
                            ->displayFormat('d/m/y')
                            ->required(),
                        TextInput::make('value')
                            ->label('Valor')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'pago'     => 'Pago',
                            ])
                            ->required()
                            ->columnSpan('full')
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
