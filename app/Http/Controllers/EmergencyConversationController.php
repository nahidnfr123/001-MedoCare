<?php

namespace App\Http\Controllers;

use App\AppointmentRequest;
use App\Consultation;
use App\Conversation;
use App\EmergencyConversation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Cookie;

class EmergencyConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return string
     */
    public function store(Request $request){
        if(Cookie::get('Token') == true) {
            if ($request->ajax()) {
                if ($request->has('Message') && $request->has('Token') && $request->has('Sender_id')) {
                    $App_Request = AppointmentRequest::where('token', '=', decrypt($request->Token))->first();
                    if ($App_Request !== null) {

                        //Get the Receiver id ...
                        if(auth()->check()){
                            if (Auth::user()->role()->pluck('name')->first() == 'Patient') {
                                $Receiver_id = $App_Request->doctor->user->id;

                            } elseif (Auth::user()->role()->pluck('name')->first() == 'Doctor') {
                                $Receiver_id = $App_Request->user_id;
                            }
                        }else{
                            $Receiver_id = $App_Request->doctor->user->id;
                        }

                        //return response($request->Sender_id . ' '. $App_Request->doctor->user->id);
                        EmergencyConversation::Insert([
                            'sender_id' => $request->Sender_id,
                            'receiver_id' => $Receiver_id,
                            'appointment_request_id' => $App_Request->id,
                            'conversation_text' => $request->Message,
                            'conversation_file' => null,
                            'seen' => 0,
                            'created_at' => Carbon::now(),
                        ]);
                        return response('inserted');
                    } else {
                        $Output = 'Unable to send message.';
                        return response($Output);
                    }
                } else {
                    $Output = 'Missing data';
                    return response($Output);
                }
            } else {
                return back()->with('Success', 'Fool!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmergencyConversation  $emergencyConversation
     * @return \Illuminate\Http\Response
     */
    public function show(EmergencyConversation $emergencyConversation)
    {
        //
    }





    // Patient can upload previous report ....
    public function reportHistory(Request $request){
        //dd($request->all());
        $Sender_id = $request->Sender_Id;
        $Token = decrypt($request->AppReq_Token);
        $App_Request = AppointmentRequest::where('token', '=', $Token)->first();
        if ($App_Request !== null) {

            //Get the Receiver id ...
            if(auth()->check()){
                if (Auth::user()->role()->pluck('name')->first() == 'Patient') {
                    $Receiver_id = $App_Request->doctor->user->id;

                } elseif (Auth::user()->role()->pluck('name')->first() == 'Doctor') {
                    $Receiver_id = $App_Request->user_id;
                }
            }else{
                $Receiver_id = $App_Request->doctor->user->id;
            }
            //dd($App_Request->user_id, $App_Request->doctor->user->id, $Sender_id, $Receiver_id);

            if ($request->hasFile('Report_file')) {
                $Full_name = $App_Request->id.'-EM';

                $get_image = $request->file('Report_file'); // get the image form post method...
                $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
                $extension = $get_image->getClientOriginalExtension();// get the file extension

                $allowed_Ext = array('jpg', 'jpeg', 'pdf', 'doc', 'docx');
                if (in_array(strtolower($extension), $allowed_Ext, true) == false) {
                    //return back()->withErrors('Error', 'Blog image can only contain jpg, jpeg and png file.');
                    $Output = 'Error uploading report';
                    return $Output;
                }
                $newFileName = $Full_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....

                $Location = '/public/user_data/patient/report/';
                $get_image->storeAs($Location, $newFileName); // set the storage path ...
                $StorageLink = $this->domain_image_url().'/storage/user_data/patient/report/' . $newFileName;
            } else {
                $StorageLink = '';
            }

            EmergencyConversation::Insert([
                'sender_id' => $Sender_id,
                'receiver_id' => $Receiver_id,
                'appointment_request_id' => $App_Request->id,
                'conversation_text' => null,
                'conversation_file' => $StorageLink,
                'seen' => 0,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->back();
        }
    }





    public function loaderAll(Request $request){
        if(Cookie::get('Token') == true) {
            if ($request->ajax()) {
                $Output = '';
                $Identity = '';
                if ($request->has('Token')) {
                    $Token = decrypt($request->Token);
                    $AppReq = AppointmentRequest::where('token', '=', $Token)->first();
                    $AppReq_Id = $AppReq->id;
                    if (Auth::check()) { /// User is logged in ....
                        if (Auth::user()->role()->pluck('name')->first() == 'Patient') {
                            $User_data = User::find(AppointmentRequest::find($AppReq_Id)->doctor->user->id); // Get doctor if patient is logged in
                        } elseif (Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor') {
                            $User_data = User::find(AppointmentRequest::find($AppReq_Id)->user_id); // Get patient if doctor is logged in
                        }
                        $SenderUser_id = Auth::id();
                        if ($User_data !== null) {
                            $Avatar = $User_data->avatar;
                            $Identity = $User_data->first_name . ' ' . $User_data->last_name;
                        } else {
                            $Avatar = '';
                            $Identity = $AppReq->phone;
                        }
                    } else { // User is not logged in ....
                        $User_data = User::find(AppointmentRequest::find($AppReq_Id)->doctor->user->id); // Get doctor if patient is not logged in
                        $SenderUser_id = 0;
                        $Avatar = '';
                        $Identity = $User_data->first_name . ' ' . $User_data->last_name;
                    }
                    $Conversation = EmergencyConversation::where('appointment_request_id', '=', $AppReq_Id)
                        /*->whereIn('sender_id', [Auth::id(), $User_data->id])->whereIn('receiver_id', [Auth::id(), $User_data->id])*/
                        ->orderBy('id', 'ASC')->orderBy('created_at', 'ASC')
                        ->get();
                    if (count($Conversation) > 0) {
                        foreach ($Conversation as $Conv) {
                            if ($Conv->conversation_file !== null) {
                                $Previous_Report = '<span class="text-white" style="color: white!important;"><b><a style="font-size: 12px;" href="' . $Conv->conversation_file . '" target="_blank">Report or Prescription .FILE</a></b></span>';
                            } else {
                                $Previous_Report = '';
                            }

                            if ($Conv->sender_id == $SenderUser_id) {
                                $Output .= '
                            <li style="position: relative;width: 100%; height: auto;padding: 0 6px;" class="m-t-6">
                                <div class="Msg_Sender float-right p-l-10 p-r-10" title="' . date('d.M.Y h:i a', strtotime($Conv->created_at)) . '">
                                    <b>You: </b> <span>' . htmlspecialchars($Conv->conversation_text) . '</span>
                                    ' . $Previous_Report . '
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            ';
                            } else {
                                $Output .= '
                            <li style="position: relative;width: 100%; height: auto; padding: 0 6px;"  class="m-t-6">
                                <div class="Msg_Receiver float-left p-l-10 p-r-10" title="' . date('d.M.Y h:i a', strtotime($Conv->created_at)) . '">
                                    <b>-> </b> <span>' . htmlspecialchars($Conv->conversation_text) . '</span>
                                    ' . $Previous_Report . '
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        ';
                            }
                            if (Auth::id() == $Conv->reciever_id) {
                                EmergencyConversation::where('id', '=', $Conv->id, 'AND', 'seen', '=', 0)->update([
                                    'seen' => '1'
                                ]);
                            }
                        }
                    } else {
                        $Output .= '<div class="text-center">No conversations yet.</div>';
                    }
                    return response()->json(array('Identity' => $Identity, 'Avatar' => $Avatar, 'Output' => $Output), 200);

                } else {
                    $Output = 'Data not found.';
                    return response($Output);
                }
            } else {
                return redirect()->back()->with('Error', 'Unable to fetch conversation data.');
            }
        }else{
            $Output = 'Conversation session end.';
            return response()->json(array('TimeOut' => $Output, 'DisableForm' => 'disabled'), 200);
        }
    }



    public function loaderNewMessage(Request $request){
        if(Cookie::get('Token') == true) {
            if ($request->ajax()) {
                $Output = '';
                if ($request->has('Token')) {
                    $Token = decrypt($request->Token);
                    $AppReq = AppointmentRequest::where('token', '=', $Token)->first();
                    $AppReq_Id = $AppReq->id;
                    if (Auth::check()) { /// User is logged in ....
                        if (Auth::user()->role()->pluck('name')->first() == 'Patient') {
                            $User_data = User::find(AppointmentRequest::find($AppReq_Id)->doctor->user->id); // Get doctor if patient is logged in
                            $Receiver_id = $User_data->id;
                        } elseif (Auth::user()->role()->pluck('name')->first() == 'Doctor') {
                            $User_data = User::find(AppointmentRequest::find($AppReq_Id)->user_id); // Get patient if doctor is logged in
                            if ($User_data == null) {
                                $Receiver_id = 0;
                            } else {
                                $Receiver_id = $User_data->id;
                            }
                        }
                        $SenderUser_id = Auth::id();

                    } else { // User is not logged in ....
                        $User_data = User::find(AppointmentRequest::find($AppReq_Id)->doctor->user->id); // Get doctor if patient is not logged in
                        $SenderUser_id = 0;
                        $Receiver_id = $User_data->id;
                    }
                    $Conversation = EmergencyConversation::where('appointment_request_id', '=', $AppReq_Id)
                        ->where('seen', '=', 0)
                        ->whereIn('sender_id', [$SenderUser_id, $Receiver_id])->whereIn('receiver_id', [$SenderUser_id, $Receiver_id])
                        ->where('sender_id', '!=', $SenderUser_id)
                        ->orderBy('id', 'ASC')->orderBy('created_at', 'ASC')
                        ->get();
                    //$Output = $Receiver_id . $SenderUser_id;
                    if (count($Conversation) > 0) {
                        foreach ($Conversation as $Conv) {
                            if ($Conv->seen == 0) {
                                if ($Conv->conversation_file !== null) {
                                    $Previous_Report = '<span class="text-white" style="color: white!important;"><b><a style="font-size: 12px;" href="' . $Conv->conversation_file . '" target="_blank">Report or Prescription .FILE</a></b></span>';
                                } else {
                                    $Previous_Report = '';
                                }
                                if ($Conv->sender_id !== $SenderUser_id) {
                                    $Output .= '
                                        <li style="position: relative;width: 100%; height: auto; padding: 0 6px;"  class="m-t-6">
                                            <div class="Msg_Receiver float-left p-l-10 p-r-10" title="' . date('d.M.Y h:i a', strtotime($Conv->created_at)) . '">
                                                <b>-> </b> <span>' . htmlspecialchars($Conv->conversation_text) . '</span>
                                                ' . $Previous_Report . '
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    ';
                                }
                                if ($Receiver_id == $Conv->sender_id) {
                                    EmergencyConversation::where('id', '=', $Conv->id)->where('seen', '=', 0)
                                        ->where('appointment_request_id', '=', $AppReq_Id)
                                        ->where('receiver_id', '=',  $Conv->receiver_id)
                                        ->update([
                                        'seen' => '1'
                                    ]);
                                }
                            }
                        }
                    }
                    $EndTimer = Carbon::parse($AppReq->updated_at)->addMinutes(15);
                    $StartTimer = Carbon::now();
                    $Timer = 'Consultation ends in: ' .Carbon::parse($EndTimer->diffInSeconds($StartTimer))->format('i:s') . 'min';
                    return response()->json(array('Output' => $Output, 'Timer' => $Timer), 200);
                }
                else {
                    $Output = 'Data not found.';
                    return response($Output);
                }
            }
            else {
                return redirect()->back()->with('Error', 'Unable to fetch conversation data.');
            }
        }
        else{
            $Output = '<div class="text-center alert alert-info">Conversation session end.</div>';
            return response()->json(array('TimeOut' => $Output, 'DisableForm' => 'disabled'), 200);
        }
    }









    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmergencyConversation  $emergencyConversation
     * @return \Illuminate\Http\Response
     */
    public function edit(EmergencyConversation $emergencyConversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmergencyConversation  $emergencyConversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyConversation $emergencyConversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmergencyConversation  $emergencyConversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmergencyConversation $emergencyConversation)
    {
        //
    }
}
