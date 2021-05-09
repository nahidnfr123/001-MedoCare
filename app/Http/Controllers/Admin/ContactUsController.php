<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use App\Mail\SendEmail;
use App\Mail\SendEmailMarkDown;
use App\Rules\WordCountRule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$MessageCount = count(ContactUs::where('seen', '=', '0')->get());*/
        /*$Count_Msg = $this->Count_Message();*/
        $Messages = ContactUs::orderBy('created_at', 'DESC')->paginate(15);
        return view('admin.contact.contact-us', compact('Messages'));
    }

    public function trashMessage()
    {
        $MessageCount = count(ContactUs::where('seen', '=', '0')->get());
        //$Messages = ContactUs::orderBy('created_at', 'DESC')->paginate(15);
        $Deleted_Messages = ContactUs::orderBy('id', 'DESC')->onlyTrashed()->paginate(15);
        return view('admin.contact.contact-us_trash', compact('Deleted_Messages', 'MessageCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() // this displays the send email form ...
    {
        $MessageCount = count(ContactUs::where('seen', '=', '0')->get());
        return view('admin.contact.send-mail', compact('MessageCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404

        ContactUs::findOrFail($id)->update([
            'seen' => 1,
            'updated_at' => Carbon::now(),
        ]);
        //$MessageCount = count(ContactUs::where('seen', '=', '0')->get());
        $Message = ContactUs::findOrFail($id);
        $FindUser = User::where('email', '=', $Message->email)->first();
        return view('admin.contact.contact-us_details', compact('Message', 'FindUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }



    public function multipleDelete(Request $request)
    {
        $Id_array = $request->input('id');
        $Message = ContactUs::whereIn('id', $Id_array);
        if($Message->delete()){
            echo 'Message successfully deleted.';
        }
    }


    public function delete($id)
    {
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        ContactUs::withoutTrashed()->findOrFail($id)->delete();
        return redirect()->route('admin.inbox')->with('Success', 'Message successfully deleted.');
    }

    // Restore deleted blog ...
    public function restore(Request $request){
        $Id_array = $request->input('id');
        $Message = ContactUs::onlyTrashed()->whereIn('id', $Id_array);
        if($Message->restore()){
            echo 'Message successfully restored.';
        }
    }


    public function multipleDestroy(Request $request)
    {
        $Id_array = $request->input('id');
        $Message = ContactUs::whereIn('id', $Id_array);
        if($Message->forceDelete()){
            echo 'Message successfully deleted.';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function sendEmail(Request $request){
        Session::flash('Error_sending_Email', 'Create Error.');
        $request->validate([
            'email' => 'required|email',
            'message_subject' => 'required|',
            'message_body' => ['required', new WordCountRule('Message body', 20, 200)],
            'received_message' => 'required|',
            'name' => 'required|',
        ],[
            'email.required' => 'Recipient email is required.',
            'email.email' => 'Recipient email must be a email.',

            'message_subject.required' => 'Email subject is required.',

            'message_body.required' => 'Message body is required.',
            'received_message.required' => 'Message body is required.',
        ]);

        if(str_word_count($request->message_subject) > 50){
            return back()->with('Error', 'Message subject should be less then 50 words.');
        }
        if(str_word_count($request->message_body) > 500){
            return back()->with('Error', 'Message body should be less then 500 words.');
        }

        if(!empty($request->id)){
            //$id = decrypt($request->id);
            $id = $this->decryptID($request->id); // Perform decryption If not successful then redirect to 404
            ContactUs::findOrFail($id)->update([
                'replied' => 1,
            ]);
        }

        $data = array(
            'email' => $request->email,
            'message_subject' => ucfirst($request->message_subject),
            'message_body' => ucfirst($request->message_body),
            'received_message' => ucfirst(decrypt($request->received_message)),
            'name' => ucfirst(decrypt($request->name)),
        );

        Mail::to($request->email)->send(new SendEmailMarkDown($data));

        Session::forget('Error_sending_Email');
        return back()->with('Success', 'Email successfully sent.');
    }




    // Send email to specific user email defined by the admin...
    public function sendEmailIntended(Request $request){
        Session::flash('Error_sending_Email', 'Create Error.');
        $request->validate([
            'email' => 'required|email',
            'message_subject' => ['required', new WordCountRule('Message body', 1, 50)],
            'message_body' => ['required', new WordCountRule('Message body', 20, 200)],
        ],[
            'email.required' => 'Recipient email is required.',
            'email.email' => 'Recipient email must be a email.',

            'message_subject.required' => 'Email subject is required.',

            'message_body.required' => 'Message body is required.',
        ]);
        $request->request->add(['name'=> 'there']);

        $data = array(
            'email' => $request->email,
            'message_subject' => ucfirst($request->message_subject),
            'message_body' => ucfirst($request->message_body),
            'name' => ucfirst($request->name),
        );

        Mail::to($request->email)->send(new SendEmail($data));

        Session::forget('Error_sending_Email');
        return back()->with('Success', 'Email successfully sent.');
    }





}
