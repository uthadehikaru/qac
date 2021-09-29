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
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Carbon\Carbon;
use DataTables;
use Validator;
use DB;
use Image;
use Str;

class MemberBatchController extends Controller
{
    public function index(MemberBatchDataTable $dataTable, $course_id, $batch_id)
    {
        $batch = Batch::with('members')->find($batch_id);
        $data['title'] = 'Data Anggota - <a href="'.route('admin.courses.batches.index', $batch->course_id).'" class="pointer text-blue-500">Angkatan '.$batch->full_name.'</a>';
        $data['button'] = '';

        if($batch->members()->where('member_batch.status',3)->count()>0)
            $data['button'] .= '<a class="ml-3 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.courses.batches.members.label', [$course_id, $batch_id]).'" target="_blank">Print Label</a>';
        if($batch->members()->where('member_batch.status',6)->count()>0 && $batch->certificate_id>0)
            $data['button'] .= '<a class="ml-3 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.courses.batches.members.certificates', [$course_id, $batch_id]).'">Create Certificates</a>';
        if($batch->members()->where('member_batch.status',1)->count()>0 && Carbon::now()->greaterThanOrEqualTo($batch->start_at))
            $data['button'] .= '<a class="ml-3 inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.courses.batches.members.waitinglist', [$course_id, $batch_id]).'">Proses Waiting List</a>';
        
        $dataTable->setBatch($batch_id);

        $data['statuses'] = MemberBatch::statuses;
        $data['batch'] = $batch;
        return $dataTable->render('admin.batch-member-datatable', $data);
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
        $data['statuses'] = MemberBatch::statuses;
        $data['sessions'] = $batch->sessions!=''?explode(',',$batch->sessions):[];
        $data['members'] = Member::whereNotExists(function($query)use($batch_id)
            {
                $query->select(DB::raw(1))
                    ->from('member_batch')
                    ->whereRaw('member_batch.member_id=members.id and member_batch.batch_id='.$batch_id);
            })->orderBy('full_name')->get();
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
        $data['statuses'] = MemberBatch::statuses;
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

    public function certificates($course_id, $batch_id, $regenerate=false)
    {
        $batch = Batch::find($batch_id);
        $memberBatches = MemberBatch::where('batch_id',$batch_id)->get();
        $template = $batch->certificate;
        
        foreach($memberBatches as $memberBatch)
        {
            if($memberBatch->status==6 && (!$memberBatch->file || $regenerate)){
                $this->generateCertificate($template, $memberBatch);
            }
        }

        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Certificates created');
    }

    public function regenerateCertificates($course_id, $batch_id)
    {
        return $this->certificates($course_id, $batch_id, true);
    }

    public function certificate($course_id, $batch_id, $member_batch_id)
    {
        $batch = Batch::find($batch_id);
        $memberBatch = MemberBatch::find($member_batch_id);
        $template = $batch->certificate;
        return $this->generateCertificate($template, $memberBatch, true);
    }

    private function generateCertificate(Certificate $template, MemberBatch $memberBatch, $preview=false)
    {
        $name = "certificate ".$memberBatch->batch->full_name."-".$memberBatch->member->full_name."-".$memberBatch->member->id;
        $config = json_decode($template->config, true);

        $certificate = Image::make(storage_path('app/public/'.$template->template))
        ->resize($config['sertifikat']['width'], $config['sertifikat']['height']);

        if(isset($config['nama_anggota'])){
            $certificate->text(Str::title($memberBatch->member->full_name), $config['nama_anggota']['position_x'],$config['nama_anggota']['position_y'], function($font) use($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['nama_anggota']['font_size']);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }

        if(!$memberBatch->member_batch_uu){
            $memberBatch->member_batch_uu = Str::random(10);
            $memberBatch->save();
        }

        if(isset($config['qrcode'])){
            $qr = QrCode::create(route('certificate',$memberBatch->member_batch_uu))->setSize(150);
            $writer = new PngWriter();
            $result = $writer->write($qr);
            $certificate->insert($result->getString(), $config['qrcode']['position'], $config['qrcode']['position_x'],$config['qrcode']['position_y']);
        }

        
        if(isset($config['unique_code'])){
            $certificate->text($memberBatch->member_batch_uu, $config['unique_code']['position_x'],$config['unique_code']['position_y'], function($font) use($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['unique_code']['font_size']);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
            });
        }

        if(isset($config['footer'])){
            $certificate->text("*scan barcode untuk verifikasi keaslian sertifikat", $config['footer']['position_x'],$config['footer']['position_y'], function($font) use($config) {
                $font->file(public_path('Roboto-Regular.ttf'));
                $font->size($config['footer']['font_size']);
                $font->color('#000000');
                $font->align('left');
                $font->valign('bottom');
            });;
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

        if($preview)
            return $certificate->response('png');

    }

    public function label($course_id, $batch_id)
    {
        $data['batch'] = Batch::with(['members'=>function($query){
            return $query->where('member_batch.status',3);
        }])->find($batch_id);
        return view('admin.batch-member-label', $data);
    }

    public function updateStatus($course_id, $batch_id, $id, $status)
    {
        $memberBatch = MemberBatch::find($id);
        $memberBatch->status=$status;
        $memberBatch->save();
        $memberBatch->member->user->notify(new BatchStatusUpdate($memberBatch));
        return back()->with('status','Berhasil memperbaharui status');
    }

    public function updateStatuses(Request $request, $course_id, $batch_id)
    {
        $request->validate([
            'members' => 'required',
            'status_id'=>'required',
        ]);

        $ids = trim($request->members,",");
        $status_id = $request->status_id;

        $memberBatches = MemberBatch::whereRaw("id in (".$ids.")")->get();
        $count = 0;
        foreach($memberBatches as $memberBatch){
            if($memberBatch->status==$status_id)
                continue;
            
            $memberBatch->status=$status_id;
            $memberBatch->save();
            $memberBatch->member->user->notify(new BatchStatusUpdate($memberBatch));
            $count++;
        }

        return back()->with('status','Berhasil memperbaharui status '.$count.' peserta');
    }

    public function waitinglist($course_id, $batch_id)
    {
        $batch = Batch::find($batch_id);
        $memberBatches = MemberBatch::where('batch_id',$batch_id)->get();
        
        $count = 0;
        foreach($memberBatches as $memberBatch)
        {
            if($memberBatch->status==1){
                $memberBatch->status=0;
                $memberBatch->save();
                $memberBatch->member->courses()->attach($course_id);
                $count++;
            }
        }

        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Process waiting list done. '.$count.' added to waiting list');
    }
}
