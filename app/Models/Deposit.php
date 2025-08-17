<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Deposit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'entry_date' => 'datetime',
        'created_at' => 'datetime'
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->user_id = Auth::user()->id;

            $wage = str_replace(',', '', $model->wage);

            $model->wage = $wage;
        });

        static::updating(function ($model) {
            $model->user_id = Auth::user()->id;

            $wage = str_replace(',', '', $model->wage);

            $model->wage = $wage;
        });
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
