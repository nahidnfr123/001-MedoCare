<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Admin') {
            $this->redirectTo = route('admin.dashboard');
        } else{
            $this->redirectTo = route('user.user-profile');
        }
        // Destroy cookies if exists ....
        Cookie::queue(Cookie::forget('EmergencyConsultation'));
        Cookie::queue(Cookie::forget('RequestAppointment'));
        Cookie::queue(Cookie::forget('Token'));

        $this->middleware('guest')->except('logout');
    }
}
