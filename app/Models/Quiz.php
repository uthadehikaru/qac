<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

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

    public static function boot() {
        parent::boot();

        static::deleting(function($member) { 
             $member->questions()->delete();
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

    public function getDurationDateAttribute($value)
    {
        $duration = "";
        if($this->start_date)
            $duration .= $this->start_date->format('d M Y');
        if($this->end_date && $this->start_date<>$this->end_date)
            $duration .= " - ".$this->end_date->format('d M Y');
        return $duration;
    }

    public function isAllowed($user)
    {
        if($user->role=='admin')
            return true;
        
        if($user->member && $this->course_id>0)
            return DB::table('member_batch')
            ->whereRaw("member_batch.member_id=".$user->member->id." AND member_batch.status='6' AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$this->course_id.")" )
            ->exists();

        return false;
    }
}
