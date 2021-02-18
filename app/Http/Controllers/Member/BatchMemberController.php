<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MemberBatch;
use App\Models\Member;
use DataTables;
use Auth;

class BatchMemberController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::where('user_id',Auth::id())->first();
        if ($request->ajax()) {
            $data = MemberBatch::select('*')->where('member_id',$member->id);
            return Datatables::of($data)
                    ->addColumn('batch_id', function($row){
                        return $row->batch->name;
                    })
                    ->editColumn('approved_at',function($row){
                        return $row->approved_at?'Approved at '.$row->approved_at->format('d-M-Y H:i'):'Not Approved';
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['member'] = $member;
        return view('member/batch-member-list', $data);
    }
}
