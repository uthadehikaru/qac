<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecourse_id',
        'member_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date:d-M-Y',
        'end_date' => 'date:d-M-Y',
    ];

    public function ecourse():BelongsTo
    {
        return $this->belongsTo(Ecourse::class);
    }

    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
