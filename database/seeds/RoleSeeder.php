<?php

use App\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = 'admin';
        Role::insert([
            'name'=>ucwords($role),
            'slug'=>$role,
            'created_at'=>Carbon::now()
        ]);

        $role = 'patient';
        Role::insert([
            'name'=>ucwords($role),
            'slug'=>$role,
            'created_at'=>Carbon::now()
        ]);

        $role = 'doctor';
        Role::insert([
            'name'=>ucwords($role),
            'slug'=>$role,
            'created_at'=>Carbon::now()
        ]);

        $role = 'blood_bank_staff';
        Role::insert([
            'name'=>ucwords($role),
            'slug'=>$role,
            'created_at'=>Carbon::now()
        ]);

        $role = 'blood_donor';
        Role::insert([
            'name'=>ucwords($role),
            'slug'=>$role,
            'created_at'=>Carbon::now()
        ]);
    }
}
