<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'start_at',
        'end_at',
        'session',
        'duration',
        'point',
        'email',
    ];

    protected $dates = ['start_at','end_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(ParticipantAnswer::class);
    }

    public function getFinishAttribute()
    {
        return $this->start_at && $this->end_at;
    }
}
