<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'gender',
        'address',
        'city',
        'instagram',
        'profesi',
        'pendidikan',
        'village_id',
        'zipcode',
        'is_overseas',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'is_overseas' => 'boolean',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($member) { 
             $member->batches()->detach();
             $member->queues()->delete();
        });
    }

    public function isCompleted()
    {
        return $this->phone && $this->gender && $this->address;
    }

    public function getNameAttribute($value)
    {
        return $this->user?$this->user->name:'';
    }

    public function getEmailAttribute($value)
    {
        return $this->user?$this->user->email:'';
    }

    public function getAddressDetailAttribute($value)
    {
        $address = $this->address;

        if($this->village_id>0){
            $data = DB::table('villages')
                ->select('provinces.name as province','regencies.name as regency','districts.name as district','villages.name as village')
                ->join('districts','districts.id','villages.district_id')
                ->join('regencies','regencies.id','districts.regency_id')
                ->join('provinces','provinces.id','regencies.province_id')
                ->where('villages.id',$this->village_id)
                ->first();
            if($data){
                $address .= ". ".$data->province.', '.$data->regency.', '.$data->district.', '.$data->village;
            }
        }

        if($this->zipcode!='')
            $address .= " ".$this->zipcode;

        return $address;
    }

    public function setPhoneAttribute($value)
    {
        $phone = $value;
        $prefix = substr($phone,0,1);
        if ($prefix=='+')
            $phone = substr($phone,1,strlen($phone));
            
        $prefix = substr($phone,0,1);
        if ($prefix=='0')
            $phone = "62".substr($phone,1,strlen($phone));
        $this->attributes['phone'] = $phone;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProvinceAttribute()
    {
        if($this->village_id){
            $province = DB::table('villages')
            ->join('districts', 'districts.id', '=', 'villages.district_id')
            ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
            ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
            ->where('villages.id', $this->village_id)
            ->selectRaw('provinces.*')
            ->first();

            return $province->name;
        }
        
        return $this->city;
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class,'member_batch')->withPivot('id','session', 'status')->using(MemberBatch::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'queues')->withTimestamps()->using(Queue::class);
    }

    public function level()
    {
        return DB::table('member_batch')
        ->join('batches', 'batches.id', '=', 'member_batch.batch_id')
        ->join('courses', 'courses.id', '=', 'batches.course_id')
        ->where('member_batch.member_id',$this->id)
        ->where('member_batch.status','6')
        ->max('courses.level');
    }
}
