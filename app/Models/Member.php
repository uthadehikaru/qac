<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'gender',
        'address',
        'city',
        'instagram',
        'profesi',
        'pendidikan',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($member) { 
             $member->batches()->detach();
             $member->queues()->delete();
        });
    }

    public function isCompleted()
    {
        return $this->phone && $this->gender && $this->address;
    }

    public function getNameAttribute($value)
    {
        return $this->user?$this->user->name:'';
    }

    public function getEmailAttribute($value)
    {
        return $this->user?$this->user->email:'';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class,'member_batch')->withPivot('id','session', 'status')->using(MemberBatch::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'queues')->withTimestamps()->using(Queue::class);
    }

    public function level()
    {
        return DB::table('member_batch')
        ->join('batches', 'batches.id', '=', 'member_batch.batch_id')
        ->join('courses', 'courses.id', '=', 'batches.course_id')
        ->where('member_batch.member_id',$this->id)
        ->where('member_batch.status','6')
        ->max('courses.level');
    }
}
