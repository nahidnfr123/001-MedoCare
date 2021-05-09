<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentBooking;
use App\Department;
use App\DoctorRating;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    public function index()
    {
        $Departments = Department::all();
        return view('pages.appointment.appointment-view', compact('Departments'));
    }

    public function create()
    { // show create appointment form

    }


    public function validation($request, $StartAfter5days)
    {
        session()->flash('Error_create_Appointment', 'true');

        $request->validate([
            'Start_Date' => ['required', 'date', 'date_format:Y-m-d', 'after:' . $StartAfter5days, /*'before:End_Date'*/],
            'End_Date' => ['required', 'date', 'date_format:Y-m-d', 'after:Start_Date',],
            'Start_Time' => ['required', 'date_format:"H:i:s"', 'before:End_Time',],
            'End_Time' => ['required', 'date_format:"H:i:s"', 'after:Start_Time'],
            'Fees' => 'sometimes|nullable|numeric|max:2000|min:400',
            'Booking_Start_Date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . Carbon::now(), 'before:' . date('Y-m-d', strtotime($request->Start_Date) - 1)],
        ], [
            'Start_Date.required' => 'Start date is required.',
            'Start_Date.date' => 'Start date must be a date.',
            'Start_Date.date_format' => 'Start date is in incorrect format. Correct date format is Y-m-d.',
            'Start_Date.after' => 'Start date should be at-least after 5 days from today.',
            'Start_Date.before' => 'Start date should be before end date.',

            'End_Date.required' => 'End date is required.',
            'End_Date.date' => 'End date must be a date.',
            'End_Date.date_format' => 'End date is in incorrect format. Correct date format is Y-m-d.',
            'End_Date.after' => 'End date should be a date after end date.',

            'Start_Time.required' => 'START time is required.',
            'Start_Time.date_format' => 'START time is incorrectly formatted.',
            'Start_Time.before' => 'START time should be before END time.',

            'End_Time.required' => 'END time is required.',
            'End_Time.date_format' => 'END time is incorrectly formatted.',
            'End_Time.after' => 'END time must be after START time.',

            'Fees.numeric' => 'Fees must be numeric.',
            'Fees.min' => 'Fees must be at-least 400 TK.',
            'Fees.max' => 'Fee is too high. Maximum fee can be 2000 TK.',
        ]);
    }

    public function store(Request $request)
    { // save the created appointment

        $User_id = Auth::id();
        $Doctor_id = Auth::user()->doctor->id;

        $Start_Date = $request->Start_Date;
        $End_Date = $request->End_Date;
        $Date_Form = Carbon::parse($Start_Date);
        $Date_To = Carbon::parse($End_Date);
        $diff_in_days = $Date_To->diffInDays($Date_Form);
        //echo $diff_in_days . '<br>';

        //dd($Date_Form);


        $start_time = $request->Start_Time;
        $end_time = $request->End_Time;

        $ST = Carbon::parse($start_time)->format('H:i:s');
        $ET = Carbon::parse($end_time)->format('H:i:s');

        $request['Start_Time'] = $ST;
        $request['End_Time'] = $ET;

        $Reformated_start_time = Carbon::parse($start_time)->format('H:i:s');
        $Reformated_end_time = Carbon::parse($end_time)->format('H:i:s');
        //dd($Reformated_start_date, $Reformated_end_date);

        $Time_Form = Carbon::parse($Reformated_start_time);
        $Time_To = Carbon::parse($Reformated_end_time);
        $diff_in_hours = $Time_To->diffInHours($Time_Form);
        //echo $diff_in_hours;

        //dd($diff_in_hours);

        $StartAfter5days = date('Y-m') . '-' . (date('d') + 5);

        //Get month and year from selected dates ...
        $Start_Date_month = Carbon::parse($Start_Date)->month;
        $End_Date_month = Carbon::parse($End_Date)->month;
        $Start_Date_year = Carbon::parse($Start_Date)->year;
        $End_Date_year = Carbon::parse($End_Date)->year;

        //Validating the requests by default validation rules ...
        $this->validation($request, $StartAfter5days);

        $Get_Appointment = Appointment::where('doctor_id', '=', $Doctor_id)->where('validity', '=', 1)
            ->whereBetween('start_date', [$Start_Date, $End_Date])->whereBetween('end_date', [$Start_Date, $End_Date])
            ->whereYear('start_date', '>=', $Start_Date_year)->whereYear('end_date', '<=', $End_Date_year)
            ->orwhereMonth('start_date', '=', $Start_Date_month, 'OR', 'end_date', '=', $End_Date_month)
            ->where('doctor_id', '=', $Doctor_id)
            ->get();

        //dd($request->all(), $Get_Appointment, $Start_Date_month, $End_Date_month);

        $Count_Appointments = Appointment::where('doctor_id', '=', $Doctor_id)->where('validity', '=', 1)->get();
        //dd($Get_Appointment);
        if (count($Count_Appointments) >= 3) {
            return back()->with('Error', 'You already have 3 appointments with validity. You cannot have more then 3 appointments at once.')->withInput();
        }

        //dd($Get_Appointment);

        /*if($Get_Appointment !== null){ // IF conflicting date is found return false hence return error ....
            return back()->with('Error', 'You already have appointment, from '. $Get_Appointment->start_date . ' to ' . $Get_Appointment->end_date . '. Please select new appointment date after ' . $Get_Appointment->end_date)->withInput();
        }*/
        if (count($Get_Appointment) > 0) { // IF conflicting date is found return false hence return error ....
            return back()->with('Error', 'Your appointment dates are conflicting. Make sure there are no existing appointment on the selected dates.')->withInput();
        } else { // No conflicting dates found ...

            // Date validation ....
            if ($diff_in_days < 7) { // appointment date duration should be at-least 7 days ....
                return back()->with('Error', 'Your appointment should last for at-least 7 days')->withInput();
            } elseif ($diff_in_days > 60) { // appointment date duration should be less then 60 days ....
                return back()->with('Error', 'Your appointment should last for less then or equal to 2 months')->withInput();
            }
            // Time validation ...
            if ($Reformated_start_time > date('H:i:s', strtotime('20:00:00')) || $Reformated_start_time < date('H:i:s', strtotime('6:00:00'))) {
                return back()->with('Error', 'Consultation time should start before 8 Pm and after 6 Am.')->withInput();
            }
            if ($diff_in_hours < 2) {  // Per day appointment duration should be at-least 2 hr ....
                return back()->with('Error', 'Consultation time should be at-least 2hr.')->withInput();
            } elseif ($diff_in_hours > 6) { // appointment buration can be at max 6 hr ....
                return back()->with('Error', 'Consultation time should be less or equal to 8hr.')->withInput();
            }

            // get week days ...
            $Week_Days = array();
            if ($request->has('Sunday')) {
                $Week_Days[] = ucfirst($request->Sunday);
            }
            if ($request->has('Monday')) {
                $Week_Days[] = ucfirst($request->Monday);
            }
            if ($request->has('Tuesday')) {
                $Week_Days[] = ucfirst($request->Tuesday);
            }
            if ($request->has('Wednesday')) {
                $Week_Days[] = ucfirst($request->Wednesday);
            }
            if ($request->has('Thursday')) {
                $Week_Days[] = ucfirst($request->Thursday);
            }
            if ($request->has('Friday')) {
                $Week_Days[] = ucfirst($request->Friday);
            }
            if ($request->has('Saturday')) {
                $Week_Days[] = ucfirst($request->Saturday);
            }
            if (count($Week_Days) <= 1) {
                return back()->with('Error', 'working days should be at-least 2 days')->withInput();
            } elseif (count($Week_Days) > 5) {
                return back()->with('Error', 'Working days should be less then 6 days')->withInput();
            }
            $Week_Days = implode(', ', $Week_Days);

            // Insert data ....
            Appointment::Insert([
                'doctor_id' => $Doctor_id,
                'start_date' => $request->Start_Date,
                'end_date' => $request->End_Date,
                'start_time' => $Reformated_start_time,
                'end_time' => $Reformated_end_time,
                'week_days' => $Week_Days,
                'fees' => $request->Fees,
                'validity' => 1,
            ]);

            Session::forget('Error_create_Appointment');
            return back()->with('Success', 'Appointment successfully created.');
            //dd($request->all());
        }
    }


    public function show()
    {

    }

    public function update(Request $request)
    { // Doctor can update appointment ....

    }

    public function pauseAppointmentBooking($id)
    {
        $id = $this->decryptID($id);

        Appointment::findOrFail($id)->update([
            'booking_status' => 'closed',
        ]);

        //return redirect()->back()->with('Success', 'Appointment booking is set to closed.');
        return back()->with('Success', 'Appointment booking is set to closed.');
    }

    public function startAppointmentBooking($id)
    {
        $id = $this->decryptID($id);

        Appointment::findOrFail($id)->update([
            'booking_status' => 'open',
        ]);

        //return redirect()->back()->with('Success', 'Appointment booking is set to open.');
        return back()->with('Success', 'Appointment booking is set to open.');

    }

    public function delete($id)
    { // Doctor can delete appointment ....
        $id = $this->decryptID($id);

        $AppointmentData = Appointment::where('id', '=', $id)
            ->where('doctor_id', '=', Auth::user()->doctor->id)
            ->first();
        //dd($AppointmentData->id);
        $AppBooking = AppointmentBooking::where('appointment_id', '=', $AppointmentData->id)
            ->join('consultations', 'consultations.appointment_booking_id', 'appointment_bookings.id')
            ->where('status', '!=', 'session end')
            ->get();

        if (count($AppBooking) > 0) {
            //return redirect()->back()->with('Error', 'Unable to delete appointment because you have pending appointment dates to attend.');
            return back()->with('Error', 'Unable to delete appointment because you have pending appointment dates to attend.');
        } else {
            Appointment::findOrFail($AppointmentData->id)->delete();
            //return redirect()->back()->with('Success', 'Appointment successfully deleted.');
            return back()->with('Success', 'Appointment successfully deleted.');
        }
    }

    public function destroy($id)
    { // Doctor can destroy appointment ....

    }


    // Appointment loader methods ...
    public function appointmentLoader(Request $request)
    {
        if ($request->ajax()) {
            $search_Date = $request->date;
            $Search_Department_id = $request->department;
            $Output = '';
            if ($request->has('date') && $request->has('department')) {
                if ($Search_Department_id == 0) {
                    return $this->ByAllDepartmentAndDate($Output, $search_Date);
                } else {
                    return $this->BySpecificDepartmentAndDate($Output, $search_Date, $Search_Department_id);
                }
            } elseif (!$request->has('date') && $request->has('department')) {
                if ($Search_Department_id == 0) {
                    return $this->ByAllDepartmentOnly($Output);
                } else {
                    return $this->BySpecificDepartmentOnly($Output, $Search_Department_id);
                }
            }
        } else {
            abort(404, 'Page not found.');
        }
    }


    public function ByAllDepartmentAndDate($Output, $search_Date)
    {
        //Get doctors(id) who have created appointment ...
        $Get_Doctor_with_appointment = Appointment::where('validity', '=', 1)->select('appointments.doctor_id')->get()->toArray();

        $Doctors_data = User::where('users.id', '!=', Auth::id())
            ->where('email_verified_at', '!=', null)->where('is_admin', '=', 0)->where('blocked', '=', 0)
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'departments.id', 'doctors.department_id')
            ->whereIn('doctors.id', $Get_Doctor_with_appointment)  /// Select doctors with only appointments ...
            ->select('users.id as user_id', 'first_name', 'last_name', 'email', 'department_name', 'doctors.id as doc_id',
                'department_id as dep_id', 'work_place_name', 'experience', 'working_days', 'education', 'doctors.fees', 'nationality', 'avatar')
            ->orderBy('doctors.id', 'ASC')
            ->get();

        //dd($Get_Doctor_with_appointment, $Doctors_data);
        return $this->content($Output, $Doctors_data, $search_Date);
    }

    public function BySpecificDepartmentAndDate($Output, $search_Date, $Search_Department_id)
    {
        //Get doctors(id) who have created appointment ...
        $Get_Doctor_with_appointment = Appointment::where('validity', '=', 1)->select('appointments.doctor_id')->get()->toArray();

        $Doctors_data = User::where('users.id', '!=', Auth::id())
            ->where('email_verified_at', '!=', null)->where('is_admin', '=', 0)->where('blocked', '=', 0)
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->where('doctors.department_id', '=', $Search_Department_id)
            ->join('departments', 'departments.id', 'doctors.department_id')
            ->whereIn('doctors.id', $Get_Doctor_with_appointment)  /// Select doctors with only appointments ...
            ->select('users.id as user_id', 'first_name', 'last_name', 'email', 'department_name', 'doctors.id as doc_id',
                'department_id as dep_id', 'work_place_name', 'experience', 'working_days', 'education', 'doctors.fees', 'nationality', 'avatar')
            ->orderBy('doctors.id', 'ASC')
            ->get();

        //dd($Get_Doctor_with_appointment, $Doctors_data);

        return $this->content($Output, $Doctors_data, $search_Date);
    }

    public function content($Output, $Doctors_data, $search_Date)
    {

        if (count($Doctors_data) > 0) {
            foreach ($Doctors_data as $Data) {
                // Calculate doctor rating ....
                $Ratings = DoctorRating::where('doctor_id', '=', $Data->doc_id)->get();
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
                // End rating calculation

                if ($Data->fees == null || $Data->fees == 0) {
                    $Show_Fees = 'Free';
                } else {
                    $Show_Fees = $Data->fees . ' .TK';
                }

                $Inner = '';
                $Appointments = Appointment::where('doctor_id', '=', $Data->doc_id)->where('validity', '=', 1)
                    ->where('start_date', '<=', $search_Date)->where('end_date', '>=', $search_Date)
                    ->get();

                if (count($Appointments) > 0) {
                    foreach ($Appointments as $Appointment) {
                        $BookAppointment = AppointmentBooking::where('user_id', '=', Auth::id())
                            ->where('appointment_id', '=', $Appointment->id)
                            ->whereBetween('booked_date', [date('Y-m-d', strtotime($Appointment->start_date)), date('Y-m-d', strtotime($Appointment->end_date))])
                            ->first();
                        //dd($BookAppointment, date('Y-m-d', strtotime($Appointment->start_date)), date('Y-m-d', strtotime($Appointment->end_date)));
                        //dd($BookAppointment->booked_time);
                        //echo $BookAppointment->booked_date;
                        $InnerInner = '';
                        $week_days = explode(', ', $Appointment->week_days);
                        //$DateF = date('Y-m-d-l', strtotime($search_Date));
                        //echo $DateF;
                        //$DateX = explode('-', $DateF);
                        $DateName = Carbon::parse($search_Date)->dayName;
                        //echo $DateX[2];
                        if (in_array($DateName, $week_days, true)) {
                            // Very complex calculation ....
                            //echo date('H:i:s', strtotime($Appointment->end_time)) . ' - - -  '.$Appointment->end_time;
                            // Str to time is done twice to prevent the problem of AM and PM
                            $end = strtotime(date('H:i:s', strtotime($Appointment->end_time))); // Appointment End Time ....
                            $start = strtotime(date('H:i:s', strtotime($Appointment->start_time))); // Appointment Start Time ....
                            $Diff = $end - $start; // Difference between start and end time .... Eg: 2hr....
                            $Total_time = $Diff / 60; // Get number of minutes ...
                            $No_Of_patient = $Total_time / (25 + 5); // Get number of patient in the total time ...
                            $No_Of_patient = floor($No_Of_patient); // round down Number of patient ....
                            $loop = ((25 + 5) * 60); // Convert the time to minutes and add 5 min break after each patient
                            $Time = strtotime($Appointment->start_time) - $loop; // Set initial time to zero ...
                            $T = strtotime($Appointment->start_time) - (5 * 60); // to get the end time ...
                            for ($i = 1; $i <= $No_Of_patient; $i++) {
                                $Time += $loop; // Add time per patient to the current time ....
                                $single_time = date('h:i a', $Time); // Display the time in proper format ....

                                // For display on text field end time ...
                                $T += $loop;
                                $E_T = date('h:i a', $T);

                                $Disable = '';
                                $Booked_Time = '';
                                $btn_type = 'btn-primary';
                                $AppointmentBookings = AppointmentBooking::where('appointment_id', '=', $Appointment->id)
                                    ->where('booked_date', '=', $search_Date)->get();
                                //dd($AppointmentBookings);
                                if (count($AppointmentBookings) > 0) {
                                    foreach ($AppointmentBookings as $AB) {
                                        $Booked_Time = date('H:i', strtotime($AB->booked_time));
                                        //echo $Booked_Time.' - '. date('H:i:s', strtotime($single_time)) . ' ';
                                        if (date('Y-m-d', strtotime($AB->booked_date)) == $search_Date && strtotime($Booked_Time) == strtotime(date('H:i:s', strtotime($single_time)))) {
                                            $Disable = ' disabled';
                                            $btn_type = 'btn-warning';
                                        }
                                    }
                                }
                                /*else{
                                    $Booked_Time ='';
                                    //echo 'no appointment booking yet.';
                                }*/
                                $BookApp = AppointmentBooking::where('user_id', '=', Auth::id())->where('booked_date', '=', $search_Date)->get();
                                if (count($BookApp) > 0) {
                                    foreach ($BookApp as $BooAp) {
                                        $All_Booked_Time = date('h:i a', strtotime($BooAp->booked_time));
                                        if (date('Y-m-d', strtotime($BooAp->booked_date)) == $search_Date && strtotime($All_Booked_Time) == strtotime($single_time)) {
                                            $Disable = ' disabled';
                                            $btn_type = 'btn-info';
                                        }
                                    }
                                }
                                if ($BookAppointment !== null) {
                                    $InnerInner = '<div class="alert alert-warning">
                                    You have already booked an appointment. ( <b> Date: </b>  ' .
                                        $BookAppointment->booked_date . ' <b> Time: </b> ' .
                                        date('h:i a', strtotime($BookAppointment->booked_time)) . ' ) </div>';
                                } else {
                                    $InnerInner .= '
                                    <button class="m-t-2 m-b-2 btn ' . $btn_type . ' btn-sm TimeButton"
                                        data-name="' . $Data->first_name . ' ' . $Data->last_name . '"
                                        data-doc_id="' . $Appointment->doctor_id . '"
                                        data-appID="' . $Appointment->id . '"
                                        data-Start-time="' . $single_time . '"
                                        data-Fees="' . $Show_Fees . '"
                                        data-End-time="' . $E_T . '" ' . $Disable
                                        //echo $Date;
                                        // Check for existing booking ...
                                        . '>' . $single_time . '</button>';
                                }
                            }
                        }
                        if ($Appointment->booking_status !== 'open') {
                            $Inner .= '
                            <div class="text-center m-t-5 m-b-5">
                                <div class="alert alert-danger"><b>' . $Appointment->start_date . '</b>  to  <b>' . $Appointment->end_date . '</b>. (Closed)</div>
                            </div>
                            ';
                        } elseif ($Appointment->booking_status == 'open' && $Appointment->booking_start_date >= Carbon::now()) {
                            $Inner .= '
                            <div class="text-center m-t-5 m-b-5">
                                <div class="alert alert-secondary"><b>' . $Appointment->start_date . '</b>  to  <b>' . $Appointment->end_date . '</b>
                                ( ' . $Appointment->week_days . ' ) <br> ( Booking starts from: <b>' . date('j.M.Y', strtotime($Appointment->booking_start_date)) . '</b> )</div>
                            </div>
                            ';
                        } else {
                            $Inner .= '
                            <div class="text-center m-auto alert alert-info col-12">
                                <b>' . $Appointment->start_date . '</b>  to  <b>' . $Appointment->end_date . '</b>
                                ( ' . $Appointment->week_days . ' )
                            </div>
                            <div>
                            ' . $InnerInner . '
                            </div>
                            ';
                        }
                    }
                }

                $Output .= '
                <div class="m-t-10 m-b-10">
                    <div class="p-t-10 p-b-10 rounded" style="box-shadow: 0 2px 2px rgba(0,0,0,.2);">
                        <div class="col-12 text-center" style="position: relative;">
                            <div class="row col-12">
                                <div style="text-align: left;" class="col-12 col-sm-2 col-lg-2">
                                    <img src="' . $Data->avatar . '" alt="" class="rounded m-r-10" height="100" width="100" style="object-fit: cover;object-position: center top;">
                                </div>
                                <div class="text-center col-12 col-sm-12 col-md-10 col-xs-12 col-xl-10 col-lg-10" style="color:#666!important;font-size: 12px;">

                                ' . $Inner . '

                                </div>
                            </div>
                            <div class="text-left">
                                <div class="">
                                    <a target="_blank" href="' . urlencode('doctors-details|' . encrypt($Data->user_id)) . '">
                                        <span style="color: #0d8ddb;">' . $Data->first_name . ' ' . $Data->last_name . '</span>
                                    </a> |
                                    <span style="font-size: 10px;"><b>Hospital: </b> <span> ' . $Data->work_place_name . ' </span></span> |
                                    <span style="font-size: 10px;"><b>Department: </b> <span> ' . $Data->department_name . ' </span></span> |
                                    <span style="font-size: 10px;"><b>Experience: </b> <span> ' . $Data->experience . ' Years</span></span> |
                                    <span style="font-size: 10px;"><b class="p-r-6">Rating: </b>' . round($rating, 2) . ' <i class="fa fa-star" style="color: yellow;text-shadow: 0 0 6px rgba(0,0,0)"></i></span>

                                    <span class="alert alert-success float-right" style="font-size: 12px;"><span>' . $Show_Fees . '</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>No appointments found.</p></div>';
        }

        return response($Output);
    }


    public function ByAllDepartmentOnly($Output)
    {
        //Get doctors(id) who have created appointment ...
        $Get_Doctor_with_appointment = Appointment::where('validity', '=', 1)->select('appointments.doctor_id')->get()->toArray();

        //dd(Appointment::where('validity', '=', 1)->get()->toArray());
        $Doctors_data = User::where('users.id', '!=', Auth::id())
            ->where('email_verified_at', '!=', null)->where('is_admin', '=', 0)->where('blocked', '=', 0)
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'departments.id', 'doctors.department_id')
            ->whereIn('doctors.id', $Get_Doctor_with_appointment)  /// Select doctors with only appointments ...
            ->select('users.id as user_id', 'first_name', 'last_name', 'email', 'department_name', 'doctors.id as doc_id',
                'department_id as dep_id', 'work_place_name', 'experience', 'working_days', 'education', 'doctors.fees', 'nationality', 'avatar')
            ->orderBy('doctors.id', 'ASC')
            ->get();

        //dd($Get_Doctor_with_appointment, $Doctors_data);
        return $this->content2($Output, $Doctors_data);
    }

    public function BySpecificDepartmentOnly($Output, $Search_Department_id)
    {
        //Get doctors(id) who have created appointment ...
        $Get_Doctor_with_appointment = Appointment::where('validity', '=', 1)->select('appointments.doctor_id')->get()->toArray();

        $Doctors_data = User::where('users.id', '!=', Auth::id())
            ->where('email_verified_at', '!=', null)->where('is_admin', '=', 0)->where('blocked', '=', 0)
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->where('doctors.department_id', '=', $Search_Department_id)
            ->join('departments', 'departments.id', 'doctors.department_id')
            ->whereIn('doctors.id', $Get_Doctor_with_appointment)  /// Select doctors with only appointments ...
            ->select('users.id as user_id', 'first_name', 'last_name', 'email', 'department_name', 'doctors.id as doc_id',
                'department_id as dep_id', 'work_place_name', 'experience', 'working_days', 'education', 'doctors.fees', 'nationality', 'avatar')
            ->orderBy('doctors.id', 'ASC')
            ->get();

        //dd($Get_Doctor_with_appointment, $Doctors_data);

        return $this->content2($Output, $Doctors_data);
    }

    public function content2($Output, $Doctors_data)
    {

        if (count($Doctors_data) > 0) {
            foreach ($Doctors_data as $Data) {
                // Calculate doctor rating ....
                $Ratings = DoctorRating::where('doctor_id', '=', $Data->doc_id)->get();
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
                // End rating calculation

                if ($Data->fees == null || $Data->fees == 0) {
                    $Show_Fees = 'Free';
                } else {
                    $Show_Fees = 'Fees: ' . $Data->fees . '.TK';
                }

                $Inner = '';
                $Appointments = Appointment::where('doctor_id', '=', $Data->doc_id)->where('validity', '=', 1)
                    ->get();

                if (count($Appointments) > 0) {
                    foreach ($Appointments as $Appointment) {

                        if ($Appointment->booking_status !== 'open') {
                            $Inner .= '
                            <div class="text-center m-t-5 m-b-5">
                                <div class="alert alert-danger"><span style="text-decoration: line-through;"><b>' . $Appointment->start_date . '</b>  to  <b> ' . $Appointment->end_date . '</b>( ' . $Appointment->week_days . ' ).</span> (Closed)</div>
                            </div>
                            ';
                        } elseif ($Appointment->booking_status == 'open' && $Appointment->booking_start_date >= Carbon::now()) {
                            $Inner .= '
                            <div class="text-center m-t-5 m-b-5">
                                <div class="alert alert-secondary"><b>' . $Appointment->start_date . '</b>  to  <b>' . $Appointment->end_date . '</b>
                                ( ' . $Appointment->week_days . ' ) <br> ( Booking starts from: <b>' . date('j.M.Y', strtotime($Appointment->booking_start_date)) . '</b> )</div>
                            </div>
                            ';
                        } else {
                            $Inner .= '
                            <div class="text-center alert alert-info col-12 m-auto">
                                <b>' . $Appointment->start_date . '</b>  to  <b>' . $Appointment->end_date . '</b>
                                ( ' . $Appointment->week_days . ' ). (<strong>Open</strong>)
                            </div>
                            <div>

                            </div>
                            ';
                        }

                    }
                }

                $Output .= '
                <div class="m-t-10 m-b-10">
                    <div class="p-t-10 p-b-10 rounded" style="box-shadow: 0 2px 2px rgba(0,0,0,.2);">
                        <div class="col-12 text-center" style="position: relative;">
                            <div class="row col-12">
                                <div style="text-align: left;" class="col-12 col-sm-2 col-lg-2">
                                    <img src="' . $Data->avatar . '" alt="" class="rounded m-r-10" height="100" width="100" style="object-fit: cover;object-position: center top;">
                                </div>
                                <div class="text-center col-12 col-sm-12 col-md-10 col-xs-12 col-xl-10 col-lg-10" style="color:#666!important;font-size: 12px;">

                                ' . $Inner . '

                                </div>
                            </div>
                            <div class="text-left">
                                <div class="">
                                    <a target="_blank" href="' . urlencode('doctors-details|' . encrypt($Data->user_id)) . '">
                                        <span style="color: #0d8ddb;">' . $Data->first_name . ' ' . $Data->last_name . '</span>
                                    </a> |
                                    <span style="font-size: 10px;"><b>Hospital: </b> <span> ' . $Data->work_place_name . ' </span></span> |
                                    <span style="font-size: 10px;"><b>Department: </b> <span> ' . $Data->department_name . ' </span></span> |
                                    <span style="font-size: 10px;"><b>Experience: </b> <span> ' . $Data->experience . ' Years</span></span> |
                                    <span style="font-size: 10px;"><b class="p-r-6">Rating: </b>' . round($rating, 2) . ' <i class="fa fa-star" style="color: yellow;text-shadow: 0 0 6px rgba(0,0,0)"></i></span>

                                    <span class="alert alert-success float-right" style="font-size: 12px;"><span>' . $Show_Fees . '</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>No appointments found.</p></div>';
        }

        return response($Output);
    }


}
