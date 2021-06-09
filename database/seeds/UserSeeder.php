<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        $arr_ip = geoip()->getLocation('127.0.0.1');
        $Location = encrypt($arr_ip);

        User::insert([
            'first_name'=> 'Admin',
            'last_name'=> 'User',
            'email'=> 'admin_user@gmail.com',
            'email_verified_at'=> '2019-08-21',
            'password'=> Hash::make('admin_user@gmail.com'),
            'dob'=> '1996-08-21',
            'phone'=> '01857823870',
            'gender'=> 'male',
            'avatar'=> '/storage/app/public/user_data/admin/Admin.gif',
            'blood_group'=> 'B+',
            'location' => $Location,
            'address' => 'Kalabagan, Dhaka 1205',
            'is_admin'=> '1',
            'created_at'=>Carbon::now()
        ]);

        // No controller needed for pivot table role_user
        // Insert data by attaching ...
        // use detach to delete...
        // and sync to replace the id...
        $User = User::find(1);
        $User->role()->sync(1);
    }
}
