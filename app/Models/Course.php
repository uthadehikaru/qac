<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'fee',
        'level',
        'is_active',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFeeFormatAttribute($value)
    {
        return "Rp. ".($this->fee/1000).'rb';
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class,'queues')->withTimestamps()->using(Queue::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function lastBatch()
    {
        return $this->batches()->orderBy('end_at','DESC')->first();
    }
}
