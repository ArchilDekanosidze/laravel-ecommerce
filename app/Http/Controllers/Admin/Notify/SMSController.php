<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Models\Notify\SMS;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sms = SMS::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.notify.smss.index', compact('sms'));
    }
    public function create()
    {
        return view('admin.notify.smss.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SMSRequest $request)
    {
        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $sms = SMS::create($inputs);
        return redirect()->route('admin.notify.smss.index')->with('swal-success', __('admin.New SMS has been successfully registered'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMS $sms)
    {
        return view('admin.notify.smss.edit', compact('sms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SMSRequest $request, SMS $sms)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int) $realTimestampStart);
        $sms->update($inputs);
        return redirect()->route('admin.notify.smss.index')->with('swal-success', __('admin.The SMS has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMS $sms)
    {
        $result = $sms->delete();
        return redirect()->route('admin.notify.smss.index')->with('swal-success', __('admin.The SMS has been successfully removed'));
    }

    public function status(SMS $sms)
    {

        $sms->status = $sms->status == 0 ? 1 : 0;
        $result = $sms->save();
        if ($result) {
            if ($sms->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
