<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'is_array',
    ];

    public function getValueAttribute($value)
    {
        if($this->is_array)
            return json_decode($value);

        return $value;
    }
}
