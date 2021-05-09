<?php

namespace App\Http\Controllers\Users;

use App\AppointmentBooking;
use App\Consultation;
use App\Conversation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id = $this->decryptID($id);
        $Consultation_id = $id;

        $All_Consultations = Consultation::where('consultations.user_id','=', Auth::id())
            ->where('consultations.user_id', '=', Auth::id())
            ->join('appointment_bookings', 'appointment_bookings.id', 'consultations.appointment_booking_id')
            ->orderBy('appointment_bookings.booked_date')
            ->get();

        $CheckStatus = Consultation::where('consultations.id', '=', $Consultation_id)
            /*->where('consultations.user_id', '=', Auth::id(), 'OR', 'consultations.doctor_id', '=', Auth::id())*/
            ->join('appointment_bookings', 'appointment_bookings.id', 'consultations.appointment_booking_id')
            ->select('consultations.*', 'consultations.id as con_id', 'appointment_bookings.*')
            ->first();

        $RawDate = strtotime($CheckStatus->booked_date); $RawTime = date('H:i:s', strtotime($CheckStatus->booked_time));
        $Date_time = date('F', $RawDate).' '.date('d', $RawDate).' '.date('Y', $RawDate) .' '. $RawTime;
        //dd($Consultation_id);
        if(Carbon::now() > $Date_time  && $CheckStatus->status == 'in progress'){
            Consultation::findOrFail($CheckStatus->con_id)->update(['status'=>'session end']);
        }

        if(Auth::user()->role()->pluck('name')->first() == 'Patient'){
            $User_data = User::find(Consultation::find($Consultation_id)->doctor->user->id); // Get doctor if patient is logged in
            // Show all conversations ..
            $Consultations  = Consultation::where('user_id','=', Auth::id())
                ->where('status', '!=', 'pending')->orderBy('id', 'DESC')
                ->get();

        }
        elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor') {
            $User_data = User::find(Consultation::find($Consultation_id)->user_id); // Get patient if doctor is logged in
            // Show all conversations ..
            $Consultations  = Consultation::where('doctor_id','=', Auth::user()->doctor->id)
                ->where('status', '!=', 'pending')->orderBy('id', 'DESC')
                ->get();
            //dd($Consultations);
        }
        //$App_Booking = AppointmentBooking::findOrFail($User_data->doctor->appointment->id)->get();

        //dd());

        if($User_data !== null){
            return view('pages.conversation.chatbox', compact('User_data', 'Consultation_id', 'All_Consultations', 'CheckStatus', 'RawDate', 'Date_time', 'Consultations'));
        }
        else{
            return redirect()->back()->with('Error', 'Unable to fetch conversation data.');
        }
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
        if($request->ajax()){
            if($request->has('Consultation_id') && $request->has('Message') && $request->has('Sender_id') && $request->has('Receiver_id') ){
                Conversation::Insert([
                    'consultation_id' => $request->Consultation_id,
                    'conversation_text' => $request->Message,
                    'sender_id' => $request->Sender_id,
                    'receiver_id' => $request->Receiver_id,
                    'created_at' => Carbon::now(),
                ]);
            }
            else{
                $Output = 'Missing data';
                return response($Output);
            }
        }
    }

    // Patient can upload previous report ....
    public function reportHistory(Request $request){
        $Sender_id = Auth::id();

        if(Auth::user()->role()->pluck('name')->first() == 'Patient') {
            if ($request->hasFile('Report_file')) {
                $Full_name = Auth::user()->first_name . '_' . Auth::user()->last_name;

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
                $StorageLink = '/storage/user_data/patient/report/' . $newFileName;
            }
            else {
                $StorageLink = '';
            }

            Conversation::Insert([
                'consultation_id' => $request->Consultation_id,
                'conversation_text' => null,
                'sender_id' => $Sender_id,
                'receiver_id' => $request->Receiver_id,
                'conversation_file' => $StorageLink,
                'created_at' => Carbon::now(),
            ]);
        }
        return redirect()->back();
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


    public function loaderAll(Request $request){
        if($request->ajax()){
            $Output = '';
            if($request->has('Consultation_id')){
                $ConsultationId = $request->Consultation_id;

                if(Auth::user()->role()->pluck('name')->first() == 'Patient'){
                    $User_data = User::find(Consultation::find($ConsultationId)->doctor->user->id); // Get doctor if patient is logged in
                }
                elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){
                    $User_data = User::find(Consultation::find($ConsultationId)->user_id); // Get patient if doctor is logged in
                }


                $Conversation = Conversation::where('consultation_id','=',$ConsultationId)
                    /*->whereIn('sender_id', [Auth::id(), $User_data->id])->whereIn('receiver_id', [Auth::id(), $User_data->id])*/
                    ->orderBy('id', 'ASC')->orderBy('created_at', 'ASC')
                    ->get();
                if(count($Conversation)>0){
                    foreach ($Conversation as $Conv) {
                        if(Auth::user()->role()->pluck('name')->first() == 'Patient'){ $avatar = $Conv->consultation->doctor->user->avatar; $name = $Conv->consultation->doctor->user->first_name; }
                        elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){$avatar = $Conv->consultation->user->avatar; $name = $Conv->consultation->user->first_name;}

                        if($Conv->conversation_file !== null){
                            //$n = + 1;
                            $Previous_Report = '<div class="text-primary"><a style="font-size: 12px;" href="'.$Conv->conversation_file.'" target="_blank">Report or Prescription</a></div>';
                        }
                        else{
                            $Previous_Report = '';
                            //$n = '';
                        }

                        if($Conv->sender_id == Auth::id()){
                            $Output .= '
                            <li style="width: 100%; height: auto;">
                                <div class="O sender" style="width: auto; height: auto;position: relative;">
                                    <div>
                                        <div class="MessageTest">'.htmlspecialchars($Conv->conversation_text).'</div>
                                        '.$Previous_Report.'
                                        <div class="Time text-muted">'.date('d.M.Y h:i a', strtotime($Conv->created_at)).'</div>
                                    </div>
                                </div>
                            </li>
                            ';
                        } else{
                            $Output .= '
                            <li style="position: relative; padding: 0 20px;" class="row col-12">
                            <img src="'.$avatar.'" alt="" class="User_50" height="20" width="20" style="left:4px;top:-10px;position: absolute; height: 24px!important; width: 24px!important; margin-left: 12px;object-position: center top; object-fit: cover;">
                                <div class="O received" style=" width: auto; height: auto;">
                                    <p class="name font-bold m-r-6" style="font-size: 10px;"><b>'.$name.': </b></p>
                                    <div>
                                        <div class="MessageTest">'.htmlspecialchars($Conv->conversation_text).'</div>
                                        '.$Previous_Report.'
                                        <div class="Time">'.date('d.M.Y h:i a', strtotime($Conv->created_at)).'</div>
                                    </div>
                                </div>
                            </li>
                        ';
                        }
                        if(Auth::id() == $Conv->reciever_id){
                            Conversation::where('id', '=', $Conv->id, 'AND', 'seen', '=', 0)->update([
                                'seen' => '1'
                            ]);
                        }
                    }
                }else{
                    $Output .= 'No conversations yet.';
                }
                return response($Output);

            }else{
                $Output = 'data not found.';
                return response($Output);
            }
        }else{
            return redirect()->back()->with('Error', 'Unable to fetch conversation data.');
        }
    }



    public function loaderNewMessage(Request $request){
        if($request->ajax()){
            $Output = '';
            if($request->has('Consultation_id')){
                $ConsultationId = $request->Consultation_id;
                //$Consultation = Consultation::where('id', '=', $ConsultationId, 'AND', 'user_id', '=', Auth::id())->first();
                if(Auth::user()->role()->pluck('name')->first() == 'Patient'){
                    $User_data = User::find(Consultation::find($ConsultationId)->doctor->user->id); // Get doctor if patient is logged in
                }
                elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){
                    $User_data = User::find(Consultation::find($ConsultationId)->user_id); // Get patient if doctor is logged in
                }

                $Conversation = Conversation::where('consultation_id','=',$ConsultationId)
                    ->where('seen', '=', 0)
                    ->whereIn('sender_id', [Auth::id(), $User_data->id])->whereIn('receiver_id', [Auth::id(), $User_data->id])
                    ->where('sender_id', '!=', Auth::id())
                    ->orderBy('id', 'ASC')->orderBy('created_at', 'ASC')
                    ->get();

                if(count($Conversation)>0){
                    foreach ($Conversation as $Conv) {
                        if(Auth::user()->role()->pluck('name')->first() == 'Patient'){ $avatar = $Conv->consultation->doctor->user->avatar;  $name = $Conv->consultation->doctor->user->first_name; }
                        elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){$avatar = $Conv->consultation->user->avatar;  $name = $Conv->consultation->user->first_name; }
                        //dd(Auth::id() , $Conv->receiver_id);
                        if(Auth::id() == $Conv->receiver_id){
                            Conversation::where('id', '=', $Conv->id, 'AND', 'seen', '=', 0)->update([
                                'seen' => '1'
                            ]);
                        }
                        if($Conv->seen == 0){

                            if($Conv->conversation_file !== null){
                                //$n = + 1;
                                $Previous_Report = '<div class="text-primary"><a style="font-size: 12px;" href="'.$Conv->conversation_file.'" target="_blank">Report or Prescription</a></div>';
                            }
                            else{
                                $Previous_Report = '';
                                //$n = '';
                            }

                            if($Conv->sender_id !== Auth::id()){
                                /*$Output = '
                                <li style="width: 100%; height: auto;">
                                    <div class="O sender" style=" width: auto; height: auto;">
                                        <div>
                                            <div class="MessageTest">'.htmlspecialchars($Conv->conversation_text).'</div>
                                            <div class="Time text-muted">'.date('d.M.Y h:i a', strtotime($Conv->created_at)).'</div>
                                        </div>
                                    </div>
                                </li>
                                ';
                            } else{*/
                                $Output .= '
                                <li style="position: relative; padding: 0 20px;" class="row col-12">
                                   <img src="'.$avatar.'" alt="" class="User_50" height="20" width="20" style="left:4px;top:-10px;position: absolute; height: 24px!important; width: 24px!important; margin-left: 12px;object-position: center top; object-fit: cover;">
                                    <div class="O received" style="width: auto; height: auto;">
                                    <p class="name font-bold name font-bold m-r-6" style="font-size: 10px;"><b>'.$name.': </b></p>
                                    <div>
                                        <div class="MessageTest">'.htmlspecialchars($Conv->conversation_text).'</div>
                                        '.$Previous_Report.'
                                        <div class="Time">'.date('d.M.Y h:i a', strtotime($Conv->created_at)).'</div>
                                    </div>
                                    </div>
                                </li>
                                ';
                            }
                        }
                    }
                }
                return response($Output);

            }else{
                $Output = 'data not found.';
                return response($Output);
            }
        }else{
            return redirect()->back()->with('Error', 'Unable to fetch conversation data.');
        }
    }

}
/*<img src="'.$avatar.'" alt="" class="User_50" height="20" width="20" style="left:4px;top:-10px;position: absolute; height: 24px!important; width: 24px!important; margin-left: 12px;object-position: center top; object-fit: cover;">*/
