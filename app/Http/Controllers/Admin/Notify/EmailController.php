<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Models\Notify\Email;
use Illuminate\Http\Request;
use App\Jobs\SendEmailToUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */    
        
    public function index()
    {
        $emails = Email::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.notify.emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notify.emails.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $email = Email::create($inputs);
        return redirect()->route('admin.notify.emails.index')->with('swal-success', __('admin.New email has been successfully registered'));
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
    public function edit(Email $email)
    {
        return view('admin.notify.emails.edit', compact('email'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmailRequest $request, Email $email)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $email->update($inputs);
        return redirect()->route('admin.notify.emails.index')->with('swal-success', __('admin.The email has been successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        $result = $email->delete();
        return redirect()->route('admin.notify.emails.index')->with('swal-success', __('admin.The email has been successfully removed'));
    }


    public function status(Email $email){

        $email->status = $email->status == 0 ? 1 : 0;
        $result = $email->save();
        if($result){
                if($email->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }

    public function sendMail(Email $email)
    {
        SendEmailToUsers::dispatch($email);

        return back()->with('swal-success', __('admin.Your email has been sent successfully'));
    }

}
