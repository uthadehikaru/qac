<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'slug',
    ];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
