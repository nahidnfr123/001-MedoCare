<?php
//Route::get('/', function () {
//    return view('welcome');
//});

// Model - Singular eg: User
// Table - plural eg: Users


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/image', function (){
    $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/public/storage';
    symlink($targetFolder,$linkFolder);
    echo 'Symlink process successfully completed';
});

Route::get('/', 'FrontendRoutesController@index')->name('home');
Route::get('/home', 'FrontendRoutesController@index')->name('home');

//Join us ...
Route::get('/join_us', 'JoinUsController@index')->name('join_us');
Route::post('/join_doctor', 'JoinUsController@store')->name('join_doctor');
Route::get('/verify-email|{token}', 'JoinUsController@verifyEmail')->name('verify-email');

// Frontend blog routes ...
Route::get('/blog', 'BlogController@index')->name('blog');
Route::get('/view-blog|{id}', 'BlogController@show')->name('view-blog');
Route::get('/blog-search', 'BlogController@search')->name('blog-search');

//Route::get('/test|{id}', 'BlogController@test')->name('test');
// Department view ....
Route::get('/departments', 'FrontendRoutesController@viewDepartments')->name('departments');
Route::get('/department-details|{id}', 'FrontendRoutesController@departmentsDetails')->name('department-details');

// Contact Us ....
Route::get('/contact-us', 'ContactUsController@index')->name('contact-us');
Route::post('/send-message', 'ContactUsController@store')->name('send-message');

// Terms and conditions ....
Route::get('/terms-condition', 'FrontendRoutesController@terms_condition')->name('terms-condition');
Route::get('/help', 'FrontendRoutesController@help')->name('help');
Route::get('/work-document', 'FrontendRoutesController@workDocument')->name('work-document');

//About page ....
Route::get('/about-us', 'FrontendRoutesController@aboutUs')->name('about-us');


// Doctors Page...
Route::get('/doctors', 'FrontendRoutesController@allDoctors')->name('all-doctors');
Route::get('/doctors-details|{id}', 'FrontendRoutesController@doctorDetails')->name('doctors-details'); // Doctors details ...
// Search Doctor
Route::get('/search-doctors', 'DoctorSearchController@index');





Auth::routes(['verify' => true]); // Must verify email

// Admin routes --Backend
Route::group(['as'=>'admin.', 'prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => ['verified', 'admin', 'blocked_usr']], function () {
    // prefix required for get route , namespace required for controller folder path , as is for defining admin.dashboard

    View::composer(['*'], function($view) {
        $Count_Msg = count(\App\ContactUs::where('seen', '=', '0')->get());
        $Msg = \App\ContactUs::orderBy('created_at', 'DESC')->take(3)->get();
        $view->with('Count_Msg', $Count_Msg)->with('Msg', $Msg);
    });

    Route::get('/', 'RouteController@index')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('admin-profile');
    Route::post('/profile-update', 'ProfileController@update')->name('profile-update');
    Route::post('/change-password', 'ProfileController@passwordChange')->name('change-password');

    // Manage Departments .... //
    Route::get('/view-departments', 'DepartmentsController@index')->name('view-departments');
    Route::post('/add-department', 'DepartmentsController@store')->name('add-department');
    Route::get('/delete-department|{id}', 'DepartmentsController@soft_delete_department')->name('soft-delete-department');
    Route::get('/hard-delete-department|{id}', 'DepartmentsController@destroy')->name('hard-delete-department');
    Route::get('/restore-department|{id}', 'DepartmentsController@restore_department')->name('restore-department');
    Route::get('/Show_Edit_Form_Content', 'DepartmentsController@edit')->name('Show_Edit_Form_Content');// Ajax edit form content display...
    Route::post('/update-department', 'DepartmentsController@update')->name('update-department');// Update Query ...

    // Doctors in specific department ....
    Route::get('/department-doctor|{id}', 'DepartmentsController@doctorByDepartment')->name('department-doctor');// Update Query ...
    // End //

    // Manage User .... //
    Route::get('/create-user','ManageUserController@create')->name('create-user');
    Route::post('/create-user','ManageUserController@store');
        // Doctor
        Route::get('/manage-doctor','ManageUserController@view_doctors')->name('manage-doctor');
        Route::get('/view-doctor|{id}','ManageUserController@showDoctor')->name('view-doctor');
        Route::get('/send-token|{id}','ManageUserController@sendAccountActivationToken')->name('send-token');
        Route::post('/ignore-join-request','ManageUserController@ignoreRequest')->name('ignore-join-request');
        // End //

        // Patient //
        Route::get('/manage-patient','ManageUserController@view_patients')->name('manage-patient');
        Route::get('/view-patient|{id}','ManageUserController@showPatient')->name('view-patient');
        // End //

        // Common //
        Route::post('/block-user','ManageUserController@blockUser')->name('block-user');
        Route::get('/unblock-user|{id}','ManageUserController@unblockUser')->name('unblock-user');
        Route::post('/delete-user','ManageUserController@delete')->name('delete-user');
        Route::get('/restore-user|{id}','ManageUserController@restore')->name('restore-user');
        Route::post('/send-email-to-user','ManageUserController@sendEmail')->name('send-email-to-user');
    // End //
    // End //


    // Manage Blog .... //
    Route::get('/view-blog', 'BlogController@index')->name('view-blog');
    Route::post('/add-blog', 'BlogController@store')->name('add-blog');
    Route::get('/soft-delete-blog|{id}', 'BlogController@softDelete')->name('soft-delete-blog');
    Route::get('/destroy-blog|{id}', 'BlogController@destroy')->name('destroy-blog');
    Route::get('/restore-blog|{id}', 'BlogController@restore')->name('restore-blog');
    Route::get('/blog-read-more|{id}', 'BlogController@show')->name('blog-read-more');
    Route::get('/blog-search', 'BlogController@search')->name('blog-search');
    Route::get('/blog-edit', 'BlogController@edit')->name('blog-edit');
    Route::post('/update-blog', 'BlogController@update')->name('update-blog');
    // End //

    //Route::get('/test', 'BlogController@test')->name('test');

    // Contact Us .... //
    Route::get('/inbox', 'ContactUsController@index')->name('inbox');
    Route::get('/message-details|{id}', 'ContactUsController@show')->name('message-details');
    Route::get('/delete-multiple-message', 'ContactUsController@multipleDelete')->name('delete-multiple-message');
    Route::get('/destroy-multiple-message', 'ContactUsController@multipleDestroy')->name('destroy-multiple-message');
    Route::get('/delete-message|{id}', 'ContactUsController@delete')->name('delete-message');
    Route::get('/restore-multiple-message', 'ContactUsController@restore')->name('restore-multiple-message');
    Route::get('/trash-message', 'ContactUsController@trashMessage')->name('trash-message');
    Route::get('/send-email-form', 'ContactUsController@create')->name('send-email-form');
    Route::post('/send-email', 'ContactUsController@sendEmail')->name('send-email');
    Route::post('/send-email-Intended', 'ContactUsController@sendEmailIntended')->name('send-email-Intended');
    // End //

});





// Users routes --Frontend
Route::group(['as'=>'user.', 'prefix'=>'user', 'namespace'=>'Users', 'middleware' => ['verified', 'user', 'blocked_usr']], function () {
    // User Profile ... *Common
    Route::get('/profile', 'ProfileController@index')->name('user-profile');
    Route::post('/avatar-update', 'ProfileController@updateAvatar')->name('avatar-update');

    // Patient ... update
    Route::post('/patient-profile-update', 'PatientController@update')->name('patient-profile-update');
    // Doctor ... update
    Route::post('/doctor-profile-update', 'DoctorController@update')->name('doctor-profile-update');
    Route::get('/show-appointment-bookings', 'DoctorController@showBookings')->name('show-appointment-bookings');
    Route::get('/test', 'DoctorController@test')->name('test');


    //Route::get('/show-profile|{id}', 'ProfileController@show')->name('show-profile');
    // End User profile ...

    // Appointment booking ...
    Route::post('/book-appointment', 'BookAppointmentController@book_appointment')->name('book-appointment'); // Allow patients to book appointments ...

    Route::get('chat-box|{id}','ChatBoxController@index')->name('chat-box');
    Route::get('load-all-message','ChatBoxController@loaderAll')->name('load-all-message');
    Route::get('load-new-message','ChatBoxController@loaderNewMessage')->name('load-new-message');
    Route::get('send-message','ChatBoxController@store')->name('send-message');

    // Patient upload previous reports
    Route::post('/report_history', 'ChatBoxController@reportHistory')->name('report_history');

    // publish report ...
    Route::post('/report', 'ReportController@store')->name('report');
});





// Common Routes --When Auth Verified ....
Route::group(['middleware' => ['verified', 'blocked_usr']], static function () {
    // Blog comment system ...
    Route::get('/load-comment', 'CommentController@loadComment')->name('load-comment');
    Route::post('/add-comment', 'CommentController@store')->name('add-comment');
    Route::get('/delete-comment|{id}', 'CommentController@delete')->name('delete-comment');
    Route::get('/edit-comment|{id}', 'CommentController@edit')->name('edit-comment');
    Route::post('/update-comment', 'CommentController@update')->name('update-comment');
    // End //

    // Appointment system
    Route::post('/appointment-store', 'AppointmentController@store')->name('appointment-store'); // Allow doctors to create appointment dates....
    Route::get('/delete_appointment|{id}', 'AppointmentController@delete')->name('delete_appointment');
    Route::get('/pause_appointment|{id}', 'AppointmentController@pauseAppointmentBooking')->name('pause_appointment');
    Route::get('/start_appointment|{id}', 'AppointmentController@startAppointmentBooking')->name('start_appointment');
    // End //

    // Load new received message ....
    Route::get('/NewMsg', 'FrontendRoutesController@NewMsg')->name('NewMsg');

    // Doctor decline emergency request ...
    Route::get('/decline_request|{token}', 'RequestAppointmentController@declineRequest');
});


// Appointment system
Route::get('/appointment', 'AppointmentController@index')->name('appointment');
Route::get('/appointmentLoader', 'AppointmentController@appointmentLoader');

//Request appointment ...
Route::get('/request-appointment-form', 'RequestAppointmentController@create'); // Load request form data ...
Route::post('/request-appointment', 'RequestAppointmentController@store');

// Appointment request response ....
Route::get('/loadAppointmentRequest', 'RequestAppointmentController@loadAppointmentRequest');
Route::get('/acceptRequest|{token}', 'RequestAppointmentController@acceptRequest');
Route::get('/GetRequestResponse|{token}', 'RequestAppointmentController@GetRequestResponse');
Route::get('/end-session|{token}', 'RequestAppointmentController@EndSession');


// Emergency consultation ....
Route::get('/send-em-msg', 'EmergencyConversationController@store');
Route::get('/load-all-em-msg', 'EmergencyConversationController@loaderAll');
Route::get('/load-new-em-msg', 'EmergencyConversationController@loaderNewMessage');
Route::post('/em-report', 'EmergencyConversationController@reportHistory');




//Route::get('/test|{token}', 'RequestAppointmentController@GetRequestResponse');

