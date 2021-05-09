<?php

namespace App\Http\Controllers;

use App\ContactUs;
use App\Rules\NameValidate;
use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\Rules\WordCountRule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.contact_us');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', new NameValidate, 'min:3'],
            'email' => 'required|email',
            'contact' => ['required','numeric', 'regex:/(01)[0-9]{9}/', new PhoneMinLength , new PhoneMaxLength],
            'message' => ['required', 'string', new WordCountRule('Message body', 6, 200)],
            'user_id' => 'nullable',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at-least 3 letters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be an email.',

            'contact.required' => 'Contact is required.',
            'contact.numeric' => 'Contact must be numeric.',

            'message.required' => 'Message is required.',
        ]);

        if($request->user_id == null){
            $User_id = 0;
        }else{
            $User_id = decrypt($request->user_id);
        }

        if(str_word_count($request->message) > 200){
            return back()->withErrors('Error', 'Contact message must be under 200 words.');
        }
        else{
            ContactUs::Insert([
                'name' => ucwords($request->name),
                'email' => $request->email,
                'phone' => $request->contact,
                'message' => ucfirst($request->message),
                'user_id' => $User_id,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('Success', 'Your message was received. We will reply soon in your email.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
