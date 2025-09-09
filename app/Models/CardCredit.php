<?php

namespace App\Models;

use App\Helpers\FormatCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardCredit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->user_id = Auth::user()->id;
        });

        static::updating(function ($model) {
            $slug = strip_tags($model->slug);
            $model->slug = Str::slug($slug);
            $model->user_id = Auth::user()->id;
        });
    }

    public static function getCardCreditsTotalCurrentMonth($month, $year)
    {
        return self::with('bank', 'invoices.credits')
            ->get()
            ->map(function ($cardCredit) use ($month, $year) {
                $bank = $cardCredit->bank;

                $invoice = $cardCredit->invoices()
                    ->whereMonth('referential_date', $month)
                    ->whereYear('referential_date', $year)
                    ->first();

                $creditsTotal = 0;

                if ($invoice) {
                    $creditsTotal = optional($invoice)->credits()?->sum('value');
                }

                $limit = (float) $cardCredit->value - (float) $creditsTotal;

                $credits = $invoice->credits()
                    ->orderBy('pay_day', 'desc')
                    ->get();

                return [
                    'title'        => $cardCredit->title,
                    'limit'        => FormatCurrency::getFormatCurrency($limit),
                    'bank_title'   => $bank->title,
                    'bank_icon'    => $bank->icon_bank,
                    'bank_color'   => $bank->color,
                    'creditsTotal' => FormatCurrency::getFormatCurrency($creditsTotal),
                    'status'       => $invoice->status,
                    'credits'      => $credits
                ];
            });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
