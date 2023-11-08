<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriptionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Ecourse;
use App\Models\Member;
use App\Models\Subscription;
use App\Services\EcourseService;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionsDataTable $dataTable, string $ecourse_id)
    {
        $data['title'] = "Subscribers";
        $data['buttons'][] = [
            'name' => 'Back',
            'href' => route('admin.ecourses.index'),
        ];
        $dataTable->setEcourse($ecourse_id);
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $ecourse_id)
    {
        $data['ecourse'] = Ecourse::find($ecourse_id);
        $data['members'] = Member::select('id','full_name')->get();
        $data['subscription'] = null;
        return view('admin.subscription-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request, EcourseService $ecourseService, string $ecourse_id)
    {
        $data = $request->validated();
        $data['id'] = null;
        $data['ecourse_id'] = $ecourse_id;
        $ecourseService->updateOrCreateSubscription($data);
        return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('message','Data created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ecourse_id, string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $ecourse_id, string $id)
    {
        $data['ecourse'] = Ecourse::find($ecourse_id);
        $data['members'] = Member::select('id','full_name')->get();
        $data['subscription'] = Subscription::find($id);
        return view('admin.subscription-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, EcourseService $ecourseService, string $ecourse_id, string $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data['ecourse_id'] = $ecourse_id;
        $ecourseService->updateOrCreateSubscription($data);
        return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('message','Data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ecourse_id, string $id)
    {
        //
    }
}
