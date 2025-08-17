<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImmediateExpense extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'pay_day' => 'datetime',
        'due_date' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if ($model->type === 'inscontante') {
                $model->status = 'pago';
            }
        });

        static::updating(function ($model) {
            if ($model->type === 'inscontante') {
                $model->status = 'pago';
            }
        });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function meanPayment(): BelongsTo
    {
        return $this->belongsTo(MeanPayment::class);
    }
}
