<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Doctor;
use App\DoctorRating;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorSearchController extends Controller
{
    /*public function __construct(Request $request)
    {
        $Department_id = $request->department_id;
        if($Department_id == 0){
            $this->index($request->all());
        }
    }*/

    public function index(Request $request){ // Process ajax search logic
        if(Auth::check()){
            $Active_User = auth()->user()->id;
        } else{
            $Active_User = 0;
        }
        if($request->ajax()) {
            $Output = '';

            if($request->has('department_id') && !$request->has('doctor_name')){
                $Department_id = $request->department_id;
                if($Department_id == 0){
                    return $this->allDoctors($Department_id, $Output, $Active_User);
                }
                elseif($Department_id != 0){
                    return $this->bydepartment($Department_id, $Output, $Active_User);
                }
            }
            elseif($request->has('department_id') && $request->has('doctor_name')){
                $Department_id = $request->department_id; $Doctor_name = $request->doctor_name;
                if($Department_id == 0){
                    return $this->allDoctorsByName($Doctor_name, $Output, $Active_User);
                }
                elseif($Department_id != 0){
                    return $this->byDepartmentAndName($Department_id, $Doctor_name, $Output, $Active_User);
                }
            }
        }
        else{
            abort(404, 'Page not found.');
        }
    }



    public function allDoctors($Department_id, $Output, $Active_User){ // Select doctor from all departments ....
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




    public function allDoctorsByName($Doctor_name, $Output, $Active_User){ // Search doctors from all department by name ...
        $Doctors  = User::where('is_admin', '=', 0)
            ->where('users.id', '!=', $Active_User)
            ->where('users.first_name', 'like', '%'.$Doctor_name.'%')
            ->orWhere('users.last_name', 'like', '%'.$Doctor_name.'%')
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



    public function byDepartmentAndName($Department_id, $Doctor_name, $Output, $Active_User){ // Select doctor from all departments ....
        $Doctors  = User::where('is_admin', '=', 0)
            ->where('users.id', '!=', $Active_User)
            ->where('users.first_name', 'like', '%'.$Doctor_name.'%')
            /*->where('users.last_name', 'like', '%'.$Doctor_name.'%')*/
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
        if(count($Doctors) > 0) {
            foreach ($Doctors as $Doctor) {
                /*if ($Doctor->status == 1) {
                    $onlineOut = '<div class="online_ab rounded"><i class="fa fa-circle" style="color: greenyellow;"></i> online now</div>';
                } else {
                    $onlineOut = '';
                }*/
                if($Doctor->userIsOnline()){
                    $onlineOut = '<div class="online_ab rounded"><i class="fa fa-circle" style="color: greenyellow;"></i> online </div>';
                } else {
                    $onlineOut = '';
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

                $Output .= '
                    <div class="col-12 col-md-4 col-lg-3 m-t-10 m-b-10 Doc_Each wow fadeIn">
                        <div class="p-t-10 p-b-10 rounded" style="box-shadow: 0 2px 2px rgba(0,0,0,.2);">
                            <div class="col-12 text-center doc_img_div" style="position: relative;">
                            ' . $onlineOut . '
                                <img src="' . $Doctor->avatar . '" alt="" class="Doc_Each_Img">
                                <div class="filter_cover text-center">
                                    <a href="' . urlencode('doctors-details|') . encrypt($Doctor->users_id) . '" class="btn btn-primary btn-sm Doc_Details_btn">More Details</a>
                                    <div class="display_doc_details">
                                        <div>Hospital: <span style="color: #ffffff;">' . $Doctor->work_place_name . '</span></div>
                                        <div>Experience: <span style="color: #ffffff;">' . $Doctor->experience . ' Years</span></div>
                                        <div>Rating: <span style="color: #ffffff;">
                                            ' . $rating . ' <i class="fa fa-star" style="color: yellow;"></i>
                                        </span></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-12">
                                <div>Name: <a href="' . urlencode('doctors-details|') . encrypt($Doctor->users_id) . '"><span style="color: #0d8ddb;">' . $Doctor->first_name . ' ' . $Doctor->last_name . '</span></a></div>
                                <div>Department: <span style="color: #0d8ddb;">' . $Doctor->department_name . '</span></div>
                            </div>
                        </div>
                    </div>
                    ';
            }
        }else{
            $Output .= '<div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>No doctors found</p></div>';
        }
        return response($Output);
    }

}
