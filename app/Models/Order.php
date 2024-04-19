<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function ecourse():BelongsTo
    {
        return $this->belongsTo(Ecourse::class);
    }

    public function subscription():BelongsTo
    {
        return $this->belongsTo(subscription::class);
    }
}
