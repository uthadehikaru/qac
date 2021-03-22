<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Event extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'views',
        'event_at',
        'is_public',
    ];
    
    protected $casts = [
        'event_at' => 'date:Y-m-d H:i:s',
    ];

    protected $autoUploadImages = true;
    
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 400,
            'height' => 400,
            'crop' => true,
            'disk' => 'public',
            'path' => 'events',
            'placeholder' => '/event qac.jpg',
            'rules' => 'image|max:2000',
        ],
    ];

    public function scopeIncoming($query)
    {
        return $query->where('event_at', '>=', date('Y-m-d'));
    }
}
