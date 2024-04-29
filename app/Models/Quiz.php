<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'duration',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($quiz) {
            $quiz->questions()->delete();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'));
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function getDurationDateAttribute($value)
    {
        $duration = '';
        if ($this->start_date) {
            $duration .= $this->start_date->format('d M Y');
        }
        if ($this->end_date && $this->start_date != $this->end_date) {
            $duration .= ' - '.$this->end_date->format('d M Y');
        }

        return $duration;
    }

    public function getIsActiveAttribute($value)
    {
        return Carbon::now()->between($this->start_date, $this->end_date);
    }

    public function getIsFinishedAttribute($value)
    {
        return Carbon::now()->greaterThan($this->end_date);
    }

    public function isAllowed($user)
    {
        if ($user->role == 'admin') {
            return true;
        }

        if ($user->member && $this->course_id > 0) {
            return DB::table('member_batch')
                ->whereRaw('member_batch.member_id='.$user->member->id." AND member_batch.status='6' AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$this->course_id.')')
                ->exists();
        }

        return false;
    }
}
