<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'batch_no',
        'description',
        'start_at',
        'end_at',
        'registration_start_at',
        'registration_end_at',
    ];
    
    protected $casts = [
        'start_at' => 'date:Y-m-d',
        'end_at' => 'date:Y-m-d',
        'registration_start_at' => 'date:Y-m-d',
        'registration_end_at' => 'date:Y-m-d',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_batch');
    }
}
