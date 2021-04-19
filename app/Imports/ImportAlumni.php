<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use App\Models\User;
use App\Models\Member;
use App\Models\Batch;
use Str;
use Hash;

class ImportAlumni implements ToCollection, WithProgressBar
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row[2]=='' || $row[5]=='')
                continue;
            
            if(User::where('email',$row[2])->exists())
                $row[2] = $row[5].".".$row[2];
            
            $user = User::create([
                'name' => $row[1],
                'email' => $row[2],
                'password' => Hash::make(Str::random(8)),
            ]);

            $member = Member::create([
                'user_id' => $user->id,
                'full_name' => $row[1],
                'phone' => $row[5],
                'address' => $row[4],
                'gender'=>$row[3],
            ]);

            $batch = Batch::where('name',$row[8])
            ->where('course_id',1)->first();
            if($batch){
                $member->batches()->attach($batch->id,['status'=>6]);
            }

            $batch = Batch::where('name',$row[7])
            ->where('course_id',2)->first();
            if($batch){
                $member->batches()->attach($batch->id,['status'=>6]);
            }

            $batch = Batch::where('name',$row[6])
            ->where('course_id',3)->first();
            if($batch){
                $member->batches()->attach($batch->id,['status'=>6]);
            }
        }
    }
}
