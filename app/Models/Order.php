<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
        'start_date' => 'date:d-M-Y',
        'end_date' => 'date:d-M-Y',
    ];

    public function scopeVerified($query)
    {
        $query->whereNotNull('verified_at');
    }

    public function scopeActive($query)
    {
        $query->where('start_date', '<=', date('Y-m-d'));
        $query->where('end_date', '>=', date('Y-m-d'));
    }

    public function getIsActiveAttribute()
    {
        return Carbon::now()->betweenIncluded($this->start_date, $this->end_date);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(subscription::class);
    }
}
