<?php

namespace App\Http\Controllers\Users;

use App\Appointment;
use App\AppointmentBooking;
use App\Consultation;
use App\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }



    public function Validation($request){
        //dd(Carbon::now()->add(1, 'day'));
        $request->validate([
            'App_ID' => 'required|numeric', // Appointment id
            'appointment_date' => ['required','date', 'date_format:Y-m-d','after:' . Carbon::now()->add(1, 'day'),], //
            'Doc_ID' => 'required|numeric',
            'Doctor_Name' => 'required|string|min:6|max:60',
            'Start_Time_Input' => ['required', 'before:End_Time_Input'],
            'End_Time_Input' => ['required', 'after:Start_Time_Input'],
            'User_ID' => 'required|numeric',
        ],[
            'App_ID.required' => 'Appointment ID is required.',
            'App_ID.numeric' => 'Appointment ID should ne numeric.',

            'Start_Time_Input.required' => 'START time is required.',
            'Start_Time_Input.date_format' => 'START time is incorrectly formatted.',
            'Start_Time_Input.before' => 'START time should be before END time.',

            'End_Time_Input.required' => 'END time is required.',
            'End_Time_Input.date_format' => 'END time is incorrectly formatted.',
            'End_Time_Input.after' => 'END time must be after START time.',
        ]);
    }

    public function book_appointment(Request $request){
        if(Auth::check()){
            $this->Validation($request);

            // Restrict booking more then 2 appointments .... where status != complete
            if(count(Consultation::where('user_id', '=', Auth::id(), 'AND', 'status', '!=', 'session end')->get()) >= 3) {
                return back()->with('Error', 'Hey! Stop there you have already two or more consultations pending. Please complete those and then book new appointments.')->withInput();
            }

            $Appointment_id = $request->App_ID;
            $Appointment_date = date('Y-m-d', strtotime($request->appointment_date));
            $Doctor_id = $request->Doc_ID;
            $Doctor_name = $request->Doctor_Name;
            $Start_Time_Input = date('H:i:s', strtotime($request->Start_Time_Input));
            $End_Time_Input = date('H:i:s', strtotime($request->End_Time_Input));
            $User_ID = $request->User_ID;
            //dd($User_ID, Auth::id());

            if(Auth::id() != $User_ID){return back()->with('Error', 'OOps! Something went wrong.')->withInput();}

            // Make sure their is appointment available ...
            $Chk_Appointment = Appointment::where('id', '=', $Appointment_id)->where('booking_status', '=', 'open')
                ->where('doctor_id','=', $Doctor_id)->where('validity', '=', 1)
                ->whereDate('start_date', '<=', $Appointment_date)
                ->whereDate('end_date', '>=', $Appointment_date)
                /*->whereTime('start_time', '>=', $Start_Time_Input)
                ->whereTime('end_time', '<=', $End_Time_Input)*/
                ->first();

            // Get doctor details ....
            $Doctor =  Doctor::findOrFail($Doctor_id);
            $Full_name = $Doctor->user->first_name . ' ' .  $Doctor->user->last_name;
            //dd($request->all(), $Chk_Appointment);
            // Check duplicate booking ...

            //dd($Full_name);
            if($Chk_Appointment !== null && $Full_name == $Doctor_name){
                // IF fees is greater then 0 return message Payment feature is under development
                if($Doctor->fees > 000){
                    //abort('404', 'Payment feature under development.');
                    return back()->with('Error', 'Sorry! Payment feature is under development. You can only book free appointments.');
                }
                else {
                    /*$BookAppointment = AppointmentBooking::where('appointment_id', '=', $Appointment_id)
                        ->where('booked_date', '=', $Appointment_date)
                        ->get();*/
                    //dd($BookAppointment, $Appointment_date);

                    $token = str_replace([' ', ':', '-', '@', '/', '?'], '', str_shuffle(Str::random(20).Carbon::now()));

                    // Confirm the booking

                    // Insert data to appointment booking table ..
                    $AppointmentBooking = new AppointmentBooking;
                    $AppointmentBooking->user_id = $User_ID;
                    $AppointmentBooking->appointment_id = $Appointment_id;
                    $AppointmentBooking->booked_date = $Appointment_date;
                    $AppointmentBooking->booked_time = $Start_Time_Input;
                    $AppointmentBooking->token = $token;
                    $AppointmentBooking->created_at = Carbon::now();
                    $AppointmentBooking->save();

                    $AppointmentBooking_id = $AppointmentBooking->id;

                    // Create consultation data ....
                    Consultation::Insert([
                        'user_id' => $User_ID,
                        'doctor_id' => $Doctor_id,
                        'appointment_booking_id' => $AppointmentBooking_id,
                        'status' => 'pending',
                        'created_at' => Carbon::now(),
                    ]);

                    return redirect()->route('user.user-profile')->with('Success', 'Your appointment booking is successfully done.');
                }
            }
            else{
                return back()->with('Error', 'Invalid Appointment booking request.')->withInput();
            }
        }
        else{
            return redirect()->route('login');
        }
        //dd($request->all(), $Chk_Appointment, $Start_Time_Input);
    }

}
