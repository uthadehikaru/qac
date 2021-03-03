<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberBatch;
use App\Models\Batch;
use App\Models\Member;
use App\Notifications\BatchApproval;
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
                        $btn .= '<a href="'.route('admin.courses.batches.members.approve', ['course'=>$row->batch->course_id,'batch'=>$row->batch_id,'id'=>$row->id]).'" class="ml-3 text-green-500">'.($row->approved_at?'Unapprove':'Approve').'</a>';
                        $btn .= '<a href="#" id="delete-'.$row->id.'" data-id="'.$row->id.'" class="delete ml-3 text-red-500">Delete</a>';
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
        $data['batch'] = Batch::find($batch_id);

        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'session' => '',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.courses.batches.members.create', [$course_id, $batch_id])
            ->withErrors($validator)
            ->withInput();
        }

        $memberBatch = MemberBatch::create([
            'batch_id'=>$batch_id,
            'member_id'=>$request->member_id,
            'session'=>$request->session,
        ]);
        return redirect()->route('admin.courses.batches.members', [$course_id, $batch_id])
            ->with('status','Member added');
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
