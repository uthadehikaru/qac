<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Queue extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'course_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
