<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MemberBatch extends Pivot
{
    use HasFactory;
    
    protected $table = 'member_batch';

    protected $fillable = [
        'member_id',
        'batch_id',
        'approved_at',
    ];

    public $timestamps = false;
    
    protected $dates = ['approved_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
