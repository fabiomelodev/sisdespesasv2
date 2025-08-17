<?php

namespace App\Models;

use App\Helpers\FormatCurrency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    public static function getTotalBankValueCurrentMonth($startDate, $endDate)
    {
        return Bank::get()
            ->map(function ($bank) use ($startDate, $endDate) {
                $expenses = $bank->immediateExpenses()
                    ->whereHas('meanPayment', fn(Builder $query) => $query->whereNot('slug', 'credito'))
                    ->where('status', 'pago')
                    ->when($startDate, fn(Builder $query) => $query->whereDate('pay_day', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('pay_day', '<=', $endDate))
                    ->get();

                $expensesTotalValue = $expenses->sum('value');

                $depositsTotalValue = $bank->deposits()
                    ->where('status', 'pago')
                    ->when($startDate, fn(Builder $query) => $query->whereDate('entry_date', '>=', $startDate))
                    ->when($endDate, fn(Builder $query) => $query->whereDate('entry_date', '<=', $endDate))
                    ->sum('wage');

                $remainingTotalValue = $depositsTotalValue - $expensesTotalValue;

                return [
                    'title'               => $bank->title,
                    'icon'                => $bank->icon_bank,
                    'color'               => $bank->color,
                    'depositsTotalValue'  => FormatCurrency::getFormatCurrency($depositsTotalValue),
                    'expensesTotalValue'  => FormatCurrency::getFormatCurrency($expensesTotalValue),
                    'remainingTotalValue' => FormatCurrency::getFormatCurrency($remainingTotalValue)
                ];
            });
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function immediateExpenses(): HasMany
    {
        return $this->hasMany(ImmediateExpense::class);
    }
}
