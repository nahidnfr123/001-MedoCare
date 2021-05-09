<?php

namespace App\Http\Controllers\Users;

use App\Rules\WordCountRule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        // update patient account details
        $Location = '';
        if ($request->has('auto_locate')) {
            $request->validate([
                'auto_locate' => 'required|string',
                'address' => ['sometimes','string', new WordCountRule('Address', '2', '8')],
            ]);
            $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
            $Location = encrypt($arr_ip);
        }
        elseif ($request->has('Location')) {
            $request->validate([
                'Location' => 'required|string',
                'address' => ['sometimes','string', new WordCountRule('Address', '2', '8')],
            ]);
            $Location = $request->Location;
            $Location_array = explode(',', $Location);
            if (count($Location_array) < 3) {
                return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State');
            }
            else{
                foreach ($Location_array as $loc){
                    if(strlen($loc) < 3){
                        return back()->with('Error', 'Invalid location format. Correct format: Country, City, Division/State');
                    }
                }
            }
        }
        User::findOrFail($request->id)->update(['location' => $Location, 'address' => $request->address]);

        // Change password if change password checkbox is checked....
        if ($request->has('change_password')) {
            $request->validate([
                'old_password' => 'required|string|min:8|max:60',
                'new_password' => 'required|string|min:8|max:60|confirmed',
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
                    return back()->with('Success', 'Password successfully changed.');
                }
            }else{
                return back()->with('Error', 'Old password is wrong.');
            }
        }
        return back()->with('Success', 'Account information successfully updated.');
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
