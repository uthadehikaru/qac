<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompletedLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'member_id',
    ];

    public function lesson():BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
