<?php

namespace App\Services;

use App\Models\Ecourse;
use App\Models\File;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EcourseService {

    public function latestEcourses($limit=8)
    {
        return Ecourse::published()->latest()->take($limit)->get();
    }

    public function publishedEcourses()
    {
        return Ecourse::published()->latest()->paginate(6);
    }

    public function updateOrCreate($data): Ecourse
    {
        $data['slug'] = Str::slug($data['title']);
        return Ecourse::create($data);
    }

    public function find($id): Ecourse
    {
        return Ecourse::find($id);
    }

    public function findBySlug($slug): Ecourse
    {
        return Ecourse::where('slug',$slug)->first();
    }

    public function getSections()
    {
        return Section::all();
    }

    public function getLesson($id): Lesson
    {
        return Lesson::find($id);
    }

    public function updateOrCreateLesson($data): Lesson
    {
        $lesson = null;

        if($data['id']){
            $lesson = Lesson::find($data['id']);
            $lesson->update($data);
        }else{
            $data['lesson_uu'] = Str::uuid();
            $lesson = Lesson::create($data);
        }

        return $lesson;
    }

    public function updateOrCreateSubscription($data): Subscription
    {
        $subscription = null;

        if($data['id']){
            $subscription = Subscription::find($data['id']);
            $subscription->update($data);
        }else{
            $subscription = Subscription::create($data);
        }

        return $subscription;
    }

    public function uploadFile($lesson, $file)
    {
        return File::create([
            'name'=>$lesson->subject,
            'filename'=>$file->getClientOriginalName(),
            'tablename'=>'lessons',
            'record_id'=>$lesson->id,
            'type'=>$file->getClientOriginalExtension(),
            'size'=>$file->getSize(),
        ]);
    }

    public function memberEcourses($member_id)
    {
        return Ecourse::whereRelation('subscribers','member_id',$member_id)->get();
    }
}