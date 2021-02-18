<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'address'
    ];

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
        return $this->belongsToMany(Batch::class,'member_batch')->using(MemberBatch::class);
    }
}
