<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use QCod\ImageUp\HasImageUploads;

class Event extends Model
{
    use HasFactory;
    use HasImageUploads;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'views',
        'event_at',
        'is_public',
        'course_id',
        'attachment',
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

    protected static $fileFields = [
        'attachment' => [
            'disk' => 'public',
            'path' => 'events',
            'rules' => 'mimes:pdf|max:10000',
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

    public function isAvailable()
    {
        return $this->event_at->isFuture();
    }

    public function isAllowed($user)
    {
        if ($user->role == 'admin') {
            return true;
        }

        if ($user->member && $this->course_id > 0) {
            return DB::table('member_batch')
                ->whereRaw('member_batch.member_id='.$user->member->id." AND member_batch.status>=".MemberBatch::STATUS_PAID." AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$this->course_id.')')
                ->exists();
        }

        return false;
    }

    protected function attachmentUploadFilePath($file)
    {
        return $this->slug.'.'.$file->getClientOriginalExtension();
    }
}
