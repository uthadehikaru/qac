<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use QCod\ImageUp\HasImageUploads;

class Ecourse extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $autoUploadImages = true;
    
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 1024,
            'height' => 683,
            'crop' => false,
            'disk' => 'public',
            'path' => 'ecourses',
            'placeholder' => '/event qac.jpg',
            'rules' => 'image|max:2000',
        ],
    ];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function getPublishedAttribute()
    {
        return $this->published_at;
    }

    public function getPriceFormatAttribute()
    {
        return 'Rp. '.number_format($this->price,0,",",".").",-";
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
