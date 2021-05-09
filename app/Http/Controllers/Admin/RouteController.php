<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    // Require login ...
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $Dashboard_Msg = \App\ContactUs::orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->take(6)->get();
        $Blog = Blog::orderBy('publish_date', 'DESC')->orderBy('id', 'DESC')->where('publish_date', '<', Carbon::now())->take(2)->get();

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
            ->get();
        $countNot_verified_Doctors = count($Not_verified_Doctors);

        $Verified_Doctors = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('users.email_verified_at' , '!=', null)
            ->where('roles.name' , '=', 'Doctor')
            ->where('users.deleted_at', '=', null)
            ->where('users.blocked', '=', 0)
            ->where('doctors.deleted_at', '=', null)
            ->select('users.*', 'users.id as user_id', 'roles.*', 'doctors.*', 'doctors.id as doc_id', 'departments.*')
            ->get();
        $countVerified_Doctors = count($Verified_Doctors);

        $Patient = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('patients', 'patients.user_id', 'users.id')
            ->where('users.email_verified_at' , '!=', null)
            ->where('roles.name' , '=', 'Patient')
            ->where('users.deleted_at', '=', null)
            ->where('users.blocked', '=', 0)
            ->select('users.*', 'users.id as user_id', 'roles.*', 'patients.*')
            ->get();
        $countPatient = count($Patient);

        return view('admin.dashboard', compact('Blog', 'Dashboard_Msg', 'countNot_verified_Doctors', 'countVerified_Doctors', 'countPatient', 'Verified_Doctors'));
    }
}
