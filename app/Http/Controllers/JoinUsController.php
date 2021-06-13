<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Department;
use App\Doctor;
use App\Role;
use App\Rules\FullName;
use App\Rules\NameValidate;
use App\Rules\OneWordName;
use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\Rules\WordCountRule;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JoinUsController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // prevent logged in user from accessing this page ...
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        //$countries = Country::all();
        $departments = Department::orderBy('department_name', 'ASC')->get();
        return view('auth.join_us', compact('arr_ip', 'departments'));
    }

    // lists('name', 'id')

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function dataValidation($request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:3', 'max:60', new NameValidate, new FullName],
            'email' => 'required|string|email|unique:users|max:80|',
            'password' => 'required|string|max:80|min:8|confirmed|',
            'dob' => 'required|date|',
            'phone' => ['required', 'numeric', 'unique:users', 'regex:/(01)[0-9]{9}/', new PhoneMinLength, new PhoneMaxLength],
            'gender' => 'required|string|',
            'Profile_Image' => 'required|image|mimes:jpg,jpeg,JPG,JPEG|',
            'nationality' => ['required', 'string', new OneWordName],
            'location' => 'sometimes|string',
            'auto_locate' => 'sometimes|string|',
            'education' => ['required', 'string', new WordCountRule('Education', 1, 4)],
            'work_place_name' => ['required', 'string', new WordCountRule('Work place name', 2, 12)],
            'department' => 'required|',
            'experience' => 'required|numeric|min:1|max:50',
            'Work_Document' => 'required|file|mimes:pdf|',
            'terms_and_condition' => 'required|string|',
        ], [
            'full_name.required' => 'Full name is required.',
            'full_name.string' => 'Full name must be a string.',
            'full_name.min' => 'Full name must be a at-least 3 letters.',
            'full_name.max' => 'Full name must be less then 60 words.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Email address must be an email.',
            'email.unique' => 'Account already exists with this email address.',
            'email.max' => 'Email address is too long.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password should be at-least 8 characters.',
            'password.max' => 'Password should be less then 80 characters.',
            'password.confirmed' => 'Password and Confirm password did not match.',

            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Date of birth must be a date.',

            'phone.required' => 'Phone number is required.',
            'phone.numeric' => 'Phone number must be numeric.',
            'phone.min' => 'Phone number must be more then 7 digit.',
            'phone.unique' => 'Account already exists with this phone number.',

            'gender.required' => 'Gender is required.',
            'gender.string' => 'Gender must be string.',

            'Profile_Image.required' => 'Profile image is required.',
            'Profile_Image.image' => 'Profile image must be a image file.',
            'Profile_Image.mimes' => 'Profile image must be jpg, jpeg file.',

            'nationality.required' => 'Nationality is required.',
            'nationality.string' => 'Nationality must be a string.',

            'education.required' => 'Educational qualification is required.',

            'work_place_name.required' => 'Work place name is required.',

            'department.required' => 'Department name is required.',

            'experience.required' => 'Experience is required',
            'experience.numeric' => 'Experience must be a numeric value.',
            'experience.min' => 'Experience must a positive numeric value.',
            'experience.max' => 'You are too much experienced. Please retire.',

            'Work_Document.required' => 'Work document is required.',
            'Work_Document.file' => 'Work document must be a file',
            'Work_Document.mimes' => 'Work document must be a PDF file.',

            'terms_and_condition.required' => 'You must accept the terms and conditions.',
            'terms_and_condition.string' => 'Terms and conditions must be a string.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->dataValidation($request);

        $Full_name = $request->full_name;
        $split_name = explode(' ', $Full_name);
        $first_name = $split_name[0];
        $last_name = implode(' ', array_slice($split_name, 1));

        // Image Upload
        if ($request->hasFile('Profile_Image')) {
            $get_image = $request->file('Profile_Image'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('jpg', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed_Ext, true) == false) {
                return back()->withErrors('Error', 'Blog image can only contain jpg, jpeg and png file.');
            }
            $newFileName = $Full_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....
            $ImgLocation = '/public/user_data/doctor/';
            $get_image->storeAs($ImgLocation, $newFileName); // set the storage path ...
            $StorageLink = $this->domain_image_url().'/storage/user_data/doctor/' . $newFileName;
        }

        // Check doctor document ...
        if ($request->hasFile('Work_Document')) {
            $get_image = $request->file('Work_Document'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('pdf');
            if (in_array(strtolower($extension), $allowed_Ext, true) == false) {
                return back()->withErrors('Error', 'Work place document must be a pdf file.');
            }
            $newFileName = $Full_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....
            $fileLocation = '/public/user_data/doctor/document/';
            $get_image->storeAs($fileLocation, $newFileName); // set the storage path ...
            $StorageLink2 = $this->domain_image_url().'/storage/user_data/doctor/document/' . $newFileName;
        }

        if ($request->has('auto_locate')) {
            $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
            $Location = encrypt($arr_ip);
        } elseif ($request->has('location')) {
            $Location = $request->location;
            $Location_array = explode(',', $Location);
            if (count($Location_array) < 3) {
                return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State');
            } else {
                foreach ($Location_array as $loc) { // Send error if words in location are less then 3 letters ...
                    if (strlen($loc) < 3) {
                        return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State');
                    }
                }
            }
        }

        $User = User::create([
            'first_name' => ucfirst(trim($first_name)),
            'last_name' => ucfirst(trim($last_name)),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'avatar' => $StorageLink,
            'blood_group' => $request->blood_group,
            'location' => $Location,
            'created_at' => Carbon::now(),
        ]);
        $User_id = $User->id;
        // need to attach a role for the doctor
        $User->role()->attach(Role::where('name', 'Doctor')->first());

        Doctor::create([
            'user_id' => $User_id,
            'department_id' => $request->department,
            'nationality' => ucfirst($request->nationality),
            'work_place_name' => $request->work_place_name,
            'work_place_document' => $StorageLink2,
            'education' => $request->education,
            'experience' => $request->experience,
            'created_at' => Carbon::now(),
        ]);

        session()->flash('Success', 'Your join request is submitted and is under review by our admins. Wait for an Email response.');
        return redirect('login');

        /*//$arr_ip = geoip()->getLocation('77.111.246.63');
        $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        dd($arr_ip);*/
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function verifyEmail($token = null)
    {
        if ($token == null) {
            //return redirect('login');
            abort(403, 'Invalid token or Invalid URL.');
        }
        $Doc = Doctor::where('email_verification_token', '=', $token)->first();
        if ($Doc == null) {
            abort(403, 'Invalid token or Invalid URL.');
        } else {
            $User_id = $Doc->user->id;
            User::where('id', '=', $User_id)->update([
                'email_verified_at' => Carbon::now(),
            ]);
            Doctor::where('user_id', '=', $User_id)->update([
                'email_verification_token' => null,
            ]);
        }
        session()->flash('Success', 'Account successfully verified. You can login.');
        return redirect('login');
    }


}
