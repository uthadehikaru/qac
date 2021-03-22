<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'sessions',
        'start_at',
        'end_at',
        'registration_start_at',
        'registration_end_at',
    ];
    
    protected $dates = [
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
        return $this->belongsToMany(Member::class,'member_batch')->withPivot('id','session', 'status')->using(MemberBatch::class);
    }

    public function file()
    {
        return $this->hasOne(File::class,'record_id')->where('tablename','batches');
    }

    public function scopeOpen($query)
    {
        return $query->where('registration_start_at', '<=', date('Y-m-d'))
            ->where('registration_end_at', '>=', date('Y-m-d'));
    }

    public function getFullNameAttribute($value)
    {
        return $this->course->name.' batch '.$this->name;
    }

    public function getDurationAttribute($value)
    {
        $duration = '';
        if($this->start_at)
            $duration .= $this->start_at->format('d F Y');
            
        if($this->end_at)
            $duration .= ' s/d '.$this->end_at->format('d F Y');

        return $duration;
    }

    public function getIsOpenAttribute()
    {
        return Carbon::now()->betweenIncluded($this->registration_start_at,$this->registration_end_at);
    }

    public function getIsActiveAttribute()
    {
        return Carbon::now()->betweenIncluded($this->start_at,$this->end_at);
    }

    public function sessionList()
    {
        if($this->sessions)
            return explode(',',$this->sessions);
        
        return null;
    }
}
