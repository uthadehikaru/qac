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
    
    protected $casts = [
        'start_at' => 'date:d M Y H:i:s',
        'end_at' => 'date:d M Y H:i:s',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($participant) { 
             $participant->answers()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
