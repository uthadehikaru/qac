<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_notify',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'login_at' => 'datetime',
    ];

    public static function admin()
    {
        return self::where('role', 'admin')->get();
    }

    public function scopeNotify($query)
    {
        return $query->where('is_notify', true);
    }

    public function getIsMemberAttribute($value)
    {
        return $this->role == 'member';
    }

    public function getIsAdminAttribute($value)
    {
        return $this->role == 'admin';
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
