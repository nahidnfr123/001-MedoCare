<?php

namespace App\Http\Controllers\Admin;

use App\Doctor;
use App\Mail\DoctorVerification;
use App\Mail\EmailVerification;
use App\Mail\SendEmail;
use App\Patient;
use App\Role;
use App\Rules\NameValidate;
use App\Rules\OneWordName;
use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManageUserController extends Controller
{
    /*public function test_user_&_role()
    {
        $Patients = User::all();
        //$User = User::find(2)->role;
        //$U = Auth::user()->role->id;
        //$role = User::has('role', '=' , 1)->get();
        //$role = User::find(2)->role()->orderBy('name')->get(); // Working

        $role = Auth::user()->role()->pluck('name')->first(); // Working Good
        dd($role);


        // Get patients Join table ...
        $Patients = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('patients', 'patients.user_id', 'users.id')
            ->where('roles.name' , '=', 'patient')
            ->get();
        //dd($Patients);
    }*/

    public function view_patients(){
        $Patients_data = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('patients', 'patients.user_id', 'users.id')
            ->where('roles.name' , '=', 'Patient')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'patients.*')
            ->get();
        //$Patients_data = User::where('is_admin','=','0')->role()->orderBy('name')->get();
        //dd($Patients_data);
        return view('admin.manage_users.patient', compact('Patients_data'));
    }


    public function showPatient($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $ViewPatient = User::where('users.id', '=', $id)
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('patients', 'patients.user_id', 'users.id')
            ->where('roles.name' , '=', 'Patient')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'patients.*')
            ->first();
        return view('admin.manage_users.view_patient', compact('ViewPatient'));
    }

    public function view_doctors(){
        $Not_verified_Doctors = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('users.email_verified_at' , '=', null)
            ->where('roles.name' , '=', 'Doctor')
            ->where('users.deleted_at', '=', null)
            ->where('doctors.deleted_at', '=', null)
            ->select('users.*', 'users.id as user_id', 'roles.*', 'doctors.*', 'departments.*')
            ->paginate(6);

        $Doctors_data = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            /*->join('doctor_ratings', 'doctor_ratings.doctor_id', 'doctor_ratings.id')*/
            ->where('users.email_verified_at' , '!=', null)
            ->where('roles.name' , '=', 'Doctor')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'doctors.id as doc_id', 'departments.*')
            ->get();

            $Ignore_request = DB::table('users')
                ->join('role_user', 'users.id', 'role_user.user_id')
                ->join('roles', 'roles.id', 'role_user.role_id')
                ->join('doctors', 'doctors.user_id', 'users.id')
                ->join('departments', 'doctors.department_id', 'departments.id')
                /*->join('doctor_ratings', 'doctor_ratings.doctor_id', 'doctor_ratings.id')*/
                ->where('roles.name' , '=', 'Doctor')
                ->where('users.email_verified_at' , '=', null)
                ->where('users.deleted_at' , '!=', null)
                ->where('doctors.email_sent' , '=', 0)
                ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'departments.*')
                ->get();

        return view('admin.manage_users.doctor', compact('Not_verified_Doctors', 'Doctors_data', 'Ignore_request'));
    }

    public function showDoctor($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $ViewDoctor = User::where('users.id', '=', $id)
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('roles.name' , '=', 'Doctor')
            ->select('users.*', 'users.id as user_id', 'roles.*', 'doctors.*', 'departments.*')
            ->first();
        return view('admin.manage_users.view_doctor', compact('ViewDoctor'));
    }




    public function sendAccountActivationToken($id){ // send the account activation mail to doctor ...
        $id = $this->decryptID($id);
        $User = User::findOrFail($id);
        //$Doc = $User->doctor;
        //dd($Doc);
        Doctor::where('user_id', '=', $id)->update([
            'email_verification_token' => str_shuffle(Str::random(32)),
            'email_sent' => 1
        ]);
        Mail::to($User->email)->send(new DoctorVerification($User));
        return back()->with('Success', 'Account activation code successfully sent.');
    }




    // Ignore doctor join request ....
    public function ignoreRequest(Request $request){
        $request->validate([
            'ID' => 'required|numeric',
            'Email' => 'required|email|string',
            'Subject' => 'required|string',
            'Message' => 'required|string',
        ],[
            'ID.required' => 'User id is required.',
            'ID.numeric' => 'User id must be numeric.',

            'Email.required' => 'User email is required.',
            'Email.email' => 'User email must be an email.',

            'Subject.required' => 'Email Subject is required.',
            'Subject.subject' => 'Email Subject must be a string.',

            'Message.required' => 'Message is required.',
            'Message.string' => 'Message must be a string.',
        ]);

        if(str_word_count($request->Message) < 20){
            return back()->with('Error', 'Message must be more then 20 words')->withInput();
        }
        $User = User::findOrFail($request->ID);

        $name = $User->first_name . ' ' . $User->last_name;

        $data = array(
            'name' => $name,
            'email' => $request->Email,
            'message_subject' => ucfirst($request->Subject),
            'message_body' => ucfirst($request->Message),
        );

        Mail::to($request->Email)->send(new SendEmail($data));

        Doctor::where('user_id', '=', $User->id)->delete();
        User::findOrFail($request->ID)->delete();

        return back()->with('Success', 'Ignore response successfully sent.');
    }





    // Block user account...
    public function blockUser(Request $request){
        $request->validate([
            'ID' => 'required|numeric',
            'Email' => 'required|email|string',
            'Subject' => 'required|string',
            'Message' => 'required|string',
        ],[
            'ID.required' => 'User id is required.',
            'ID.numeric' => 'User id must be numeric.',

            'Email.required' => 'User email is required.',
            'Email.email' => 'User email must be an email.',

            'Subject.required' => 'Email Subject is required.',
            'Subject.subject' => 'Email Subject must be a string.',

            'Message.required' => 'Message is required.',
            'Message.string' => 'Message must be a string.',
        ]);

        if(str_word_count($request->Message) < 20){
            return back()->with('Error', 'Message must be more then 20 words')->withInput();
        }
        $User = User::findOrFail($request->ID);
        $name = $User->first_name . ' ' . $User->last_name;
        $data = array(
            'name' => $name,
            'email' => $request->Email,
            'message_subject' => ucfirst($request->Subject),
            'message_body' => ucfirst($request->Message),
        );

        Mail::to($request->Email)->send(new SendEmail($data));
        User::findOrFail($request->ID)->update(['blocked' => 1]);
        return back()->with('Success', 'Account successfully blocked.');
    }





    //Unblock user account...
    public function unblockUser($id){
        $id = $this->decryptID($id);
        $User = User::findOrFail($id);

        $name = $User->first_name . ' ' . $User->last_name;
        $Email = $User->email;
        $data = array(
            'name' => $name,
            'email' => $Email,
            'message_subject' => ucfirst('Account unblocked.'),
            'message_body' => ucfirst('Your account is unblocked, you can now login to your account.'),
        );

        Mail::to($Email)->send(new SendEmail($data));
        User::findOrFail($id)->update(['blocked' => 0]);
        return back()->with('Success', 'Account successfully unblocked.');
    }




    // Delete user acount
    public function delete(Request $request){
        $request->validate([
            'ID' => 'required|numeric',
            'Email' => 'required|email|string',
            'Subject' => 'required|string',
            'Message' => 'required|string',
        ],[
            'ID.required' => 'User id is required.',
            'ID.numeric' => 'User id must be numeric.',

            'Email.required' => 'User email is required.',
            'Email.email' => 'User email must be an email.',

            'Subject.required' => 'Email Subject is required.',
            'Subject.subject' => 'Email Subject must be a string.',

            'Message.required' => 'Message is required.',
            'Message.string' => 'Message must be a string.',
        ]);

        if(str_word_count($request->Message) < 20){
            return back()->with('Error', 'Message must be more then 20 words')->withInput();
        }

        $User = User::findOrFail($request->ID);
        $name = $User->first_name . ' ' . $User->last_name;
        $data = array(
            'name' => $name,
            'email' => $request->Email,
            'message_subject' => ucfirst($request->Subject),
            'message_body' => ucfirst($request->Message),
        );

        Mail::to($request->Email)->send(new SendEmail($data));
        User::withoutTrashed()->findOrFail($User->id)->delete();

        if($User->role()->pluck('name')->first() == 'Patient'){
            Patient::withoutTrashed()->where('user_id', '=', $User->id)->delete();
        }
        else if($User->role()->pluck('name')->first() == 'Doctor'){
            Doctor::withoutTrashed()->where('user_id', '=', $User->id)->delete();
        }
        return back()->with('Success', 'Account successfully deleted.');
    }



    public function restore($id){
        $id = $this->decryptID($id);
        $User = User::onlyTrashed()->findOrFail($id);

        $name = $User->first_name . ' ' . $User->last_name;
        $Email = $User->email;
        $data = array(
            'name' => $name,
            'email' => $Email,
            'message_subject' => ucfirst('Account unblocked.'),
            'message_body' => ucfirst("Your account was deleted, It is now restored with all your information's. Now you can login to your account."),
        );

        Mail::to($Email)->send(new SendEmail($data));

        User::onlyTrashed()->findOrFail($User->id)->restore();

        if($User->role()->pluck('name')->first() == 'Patient'){
            Patient::onlyTrashed()->where('user_id', '=', $User->id)->restore();
        }
        else if($User->role()->pluck('name')->first() == 'Doctor'){
            Doctor::onlyTrashed()->where('user_id', '=', $User->id)->restore();
        }
        return back()->with('Success', 'Account successfully restored.');
    }




    public function sendEmail (Request $request){
        $request->validate([
            'ID' => 'required|numeric',
            'Email' => 'required|email|string',
            'Subject' => 'required|string',
            'Message' => 'required|string',
        ],[
            'ID.required' => 'User id is required.',
            'ID.numeric' => 'User id must be numeric.',

            'Email.required' => 'User email is required.',
            'Email.email' => 'User email must be an email.',

            'Subject.required' => 'Email Subject is required.',
            'Subject.subject' => 'Email Subject must be a string.',

            'Message.required' => 'Message is required.',
            'Message.string' => 'Message must be a string.',
        ]);

        if(str_word_count($request->Message) < 20){
            return back()->with('Error', 'Message must be more then 20 words')->withInput();
        }
        $User = User::findOrFail($request->ID);
        $name = $User->first_name . ' ' . $User->last_name;
        $data = array(
            'name' => $name,
            'email' => $request->Email,
            'message_subject' => ucfirst($request->Subject),
            'message_body' => ucfirst($request->Message),
        );

        Mail::to($request->Email)->send(new SendEmail($data));
        return back()->with('Success', 'Email successfully sent.');
    }


    public function create(){
        return view('admin.manage_users.create_user');
    }

    public function store(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:30', new OneWordName, new NameValidate],
            'last_name' => ['required', 'string',  'min:3', 'max:30', new OneWordName, new NameValidate],
            'email' => ['required', 'string', 'email', 'max:60', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:80', 'confirmed'],
            'phone' => ['required','numeric','unique:users', 'regex:/(01)[0-9]{9}/', new PhoneMinLength, new PhoneMaxLength],
            'gender' => 'required|string',
            'dob' => ['required', 'date'],
        ],[

        ]);

        $Date = strtotime($request->dob); //Initial date format ....
        $Time = date('H:i:s'); // get current time ...
        $dob = date('Y/m/d '.$Time, $Date);


        // set default profile image ... //
        if($request->gender == 'male'){
            $avatar = $this->domain_image_url().'/storage/user_data/admin/male_default.png';
        }
        elseif($request->gender == 'female'){
            $avatar = $this->domain_image_url().'/storage/user_data/admin/female_default.png';
        }
        else{
            $avatar = $this->domain_image_url().'/storage/user_data/admin/avatar_default.png';
        }

        $User = User::create([
            'first_name' => ucfirst($request->first_name),
            'last_name' =>  ucfirst($request->last_name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $dob,
            'avatar' => $avatar,
            'is_admin' => true,
            'created_at' => Carbon::now(),
        ]);

        $data = array(
            'name' => ucfirst($request->first_name) . ' ' . ucfirst($request->last_name),
            'email' => strtolower($request->email),
            'message_subject' => ucfirst('An admin account was created for you.'),
            'message_body' => ucfirst('An admin accoount was created by your email address. <br> Your credentials, <br> Email: '.strtolower($request->email).' <br> Password: '.$request->password.''),
        );

        $User->role()->attach(Role::where('name', 'Admin')->first()); // Set User to a particular role ...

        Mail::to(strtolower($request->email))->send(new SendEmail($data));

        return back()->with('Success', 'A new admin successfully added.');

        // remember_token
    }



}
