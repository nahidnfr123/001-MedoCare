<?php

use App\Appointment;
use App\BlogComment;
use App\BlogView;
use App\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(BlogSeeder::class);
        //$this->call(BlogComment::class);
        //$this->call(BlogView::class);
        $this->call(ContactUsSeeder::class);
        $this->call(DoctorRatingSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(AppointmentBookingSeeder::class);
        $this->call(ConsultationSeeder::class);
        $this->call(AllTableSeeder::class);
    }
}
