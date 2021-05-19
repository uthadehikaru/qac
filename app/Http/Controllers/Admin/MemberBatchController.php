<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\MemberBatch;
use App\Models\Batch;
use App\Models\Member;
use App\Models\File;
use App\Notifications\BatchApproval;
use App\Notifications\BatchStatusUpdate;
use App\DataTables\MemberBatchDataTable;
use Carbon\Carbon;
use DataTables;
use Validator;
use DB;
use Image;

class MemberBatchController extends Controller
{
    public function index(MemberBatchDataTable $dataTable, $course_id, $batch_id)
    {
        $batch = Batch::find($batch_id);
        $data['title'] = 'Data Anggota - <a href="'.route('admin.courses.batches.index', $batch->course_id).'" class="pointer text-blue-500">Angkatan '.$batch->full_name.'</a>';
        if($batch->certificate_id>0)
            $data['button'] = '<a class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.courses.batches.members.certificates', [$course_id, $batch_id]).'" class="float-right">Create Certificates</a>';
        $dataTable->setBatch($batch_id);
        return $dataTable->render('admin.datatable', $data);
    }

    public function approve(Request $request, $course_id, $batch_id, $id)
    {
        $memberBatch = MemberBatch::find($id);

        if($memberBatch){
            if($memberBatch->approved_at){
                $memberBatch->approved_at = null;
                $memberBatch->save();
                return back()->with('status','Member Unapproved');
            }else{
                $memberBatch->approved_at = Carbon::now();
                $memberBatch->save();
                $memberBatch->member->user->notify(new BatchApproval($memberBatch));
                return back()->with('status','Member Approved');
            }
        }
    }

    public function create(Request $request, $course_id, $batch_id)
    {
        $data['batchMember'] = null;
        $batch = Batch::find($batch_id);
        $data['batch'] = $batch;
        $data['sessions'] = $batch->sessions!=''?explode(',',$batch->sessions):[];
        $data['members'] = Member::whereNotExists(function($query)use($batch_id)
            {
                $query->select(DB::raw(1))
                    ->from('member_batch')
                    ->whereRaw('member_batch.member_id=members.id and member_batch.batch_id='.$batch_id);
            })->get();
        return view('admin.batch-member-form', $data);
    }

    public function store(Request $request, $course_id, $batch_id)
    {
        $batch = Batch::find($batch_id);

        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'session' => '',
            'status' => 'required',
            'note'=>'',
            'testimonial'=>'',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courses.batches.members.create', [$course_id, $batch_id])
            ->withErrors($validator)
            ->withInput();
        }

        $additional = [
            'session'=>$request->session,
            'status'=>$request->status,
            'note'=>$request->note,
            'testimonial'=>$request->testimonial,
        ];
        $batch->members()->attach($request->member_id, $additional);

        $member = $batch->members()->where('member_id',$request->member_id)->first();
        if($request->hasFile('filename')){
            $file = File::create([
                'name'=>'Sertifikat '.$member->name.' '.$batch->full_name,
                'filename'=>$request->file('filename')->getClientOriginalName(),
                'tablename'=>'member_batch',
                'record_id'=>$member->pivot->id,
                'type'=>$request->file('filename')->getClientOriginalExtension(),
                'size'=>$request->file('filename')->getSize(),
            ]);
        }
        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Member added');
    }

    public function edit(Request $request, $course_id, $batch_id, $id)
    {
        $batchMember = MemberBatch::find($id);
        $data['batchMember'] = $batchMember;
        $batch = Batch::find($batch_id);
        $data['batch'] = $batch;
        $data['sessions'] = $batch->sessions!=''?explode(',',$batch->sessions):[];
        return view('admin.batch-member-form', $data);
    }

    public function update(Request $request, $course_id, $batch_id, $id)
    {
        $data['batch'] = Batch::find($batch_id);

        $validator = Validator::make($request->all(), [
            'session' => '',
            'status' => 'required',
            'note'=>'',
            'testimonial'=>'',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courses.batches.members.edit', [$course_id, $batch_id, $id])
            ->withErrors($validator)
            ->withInput();
        }

        $memberBatch = MemberBatch::find($id);
        $data = [
            'session'=>$request->session,
            'status'=>$request->status,
            'note'=>$request->note,
            'testimonial'=>$request->testimonial,
        ];
        if($request->status==6)
            $data['approved_at'] = Carbon::now();
        else
            $data['approved_at'] = null;
        
        $memberBatch->update($data);
        if($memberBatch->wasChanged('status'))
            $memberBatch->member->user->notify(new BatchStatusUpdate($memberBatch));

        if($request->hasFile('filename')){
            $file = $memberBatch->file;
            if($file){
                $file->deleteFile($file->filename);
                $file->update([
                    'type'=>$request->file('filename')->getClientOriginalExtension(),
                    'size'=>$request->file('filename')->getSize(),
                ]);
            }else{
                $file = File::create([
                    'name'=>'Sertifikat '.$memberBatch->member->name.' '.$memberBatch->batch->full_name,
                    'filename'=>$request->file('filename')->getClientOriginalName(),
                    'tablename'=>'member_batch',
                    'record_id'=>$memberBatch->id,
                    'type'=>$request->file('filename')->getClientOriginalExtension(),
                    'size'=>$request->file('filename')->getSize(),
                ]);
            }
        }
        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Member updated');
    }

    public function destroy($course_id, $batch_id, $id)
    {
        $memberBatch = MemberBatch::find($id);
        
        if($memberBatch){
            $memberBatch->delete();
            return response()->json(['status'=>'Deleted successfully']);
        }else
            return response()->json(['status'=>'No Member Batch Found for id '.$id], 404);
    }

    public function certificates($course_id, $batch_id)
    {
        $batch = Batch::find($batch_id);
        $memberBatches = MemberBatch::where('batch_id',$batch_id)->get();
        $template = $batch->certificate;
        
        foreach($memberBatches as $memberBatch)
        {
            if($memberBatch->status==6 && !$memberBatch->file){
                $this->generateCertificate($template, $memberBatch);
            }
        }

        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Certificates created');
    }

    private function generateCertificate(Certificate $template, MemberBatch $memberBatch)
    {
        $name = "certificate ".$memberBatch->batch->full_name."-".$memberBatch->member->full_name."-".$memberBatch->member->id;
        $config = json_decode($template->config, true);

        $certificate = Image::make(storage_path('app/public/'.$template->template))
        ->resize(1200, 800);
        if(isset($config['nama_anggota'])){
            $certificate->text($memberBatch->member->full_name, $config['nama_anggota']['position_x'], $config['nama_anggota']['position_y'], function($font) use($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['nama_anggota']['font_size']);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }

        $filepath = 'files/'.$name.'.jpg';
        $certificate->save(storage_path('app/public/'.$filepath), 90, 'jpg');

        $file = File::create([
            'name'=>$name,
            'filename'=>$filepath,
            'tablename'=>'member_batch',
            'record_id'=>$memberBatch->id,
            'type'=>'jpg',
            'size'=>0,
        ]);
    }
}
