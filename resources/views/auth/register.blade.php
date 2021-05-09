@extends('layouts.app_front')

@section('title')
    @php $title = 'Registration'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

{{-- Default laravel registration form --}}
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
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

<div class="Wrapper" id="MainContent" style="position: relative;">
    <form action="{{ route('register') }}" method="post" class="my_forms" name="RegForm" onsubmit="return formValidationOnSubmit()">
        <h2 class="m-b-20"><u>{{ __('Patient Registration') }}</u></h2>
        @csrf

        <!-- Input user name -->
        <div class="rowss">
            <div class="collss">
                <label for="Fname">{{ __('First Name:') }}</label>
                <input type="text" id="Fname" placeholder="" minlength="3" maxlength="20" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus class="form-control @error('first_name') is-invalid @enderror">

                <div class="Errortxt ErrorFname">
                    <span class="Err"></span>
                    <i class="fas fa-exclamation-circle Show_error"></i>
                </div>
            </div>
            <div class="collss">
                <label for="Lname">{{ __('Last name:') }}</label>
                <input type="text" id="Lname" placeholder="" minlength="3" maxlength="20" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" class="form-control @error('last_name') is-invalid @enderror">

                <div class="Errortxt ErrorLname">
                    <span class="Err"></span>
                    <i class="fas fa-exclamation-circle Show_error"></i>
                </div>
            </div>

{{--            @error('first_name')--}}
{{--            <span class="alert alert-danger" role="alert">--}}
{{--                <strong>{{ $message }}</strong>--}}
{{--            </span>--}}
{{--            @enderror--}}
        </div>

        <!-- Input user email -->
        <div class="rowss">
            <label for="Email">{{ __('Email:') }}</label>
            <input type="email" id="Email" placeholder=""  name="email" value="{{ old('email') }}" required autocomplete="email" class="form-control @error('email') is-invalid @enderror">

            <div class="Errortxt ErrorEmail">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <!-- Input Password -->
        <div class="rowss">
            <label for="password_field">{{ __('Password:') }}</label>
            <label class="label_pass"><i class="far fa-eye sign_up_eye" id="lgo_eye"></i></label>
            <input type="password" minlength="8" id="password_field"  name="password" required autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">

            <div class="Errortxt ErrorPassword">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <!-- retype password -->
        <div class="rowss">
            <label for="Confirm_Password">{{ __('Retype-password:') }}</label>
            <input type="password" id="Confirm_Password" minlength="8"  name="password_confirmation" required autocomplete="new-password" class="form-control @error('confirm-password') is-invalid @enderror">

            <div class="Errortxt ErrorConfPassword">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <!-- Input gender -->
        <div class="rowss" style="margin: 6px 0;">
            <span style="margin-top:10px; margin-left: 6px;">{{ __('Gender:') }}</span>
            <label for="male" class="GenderRadio collss center_text">
                <span>
                    <input type="radio" name="gender" value="male" id="male" required @if(old('gender') === 'male') {{ 'checked' }} @endif>
                    <i class="fas fa-male Gender_icon"></i>
                    <span class="Gender_text">Male</span>
                </span>
            </label>
            <label for="female" class="GenderRadio collss center_text">
                <span>
                    <input type="radio" name="gender" value="female" id="female" required @if(old('gender') === 'female') {{ 'checked' }} @endif>
                    <i class="fas fa-female Gender_icon"></i>
                    <span class="Gender_text">Female</span>
                </span>
            </label>

            <div class="Errortxt ErrorGender">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <div class="rowss">
            <!-- Input Date of birth -->
            <div class="collss m-t-4"><label for="datepicker">{{ __('Date of birth:') }}</label></div>
            <div class="collss">
                <input type="text" id="datepicker" name="dob" value="{{ old('dob') }}" readonly required autocomplete="dob" class="form-control form-control-sm @error('dob') is-invalid @enderror">
            </div>

            <div class="Errortxt ErrorDate">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <!--  -->
        <div class="rowss">
            <label for="Phone">{{ __('Phone:') }}</label>
            <input type="text" id="Phone" maxlength="11" minlength="8" placeholder="01XXXXXXXXX" name="phone" value="{{ old('phone') }}" required autocomplete="phone" class="form-control @error('phone') is-invalid @enderror">

            <div class="Errortxt ErrorPhone">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <!--  -->
        <div class="rowss m-t-10">
            <label for="BloodGroup" class="m-r-10 mt-1">{{ __('Blood Group:') }}</label>
            <select name="blood_group" id="BloodGroup" required class="form-control form-control-sm @error('blood_group') is-invalid @enderror" style="width: 60%; border-radius: 2px; padding: 4px 2px;">
                <option value="" selected disabled>Select</option>
                <option value="A+" @if(old('blood_group') === 'A+') {{ 'selected' }} @endif>A+</option>
                <option value="A-" @if(old('blood_group') === 'A-') {{ 'selected' }} @endif>A-</option>
                <option value="AB+" @if(old('blood_group') === 'AB+') {{ 'selected' }} @endif>AB+</option>
                <option value="AB-" @if(old('blood_group') === 'AB-') {{ 'selected' }} @endif>AB-</option>
                <option value="B+" @if(old('blood_group') === 'B+') {{ 'selected' }} @endif>B+</option>
                <option value="B-" @if(old('blood_group') === 'B-') {{ 'selected' }} @endif>B-</option>
                <option value="O+" @if(old('blood_group') === 'O+') {{ 'selected' }} @endif>O+</option>
                <option value="O-" @if(old('blood_group') === 'O-') {{ 'selected' }} @endif>O-</option>
            </select>

            <div class="Errortxt ErrorBloodGroup">
                <span class="Err"></span>
                <i class="fas fa-exclamation-circle Show_error"></i>
            </div>
        </div>

        <input type="hidden" hidden name="User_Type" value="Patient" readonly>

        <div class="rowss" style="text-align: center; margin-top: 16px;">
            <button type="submit" name="Register" class="mybtn" style="flex: 1;">{{ __('Register') }}</button>
        </div>

        <span>Already have an account? </span> <a href="{{ route('login') }}"> Login </a><br>
    </form>




    {{-- Background image on registration page --}}
    <div class="" style="position: absolute; top: 50%; left: 0; transform: translate(25%, -50%);z-index: 1;">
        <div class="col-6">
            <img src="/storage/image/web_layout/bg/patient_reg.png" alt="" style="height: 300px" class="">
        </div>
    </div>
</div>





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

@endsection






@section('Page_Level_Script')

<script src="{{ asset('asset_front/js/form.js') }}"></script>

<!-- Date time picker jquery -->
<script>
    $(document).ready(function() {
        let today = new Date();
        let Y = today.getFullYear();
        let M = today.getMonth();
        let D = today.getDate();

        let minyear;
        let maxyear;

        let maxmonth;
        let minmonth;

        let maxday = D;
        let minday = D;

        minyear = Y - 100;
        maxyear = Y - 18;

        maxmonth = M;
        minmonth = M - 12;

        $( "#datepicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true,
            showOtherMonths: true,
            minDate: new Date( minyear,minmonth,minday),
            maxDate: new Date( maxyear,maxmonth,maxday)
        });
    });


    function close_div_warning(){
        document.querySelector('.Warning_Review').style.display = 'none';
    }

    function close_div(){
        document.querySelector('.Float_MSG_Error').style.display = 'none';
    }
</script>

@endsection
