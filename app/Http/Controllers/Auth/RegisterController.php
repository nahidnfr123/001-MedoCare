<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\Rules\NameValidate;
use App\Rules\OneWordName;
use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'min:3', 'max:30', new OneWordName, new NameValidate],
            'last_name' => ['required', 'string',  'min:3', 'max:30', new OneWordName, new NameValidate],
            'email' => ['required', 'string', 'email', 'max:60', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:80', 'confirmed'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'numeric', 'unique:users', 'regex:/(01)[0-9]{9}/', new PhoneMinLength , new PhoneMaxLength],
            'gender' => ['required', 'string', 'min:4', 'max:6'],
            'blood_group' => ['required', 'string'],
        ], $custom_msg = [
            'first_name.required'=>'First name is required.',
            'first_name.string'=>'First name should be string.',
            'first_name.min:3'=>'First name should be at length is 3 letters',
            'first_name.max:30'=>'First name maximum length is 30 ',

            'last_name.required'=>'Last name is required.',
            'last_name.string'=>'Last name should be string.',
            'last_name.min:3'=>'Last name should be at length is 3 letters',
            'last_name.max:30'=>'Last name maximum length is 30 ',

            'email.required'=>'Email is required.',
            'email.email'=>'Email must be an email.',
            'email.max'=>'Email must be less then 60 characters.',
            'email.unique'=>'Account already exists with this email address.',

            'password.required'=>'Password is required.',
            'password.min'=>'Password should be at-least 8 characters.',
            'password.max'=>'Password should be less then 80 characters.',
            'password.confirmed'=>'Password and confirm password did not match.',

            'dob.required'=>'Date of birth is required.',
            'dob.date'=>'Date of birth must be in correct date format.',

            'phone.required'=>'Phone number is required.',
            'phone.numeric'=>'Phone number must be numeric.',
            'phone.min'=>'Phone number should be at-least 8 digit.',
            'phone.unique'=>'Phone number is take.',

            'gender.required'=>'Gender is required.',
            'gender.string'=>'Gender must be a string.',
            'gender.min'=>'Gender should be at-least 4 letters.',
            'gender.max'=>'Gender should be less then 7 letters.',

            'blood_group.required'=>'Blood group is required.',
            'blood_group.string'=>'Blood group must be a string.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // set default profile image ... //
        if($data['gender'] == 'male'){
            $avatar = $this->domain_image_url().'/storage/user_data/profile/male_default.png';
        }
        elseif($data['gender'] == 'female'){
            $avatar = $this->domain_image_url().'/storage/user_data/profile/female_default.png';
        }
        else{
            $avatar = $this->domain_image_url().'/storage/user_data/profile/avatar_default.png';
        }

        /*if($data['User_Type'] == 'Patient'){
            $User = User::find(1);
            $User->role()->attach(1);
        }*/

        $User = User::create([
            'first_name' => ucfirst(trim($data['first_name'])),
            'last_name' => ucfirst(trim($data['last_name'])),
            'email' => trim($data['email']),
            'password' => Hash::make($data['password']),
            'dob' => trim($data['dob']),
            'phone' => trim($data['phone']),
            'gender' => trim($data['gender']),
            'avatar' => $avatar,
            'active' => 1,
            'blood_group' => trim($data['blood_group']),
        ]);
        $User->role()->attach(Role::where('name', 'Patient')->first()); // Set User to a particular role ...

        session()->flash('Success', 'Your account was registered. Please login to your account.');
        return redirect('login'); // With not working session flash is used instead ...
        /*view('auth.login')*/
    }
}
