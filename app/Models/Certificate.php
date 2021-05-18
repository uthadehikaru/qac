<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Certificate extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $fillable = [
        'name',
        'template',
        'config',
    ];

    protected static $fileFields  = [
        'template' => [
            'disk' => 'public',
            'path' => 'templates',
            'rules' => 'mimes:jpg,jpeg,png|max:2000',
        ],
    ];
}
