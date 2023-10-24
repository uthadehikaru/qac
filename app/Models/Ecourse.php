<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Ecourse extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $guarded = [];

    protected $autoUploadImages = true;
    
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 400,
            'height' => 400,
            'crop' => true,
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
}
