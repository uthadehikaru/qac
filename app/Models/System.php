<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class System extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'key',
        'value',
        'is_array',
    ];

    public static function value($key, $default = null)
    {
        $system = System::where('key', $key)->first();
        if ($system) {
            return $system->value;
        }

        return $default;
    }

    public function getValueAttribute($value)
    {
        if ($this->is_array) {
            return json_decode($value);
        }

        return $value;
    }
}
