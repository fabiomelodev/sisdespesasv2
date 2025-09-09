<?php

namespace App\Models;

use App\Helpers\DateHelper;
use App\Helpers\MonthHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);

            list($year, $month, $day) = explode('-', $model->due_date);

            $month = DateHelper::getMonth((int) $month);

            $title = $month . '/' . $year . ' - ' . $model->cardCredit()->first()->title;

            $model->title = $title;

            $model->user_id = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->title);

            list($year, $month, $day) = explode('-', $model->due_date);

            $month = DateHelper::getMonth((int) $month);

            $title = $month . '/' . $year . ' - ' . $model->cardCredit()->first()->title;

            $model->title = $title;

            $model->user_id = Auth::user()->id;

            $model->value = $model->credits()->sum('value');
        });
    }

    public function cardCredit(): BelongsTo
    {
        return $this->belongsTo(CardCredit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class);
    }

    // public function expenses(): HasMany
    // {
    //     return $this->hasMany(Expense::class);
    // }
}
