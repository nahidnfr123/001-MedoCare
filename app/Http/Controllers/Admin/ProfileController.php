<?php

namespace App\Http\Controllers\Admin;

use App\Rules\PhoneMaxLength;
use App\Rules\PhoneMinLength;
use App\Rules\UpdatePhoneNumberRule;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
        return view('admin.profile', compact('arr_ip'));
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
        session()->flash('Error_updateProfile', 'true');
        $request->validate([
            'phone' => ['required', 'numeric', 'regex:/(01)[0-9]{9}/', new PhoneMinLength , new PhoneMaxLength, new UpdatePhoneNumberRule($request->phone)],
            'location' => 'sometimes|string|',
            'address' => 'sometimes|string|',
            'image' => 'sometimes|image|mimes:jpg,jpeg,gif,png,JPG,JPEG',
        ]);

        //Image
        if ($request->hasFile('image')) {
            $get_image = $request->file('image'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('jpg','jpeg', 'gif');
            if(in_array(strtolower($extension), $allowed_Ext, true) == false){
                return back()->with('Error', 'Blog image can only contain jpg, jpeg and png file.')->withInput();
            }
            //$fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $newFileName = Auth::user()->first_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....
            $Location = '/public/image/blog/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            $StorageLink = '/storage/image/blog/' . $newFileName;
        }
        else {
            $StorageLink = Auth::user()->avatar;
        }


        // update patient account details
        $Location = '';
        if ($request->has('auto_locate')) {
            $request->validate([
                'auto_locate' => 'required|string',
            ]);
            $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
            $Location = encrypt($arr_ip);
        }
        elseif ($request->has('location')) {
            $request->validate([
                'location' => 'required|string',
            ]);
            $Location = $request->location;
            $Location_array = explode(',', $Location);
            if (count($Location_array) < 3) {
                return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State.')->withInput();
            }
            else{
                foreach ($Location_array as $loc){
                    if(strlen($loc) < 3){
                        return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State.')->withInput();
                    }
                }
            }
        }
        User::findOrFail(Auth::user()->id)->update([
            'phone' => $request->phone,
            'avatar' => $StorageLink,
            'location' => $Location,
            'address' => $request->address,
        ]);

        Session::forget('Error_updateProfile');
        return back()->with('Success', 'Profile successfully updated.');



    }





    public function passwordChange(Request $request){
        session()->flash('Error_ChangePassword', 'true');
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|max:60|confirmed',
            'new_password_confirmation' => 'required|string|min:8|max:60',
        ],[
            'old_password.required' => 'Old password is required.',
            'old_password.min' => 'Old password must be at-least 8 characters.',
            'old_password.max' => 'Old password is too long. Max length is 60 characters.',

            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at-least 8 characters.',
            'new_password.max' => 'New password is too long. Max length is 60 characters.',
            'new_password.confirmed' => 'New password and retype password does not match.',

            'new_password_confirmation.required' => 'Retype your new password.',
            'new_password_confirmation.min' => 'Retype password must be at-least 8 characters.',

        ]);

        if($request->old_password == $request->new_password){
            return back()->with('Error', 'New password cannot be same as old password.');
        }

        $User_password = User::findOrFail(Auth::user()->id)->password;

        if (Hash::check($request->old_password, $User_password)) {
            if (Hash::check($request->new_password, $User_password)) {
                return back()->with('Error', 'New password cannot be same as old password.');
            }
            else{
                User::findOrFail(Auth::user()->id)->update(['password' => Hash::Make($request->new_password)]);
            }
        }else{
            return back()->with('Error', 'Old password is wrong.');
        }
        Session::forget('Error_ChangePassword');
        return back()->with('Success', 'Password successfully changed.');
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
