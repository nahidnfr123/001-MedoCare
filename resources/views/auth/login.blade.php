@extends('layouts.app_front')

@section('title')
    @php $title = 'Login'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

{{-- Default laravel login page --}}
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}

<style>
    .Float_MSG_Error{
        padding: 10px 20px!important;
        background-color: white!important;
        color: coral!important;
        font-size: 12px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999999;
        border-radius: 10px;
        /*max-width: 260px;*/
        max-height: 400px;
        box-shadow: -6px 6px 6px rgba(0,0,0,.2);
    }
    .Error_Ul li{
        margin: 0;
        padding: 0;
    }
    .Warning_Review{
        padding: 10px 20px!important;
        background-color: lightskyblue!important;
        color: #666666!important;
        font-size: 12px;
        position: fixed;
        top: 50%;
        left: 15%;
        z-index: 999999;
        border-radius: 10px;
        max-width: 70%;
        max-height: 400px;
        box-shadow: -10px 10px 6px rgba(0,0,0,.4);
    }
    .Warning_Review p {
        color: white!important;
    }
    .Float_MSG_Success{
        padding: 10px 20px!important;
        background-color: white!important;
        color: yellowgreen!important;
        font-size: 12px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 999999;
        border-radius: 10px;
        /*max-width: 260px;*/
        max-height: 400px;
        box-shadow: -10px 10px 6px rgba(0,0,0,.4);
    }
    .Error_Ul li{
        margin: 0;
        padding: 0;
    }
    #Close_Btn{
        position: absolute;
        top: -10px;
        right: -10px;
        border-radius: 50%;
        color: dodgerblue;
        border: 2px solid dodgerblue;
        text-shadow: 0 0 10px dodgerblue;
        box-shadow: 0 0 10px dodgerblue;
        text-align: center;
        font-size: 20px;
        line-height: 26px;
        height: 30px;
        width: 30px;
        cursor: pointer;
        background-color: white;
        -webkit-transition: 200ms;
        -moz-transition: 200ms;
        -ms-transition: 200ms;
        -o-transition: 200ms;
        transition: 200ms;
    }
    #Close_Btn:hover{
        color: red;
        border: 2px solid red;
        text-shadow: 0 0 10px red;
        box-shadow: 0 0 10px red;
    }
</style>

<!-- Body content -->
    <div id="MainContent">

        <form action="{{ route('login') }}" method="post" class="my_forms" name="LogForm" onsubmit="return formValidationOnSubmit()">
            <h2><u>{{ __('Login') }}</u></h2>
            @csrf

            <!-- Input user email -->
            <div class="rowss">
                <label for="Email">{{ __('E-Mail:') }}: </label>
                <input type="email" id="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                {{-- Frontend form validation --}}
                <div class="Errortxt ErrorEmail">
                    <span class="Err"></span>
                    <i class="fas fa-exclamation-circle Show_error"></i>
                </div>

                {{-- Show error message on form after submit validation --}}
                {{--
                @error('email')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                --}}
            </div>


            <!-- Input Password -->
            <div class="rowss">
                <label for="password_field">{{ __('Password:') }}: </label>
                <label class="label_pass" for="password"><i class="far fa-eye" id="lgo_eye"></i></label>
                <input type="password" minlength="8" id="password_field" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">

                {{-- Frontend form validation --}}
                <div class="Errortxt ErrorPassword">
                    <span class="Err"></span>
                    <i class="fas fa-exclamation-circle Show_error"></i>
                </div>

                {{-- Show error message on form after submit validation --}}
                {{--
                @error('password')
                <span class="alert alert-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                --}}
            </div>

            <div class="rowss m-t-6">
                <!-- Remember password check box -->
                <label for="Remember" class="Remember_lbl">
                    <input type="checkbox" name="remember" id="Remember" {{ old('remember') ? 'checked' : '' }}><span>Remember</span>
                </label>
            </div>


            <!-- Submit Button -->
            {{--<input type="submit" name="Login" value="Login" class="mybtn"><br><br>--}}

            <div class="rowss" style="text-align: center; margin-top: 16px;">
                <button type="submit" name="Login" class="mybtn" style="flex: 1;">{{ __('Login') }}</button>
            </div>



            <span>Don't have an account? </span> <a href="{{ route('register') }}"> Register </a><br>

            <!-- Forget password link -->

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size: 12px;">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </form>
    </div>

{{--
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </div>
@endif
--}}

    {{-- Show floating error message --}}
    {{--
    @if ($errors->any())
    <div class="Float_MSG_Error animated fadeInDownBig" style="animation-delay: 1.5s!important;">
        <div id="Close_Btn" onclick="close_div()">
            <i class="fas fa-times"></i>
        </div>
        <strong style="color: red;">Error:</strong>
        <ul class="Error_Ul">
            @foreach($errors->all() as $err)
                <li><strong>- {{ $err }}</strong></li>
            @endforeach
        </ul>
        <div style="color: black;text-align: center;">Fill the form correctly and try again.</div>
    </div>
    @endif
    --}}


    {{-- Registration success meaage --}}
    {{--
    @if(session('success')) // Registration success in small letters ...
    <div class="Float_MSG_Success  animated fadeInDownBig">
        <strong style="color: yellowgreen;"><i class="fa fa-check-circle" style="font-size: 20px; margin-right: 4px;"></i> Success</strong>
        <p>{{ session('success') }}</p>
    </div>
    @endif
    --}}
@endsection






@section('Page_Level_Script')

    <script>
        // This Codes are for Showing and hiding password in lgoin field...
        var pwd = document.getElementById('password_field');
        var eye = document.getElementById('lgo_eye');

        eye.addEventListener('click', togglePass);

        function togglePass() {
            eye.classList.toggle('active_eye');
            // Turnary operator is used .... IF else could hav also been used here ....
            (pwd.type === 'password') ? pwd.type = 'text':
                pwd.type = 'password';
        }

        let email = document.forms["LogForm"]["Email"];
        email.addEventListener("blur", function () {
            // Email validation ....
            if (email.value === "") {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Email is required.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            } else if (email.value.indexOf("@", 0) < 0) {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            } else if (email.value.indexOf(".", 0) < 0) {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            } else {
                email.classList.remove('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "";
                document.querySelector('.ErrorEmail').style.display = "none";
                return true;
            }
        });
        let password = document.forms["LogForm"]["password"];
        password.addEventListener("blur", function () {
            if (password.value === "") {
                password.classList.add('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "Password is required.";
                document.querySelector('.ErrorPassword').style.display = "flex";
                return false;
            } else if (password.value.length < 8) {
                password.classList.add('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "Password should be more then 8 characters.";
                document.querySelector('.ErrorPassword').style.display = "flex";
                return false;
            } else {
                password.classList.remove('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "";
                document.querySelector('.ErrorPassword').style.display = "none";
                return true;
            }
        });
        function formValidationOnSubmit() {
            // Email validation ....
            if (email.value === "") {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Email is required.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            } else if (email.value.indexOf("@", 0) < 0) {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            } else if (email.value.indexOf(".", 0) < 0) {
                email.classList.add('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "Invalid Email.";
                document.querySelector('.ErrorEmail').style.display = "flex";
                return false;
            }else if (password.value === "") {
                password.classList.add('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "Password is required.";
                document.querySelector('.ErrorPassword').style.display = "flex";
                return false;
            } else if (password.value.length < 8) {
                password.classList.add('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "Password should be more then 8 characters.";
                document.querySelector('.ErrorPassword').style.display = "flex";
                return false;
            }else {
                email.classList.remove('Err');
                document.querySelector('.ErrorEmail span').innerHTML = "";
                document.querySelector('.ErrorEmail').style.display = "none";
                password.classList.remove('Err');
                document.querySelector('.ErrorPassword span').innerHTML = "";
                document.querySelector('.ErrorPassword').style.display = "none";
                return true;
            }
        }
    </script>

@endsection
