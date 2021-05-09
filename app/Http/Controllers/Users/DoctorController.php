<?php

namespace App\Http\Controllers\Users;

use App\Appointment;
use App\AppointmentBooking;
use App\Consultation;
use App\Doctor;
use App\Rules\DepartmentWordCountRule;
use App\Rules\WordCountRule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DoctorController extends Controller
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
    public function update(Request $request)
    {
        session()->flash('Error_edit_profile', 'Error');
        if(Auth::check()){
            $id = Auth::user()->id;
        }
        $request->validate([
            'Location' => 'sometimes|string|',
            'auto_locate' => 'sometimes|string|',
            'WorkPlace' => 'required|string|',
            'Fees' => 'sometimes|nullable|numeric|max:2000|min:400',
            'About' => ['required','string', new WordCountRule('About yourself', 20, 300)],
        ],[
            'WorkPlace.required' => 'Work place name is required.',
            'WorkPlace.string' => 'Work place name must be string.',

            'Fees.numeric' => 'Fees must be numeric.',
            'Fees.min' => 'Fees must be at-least 400 TK.',
            'Fees.max' => 'Fee is too high. Maximum fee can be 2000 TK.',
        ]);

        // get location ...
        $Location = '';
        if ($request->has('auto_locate')) {
            $request->validate([
                'auto_locate' => 'required|string',
                'address' => ['sometimes','string', new WordCountRule('Address', 2, 8)],
            ]);
            $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
            $Location = encrypt($arr_ip);
        }
        elseif ($request->has('Location')) {
            $request->validate([
                'Location' => 'required|string',
                'address' => ['sometimes','string', new WordCountRule('Address', 2, 8)],
            ]);
            $Location = $request->Location;
            $Location_array = explode(', ', $Location);
            if (count($Location_array) < 3) {
                return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State')->withInput();
            }
            else{
                foreach ($Location_array as $loc){
                    if(strlen($loc) < 3){
                        return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State')->withInput();
                    }
                }
            }
        }

        // get week days ...
        $Week_Days = array();
        if ($request->has('Sunday')){
            $Week_Days[] = ucfirst($request->Sunday);
        }if ($request->has('Monday')){
        $Week_Days[] = ucfirst($request->Monday);
        }if ($request->has('Tuesday')){
            $Week_Days[] = ucfirst($request->Tuesday);
        }if ($request->has('Wednesday')){
            $Week_Days[] = ucfirst($request->Wednesday);
        }if ($request->has('Thursday')){
            $Week_Days[] = ucfirst($request->Thursday);
        }if ($request->has('Friday')){
            $Week_Days[] = ucfirst($request->Friday);
        }if ($request->has('Saturday')){
            $Week_Days[] = ucfirst($request->Saturday);
        }
        if(count($Week_Days) <= 1){
            return back()->with('Error', 'working days should be more then 1 days');
        } elseif(count($Week_Days) > 5){
            return back()->with('Error', 'Working days should be less then 6 days');
        }
        $Week_Days = implode(', ', $Week_Days);

        // Update query ...
        User::findOrFail($id)->update(['location' => $Location, 'address' => $request->address,]);
        Doctor::where('user_id', '=', $id)->update([
            'Work_Place_name' => $request->WorkPlace,
            'fees' => $request->Fees,
            'working_days' => $Week_Days,
            'about' => $request->About,
        ]);

        // Change password if change password checkbox is checked....
        if ($request->has('change_password')) {
            $request->validate([
                'old_password' => 'required|string|min:8|max:60',
                'new_password' => 'required|string|min:8|max:60|confirmed',
            ], [
                'old_password.required' => 'Old password is required.',
                'old_password.min' => 'Old password is must be at-least 8 characters.',
                'old_password.max' => 'Old password is must be less then 60 characters.',

                'new_password.required' => 'New password is required.',
                'new_password.min' => 'New password is must be at-least 8 characters.',
                'new_password.max' => 'New password is must be less then 60 characters.',
                'new_password.confirmed' => 'New password does not match Retype password.',
            ]);

            if($request->old_password == $request->new_password){
                return back()->with('Error', 'New password cannot be same as old password.')->withInput();
            }

            $User_password = User::findOrFail(Auth::user()->id)->password;

            if (Hash::check($request->old_password, $User_password)) {
                if (Hash::check($request->new_password, $User_password)) {
                    return back()->with('Error', 'New password cannot be same as old password.')->withInput();
                }
                else{
                    User::findOrFail(Auth::user()->id)->update(['password' => Hash::Make($request->new_password)]);
                    Session::forget('Show_profile_edit_form');
                    return back()->with('Success', 'Password successfully changed.');
                }
            }else{
                return back()->with('Error', 'Old password is wrong.')->withInput();
            }
        }

        Session::forget('Error_edit_profile');
        return back()->with('Success', 'Account information successfully updated.');
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


    public function showBookings(Request $request){
        if($request->ajax()){
            $Output = '';
            if($request->has('appointment_id') && $request->has('doctor_id') ){
                $User = Auth::user();

                $Appointment_id = $request->appointment_id;
                $Doctor_id = $request->doctor_id;

                $AppointmentBooking = AppointmentBooking::where('appointment_id', '=', $Appointment_id)
                    ->join('consultations','consultations.appointment_booking_id','appointment_bookings.id')
                    ->join('appointments','appointments.id','appointment_bookings.appointment_id')
                    ->join('users','users.id','appointment_bookings.user_id')
                    ->select('appointments.*','consultations.*','appointment_bookings.*','users.first_name','users.last_name', 'users.avatar', 'consultations.id as con_id')
                    ->orderBy('booked_date', 'ASC')->orderBy('booked_time', 'ASC')
                    ->get();
                if(count($AppointmentBooking) > 0){
                    foreach($AppointmentBooking as $ABData){
                        $Output .= '<div class="col-6">
                    <div class="card m-xl-0">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <div style="font-size: 12px;" class="row">
                                <div class="m-r-10">
                                    <img src="'.$ABData->avatar.'" alt="" class="rounded-circle" width="60" height="60" style="object-fit: cover; object-position: center top;">
                                </div>
                                <div class="">
                                    <div style="font-size: 12px;">
                                        <strong>Patient Name: </strong>
                                        <span class="text-info"><span class="text-info">'.$ABData->first_name . ' ' . $ABData->last_name.'</a></span>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <strong>Booked Date: </strong>
                                        <span class="text-info">'.date('d-M-Y', strtotime($ABData->booked_date)).'</span>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <strong>Booked Time: </strong>
                                        <span class="text-info">'.date('g:i a', strtotime($ABData->booked_time)).'</span>
                                    </div>
                                    <div style="font-size: 12px;">
                                        <strong>Status: </strong>
                                        <span class="text-danger">'.ucwords($ABData->status).'</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="'.urlencode('chat-box|'.encrypt($ABData->con_id)).'" class="btn btn-sm btn-outline-info" style="font-size: 12px;"><i class="fa fa-comment m-r-4"></i> Conversation</a>
                        </div>
                    </div>
                    </div>';
                    }
                }
                else{
                    $Output .= 'No bookings yet.';
                }
            }
            else{
                $Output .= 'Wrong request.';
            }
            return response($Output);
        }
    }



    /*public function test(){
        $Appointment_id = 3;
        $AppointmentBooking = AppointmentBooking::where('appointment_id', '=', $Appointment_id)
            ->join('consultations','consultations.appointment_booking_id','appointment_bookings.id')
            ->join('appointments','appointments.id','appointment_bookings.appointment_id')
            ->join('users','users.id','appointment_bookings.user_id')
            ->select('appointments.*','consultations.*','appointment_bookings.*','users.first_name','users.last_name', 'users.avatar', 'consultations.id as con_id')
            ->get();
        dd($AppointmentBooking);
    }*/
}
