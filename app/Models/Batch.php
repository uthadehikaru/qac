<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'certificate_id',
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

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_batch')->withPivot('id', 'session', 'status')->using(MemberBatch::class);
    }

    public function paidMembers()
    {
        return $this->belongsToMany(Member::class, 'member_batch')
            ->wherePivot('status', '>=', MemberBatch::STATUS_PAID)
            ->withPivot('id', 'session', 'status')->using(MemberBatch::class);
    }

    public function file()
    {
        return $this->hasOne(File::class, 'record_id')->where('tablename', 'batches');
    }

    public function scopeOpen($query)
    {
        return $query->where('registration_start_at', '<=', date('Y-m-d'))
            ->where('registration_end_at', '>=', date('Y-m-d'));
    }

    public function scopeActive($query)
    {
        return $query->where('registration_start_at', '<=', date('Y-m-d'))
            ->where('end_at', '>=', date('Y-m-d'));
    }

    public function scopeRunning($query)
    {
        $ecource_access_month = System::value('ecource_access_month', 1);

        return $query->where('start_at', '<=', date('Y-m-d'))
            ->whereRaw('DATE_ADD(end_at, INTERVAL '.$ecource_access_month." MONTH) >= '".date('Y-m-d')."'");
    }

    public function getFullNameAttribute($value)
    {
        return $this->course->name.' batch '.$this->name;
    }

    public function getRegistrationDurationAttribute($value)
    {
        $duration = '';
        if ($this->registration_start_at) {
            $duration .= $this->registration_start_at->format('d F Y');
        }

        if ($this->registration_end_at) {
            $duration .= ' s/d '.$this->registration_end_at->format('d F Y');
        }

        return $duration;
    }

    public function getDurationAttribute($value)
    {
        $duration = '';
        if ($this->start_at) {
            $duration .= $this->start_at->format('d F Y');
        }

        if ($this->end_at) {
            $duration .= ' s/d '.$this->end_at->format('d F Y');
        }

        return $duration;
    }

    public function getIsFinishedAttribute()
    {
        return Carbon::now()->gt($this->end_at);
    }

    public function getIsOpenAttribute()
    {
        return Carbon::now()->betweenIncluded($this->registration_start_at, $this->registration_end_at);
    }

    public function getIsActiveAttribute()
    {
        return Carbon::now()->betweenIncluded($this->start_at, $this->end_at);
    }

    public function sessionList()
    {
        if ($this->sessions) {
            return explode(',', $this->sessions);
        }

        return null;
    }
}
