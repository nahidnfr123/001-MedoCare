<?php

namespace App\Http\Controllers;

use App\AppointmentBooking;
use App\AppointmentRequest;
use App\Consultation;
use App\Doctor;
use App\DoctorRating;
use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Cookie;
use Response;
use Session;
use Illuminate\Support\Str;

class RequestAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Users = User::Verified_active()->get(); // get verified and active users ....
        foreach ($Users as $User){
            if($User->userIsOnline() && $User->role()->pluck('name')->first() == 'Doctor'){
                echo 'paisi';
            }
            else{
                echo 'nai';
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){ // Ajax load request form data ....

        if(Auth::check()){ $Active_User = auth()->user()->id; }
        else{ $Active_User = 0; }
        if($request->ajax()) {
            if($request->has('department_id')){
                $Output = '';
                if($request->department_id > 0){
                    return $this->bydepartment($request->department_id, $Output, $Active_User);
                }
                else{
                    return $this->allDoctors($Output, $Active_User);
                }
            }



        }
        else{
            abort(404, 'Page not found.');
        }
    }

    public function allDoctors($Output, $Active_User){ // Select doctor from all departments ....
        $Doctors  = User::where('is_admin', '=', 0)
            ->where('users.id', '!=', $Active_User)
            ->where('email_verified_at', '!=', null)
            ->where('blocked', '!=', 1)
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('roles.name', '=', 'Doctor')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'doctors.id as doc_id', 'departments.*')
            ->get();

        return $this->content($Doctors, $Output);
    }




    public function bydepartment($Department_id, $Output, $Active_User){ // Select doctor by specific department....
        $Doctors  = User::where('is_admin', '=', 0)
            ->where('users.id', '!=', $Active_User)
            ->where('email_verified_at', '!=', null)
            ->where('blocked', '!=', 1)
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('roles.name', '=', 'Doctor')
            ->where('departments.id', '=', $Department_id)
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'doctors.id as doc_id', 'departments.*')
            ->get();

        return $this->content($Doctors, $Output);
    }


    public function content($Doctors, $Output){
        if(count($Doctors) > 0 ){
            foreach ($Doctors as $Doctor){
                if ($Doctor->fees > 0) {
                    $fees = $Doctor->fees . ' .Tk';
                } else {
                    $fees = 'Free';
                }

                // Calculate doctor rating ...
                $Ratings = DoctorRating::where('doctor_id', '=', $Doctor->doc_id)->get();
                $number_of_rating = count($Ratings);
                $c = 0;
                if (count($Ratings) > 0) {
                    foreach ($Ratings as $Rating) {
                        $c += $Rating->rating_value;
                    }
                    $rating = round($calculate = $c / $number_of_rating, 2);
                } else {
                    $rating = 0;
                }

                $CheckOnline = User::find($Doctor->users_id)->userIsOnline();

                if($CheckOnline == true){
                    $Info_Text = '<div class="alert alert-primary text-center" style="font-size: 12px;"><b>Doctor is Online.</b></div>';
                    $Check_Box = '
                            <div class="custom-control custom-radio float-right">
                                <input type="radio" required id="doc_id_'.$Doctor->doc_id.'" name="doc_id" value="'.$Doctor->doc_id.'" class="Radio_Check_Doctor float-right custom-control-input">
                                <label class="custom-control-label" for="doc_id_'.$Doctor->doc_id.'"></label>
                            </div>';
                    $Cursor = 'pointer';
                    $alert_type = 'alert-info';
                }else{
                    $Info_Text = '<div class="alert alert-secondary text-center" style="font-size: 12px;"> Doctor is offline but you can make a phone call.</div>';
                    $Check_Box = '';
                    $Cursor = '';
                    $alert_type = '';
                }

                $Output .= '
                    <label for="doc_id_'.$Doctor->doc_id.'" style="cursor: '.$Cursor.';" class="Radio_Check_Doctor_label col-12 col-lg-6 col-md-12">
                    <div class="card '.$alert_type.'">
                        <div class="card-header">
                            '.$Check_Box.'
                            <div class="row">
                                <div><img src="'.$Doctor->avatar.'" alt="" width="60" height="60" style="object-fit: cover;object-position: center top;"></div>
                                <div class="m-l-5" style="font-size: 12px;">
                                    <div><b>Name:</b> <span class="text-info m-l-5">'.$Doctor->first_name.' '.$Doctor->last_name.'</span></div>
                                    <div><b>Experience:</b> <span class="text-info m-l-5">'.$Doctor->experience.' Years</span></div>
                                    <div><b>Phone:</b> <span class="text-info m-l-5">'.$Doctor->phone.'</span></div>
                                    <div><b>Ratting:</b> <span class="text-info m-l-5">'. $rating .'</span> <i class="fa fa-star" style="color: yellow;text-shadow: 0 0 6px rgba(0,0,0, 1)"></i></div>

                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="font-size: 12px;">
                            <div><b>Department:</b> <span class="text-info m-l-5">'.$Doctor->department_name.'</span></div>
                            <div><b>Hospital:</b> <span class="text-info m-l-5">'.$Doctor->work_place_name.'</span></div>
                        </div>
                        '.$Info_Text.'
                    </div>
                    </label>
                    ';
            }
        }else{
            $Output .= '<div class=" col-12 text-centre alert alert-danger">No doctors found in this department.</div>';
        }
        return Response::json($Output);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){ // Store appointment request ....
        if(Cookie::get('RequestAppointment') == true && Cookie::get('EmergencyConsultation') != true){
            return redirect()->back()->with('Error', 'You have already requested an appointment. please wait for the doctor to respond. You can request for new consultation after 2 minutes.');
        }
        elseif(Cookie::get('EmergencyConsultation') == true){
            return redirect()->back()->with('Error', 'You are already engaged in a consultation.');
        }
        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/', new PhoneMinLength , new PhoneMaxLength],
            'doc_id' => 'required|numeric',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.min' => 'Phone number must be numeric.',
            'doc_id.required' => 'Please select a doctor to request appointment.',
            'doc_id.numeric' => 'Please select a doctor to request appointment.',
        ]);

        $User_IP = $request->ip();

        $token = str_shuffle(Str::random(32));

        if(Auth::id()){$user_id = Auth::id();}else{$user_id = 0;}
        AppointmentRequest::Insert([
            'user_id' => $user_id,
            'doctor_id' => $request->doc_id,
            'phone' => $request->phone,
            'ip_address' => $User_IP,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        //session()->regenerate();
        //$request->session()->put('UserPhone', 'value');
        //session(['RequestAppointment'=>'TRUE', 'Token' => $token]);
        //$value = session('RequestAppointment');
        //Session::forget('RequestAppointment');

        //$Location_Array = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        //dd($request->all());
        return redirect()->back()->with('Success', 'Your request is sent to the doctor.')
            ->withCookie(cookie('RequestAppointment', 'TRUE', 2))
            ->withCookie(cookie('Token', $token, 2));
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

    public function declineRequest($token){ // Doctor declines the consultation request ....
        $token = $this->decryptID($token);
        //dd($token);
        AppointmentRequest::where('token', '=', $token)->update([
            'status' => 'declined',
        ]);
        return redirect()->back()->with('Success', 'Appointment request declined successfully.');
    }


    // Doctor end ....
    public function acceptRequest($token){ // Doctor accepts the consultation request ....
        $token = $this->decryptID($token);
        $Appointment = AppointmentRequest::where('doctor_id', '=', Auth::user()->doctor->id)
            ->where('token', '=', $token)
            ->where('status', '=', 'pending')
            ->first();
        if($Appointment !== ''){
            AppointmentRequest::where('token', '=', $token)->update([
                'status' => 'accepted',
            ]);
            // Create conversation
            if($Appointment->user_id != 0){
                $Identity = $Appointment->user->first_name .' '.$Appointment->user->last_name;
            }
            else{
                $Identity =  $Appointment->phone;
            }
            //return redirect()->back()->with('Success', 'Appointment request declined successfully.');
            return response()
                ->json(array('Identity' => $Identity, 'Token' => encrypt($Appointment->token)), 200)
                ->withCookie(cookie('EmergencyConsultation', $Appointment->token, 15))
                ->withCookie(cookie('Token', $token, 15));
        }
        else{
            $Output = '<script>alert("Sorry! Their was and internal Error.")</script>';
            return response($Output);
        }

    }



    public function loadAppointmentRequest(){ // Load appointment data in doctor end ....
        $Output = '';
        // Doctors part ....
        if (Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor') {
            $Appointment_Requests = AppointmentRequest::where('doctor_id', '=', Auth::user()->doctor->id)->where('status', '=', 'pending')->get();

            if(count($Appointment_Requests) !== ''){ $Count_Request = '<div class="RequestCount">'.count($Appointment_Requests).'</div>'; }
            else{ $Count_Request = ''; }

            if (count($Appointment_Requests) > 0) {
                foreach ($Appointment_Requests as $AR) {
                    if($AR->user_id == 0) {
                        $Info = $AR->phone;
                    }else{
                        $Info = $AR->user->first_name .' '. $AR->user->last_name;
                    }
                    $Output .= '
                        <div class="row border-bottom">
                            <div class="col-6" style="font-size: 12px;">
                                '.$Info.'
                                <div>'.$AR->created_at.'</div>
                            </div>
                            <div class="col-6 btn btn-group btn-group-sm">
                                <button href="" class="btn btn-sm btn-primary Accept_Request" data-token="'.encrypt($AR->token).'">Accept</button>
                                <a href="'.url('decline_request|' . encrypt($AR->token)) .'" class="btn btn-sm btn-danger" onclick="return(confirm(\'Are you sure you want to decline the request.\'))">Decline</a>
                            </div>
                        </div>
                    ';
                    if($AR->status = 'pending'){
                        if(Carbon::now() > Carbon::parse($AR->created_at)->addMinutes(3)){
                            AppointmentRequest::where('token', '=', $AR->token)->where('status', '=', 'pending')->update([
                                'status' => 'no response',
                            ]);
                        }
                    }
                }
                //return response($Output);
                return response()
                    ->json(array('Count_Request' => $Count_Request, 'Output' => $Output), 200);
            }
            else{
                return response()
                    ->json(array('Count_Request' => '', 'Output' => ''), 200);
            }
        }
    }



    public function GetRequestResponse($token){ // Patient get Request response ....
        if(Cookie::get('Token') == true && Cookie::get('RequestAppointment') == true){
            $token = $this->decryptID($token);
            //dd($token);
            $App = AppointmentRequest::where('token', '=', $token)->first();
            $Output = '';
            $Status = '';
            if($App !== ''){
                $Status = $App->status;
                $Doc_Name =  $App->doctor->user->first_name . ' ' . $App->doctor->user->last_name;
                if($Status == 'accepted'){
                    $Output = '
                        <div class="Float_MSG_Success Float_MSG_Success2 animated fadeInDownBig slower" style="max-width: 320px;">
                            <div id="Close_Btn" onclick="close_Success_div2()">
                                <i class="fa fa-times"></i>
                            </div>
                            <h4 style="line-height: 20px; padding: 10px; font-size: 14px; color: #06a130!important;">
                                Your appointment request was accepted you can now start a conversation.
                            </h4>
                        </div>
                    ';
                    AppointmentRequest::where('token', '=', $App->token)->update([
                        'status' => 'in progress',
                    ]);

                    return response()
                        ->json(array('Response' => $Status, 'PoPMessage' => $Output, 'Doctor_id'=>$App->doctor_id, 'Doctor_name' => $Doc_Name), 200)
                        ->withCookie(cookie('EmergencyConsultation', $App->token, 15))
                        ->withCookie(cookie('RequestAppointment', 'TRUE', 15))
                        ->withCookie(cookie('Token', $token, 15));
                }
                elseif($Status == 'declined'){
                    Cookie::queue(Cookie::forget('RequestAppointment'));
                    Cookie::queue(Cookie::forget('Token'));
                    $Output = '
                        <div class="Float_MSG_Error Float_MSG_Error2 animated fadeInDownBig slower" style="max-width: 320px;">
                            <div id="Close_Btn" onclick="close_Error_div2()">
                                <i class="fa fa-times"></i>
                            </div>
                            <h5 style="color: coral;">Sorry!</h5>
                            <ul class="Error_Ul">
                                <li> Your appointment request was declined by the doctor.</li>
                            </ul>
                        </div>
                    ';
                    return response()->json(array('Response' => $Status, 'PoPMessage' => $Output), 200);
                }
                elseif($Status == 'session end'){
                    Cookie::queue(Cookie::forget('EmergencyConsultation'));
                    Cookie::queue(Cookie::forget('RequestAppointment'));
                    Cookie::queue(Cookie::forget('Token'));
                    $Output = '
                        <div class="Float_MSG_Error Float_MSG_Error4 animated fadeInDownBig" style="max-width: 320px;">
                            <div id="Close_Btn" onclick="close_Error_div4()">
                                <i class="fa fa-times"></i>
                            </div>
                            <!--<h5 style="color: coral;">Sorry!</h5>-->
                            <ul class="Error_Ul">
                                <li> Your consultation session has ended.</li>
                            </ul>
                        </div>
                        ';
                    return response()->json(array('Response' => $Status, 'PoPMessage' => $Output), 200);
                }
            }
            return response()
                ->json(array('Response' => $Status, 'PoPMessage' => $Output, 'Doctor_id'=>$App->doctor_id, 'Doctor_name' => $Doc_Name), 200);
        }
    }



    public function EndSession($token){
        if(Cookie::get('EmergencyConsultation') == true) {
            $token = $this->decryptID($token);
            //dd($token);
            AppointmentRequest::where('token', '=', $token)->update([
                'status' => 'session end',
            ]);
            $Output = '
                <div class="Float_MSG_Success Float_MSG_Success2 animated fadeInDownBig slower" style="max-width: 320px;">
                    <div id="Close_Btn" onclick="close_Success_div2()">
                        <i class="fa fa-times"></i>
                    </div>
                    <h4 style="line-height: 20px; padding: 10px; font-size: 14px; color: #06a130!important;">
                        Consultation session has ended.
                    </h4>
                </div>
            ';
            Cookie::queue(Cookie::forget('EmergencyConsultation'));
            Cookie::queue(Cookie::forget('RequestAppointment'));
            Cookie::queue(Cookie::forget('Token'));
            return response($Output);
        }
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


}
