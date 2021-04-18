<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function boot() {
        parent::boot();

        static::deleting(function($member) { 
             $member->batches()->detach();
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
}
