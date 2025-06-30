<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function scopeRecomendation(Builder $query): void
    {
        $query->whereNotNull('recomendation')
        ->orderBy('recomendation', 'asc');
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at');
    }

    public function scopeSubscriber(Builder $query): void
    {
        $query->where('is_only_active_batch', 0);
    }

    public function scopeBatch(Builder $query): void
    {
        $query->where('is_only_active_batch', 1);
    }

    public function scopeCourse(Builder $query): void
    {
        $query->whereNotNull('course_id');
    }

    public function getPublishedAttribute()
    {
        return $this->published_at;
    }

    public function getPriceFormatAttribute()
    {
        return 'Rp. '.number_format($this->price, 0, ',', '.').',-';
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
