<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberBatch;
use App\Models\Batch;
use DataTables;
use Carbon\Carbon;

class MemberBatchController extends Controller
{
    public function index(Request $request, $course_id, $batch_id)
    {
        if ($request->ajax()) {
            $data = MemberBatch::select('*')->where('batch_id',$batch_id);
            return Datatables::of($data)
                    ->addColumn('name', function($row){
                        return $row->member->name;
                    })
                    ->editColumn('approved_at',function($row){
                        return $row->approved_at?'Approved at '.$row->approved_at->format('d-M-Y H:i'):'Not Approved';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route('admin.members.show', $row->member_id).'" class="text-blue-500">Detail</a>';
                            $btn .= '<a href="'.route('admin.courses.batches.members.update', ['course'=>$row->batch->course_id,'batch'=>$row->batch_id,'id'=>$row->id]).'" class="ml-3 text-yellow-500">'.($row->approved_at?'Unapprove':'Approve').'</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['batch'] = Batch::find($batch_id);
        return view('admin/batch-member-list', $data);
    }

    public function update(Request $request, $batch_id, $id)
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
                return back()->with('status','Member Approved');
            }
        }
    }
}
