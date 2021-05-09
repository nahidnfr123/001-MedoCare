@extends('layouts.app_front')

@section('title')
    @php $title = 'Contact-Us'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')


    <!-- Body content -->
        <div id="MainContent">

            <div class="Banner">
                <div class="filter_color"></div>
                <img data-src="storage/image/web_layout/banner/contact-us-banner.jpg" alt="">
                <h1 class="Banner_Text">
                    <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }}
                </h1>
            </div>


            <section class="contact_section">
                <br><br>
                <div class="contact_main">

                    <div class="phone wow fadeInUp" style="text-align: center;">
                        <center>
                            <h1>Call us...</h1>
                            <h1 style="font-size: 24px;">+880 1000000000</h1><br><br>
                            <div class="pulse" style="text-align: center;"><i class="fas fa-phone" id="pulsephone"></i></div>

                            <br>
                            <h1>Email us...</h1>
                            <a href="mailto:ta224604@gmail.com">ta224604@gmail.com</a><br><br>
                            <div class="pulse" style="text-align: center;"><i class="fas fa-envelope" id="pulse_envelop"></i></div>
                        </center>
                    </div>

                    <div class="Contact_Form_DIV bg-gray wow fadeInDown">
                        <h1 style="text-align:center;">Get in touch...</h1><br>
                        <div class="col-12 col-md-8 col-lg-12 content container">
                            <form action="{{ route('send-message') }}" method="post" class="form contact-needs-validation" novalidate>
                                @csrf
                                <input type="hidden" hidden name="user_id" value="@if (Auth::check() && Auth::user()->is_admin !== 1 ){{ encrypt(Auth::user()->id) }}@endif">

                                <div class="form-group custom-control">
                                    <label for="name">Name: <br></label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" id="name" minlength="3" maxlength="30" required @if(Auth::check()) readonly @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->first_name .' '. Auth::user()->last_name }}@else{{ old('name') }}@endif">
                                    <div class="invalid-tooltip">Name is required. Minlength 3.</div>
                                </div>
                                <div class="form-group custom-control">
                                    <label for="email">Email: <br></label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" minlength="10" maxlength="60" required @if(Auth::check()) readonly @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->email }}@else{{ old('email') }}@endif">
                                    <div class="invalid-tooltip">Email is required.</div>
                                </div>
                                <div class="form-group custom-control">
                                    <label for="contact">Contact no: <br></label>
                                    <input type="text" class="form-control" placeholder="01XXXXXXXXX" name="contact" id="contact" maxlength="11" minlength="11" required @if(Auth::check()) readonly @endif value="@if(Auth::check() && Auth::user()->is_admin !== 1 ){{ Auth::user()->phone }}@else{{ old('contact') }}@endif">
                                    <div class="invalid-tooltip">Phone number is required. Minlength 11.</div>
                                </div>
                                <div class="form-group custom-control">
                                    <label for="">Message: <br></label>
                                    <textarea name="message" id="" cols="30" rows="4" placeholder="Message" class="form-control resize_none" required minlength="10">{{ old('message') }}</textarea>
                                    <div class="invalid-tooltip">Message is required</div>
                                </div>
                                <div class="form-group custom-control">
                                    <button type="submit" name="SendMessage" class="btn_blue wow bounceIn delay-1s" id="Contact_btn">
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
                    </div>

                    <div class="location wow fadeInUp">
                        <center><br>
                            <h1>Our location...</h1>
                            <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d724.6213122523719!2d90.38161087023289!3d23.752270451682126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8afb693ff75%3A0x32051f5a37ac6420!2sDaffodil+International+Academy!5e0!3m2!1sen!2sbd!4v1527285423870" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </center>
                    </div>
                </div>
            </section>
        </div>


@stop



@section('Page_Level_Script')

    <script>
        // form validation ....
        // Trim text field value ....
        $(document).ready(function(){
            $('.contact-needs-validation').submit(function(){
                $(':input').each(function(){
                    $(this).val($.trim($(this).val()))
                }, false);
            });
        });
        // Bootstrap validation ....
        $(document).ready(function() {
            //'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.getElementsByClassName('contact-needs-validation');
                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
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

@stop
