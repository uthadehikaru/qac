<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;
use DB;

class Event extends Model
{
    use HasFactory;
    use HasImageUploads;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'views',
        'event_at',
        'is_public',
        'course_id',
    ];
    
    protected $casts = [
        'event_at' => 'date:Y-m-d H:i:s',
    ];

    protected $autoUploadImages = true;
    
    protected static $imageFields = [
        'thumbnail' => [
            'width' => 400,
            'height' => 400,
            'crop' => true,
            'disk' => 'public',
            'path' => 'events',
            'placeholder' => '/event qac.jpg',
            'rules' => 'image|max:2000',
        ],
    ];
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeIncoming($query)
    {
        return $query->where('event_at', '>=', date('Y-m-d'));
    }

    public function isAllowed($user)
    {
        if($user->role=='admin')
            return true;
        
        if($user->member && $this->course_id>0)
            return DB::table('member_batch')
            ->whereRaw("member_batch.member_id=".$user->member->id." AND member_batch.status='6' AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$this->course_id.")" )
            ->exists();

        return false;
    }
}
