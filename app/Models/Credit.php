<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Credit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pay_day' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $value = $model->value =  str_replace(',', '.', $model->value);

            $model->value = (float) $value;
        });

        static::updating(function ($model) {
            $value = $model->value =  str_replace(',', '.', $model->value);

            $model->value = (float) $value;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
