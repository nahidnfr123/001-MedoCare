<?php

namespace App\Providers;

use App\Appointment;
use App\AppointmentBooking;
use App\AppointmentRequest;
use App\Consultation;
use App\Conversation;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_ENV') !== "local"){
            URL::forceScheme('https');
        }
        date_default_timezone_set('Asia/Dhaka'); // Set the default time zone ....
        Schema::defaultStringLength(191); // Set the default string length ...

        Session::regenerate(); // Regenerate Session id on page load ...

        //return $this->bootLoader();
    }


    private function bootLoader(){
        // Update consultation status to in progress
        $GetDataToUpdate = AppointmentBooking::where('booked_date', '<=', date('Y-m-d'))
        ->where('booked_time', '<', Carbon::now()->format('H:i:s'))
        ->join('appointments', 'appointments.id', 'appointment_bookings.appointment_id')
        ->join('consultations', 'consultations.appointment_booking_id', 'appointment_bookings.id')
        ->where('consultations.status', '!=', 'in progress')
        ->select('consultations.id as cons_id', 'appointment_bookings.booked_date', 'appointment_bookings.booked_time')
        ->get();
        if (count($GetDataToUpdate) > 0) {
            foreach ($GetDataToUpdate as $GDTU) {
                $Consultation_id = $GDTU->cons_id;
                Consultation::findOrFail($Consultation_id)->update(['status' => 'in progress']);
                //echo $GDTU->booked_time.' ---- '.'<br>';
            }
        }


        $Now = Carbon::now()->subMinutes(25)->format('H:i:s');

        /*$newtimestamp = strtotime('+ 25 minute');
        echo date('H:i', $newtimestamp);*/

        // ... update consultation status to end ... //
        $GetDataToUpdate = AppointmentBooking::where('booked_date', '<=', date('Y-m-d'))
        ->where('booked_time', '<', $Now)
        ->join('appointments', 'appointments.id', 'appointment_bookings.appointment_id')
        ->join('consultations', 'consultations.appointment_booking_id', 'appointment_bookings.id')
        ->where('consultations.status', '!=', 'session end')
        ->select('consultations.id as cons_id', 'appointment_bookings.booked_date', 'appointment_bookings.booked_time')
        ->get();
        if (count($GetDataToUpdate) > 0) {
            foreach ($GetDataToUpdate as $GDTU) {
                $Consultation_id = $GDTU->cons_id;
                Consultation::findOrFail($Consultation_id)->update(['status' => 'session end']);
                //echo $GDTU->booked_time.' ---- '. $Now.'<br>';
            }
        }
        //dd($GetDataToUpdate);



        // ... update appointments validity and booking status ... //
        $GetDataToUpdate = Appointment::where('end_date', '<', date('Y-m-d'))
        ->select('appointments.id as app_id')
        ->get();
        if(count($GetDataToUpdate) > 0){
            foreach ($GetDataToUpdate as $GDTU){
                $Appointments_id = $GDTU->app_id;
                Appointment::findOrFail($Appointments_id)->update(['validity' => 0, 'booking_status' => 'closed']);
            }
        }
    }

}
