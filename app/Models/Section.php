<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use QCod\ImageUp\HasImageUploads;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    use HasImageUploads;
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 1024,
            'height' => 683,
            'crop' => false,
            'disk' => 'public',
            'path' => 'lessons',
            'placeholder' => '/event qac.jpg',
            'rules' => 'image|max:2000',
        ],
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
