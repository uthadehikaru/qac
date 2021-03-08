<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberBatch;
use App\Models\Batch;
use App\Models\Member;
use App\Models\File;
use App\Notifications\BatchApproval;
use App\Notifications\BatchStatusUpdate;
use DataTables;
use Validator;
use DB;
use Carbon\Carbon;

class MemberBatchController extends Controller
{
    public function index(Request $request, $course_id, $batch_id)
    {
        if ($request->ajax()) {
            $data = MemberBatch::select('*')->where('batch_id',$batch_id);
            return Datatables::of($data)
                    ->addColumn('name', function($row){
                        return $row->member->full_name.' ('.$row->member->name.')';
                    })
                    ->editColumn('status',function($row){
                        return __('batch.status_'.$row->status);
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route('admin.members.show', $row->member_id).'" class="text-blue-500">Detail</a>';
                        $btn .= '<a href="'.route('admin.courses.batches.members.edit', ['course'=>$row->batch->course_id,'batch'=>$row->batch_id,'id'=>$row->id]).'" class="ml-3 text-green-500">Edit</a>';
                        $btn .= '<a href="#" id="delete-'.$row->id.'" data-id="'.$row->id.'" class="delete ml-3 text-red-500">Delete</a>';
                        if($row->file)
                        $btn .= '<a href="'.$row->file->fileUrl('filename').'" class="ml-3 text-green-500">Sertifikat</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['batch'] = Batch::find($batch_id);
        return view('admin/batch-member-list', $data);
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courses.batches.members.create', [$course_id, $batch_id])
            ->withErrors($validator)
            ->withInput();
        }

        $additional = [
            'session'=>$request->session,
            'status'=>$request->status,
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
}
