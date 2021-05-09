<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Doctor;
use App\Rules\DepartmentWordCountRule;
use App\Rules\NameValidate;
use App\Rules\WordCountRule;
use Carbon\Carbon;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $Departments = Department::orderBy('department_name', 'ASC')->paginate(11);
        $Soft_Deleted_Department = Department::orderBy('department_name', 'ASC')->onlyTrashed()->get();
        return view('admin.manage_department', compact('Departments', 'Soft_Deleted_Department'));
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


    public function store_Validation($request): void
    {
        Session::flash('Error_create', 'Create Error.');
        $request->validate([
            'department_name' => ['required','string','unique:departments','max:60','min:3', new NameValidate],
            'icon' => 'required|file|image|max:2000|mimes:png',
            'details' => ['required', new WordCountRule('Department details',50,300)],
        ],[
            'department_name.required' => 'Department name is required.',
            'department_name.string' => 'Department name is must be a string.',
            'department_name.unique' => 'Department ' . ucwords($request->department_name) . ' is already added.',
            'department_name.max' => 'Department name is too long.',
            'department_name.min' => 'Department name should be at-least three letters.',

            'icon.required' => 'Department icon is required.',
            'icon.file' => 'Department icon must be an image.',
            'icon.image' => 'Department icon must be an image.',
            'icon.max' => 'Department icon should br less then 2 Mb.',
            'icon.mimes' => 'Department icon must be a png image.',

            'details.required' => 'Department details is required.',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->store_Validation($request); // Validate request ....

        $Department_name = ucwords(trim($request->department_name));
        $Department_details = ucfirst(trim($request->details));

        $icon_name = str_replace(array('?', '!', '.', ':', ' ', ','), '-', $Department_name);

        if($request->hasFile('icon')){
            $get_image = $request->file('icon'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('png');
            if(in_array(strtolower($extension), $allowed_Ext, true) == false){
                Session::flash('Error_create', 'Create Error.');
                return back()->with('Error', 'Department icon should be a PNG file.');
            }
            $newFileName = $icon_name.'-'.time().'.'.$extension; // Set the file name to store in the database ....
            $Location = '/public/image/web_layout/icon/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            //$StorageLink='/storage/image/web_layout/icon/'.$newFileName;
        }
        else{
            $newFileName = '';
        }

        Department::Insert([
            // Database field name => Form request data
            'department_name' => $Department_name,
            'icon' => $newFileName,
            'details' => $Department_details,
            'created_at' => Carbon::now(),
        ]);

        Session::forget('Error_create');
        //return Redirect::back();
        return back()->with('Success', 'Department "'. ucwords($request->department_name) .'" successfully added.');
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

        //return redirect()->route('view-departments');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $department_id = $request->department_id;
        $Department = Department::findOrFail($department_id);
        $Name = $Department->department_name;
        $Image = '/storage/image/web_layout/icon/'.$Department->icon;
        $Details = $Department->details;

        return response()->json(array('Id' => $department_id , 'Name' => $Name, 'Icon' =>$Image, 'Details' => $Details), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_validate($request){
        Session::flash('Error_update', 'Update Error.');

        $request->validate([
            'department_name' => ['required', 'string', 'max:60', 'min:3', new NameValidate],
            'icon' => 'sometimes|required|mimes:png|max:2048',
            'edit_details' => ['required', new WordCountRule('Department details',50,300)],
        ],[
            'department_name.required' => 'The department name is required',
            'department_name.string' => 'Department name must be a string.',
            'department_name.max' => 'Department name must be between 3 to 60 letters.',
            'department_name.min' => 'Department name must be between 3 to 60 letters.',

            'icon.mimes' => 'The Icon must be a PNG image.',
            'icon.max' => 'The Icon must be less then 2 Mb.',

            'edit_details.required' => 'Department details is required.',
        ]);

    }
    public function update(Request $request)
    {
        $this->update_validate($request); // Validate request ...

        $ID = trim($request->id);
        $Department_name = ucwords(trim($request->department_name));
        $Department_details = ucfirst(trim($request->edit_details));

        $icon_name = str_replace(array('?', '!', '.', ':', ' ', ','), '-', $Department_name);

        $GetDepartment = Department::where('department_name','=', $Department_name)->where('id', '!=', $ID)->get();
        if(count($GetDepartment)>0){
            return back()->with('Error', 'Department name "'.$Department_name.'" is already added.');
        }
        if($request->hasFile('icon')){
            $get_image = $request->file('icon'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('png');
            if(in_array(strtolower($extension), $allowed_Ext, true) == false){
                Session::flash('Error_update', 'Create Error.');
                return back()->with('Error', 'Department icon should be a PNG file.');
            }
            //$fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $newFileName = $icon_name.'-'.time().'.'.$extension; // Ste the file name to store in the database ....
            $Location = '/public/image/web_layout/icon/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            //$StorageLink='/storage/image/web_layout/icon/'.$newFileName;

            // Delete old file if new file is uploaded ...
            $Department = Department::findOrFail($ID);
            if (! Storage::exists($Department->icon)) {
                Storage::delete('/public/image/web_layout/icon/'.$Department->icon);
            }

            //Update Query ...
            Department::findOrFail($ID)->update([
                'department_name' => $Department_name,
                'icon' => $newFileName,
                'details' => $Department_details,
                'updated_at' => Carbon::now(),
            ]);
        }
        else{
            Department::findOrFail($ID)->update([
                'department_name' => $Department_name,
                'details' => $Department_details,
                'updated_at' => Carbon::now(),
            ]);
        }
        Session::forget('Error_update');
        //return Redirect::back();
        return back()->with('Success', 'Department "'. ucwords($request->department_name) .'" successfully updated.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   // Hard delete department ...
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $FindDoc = Doctor::where('department_id', $id)->get();

        if (count($FindDoc) > 0) {
            return back()->with('Error', 'Their is doctor in this department. Therefore this department cannot be deleted.');
        } else {
            $Department = Department::onlyTrashed()->findOrFail($id);
            $Department->forceDelete();
            /*$Department = Department::onlyTrashed()->findOrFail($id);*/
            if (! Storage::exists($Department->icon)) {
                Storage::delete('/public/image/web_layout/icon/'.$Department->icon);
            }
            return back()->with('Success', 'Department successfully deleted');
        }
    }


    // Soft delete function ...
    public function soft_delete_department($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $FindDoc = Doctor::where('department_id', $id)->get();
        if(count($FindDoc)>0){
            return back()->with('Error', 'Their is doctor in this department. Therefore this department cannot be deleted.');
        }
        else{
            Department::withoutTrashed()->findOrFail($id)->delete();
            return back()->with('Success', 'Department successfully deleted.');
        }
    }


    // Data restore function ....
    public function restore_department($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        Department::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('Success', 'Department successfully restored');
    }


    /*function test($id){
        //$dep = Department::find($id);
        //$doc = $dep->doctor()->where('department_id', $id)->get();
        // *** Working method *** //
        $doc = Department::find($id)->doctor;
        dd($doc);
    }*/


    /*public function Show_Edit_Form_Content(Request $request){
        $department_id = $request->department_id;
        $Department = Department::findOrFail($department_id);
        $Name = $Department->department_name;
        $Image = '/storage/image/web_layout/icon/'.$Department->icon;
        $Details = $Department->details;

        return response()->json(array('Id' => $department_id , 'Name' => $Name, 'Icon' =>$Image, 'Details' => $Details), 200);
    }*/


    function doctorByDepartment($id){
        $Department_id = $this->decryptID($id);
        $Department = Department::find($Department_id);

        $DoctorsByDepartment = DB::table('users')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->join('doctors', 'doctors.user_id', 'users.id')
            ->join('departments', 'doctors.department_id', 'departments.id')
            /*->where('users.email_verified_at' , '!=', null)*/
            ->where('doctors.email_sent' , '!=', 0)
            ->where('roles.name' , '=', 'Doctor')
            ->where('departments.id' , '=', $Department_id)
            ->where('users.deleted_at', '=', null)
            ->where('doctors.deleted_at', '=', null)
            ->select('users.*', 'users.id as user_id', 'roles.*', 'doctors.*', 'departments.*')
            ->get();

        return view('admin.department_doctor', compact('DoctorsByDepartment', 'Department'));
    }


}
