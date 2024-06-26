<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use QCod\ImageUp\HasImageUploads;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    public function ecourse(): BelongsTo
    {
        return $this->belongsTo(Ecourse::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function completed(): HasMany
    {
        return $this->hasMany(CompletedLesson::class);
    }

    public function file()
    {
        return $this->hasOne(File::class, 'record_id')->where('tablename', 'lessons');
    }

    public function isCompleted($member_id)
    {
        return $this->completed()->where('member_id', $member_id)->exists();
    }
}
