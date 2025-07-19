<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Ecourse;
use App\Models\Member;
use App\Models\MemberBatch;
use Auth;
use DataTables;
use Illuminate\Http\Request;

class BatchMemberController extends Controller
{
    public function index(Request $request)
    {
        $member = Member::where('user_id', Auth::id())->first();
        if ($request->ajax()) {
            $data = MemberBatch::select('*')->where('member_id', $member->id);

            return Datatables::of($data)
                ->addColumn('batch_id', function ($row) {
                    $value = $row->batch->full_name;
                    if ($row->session) {
                        $value .= ' '.$row->session;
                    }

                    return $value;
                })
                ->editColumn('approved_at', function ($row) {
                    return $row->approved_at ? 'Approved at '.$row->approved_at->format('d-M-Y H:i') : 'Not Approved';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('member.batches.detail', $row->id).'" class="text-blue-500 pointer">Detail</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['member'] = $member;

        return view('member/batch-member-list', $data);
    }

    public function detail($member_batch_id)
    {
        $batchMember = MemberBatch::with(['batch.file', 'file'])->find($member_batch_id);

        if (! $batchMember) {
            abort(404);
        }

        $ecourse = Ecourse::where('course_id', $batchMember->batch->course_id)
        ->where('is_only_active_batch', true)
        ->first();
        
        if (!$ecourse) {
            return redirect()->back()->with('error', 'Anda belum dapat mengakses kelas ini. Silahkan hubungi admin.');
        }

        return redirect()->route('member.ecourses.lessons', $ecourse->slug);
    }
}
