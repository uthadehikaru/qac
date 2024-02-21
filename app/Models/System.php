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

    static function value($key)
    {
        $system = System::where('key',$key)->first();
        if($system)
            return $system->value;

        return null;
    }

    public function getValueAttribute($value)
    {
        if($this->is_array)
            return json_decode($value);

        return $value;
    }
}
