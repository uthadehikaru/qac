<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;

class Lesson extends Model
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

    public function ecourse()
    {
        return $this->belongsTo(Ecourse::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function file()
    {
        return $this->hasOne(File::class,'record_id')->where('tablename','lessons');
    }
}
