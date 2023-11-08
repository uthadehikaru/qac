<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    use HasImageUploads;
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 800,
            'height' => 600,
            'crop' => true,
            'disk' => 'public',
            'path' => 'lessons',
            'placeholder' => '/event qac.jpg',
            'rules' => 'image|max:2000',
        ],
    ];
}
