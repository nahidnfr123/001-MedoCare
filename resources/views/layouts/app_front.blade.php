<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MedoCare.com') . ' / ' }} @yield('title', config('app.name', 'MedoCare.com'))</title>

    <link rel="icon" href="#">

    <link
        href="//fonts.googleapis.com/css2?family=Montserrat&family=Nunito&family=Poppins&family=Quicksand&display=swap"
        rel="stylesheet" defer>

    <link href="{{ asset('main.css') }}" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" defer>

    <link rel="stylesheet" href="{{ asset('asset_front/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_front/slider_asset/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_front/slider_asset/mm.css') }}">

    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('asset_front/css/join_us_form.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_front/css/chatbox.css') }}">


    <link href="{{ asset('css/dscountdown.css') }}" rel="stylesheet">
    <link href="{{ asset('sweet_alert/sweet_alert.css') }}" rel="stylesheet">

    <!--JS CDN Link files-->
    <script src="//code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="col-12 text-center bg-dark text-white text-bold" style="font-size:12px;"> Laravel 6.* Project Demo (Online
    Medical website), (Project 001)
</div>
<div id="app">

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>


    <!-- Main body container Starts-->
    <div id="Wrapper">
        <!-- Top bar (contact info)-->
        <div class="TopBar">
            <div class="Contact">
                <span> Contact: +880134567801 | Email: medocare@gmail.com </span>
            </div>

            {{-- If user is logged in --}}
            @if(Auth::check() && Auth::user()->is_admin != 1 )
                <div class="TopBar_ProfileDiv">
                    <div class="ProfileIconBox" onclick="ProfileMenuToggle()" id="Profile" style="position: relative;">
                        <img data-src="{{ Auth::user()->avatar }}" alt="">
                        <span>{{ Auth::user()->first_name .' '. Auth::user()->last_name }}</span>
                        {{-- Show number of recieved message --}}
                        <div class="MsgCount MsgCountfront text-info bg-white"
                             style="position: absolute;top: 0;right: -6px;padding: 0 2px;border-radius: 40px; line-height: 16px;box-shadow: 0 1px 6px rgba(0,10,20,.8)">

                        </div>
                    </div>
                    <div id="Profile_Options">
                        <span class="Arrow"><i class="fas fa-sort-up"></i></span>
                        <ul>
                            <li><a href="{{ route('user.user-profile') }}"> <i class="fas fa-user"></i> View Profile
                                </a></li>
                            <li><a href="{{ route('user.user-profile') }}"> <i class="fas fa-comment-alt"></i> Message
                                    <div class="MsgCount"></div>
                                </a>
                            </li>
                            <!--<li><a href="user_profile_settings.php"> <i class="fas fa-tools"></i> Settings </a></li>-->

                            {{-- Logout --}}
                            <li><a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            {{-- If user is not logged in --}}
            @if(Auth::guest()) {{-- || Auth::user()->is_admin != 1 --}}
            <div class="Log_Option">
                <a href="{{ url('/login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ url('/register') }}"><i class="fas fa-user-plus"></i> Register</a>
            </div>
            @endif

            {{-- If Admin is logged in --}}
            {{--@if (Auth::check() && Auth::user()->is_admin == 1 )
                <div class="Log_Option">
                    <a href="{{ url('/login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="{{ url('/register') }}"><i class="fas fa-user-plus"></i> Register</a>
                </div>
            @endif--}}
        </div>


        {{-- Navigation bar --}}
        <header class="Top_Header" id="Header">
            <div class="LogoDiv">
                <a href="{{ route('home') }}" title="Home Page">
                    <img data-src="{{ config('app.image_url', null) }}/storage/image/web_layout/Medocare.png" alt="MedoCare">
                </a>
            </div>

            {{-- Prevent undefined varriable title! Error. --}}
            @if(!isset($title)) {{$title=''}} @endif
            <div class="NavMenu_Container">
                <nav id="NavMenu" class="NavMenu">
                    <ul class="Nav_Ul">
                        <li><a href="{{ url('/') }}" class="@if($title == 'Home' || $title == '/'){{ 'Active' }}@endif">
                                <i class="fas fa-home"></i> Home </a></li>
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('all-doctors') }}" class="@if($title == 'Doctors'){{ 'Active' }}@endif">
                                <i class="fas fa-stethoscope"></i> Doctors </a></li>
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('appointment') }}"
                               class="@if($title == 'Appointment'){{ 'Active' }}@endif"> <i
                                    class="far fa-calendar-alt"></i> Appointments </a></li>
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('departments') }}"
                               class="@if($title == 'Departments'){{ 'Active' }}@endif"> <i class="fas fa-tint"></i>
                                Departments </a></li>
                        {{--<li><a href="" class=""> <i class="fas fa-tint"></i> Blood Bank </a></li>--}}
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('blog') }}" class="@if($title == 'Blog'){{ 'Active' }}@endif"> <i
                                    class="fas fa-blog"></i>Blog </a></li>
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('contact-us') }}"
                               class="@if($title == 'Contact-Us' || $title == '/'){{ 'Active' }}@endif"> <i
                                    class="fas fa-address-book"></i> Contact </a></li>
                        <span class="V-Bar"> | </span>
                        <li><a href="{{ route('about-us') }}"
                               class="@if($title == 'About' || $title == '/'){{ 'Active' }}@endif"> <i
                                    class="fas fa-question"></i> About </a></li>
                    </ul>
                </nav>
                <span class="navTrigger">
            <i></i>
            <i></i>
            <i></i>
        </span>
            </div>
        </header>
        {{-- End Navigation Bar --}}



        {{-- Show verification link... --}}
        @if((Auth::check() && Auth::user()->is_admin != 1 && Auth::user()->email_verified_at == null))
            @if(URL::current() != 'http://localhost:8000/email/verify')
                @if(URL::current() != 'http://127.0.0.1:8000/email/verify')
                    <div class="col-12 alert alert-success text-center">
                        Your email adders is not verified. Please <a href="{{url('/email/verify')}}"> Verify email. </a>
                    </div>
                @endif
            @endif
        @endif




        {{-- Dynamic Body Content --}}
        <main class="" id="MainContent">
            @yield('Main_Body_Content')
        </main>
        {{-- End Dynamic Body Content --}}


    </div>

    {{-- Help option float --}}
    <div class="HelpOption">
        <a href="{{ route('help') }}" class="a_help" target="_blank" title="Help"> <i class="fas fa-question"></i>
            <span> Need help ?</span></a>
    </div>


    {{-- Footer --}}
    <footer class="Footer_Content clearfix" style="clear: both;">
        @if(Auth::guest())
            <div class="JoinUser wow fadeInDown">
                <p>If you are a <strong>doctor</strong>{{-- or <strong>blood donor</strong>--}} join our community and
                    help us grow by becoming a part of us.</p>
                <a href="{{ route('join_us') }}" class="btn_Orange">JOIN US</a>
            </div>
            <hr class="bg-white text-white">
        @endif

        <div class="footer_body">
            <div class="FooterInnerContent">
                <div class="FAQ">
                    <div>
                        <form action="" method="post" class="my_form">
                            <div class="">
                                <label for="Question" class="my_form_lbl">Do you have any question...?</label>
                                <input type="text" name="Question" id="Question" placeholder="Question"
                                       class="my_form_control">
                            </div>
                            <div>
                                <input type="submit" name="Question" value="Submit" class="mybtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="Footer_Links">
                <ul class="Ul">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="">Services</a></li>
                    <li><a href="">FAQ</a></li>
                    <li><a href="">Blood Group</a></li>
                    <li><a href="{{ url('/about') }}">About</a></li>
                </ul>

                <ul class="Ul m-t-20">
                    <li><a href="https://facebook.com/"><i class="fab fa-facebook-square"></i></a></li>
                    <li><a href="https://gmail.com"><i class="fab fa-google-plus"></i></a></li>
                    <li><a href=""><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://youtube.com/"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>

        </div>


        <div class="Footer_Bottom">
            <p><small> <span>&#169; 2019 - {{ date('Y') }}</span> MedoCare. All right reserved. </small></p>
        </div>
    </footer>


    @include('layouts.partials.popup_msg')
</div>


{{-- Emergency message --}}
@if(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor')
    <div id="RequestAppointmentDiv">
        {{-- Ajax load content --}}
        <div class="Emergency_message_Request" id="EMR_BTN"><i class="fa fa-user-injured"></i>
            <div class="RCount"></div>
        </div>
        <div class="Emergency_Request_Btn_Option animated fadeInUp">
            <div class="RequestTextToggle">

            </div>
            <div id="RequestDetails">

            </div>
        </div>
    </div>
@endif

{{-- Patient end --}}

{{--@if(session()->has('RequestAppointment') && session()->has('Token'))--}}
{{--@if(Illuminate\Support\Facades\Cookie::get('RequestAppointment') && Illuminate\Support\Facades\Cookie::get('Token'))
    <script>alert('hello');</script>
    @php
        $Appointment_Requests = App\AppointmentRequest::where('token', '=', session('Token'))->first();
    @endphp
    @if($Appointment_Requests != '')
        @if($Appointment_Requests->status == 'declined')
            <div class="Float_MSG_Error animated fadeInDownBig slower" style="max-width: 320px;">
                <div id="Close_Btn" onclick="close_Error_div()">
                    <i class="fa fa-times"></i>
                </div>
                <h4>Sorry</h4>
                <ul class="Error_Ul">
                    <li>{{ 'Your appointment request is declined as the doctor is busy. Please find another doctor.' }}</li>
                </ul>
            </div>
            @php session()->forget('RequestAppointment'); session()->forget('Token');  @endphp
        @elseif($Appointment_Requests->status == 'accepted')

        @endif
    @endif
@endif--}}


<div id="MiniChatBox" class="MiniChatBox HideMe">
    <div id="EM_CountDownTimer"></div>
    <div class="MiniChatBox_Header" style="position: relative;">
        <div class="Identity float-left"></div>
        @if(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor')
            <div class="float-right CloseMiniChat" title="END Conversation"><i class="fa fa-times"></i></div>@endif
        <div class="float-right MinimizeMiniChat" title="Minimize"><i class="fa fa-angle-down"></i></div>
        <div class="clearfix"></div>
    </div>

    <div id="EM_MSG_Container">
        <div class="MiniChatBox_Body" style="position: relative;">
            <div class="MessageInner">
                <ul id="Get_E_Msg" style="width: 100%;">

                    <li>
                        <hr>
                    </li>
                    <li id="ScrollDownToMe"></li>
                </ul>
                <div class="Message_Status">

                </div>
            </div>
        </div>

        <div class="MiniChatBox_Footer" style="position: relative;">
            <form action="" method="post" enctype="multipart/form-data" id="E-Msg-form">
                @csrf
                <div class="" style="width: 100%;display: flex">
                    <div style="width: 270px">
                        <input type="text" class="form-control" id="Emergency_Message_Textbox" name="message"
                               placeholder="Write something .....">
                    </div>
                    <button type="button" class="btn btn-info" id="open_file_Dialog" style="width: 30px; padding: 0;"
                            title="Add report"><i class="fa fa-file"></i></button>
                </div>
            </form>

            <form action="{{ url('em-report') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="Sender_Id" id="Sender_Id" value="" hidden required readonly>
                <input type="hidden" name="AppReq_Token" id="AppReq_Token" value="" hidden required readonly>
                {{-- Upload report field --}}
                <div style="position:absolute; top: 100%;">
                    <input type="file" name="Report_file" id="select_report_emergency" hidden>
                    <button type="submit" class="btn" id="submit_report_emergency" title="Upload report"
                            hidden></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="POPMessageHolder"></div>

<!--JS CDN Link files-->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" defer crossorigin="anonymous"></script>

{{--DAte time picker--}}
<script src="{{ asset('asset_front/js/Cross-browser-Date-Time-Selector-For-jQuery-dateTimePicker/dist/date-time-picker.min.js') }}" defer></script>

{{--<script src="{{ asset('sweet_alert/sweet_alert.min.js') }}"></script>--}}
<script src="//unpkg.com/sweetalert/dist/sweetalert.min.js" defer></script>


<!-- Slider js files -->
<script src="{{ asset('asset_front/slider_asset/medocare.bundle.js') }}" defer></script>
<script src="{{ asset('asset_front/slider_asset/active.js') }}" defer></script>

<!--owl carousel for slider ....-->
<script src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" defer
        crossorigin="anonymous"></script>

<script defer>
    window.addEventListener("load", function () {
        function LoadWebContent() {
            var FontAwesome = document.createElement("script");
            FontAwesome.src = "https://kit.fontawesome.com/b18573c8b7.js";
            FontAwesome.crossorigin = "anonymous";
            document.body.appendChild(FontAwesome);

            var js2 = document.createElement("script");
            js2.src = "{{ asset('asset_front/js/function.js') }}";
            document.body.appendChild(js2);

            var js3 = document.createElement("script");
            js3.src = "//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js";
            document.body.appendChild(js3);

            var js4 = document.createElement("script");
            js4.src = "{{ asset('asset_front/js/join_form.js') }}";
            document.body.appendChild(js4);
        }

        LoadWebContent();
    });


    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
    let EncryptedURL = '';

    $(document).ready(function () {
        $('.MinimizeMiniChat').click(function () {
            $('#EM_MSG_Container').toggleClass('minimize', function () {
                let minmax = $('.MinimizeMiniChat i');
                if (minmax.hasClass('fa-angle-down')) {
                    minmax.removeClass('fa-angle-down');
                    minmax.addClass('fa-angle-up');
                } else {
                    minmax.removeClass('fa-angle-up');
                    minmax.addClass('fa-angle-down');
                }
            });
        });

    });
</script>

@yield('Page_Level_Script')

@if(Auth::check() && Auth::user()->is_admin != 1)
    <script defer>

        $(document).ready(function () {
            // Ajax show meaage count .... for all user ...
            @if(auth()->user()->email_verified_at)
            setInterval(function () {
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('NewMsg') }}"
                }).done(function (result) {
                    if (result.error == false) {
                        $(".MsgCount").html(result);
                    } else {
                        $(".MsgCount").html(result);
                    }
                });
            }, 3000);
            @endif


            // Ajax Consultation request ....
            $(".RequestCount").hide();
            let RequestTextToggle = '<h6 class="text-center border-bottom p-b-6">You have new emergency appointment request.</h6>' +
                '<div class="alert alert-info text-center" style="font-size: 10px;">You should respond in 3 min.</div>';
            $(".RequestTextToggle").html(RequestTextToggle);

            {{-- Doctors end Emergency consultation --}}
            @if(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor')
            // Load consultation Request ...
            setInterval(function () {
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('loadAppointmentRequest') }}"
                }).done(function (result) {
                    if (result.error == false) {
                        $("#RequestDetails").html(result);
                    } else {
                        let Count_Request = result.Count_Request;
                        let Output = result.Output;

                        if (Output == "") {
                            $(".RequestTextToggle").html('<div class="alert alert-info text-center" style="font-size: 12px;">No request available.</div>');
                            $(".RCount").html('');
                            $("#RequestDetails").html('');
                        } else {
                            $(".RequestTextToggle").html(RequestTextToggle);
                            $(".RCount").html(Count_Request);
                            $("#RequestDetails").html(Output);
                        }
                    }
                });
            }, 3000);
            @endif


            $('.Emergency_Request_Btn_Option').hide();
            $('#MiniChatBox').slideUp();

            let GetResponse = '';
            let Identity = '';

            @if(Illuminate\Support\Facades\Cookie::get('EmergencyConsultation') == true)
                GetResponse = 'in progress';
            @php
                $Token = Illuminate\Support\Facades\Cookie::get('EmergencyConsultation');
                $App_Request = \App\AppointmentRequest::where('token', '=', $Token)->first();
            @endphp
                {{--@if($App_Request->user_id != 0)
                    Identity = '{{ $App_Request->user->first_name .' '. $App_Request->user->last_name }}';
                @else
                    Identity = '{{ $App_Request->phone }}';
                @endif--}}
                @endif

            if (GetResponse == 'in progress') { /// If request accepted show the chat box;
                $('#MiniChatBox').slideDown();
                $(".Identity").html(Identity);
            }

            /// Request accepted and conversation start ...
            $("body").on('click', '.Accept_Request', function () {
                $('.Emergency_Request_Btn_Option').hide();
                $('#MiniChatBox').slideDown();
                let token = $(this).attr("data-token");

                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('acceptRequest|') }}" + token
                }).done(function (result) {
                    if (result.error == false) {
                        $("#RequestDetails").html(result);
                    } else {
                        let Identity = result.Identity;
                        $(".Identity").html(Identity);
                        $('#MiniChatBox').slideDown();
                        EncryptedURL = result.Token;
                        location.reload();
                    }
                });
            });

            $('#EMR_BTN').click(function () {
                //alert('hello');
                $(".Emergency_Request_Btn_Option").toggle('slow');
                //$(".Emergency_Request_Btn_Option" ).slideToggle();
            });

        });
    </script>
@endif



{{-- Patient end --}}
<script defer>
    $(document).ready(function () {

        @if(Illuminate\Support\Facades\Cookie::get('EmergencyConsultation') == false)
        // Default ...
        let GetResponse = '';
        $('#MiniChatBox').slideUp();
        $('#MiniChatBox').hide();
        @endif


        // Load Ajax Appointment request response
        @if(Illuminate\Support\Facades\Cookie::get('RequestAppointment') == true)

        // Default ...
        GetResponse = '';
        $('#MiniChatBox').slideUp();
        $('#MiniChatBox').hide();

        // Load request response by the doctor
        setInterval(function () {
            if (GetResponse == '') { // This is used for calling the ajax request once ....
                LoadRequestInfo();
            } else if (GetResponse == 'in progress') {
                LoadRequestInfo();
            } else if (GetResponse == 'session end') {

            } else if (GetResponse == 'declined') {

            }
        }, 1000);


        function LoadRequestInfo(GetResponse) {
            $.ajax({
                type: 'GET',
                method: 'GET',
                url: "{{ url('GetRequestResponse|') . encrypt(request()->cookie('Token')) }}"
            }).done(function (result) {
                if (result.error == false) {
                    //$("body").append(result.PoPMessage);
                    console.log(result);
                } else {
                    let Response = result.Response;
                    let Output = result.PoPMessage;

                    if (Response == 'session end') {
                        GetResponse = Response;
                        $("body").append(Output);
                        $('#MiniChatBox').slideUp('slower');
                    } else {
                        let Response = result.Response;
                        let Output = result.PoPMessage;
                        $("body").append(Output);

                        GetResponse = Response;
                        if (GetResponse == 'in progress') { /// If request accepted the show the chat box;
                            $('#MiniChatBox').slideDown();
                            $(".Identity").html(result.Doctor_name);
                        }
                        if (GetResponse == 'session end') {
                            $('#MiniChatBox').slideUp();
                        }
                    }
                }
            });
        }

        let Identity = '';

        @if(Illuminate\Support\Facades\Cookie::get('EmergencyConsultation') == true && Illuminate\Support\Facades\Cookie::get('Token') == true)
            @php
                $Token = Illuminate\Support\Facades\Cookie::get('Token');
                $App_Request = \App\AppointmentRequest::where('token', '=', $Token)->first();
            @endphp
            Identity = '{{$App_Request->doctor->user->first_name.' '.$App_Request->doctor->user->last_name}}';
        @if($App_Request->status != 'in progress')
        $('#MiniChatBox').slideUp();
        $(".Identity").html(Identity);
        @endif
        @endif

        @endif
    });
</script>


{{-- Send and load message script --}}
<script defer>
    $(document).ready(function () {

        // End the conversation ....
        @if(Illuminate\Support\Facades\Cookie::get('Token') == true)
        if (EncryptedURL == "") {
            EncryptedURL = '{{ encrypt(request()->cookie('Token')) }}';
        }
        @endif

        $('.CloseMiniChat').click(function () {
            if (confirm('Are you user you want to END the conversation?') == true) {
                $('#MiniChatBox').slideUp('slow', function () {
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ url('end-session|') }}" + EncryptedURL,
                    }).done(function (result) {
                        if (result.error == false) {
                            //$("body").append(result);
                            console.log(result);
                        } else {
                            $("#POPMessageHolder").html(result);
                        }
                    });
                });
            }
        });


        // Load Conversation message ....
        @php
            if(Illuminate\Support\Facades\Cookie::get('Token') == true){
                $value = Illuminate\Support\Facades\Cookie::get('Token');
                $App_Request = \App\AppointmentRequest::where('token', '=', $value)->first();
            }else{
                $value = '';
            }
        @endphp


        @if(Illuminate\Support\Facades\Cookie::get('Token') == true)
        let Token = '{{encrypt($value)}}';

        // Load Conversation message ....
        LoadAllMessage();

        // Autoload message div ... by ajax method
        function LoadAllMessage() {
            //alert(ConsultationId);
            $.ajax({
                type: 'GET',
                method: 'GET',
                url: "{{ url('load-all-em-msg') }}",
                data: {"Token": Token}
            }).done(function (result) {
                if (result.error == false) {
                    $("#Get_E_Msg").html(result);
                } else {
                    let MSG = result.Output;
                    let Identity = result.Identity;
                    let Avatar = result.Avatar;
                    $("#Get_E_Msg").html(MSG);
                    $(".Identity").html(Identity);
                    /*$('.MiniChatBox_Body').animate({
                        scrollTop: $(".Message_Status").offset().top + $(".Message_Status")[0].scrollHeight
                    });*/
                    $('.MiniChatBox_Body').animate({scrollTop: ($(document).height() + 10000)}, 2000);
                }
            });
        }

        // Load new message
        setInterval(function () {
            //alert(Consultation_id);
            $.ajax({
                type: 'GET',
                method: 'GET',
                url: "{{ url('load-new-em-msg') }}",
                data: {"Token": Token}
            }).done(function (result) {
                if (result.error == false) {
                    $("#Get_E_Msg").html(result);
                } else {
                    //$("#GetNewMsg").html(result);
                    //console.log(result);
                    if (result.DisableForm) { // Disable text box ...
                        $('#Emergency_Message_Textbox').attr("disabled", "disabled");
                        $('#open_file_Dialog').attr("disabled", "disabled");
                        //$("#POPMessageHolder").html(result.PopMessage);
                        if (result.TimeOut) {
                            $('.Message_Status').html(result.TimeOut);
                        }
                    } else {
                        $("#Get_E_Msg").append(result.Output); // Show messages ....
                        $('#EM_CountDownTimer').html(result.Timer);
                        //$('.MiniChatBox_Body').animate({ scrollTop: ($(document).height()+10000) }, 2000);
                        /*$('.MiniChatBox_Body').animate({
                            scrollTop: $(".Message_Status").offset().top + $(".Message_Status")[0].scrollHeight
                        });*/
                    }
                }
            });
        }, 1000);

        let Sender_id;
        @if(auth()->check())
            Sender_id = '{{ auth()->id() }}';
        @else
            Sender_id = 0;
        @endif


        // Send conversation message ....
        function sendMessage(Token) {
            let Message = $('#Emergency_Message_Textbox').val();
            $.ajax({
                type: 'GET',
                method: 'GET',
                url: "{{ url('send-em-msg') }}",
                data: {"Message": Message, "Token": Token, "Sender_id": Sender_id}
            }).done(function (result) {
                if (result.error == false) {
                    $("#Get_E_Msg").html(result);
                    console.log(result);
                } else {
                    $('#Emergency_Message_Textbox').val('');
                    LoadAllMessage();
                    //console.log(result);
                }
            });
        }

        let username = $("#username").html();
        $('#Emergency_Message_Textbox').keydown(function (e) {
            if ($('#Emergency_Message_Textbox').val().trim() != '') {
                if (e.keyCode == 13) {
                    $("#E-Msg-form").submit(function (e) {
                        e.preventDefault();
                        return false;
                    });
                    sendMessage(Token);
                } else {
                    //isTyping();
                }
            }
        });


        // Patient report upload ...
        $(" #open_file_Dialog").click(function () {
            $('#select_report_emergency').trigger("click");
            $('#AppReq_Token').val(Token);
            $('#Sender_Id').val(Sender_id);
        });
        $("#select_report_emergency").change(function () {
            $("#submit_report_emergency").trigger("click");
        });
        $("#submit_report_emergency").click(function () {
            $(this).submit();
        });
        @endif
    });
</script>

</body>
</html>
