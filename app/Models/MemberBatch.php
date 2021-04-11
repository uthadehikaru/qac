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
        'session',
        'status',
        'note',
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

    public function file()
    {
        return $this->hasOne(File::class,'record_id')->where('tablename','member_batch');
    }
}
