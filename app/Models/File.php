<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class File extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $fillable = [
        'name',
        'type',
        'filename',
        'size',
        'tablename',
        'record_id',
    ];

    protected static $fileFields  = [
        'filename' => [
            'disk' => 'public',
            'path' => 'files',
            'rules' => 'mimes:jpg,jpeg,png,pdf,mp4',
        ],
    ];
}