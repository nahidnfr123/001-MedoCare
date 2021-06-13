@extends('layouts.app_front')

@section('title')
    @php $title = 'Home'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')



    <!-- Modal Component -->
    <div class="modal fade bd-example-modal-lg projectInfoModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel"
         aria-hidden="true"
         id="projectInfoModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Laravel 6* project demo. (2019)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <h5>About:</h5>
                        <div>MedoCare is and online medical service which allows patients
                            to find doctors and book appointments easily for online
                            consultation through a online chat based ststem.
                        </div>
                    </div>
                    <p><strong>Technologies: </strong>HTML, CSS, BOOTSTRAP, JQuery, Ajax, Laravel 6*</p>

                    <hr>
                    <div class="text-info">Feel free to navigate around ...</div>
                    <hr>

                    <h5>Credentials:</h5>
                    <div><strong>Admin</strong></div>
                    <div><strong>Email:</strong> admin_user@gmail.com</div>
                    <div><strong>password:</strong> admin_user@gmail.com</div>
                    <hr>
                    <div><strong>Doctor</strong></div>
                    <div><strong>Email:</strong> farjana_alom@gmail.com</div>
                    <div><strong>password:</strong> farjana_alom@gmail.com</div>
                    <hr>
                    <div><strong>Patient</strong></div>
                    <div><strong>Email:</strong> bikash123@gmail.com</div>
                    <div><strong>password:</strong> bikash123@gmail.com</div>

                </div>
                <div class="modal-footer">
                    <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    {{-- Home pagge slider --}}
    <!-- Welcome Area Start -->
    <section class="welcome-area">
        <div class="welcome-slides owl-carousel">

            <!-- Single Slide -->
            <div class="single-welcome-slide bg-img bg-overlay"
                 style="background-image: url({{ config('app.image_url', null) }}/storage/image/web_layout/bg/1.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <!-- Welcome Text -->
                        <div class="col-12 col-lg-8 col-xl-6">
                            <div class="welcome-text">
                                <h2 data-animation="bounceInDown" data-delay="900ms">Meet <br> The doctor</h2>
                                <p data-animation="bounceInDown" data-delay="500ms">Booking doctor appointment is much
                                    easier then before. You can book appointment for online consultation and as well as
                                    for check up.</p>
                                <div class="hero-btn-group" data-animation="bounceInDown" data-delay="100ms">
                                    <a href="{{ route('appointment') }}"
                                       class="slider_btn btn alime-btn mb-3 mb-sm-0 mr-4"
                                       style="color:white;transition:400ms;">Book appointment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Slide -->
            <div class="single-welcome-slide bg-img bg-overlay"
                 style="background-image: url({{ config('app.image_url', null) }}/storage/image/web_layout/bg/2.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <!-- Welcome Text -->
                        <div class="col-12 col-lg-8 col-xl-6">
                            <div class="welcome-text">
                                <h2 data-animation="bounceInUp" data-delay="100ms">Donate blood <br> Become a hero</h2>
                                <p data-animation="bounceInUp" data-delay="500ms">Blood donation camp will be arranged
                                    in september, stay with us for updates on the date.</p>
                                <div class="hero-btn-group" data-animation="bounceInUp" data-delay="900ms">
                                    <a href="" class="slider_btn btn alime-btn mb-3 mb-sm-0 mr-4"
                                       style="color:white;transition:400ms;">Become a donor</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Single Slide -->
            <div class="single-welcome-slide bg-img bg-overlay"
                 style="background-image: url({{ config('app.image_url', null) }}/storage/image/web_layout/bg/3.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <!-- Welcome Text -->
                        <div class="col-12 col-lg-8 col-xl-6">
                            <div class="welcome-text">
                                <h2 data-animation="bounceInDown" data-delay="900ms">Online <br> Doctor 24/7</h2>
                                <p data-animation="bounceInDown" data-delay="500ms">Our 24/7 online doctor consultation
                                    helps to get treatment in emergency cases from anywhere.</p>
                                <div class="hero-btn-group" data-animation="bounceInDown" data-delay="100ms">
                                    <a href="{{ route('appointment') }}" id="Btn_Book_Appointment"
                                       class="slider_btn btn alime-btn mb-3 mb-sm-0 mr-4"
                                       style="color:white;transition:400ms;">Emergency Consultation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <svg class="SliderBottom" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 1366 140">
            <defs>
                <style>
                    .cls-1 {
                        fill: white;
                    }

                </style>
            </defs>
            <path class="cls-1"
                  d="M0,644.79s175,38.39,347,34.82,386-47.32,477-64.29S1014,568,1135,568s231,47.32,231,47.32V768H0Z"
                  transform="translate(0 -568)"/>
        </svg>

    </section>
    <!-- Welcome Area End -->
    {{-- End Of Home Page Slider --}}




    <!--Section 1-->
    <section class="Section_Container S_1">
        <h3 class="m-b-20 ">Why use <span style="color:dodgerblue;"> Medo</span><span
                style="color:greenyellow;">Care</span> ?</h3>
        <div class="row_single">
            <div class="item ">
                <h3><i class="far fa-clock"></i> Time saving</h3>
                <p>Get medical answers on average within 4 hours. No time required for traveling.</p>
            </div>
            <div class="item">
                <h3><i class="far fa-laugh-beam"></i> Hassle Free</h3>
                <p>No hassel of waiting for booking appointments.</p>
            </div>
            <div class="item">
                <h3><i class="fas fa-user-md"></i> Expert doctor at fingertips</h3>
                <p>Meet expert doctor for online counseling.</p>
            </div>
        </div>

        <div class="row_single flex_row">
            <div class="item  zoomIn">
                <h3><i class="fas fa-tint"></i> Blood bank</h3>
                <p>Blood bank at fingure tips. Easily find blood donor and blood from bank.</p>
            </div>
            <div class="item  zoomIn">
                <h3><i class="fas fa-money-bill-wave"></i> Save money</h3>
                <p>Consult with expert doctors online for free.</p>
            </div>
            <div class="item  zoomIn">
                <!--class="Slow400"-->
                <h3><i class="far fa-calendar-check"></i> Appointment booking</h3>
                <p>Easy appointment booking for both online and offline consultation.</p>
            </div>
        </div>
    </section>
    <!--End Section 1-->



    {{--// Doctor owl carosol ...--}}
    <section class="Section_Container S_C_OnlineDoctors follow-area clearfix">
        <div class="">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h3>Ask a doctor online for expert medical advice</h3>
                        <hr class="bg-white">
                        <div class="outline txtCenter">
                            <p class="txt-white">More then {{ $Count_all_Doc }} doctors in our community.
                                ( <i class="fas fa-circle m_l_2 m-r-2 online"></i>
                                <a href="show-online-doctors.html" class="text-white"><span
                                        class="txt_sha_dark txt_bold"> {{ $Count_Online_Doc }} doctors online </span> )</a>
                            </p>
                        </div>
                    </div>
                    <!-- Owl Carosole Slider -->
                    <div class="row owl-carousel owl-stage-outer" style="margin-top:20px;padding: 20px;">
                        @foreach ($Doctors as $Doctor)
                            <div class="doctor_hover m-b-20"><br>
                                <div class="col-lg-12 Doctor_Home overflow-hidden relative">

                                    @if($Doctor->status == 1)
                                        <div class="online_ab rounded"><i class="fa fa-circle"
                                                                          style="color: greenyellow;"></i> online
                                        </div>
                                    @endif

                                    <img data-src="{{ $Doctor->avatar }}" alt="">
                                    <div class="overflow_content">
                                        <p class="txt_sha_dark">
                                            <b>Dr. {{ $Doctor->first_name .' '.$Doctor->last_name}}</b></p>
                                        <div class="p-t-6"><span
                                                class="txt_bold text-dark">Department: </span> {{ $Doctor->department_name }}
                                        </div>
                                        <div class="p-t-6"><span
                                                class="txt_bold text-dark">Experience: </span>{{ $Doctor->experience }}
                                            Years
                                        </div>
                                        <div class="p-t-6"><span
                                                class="txt_bold text-dark">Hospital: </span>{{ $Doctor->work_place_name }}
                                        </div>
                                        <div class="p-t-6"><span class="txt_bold text-dark">Rating: </span><i
                                                class="fas fa-star"></i>
                                            <span>
                                            {{-- Calculate doctor rating --}}
                                                @php $Ratings = App\DoctorRating::where('doctor_id','=', $Doctor->doc_id)->get(); $number_of_rating = count($Ratings); $c = 0;@endphp
                                                @if(count($Ratings)>0)
                                                    @foreach($Ratings as $Rating)
                                                        @php $c += $Rating->rating_value @endphp
                                                    @endforeach
                                                    {{ round($calculate = $c / $number_of_rating, 2) }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                        </span>
                                        </div>
                                        <br>
                                        <div>
                                            <a href="{{ urlencode('doctors-details|') . encrypt($Doctor->users_id)}}"
                                               class="btn btn-light btn-sm"><i class="fas fa-user"></i> Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('all-doctors') }}" class="btn_blue float-r"> More <i
                            class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </section>



    <!-- Appointment booking -->
    <section class="Section_Container" id="Book_Appointment">
        <div class="container container-fluid">
            <div class="container col-12 col-md-12 col-lg-10  flipInX slow">
                <h3>Emergency Doctor</h3>
                <div>

                    <div class="text-center col-12 col-sm-12 col-md-12 col-lg-10 col-xl-8 m-auto">
                        <div class="alert alert-info">
                            <button type="button" class="btn btn-sm btn-info font-bold" style="font-size: 12px;"
                                    data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Request
                                consultation.
                            </button>
                        </div>
                    </div>

                    <!-- Request appointment -->
                    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title" id="exampleModalLabel">Request for consultation.</h5>
                                    </div>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{--<div class="alert alert-info">Select a online doctor and request consultation.</div>--}}
                                    <form action="{{ url('request-appointment') }}" method="post"
                                          enctype="multipart/form-data" name="Request_Appointment">
                                        @csrf
                                        <div class="row m-b-10">

                                            {{-- If no doctors are online hide button and show alert message --}}
                                            @php
                                                $CountOnline = 0;
                                                if(count($Doctors) > 0){
                                                    foreach ($Doctors as $Doctor){
                                                        $CheckOnline = App\User::find($Doctor->users_id)->userIsOnline();
                                                        if($CheckOnline == true){
                                                            ++$CountOnline;
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @if($CountOnline == 0)
                                                <div class="alert alert-info col-12 text-center">No doctors are online.
                                                    Please refresh the page, try again later or you may make a phone
                                                    call.
                                                </div>
                                            @endif

                                            <div class="col-6 col-md-6 col-lg-6">
                                                <label for="SelectDepartment2" class="control-label">Select
                                                    Department:</label>
                                                <select name="Department" id="SelectDepartment2"
                                                        class="form-control @error('Department') is-invalid @enderror">
                                                    <option value="0" @if(old('Department') == 0) selected @endif>All
                                                        departments
                                                    </option>
                                                    @if(count($Departments) > 0)
                                                        @foreach ($Departments as $Department)
                                                            <option value="{{ $Department->id }}"
                                                                    @if(old('Department') == $Department->id) selected @endif> {{ $Department->department_name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            @if($CountOnline !== 0)
                                                <div class="col-6">
                                                    <label for="Doctor_List_Option" class="text-center control-label">Phone</label>
                                                    <input type="text" class="form-control" placeholder="01XXXXXXXXX"
                                                           maxlength="11" minlength="11" name="phone"
                                                           value="{{ old('phone') }}" required>
                                                </div>
                                            @endif
                                            {{--<div class="col-6 col-md-6 col-lg-6">
                                                <div>Status:</div>
                                                <div class="row m-l-10 m-r-10 m-t-5">
                                                    <div style="line-height: 21px;" class="m-r-5">
                                                        <label class="switch">
                                                            <input type="radio" name="Status" checked id="Online" required value="Online">
                                                            <span class="slider round"></span>
                                                        </label> Online
                                                    </div>
                                                    <div style="line-height: 21px;" class="m-l-5">
                                                        <label class="switch">
                                                            <input type="radio" name="Status" id="Offline" required value="Offline">
                                                            <span class="slider round"></span>
                                                        </label> Offline
                                                    </div>
                                                </div>
                                            </div>--}}

                                        </div>

                                        {{--<div class="m-t-10 row">
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <label for="DoctorList" class="text-center control-label">Select Date: </label>
                                                <input type="text" class="form-control @error('appointment_date') is-invalid @enderror" name="appointment_date" id="Date_Picker_Request" required>
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6">
                                                <label for="Start_Time_Input" class="text-center control-label">Time </label>
                                                <input type="text" name="Start_Time_Input" id="start_time_picker" placeholder="----" class="form-control Start_Time_Input @error('Start_Time_Input') is-invalid @enderror" required >
                                            </div>
                                        </div>--}}
                                        <div class="m-b-10">Select an online doctor:</div>
                                        <div class="row" id="Doctor_Details_Info"
                                             style="overflow-y: scroll; max-height: 300px;">
                                            {{-- Show doctor details --}}
                                        </div>
                                        @if($CountOnline !== 0)
                                            <div class="m-t-20">
                                                <button type="submit"
                                                        class="btn btn-primary col-12 Request_Appointment_Btn">Request
                                                    Consultation Now
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>



    <!-- Departments -->
    <div class="our-departments">
        <div class="container col-12 col-xl-10 col-lg-11">
            <div class="row">
                <div class="col-12">
                    <div class="departments-wrap">
                        <h2 class="text-white">Departments</h2>
                        <hr class="bg-white">

                        <div class="row">
                            @if(count($Departments)>0)
                                @foreach ($Departments->take(6) as $Department)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 hover_Effect_department"
                                         style="border-radius: 6px;">
                                        <div class="our-departments-cont">
                                            <header class="entry-header d-flex flex-wrap align-items-center">
                                                <img
                                                    data-src="{{ config('app.image_url', null).'/storage/image/web_layout/icon/'.$Department->icon }}"
                                                    alt="" height="30px">
                                                <h3 style="color: #1a2d41;">{{ $Department->department_name }}</h3>
                                            </header>

                                            <div class="entry-content">
                                                <?php
                                                $string = strip_tags($Department->details);
                                                if (strlen($string) > 20) {
                                                    // truncate string
                                                    $stringCut = substr($string, 0, 100);
                                                    $endPoint = strrpos($stringCut, ' ');
                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $string .= '... ';
                                                }
                                                ?>
                                                <p>{!! $string !!}</p>
                                            </div>

                                            <footer class="entry-footer" style="margin-bottom: 10px;font-size: 14px;">
                                                <span>({{ count($Department->doctor) }}) Doctors</span>
                                                <a href="{{ urlencode('department-details|').encrypt($Department->id) }}"
                                                   class="float-right">read more</a>
                                            </footer>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{'No departments is available'}};
                            @endif
                        </div>
                        <br>
                        <div class="text-center">
                            <a href="{{ route('departments') }}"
                               {{--class="button gradient-bg"--}} class="btn_blue  bounceIn delay-1s">{{ 'More' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Departments -->


    <!-- Home blog section -->
    <div class="container mar-top-bot-40">
        <div class="row">
            <div class="col-lg-12">
                <div class="the-news">
                    <h1 class="col-lg-12 mb-10 color-666 text-center">From the blog...</h1>
                    <hr class="bg-dark">
                    <br>
                    <div class="row">
                        @if(count($Blog) > 0)
                            @foreach ($Blog as $B)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="the-news-wrap">
                                        <figure class="post-thumbnail">
                                            <img data-src="{{ $B->image }}" alt="" height="240px"
                                                 style="object-fit: cover;object-position: center center;">
                                        </figure>

                                        <header class="entry-header">
                                            <h3>{{ $B->title }}</h3>
                                            <div class="post-metas align-items-center">

                                                <div class="row">
                                                    <div class="posted-date col-6 text-left">
                                                        <label>Date: </label>
                                                        <span
                                                            class=" text-primary">{{date('M-d-y',strtotime($B->publish_date))}}</span>
                                                    </div>
                                                    <div class="posted-by col-6 text-right"><label>By: </label><span
                                                            class="text-primary"> {{ $B->author }} </span></div>
                                                </div>
                                                <div class="row col">
                                                    <div class="post-comments m-r-10"><span class="text-primary">{{ count($B->view) }} <i
                                                                class="fas fa-eye"></i> views</span></div>
                                                    <div class="post-comments"><span class="text-primary">{{ count($B->comment) }} <i
                                                                class="fas fa-comments"></i> Comments</span></div>
                                                </div>
                                            </div>
                                        </header>

                                        <div class="entry-content">
                                            <p class="text-justify" style="font-size: 14px;line-height: 18px;">
                                                <?php
                                                $string = strip_tags($B->description);
                                                if (strlen($string) > 20) {
                                                    // truncate string
                                                    $stringCut = substr($string, 0, 320);
                                                    $endPoint = strrpos($stringCut, ' ');
                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $string .= '... ';
                                                }
                                                ?>
                                                {!! $string !!}
                                            </p>
                                        </div>

                                        <footer class="entry-footer mt-2 text-center">
                                            <a href="{{ urlencode('view-blog|'.encrypt($B->id)) }}"
                                               {{--class="button gradient-bg"--}} class="btn_blue  bounceIn delay-1s text-white">Read
                                                More</a>
                                        </footer>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-center">{{ 'No blog available.' }}</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Blog section --}}



    <section class="Section_Container S_C_Contact">
        <div class="col-lg-12 m-b-20">
            <h3>Contact Us</h3>
            <hr class="bg-white">
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <form action="{{ route('send-message') }}" method="post" class="form contact-needs-validation"
                      novalidate>
                    @csrf
                    <input type="text" hidden name="user_id"
                           value="@if (Auth::check() && Auth::user()->is_admin !== 1 ){{ encrypt(Auth::user()->id) }}@endif">

                    <div class="form-group custom-control">
                        <label for="name">Name: <br></label>
                        <input type="text" class="form-control" placeholder="Name" name="name" id="name" minlength="3"
                               maxlength="30" required @if(Auth::check()) readonly
                               @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->first_name .' '. Auth::user()->last_name }}@else{{ old('name') }}@endif">
                        <div class="invalid-tooltip">Name is required. Minlength 3.</div>
                    </div>
                    <div class="form-group custom-control">
                        <label for="email">Email: <br></label>
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email"
                               minlength="10" maxlength="60" required @if(Auth::check()) readonly
                               @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->email }}@else{{ old('email') }}@endif">
                        <div class="invalid-tooltip">Email is required.</div>
                    </div>
                    <div class="form-group custom-control">
                        <label for="contact">Contact no: <br></label>
                        <input type="text" class="form-control" placeholder="01XXXXXXXXX" name="contact" id="contact"
                               maxlength="11" minlength="11" required @if(Auth::check()) readonly
                               @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->phone }}@else{{ old('contact') }}@endif">
                        <div class="invalid-tooltip">Phone number is required. Minlength 11.</div>
                    </div>
                    <div class="form-group custom-control">
                        <label for="">Message: <br></label>
                        <textarea name="message" id="" cols="30" rows="6" placeholder="Message"
                                  class="form-control resize_none" required
                                  minlength="10">{{ old('message') }}</textarea>
                        <div class="invalid-tooltip">Message is required</div>
                    </div>
                    <div class="form-group custom-control">
                        <button type="submit" name="SendMessage" class="btn_blue  bounceIn delay-1s" id="Contact_btn">
                            @if (Auth::check() && Auth::user()->is_admin !== 1 )
                                {{ 'Send message as "' . Auth::user()->first_name .' '. Auth::user()->last_name .'"'}}
                            @else
                                {{ 'Send message as ' }}<i class="fa fa-user" style="margin-left: 6px;"></i> Guest user
                            @endif
                        </button>
                    </div>
                </form>
                <br>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="col-lg-10 container">
                    <div class="contact-info h-100">
                        <h3 class="d-flex align-items-center text-center" style="background: transparent;color:white;">
                            Contact Info</h3>
                        <ul class="p-0 m-0" style="color: white;">
                            <li><span>Address: </span> Dhanmondi, House 23/A Dhaka bangladesh</li>
                            <li><span>Phone: </span> +880 1800000000</li>
                            <li><span>Email: </span> ta224604@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-10 container">
                    {{--<iframe style="box-shadow:0 0 10px rgba(0,0,0,.4); border:0;height: 260px!important;width: 100%!important;margin: 20px auto!important;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d724.6213122523719!2d90.38161087023289!3d23.752270451682126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8afb693ff75%3A0x32051f5a37ac6420!2sDaffodil+International+Academy!5e0!3m2!1sen!2sbd!4v1527285423870" frameborder="0" allowfullscreen></iframe>--}}
                </div>
            </div>
        </div>

    </section>


@stop





@section('Page_Level_Script')
    <script>
        $('#projectInfoModal').modal('show');
    </script>
    <script>
        // Book appointment scroll ...
        $(document).ready(function () {
            $('#Btn_Book_Appointment').click(500, function (e) {
                $("html, body").animate({
                    scrollTop: $('#Book_Appointment').offset().top - 150
                }, 2000);
                e.preventDefault();
            });
        });
        // Book appointment validation ....
    </script>
    <script>
        // form validation ....
        // Trim text field value ....
        $(document).ready(function () {
            $('.contact-needs-validation').submit(function () {
                $(':input').each(function () {
                    $(this).val($.trim($(this).val()))
                }, false);
            });
        });
        // Bootstrap validation ....
        $(document).ready(function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let Contact_form = document.getElementsByClassName('contact-needs-validation');
                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(Contact_form, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() == false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        });
    </script>
    <script>
        $(document).ready(function () {
            let Owl_Carousel = $('.owl-carousel');
            Owl_Carousel.owlCarousel({
                loop: true,
                lazyLoad: true,
                autoplay: true,
                mouseDrag: true,
                stagePadding: 20,
                dots: false,
                margin: 10,
                nav: true,
                //center: true,
                startPosition: 0,
                autoplayHoverPause: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 1
                    },
                    650: {
                        items: 2
                    },
                    700: {
                        items: 2
                    },
                    780: {
                        items: 3
                    },
                    960: {
                        items: 3
                    },
                    1024: {
                        items: 3
                    },
                    1300: {
                        items: 4
                    }
                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {

            // Request ... appointment ...// For request appointment part ...
            let myUrl2 = "{{ url('request-appointment-form') }}";

            let departmentId = $('#SelectDepartment2').val();
            //setInterval(function () {
            if (departmentId == 0) {
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl2,
                    dataType: "json",
                    data: {"department_id": departmentId}
                }).done(function (result) {
                    if (result.error == false) {
                        $('#Doctor_Details_Info').html(result);
                    } else {
                        $('#Doctor_Details_Info').append(result);
                    }
                });
            } else if (departmentId != 0) {
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl2,
                    data: {"department_id": departmentId}
                }).done(function (result) {
                    if (result.error == false) {
                        $('#Doctor_Details_Info').html(result);
                    } else {
                        $('#Doctor_Details_Info').html(result);
                    }
                });
            }
            //}, 2000);


            $('#SelectDepartment2').change(function () {
                let dep_id = $(this).val();
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl2,
                    data: {"department_id": dep_id}
                }).done(function (result) {
                    if (result.error == false) {
                        /*$("#Doctor_List_Option").empty();*/
                        $('#Doctor_Details_Info').html(result);
                    } else {
                        /*$('#Doctor_Details_Info').empty();
                        $("#Doctor_List_Option").empty();
                        $("#Doctor_List_Option").append('<option disabled readonly="" value="" selected>Select</option>');
                        $.each(result,function(key,value){
                            $("#Doctor_List_Option").append('<option value="'+value.doc_id+'">'+value.first_name+' '+value.last_name+'</option>');
                        });*/
                        $('#Doctor_Details_Info').html(result);
                    }
                });
            });

            $('#Request_Appointment').click(function () {
                e.preventDefault();
            });
        });
    </script>

@stop
