<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Banner extends Model
{
    use HasFactory, HasImageUploads;

    protected $guarded = [];

    protected static $fileFields  = [
        'image' => [
            'disk' => 'public',
            'path' => 'banners',
            'rules' => 'mimes:jpg,jpeg,png|max:2000',
            'height' => 500,
        ],
    ];
}
