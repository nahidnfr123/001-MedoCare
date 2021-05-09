<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Blog;
use App\Consultation;
use App\Conversation;
use App\Department;
use App\Doctor;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendRoutesController extends Controller
{
    public function index(){
        $Departments = Department::orderBy('department_name', 'ASC')->get();
        //$Blog = Blog::orderBy('id', 'DESC')->take(3)->get();
        $Blog = Blog::orderBy('publish_date', 'DESC')->orderBy('id', 'DESC')->where('publish_date', '<', Carbon::now())->take(3)->get();

        if(Auth::check()){
            $Active_User = auth()->user()->id;
        } else{
            $Active_User = 0;
        }

        $Doctors = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('users.id' , '!=', $Active_User)
            ->where('users.email_verified_at' , '!=', null)
            ->where('users.blocked' , '=', 0)
            ->where('roles.name' , '=', 'Doctor')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'doctors.id as doc_id', 'departments.*')
            ->orderBy('users.status', 'DESC')
            ->orderBy('users.id', 'ASC')
            ->get();


        $Users = User::verified_active()->get();

        //dd($Users->where('isadmin', 1));
        $Count_all_Doc = count($Doctors);
        $Count_Online_Doc = count(User::where('status', '=', 1, 'AND', 'email_verified_at', '=', null, 'AND', 'blocked', '=', 0)->join('doctors', 'doctors.user_id', 'users.id')->get());
        $Doctors = $Doctors->take(8);


        //$Doctors = Doctor::orderBy('status', 'DESC')->orderBy('id', 'ASC')->take(8)->get();
        return view('index', compact('Departments', 'Blog', 'Doctors', 'Count_all_Doc', 'Count_Online_Doc'));
    }

    public function viewDepartments(){
        $Departments = Department::orderBy('department_name', 'ASC')->get();
        return view('pages.department.view-departments', compact('Departments'));
    }

    public function departmentsDetails($id){
        $id = decrypt($id);
        $Departments = Department::findOrFail($id);

        return view('pages.department.department-details', compact('Departments'));
    }


    public function aboutUs(){
        return view('pages.about');
    }

    public function terms_Condition(){
        return view('pages.terms_&_condition');
    }
    public function help(){
        return view('pages.help');
    }
    public function workDocument(){
        return view('pages.why_need_work_document');
    }

    public function allDoctors(){
        /*$Doctors = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            ->where('users.email_verified_at' , '!=', null)
            ->where('users.blocked' , '=', 0)
            ->where('roles.name' , '=', 'Doctor')
            ->select('users.*', 'users.id as users_id', 'users.deleted_at as user_deleted', 'roles.*', 'doctors.*', 'departments.*')
            ->get();*/

        // Doctor data loading from Doctor Search controller....
        $Departments = Department::all();
        return view('pages.doctor.view_doctors', compact('Departments'));
    }


    public function doctorDetails($id){
        $id = $this->decryptID($id);
        $Doctor_Data = User::findOrFail($id);
        $Department_id = $Doctor_Data->doctor->department->id;
        $Related_Doctor = Doctor::where('user_id', '!=', $Doctor_Data->id)->where('Department_id', '=', $Department_id)->get();
        /*foreach ($Related_Doctor as $r){
            $result = $r->availableUser->status;
        }
        dd($result);*/
        $Check_appointment = Appointment::where('doctor_id', '=', $Doctor_Data->doctor->id)
            ->where('validity', '=', 1)
            ->get();
        return view('pages.doctor.doctor_details', compact('Doctor_Data', 'Related_Doctor', 'Check_appointment'));
    }

    public function NewMsg(){
        if(Auth::check() && Auth::user()->is_admin !== 1){
            if(Auth::user()->role()->pluck('name')->first() == 'Patient'){
                $id = Auth::id();
                $Consultations  = Consultation::where('user_id','=', $id)->where('status', '!=', 'pending')->get();
            }
            elseif(Auth::user()->role()->pluck('name')->first() == 'Doctor'){
                $id = Auth::user()->doctor->id;
                $Consultations  = Consultation::where('doctor_id','=', $id)->where('status', '!=', 'pending')->get();
            }

            //$Consultations  = Consultation::where('user_id','=', $id)->where('status', '!=', 'pending')->get();
            $Count_Conversation = 0;
            foreach ($Consultations as $_Conversation){
                if(count($Consultations) > 0){
                    $Count_Conversation += count(Conversation::where('consultation_id','=',$_Conversation->id)
                        ->where('seen', '=', 0)
                        /*->whereIn('sender_id', [Auth::id(), $User_data->id])*/
                        ->where('receiver_id','=', Auth::id())
                        ->get());
                }
            }
            if($Count_Conversation == 0){
                $Output = '';
            }else{
                $Output = '<span class="Notification p-l-2 p-r-2" style="font-size: 10px;">'.$Count_Conversation.'</span>';
            }
            return response($Output);
        }
        else{
            $Output = '';
            return response($Output);
        }
    }

}
