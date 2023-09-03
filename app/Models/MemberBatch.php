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
        'testimonial',
        'member_batch_uu',
        'new_book',
    ];

    public const statuses = [0,1,3,4,5,6];

    public const STATUS_CANCELED= 0;
    public const STATUS_REGISTERED = 1;
    public const STATUS_CHECKED = 2;
    public const STATUS_PAID = 3;
    public const STATUS_SHIPPED = 4;
    public const STATUS_COMPLETED = 5;
    public const STATUS_GRADUATED = 6;

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
    
    public function scopeTestimonial($query)
    {
        return $query->where('status', 6)
            ->whereNotNull('testimonial')
            ->orderBy('id','desc');
    }
}
