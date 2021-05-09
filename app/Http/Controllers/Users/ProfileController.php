<?php

namespace App\Http\Controllers\Users;

use App\Appointment;
use App\Consultation;
use App\PatientReport;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        $Data = User::findOrFail(Auth::id());

        if(Auth::user()->role()->pluck('name')->first() == 'Doctor'){
            $Get_Appointment = Appointment::orderBy('start_date', 'ASC')
                ->where('doctor_id', '=', $Data->doctor->id)
                ->where('validity', '=', 1)
                /*->where('booking_status', '=', 'open')*/
                ->get();
            //dd(Auth::user()->doctor->appointment);
            // Show all conversations ..
            $Consultations  = Consultation::where('doctor_id','=', Auth::user()->doctor->id)
                ->where('status', '!=', 'pending')->orderBy('id', 'DESC')
                ->get();
            //dd($Consultations);
            return view('pages.user_profile.profile', compact('Data', 'arr_ip', 'Get_Appointment', 'Consultations'));
        }
        elseif(Auth::user()->role()->pluck('name')->first() == 'Patient'){
            //dd($Data->consultation);
            $ConsultationsNotDone = $Data->consultation()->where('status','!=' ,'session end')->get();
            $ConsultationsDone = $Data->consultation()->where('status', 'session end')->orderBy('id', 'Desc')->take(6)->get();


            // Show all conversations ..
            $Consultations  = Consultation::where('user_id','=', Auth::id())
                ->where('status', '!=', 'pending')->orderBy('id', 'DESC')
                ->get();
            //dd($Consultations);

            return view('pages.user_profile.profile', compact('Data', 'arr_ip', 'ConsultationsDone', 'ConsultationsNotDone', 'Consultations'));
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

    }

    public function updateAvatar(Request $request){
        $request->validate([
            'uid' => 'required',
            'Profile_image' => 'required|image|mimes:jpg,jpeg,gif',
        ]);

        $User = User::findOrFail($request->uid);

        $Full_name = strtolower($User->first_name) . ' ' . strtolower($User->last_name);
        $StorageLink = '';
        // Image Upload
        if($request->hasFile('Profile_image')) {
            $get_image = $request->file('Profile_image'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('jpg', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed_Ext, true) == false) {
                return back()->withErrors('Error', 'Blog image can only contain jpg, jpeg and png file.');
            }
            $newFileName = $Full_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....

            if(Auth::user()->role()->pluck('name')->first() == 'Patient'){
                $Location = '/public/user_data/patient/';
                $get_image->storeAs($Location, $newFileName); // set the storage path ...
                $StorageLink = '/storage/user_data/patient/' . $newFileName;
            }
            elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){
                $Location = '/public/user_data/doctor/';
                $get_image->storeAs($Location, $newFileName); // set the storage path ...
                $StorageLink = '/storage/user_data/doctor/' . $newFileName;
            }
        }

        User::findOrFail($User->id)->update([
            'avatar' => $StorageLink,
            'updated_at' => Carbon::now(),
        ]);

        return back()->with('Success', 'Profile picture successfully updated.');
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
