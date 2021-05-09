@extends('layouts.app_back')

@section('title')
    @php $title = 'Manage User'; @endphp
    @php $subTitle = 'Add User'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')


    <!-- Website content -->
    <div class="wrapper wrapper-content">


            <div class="row">
                <div class="col-sm-12 white-bg">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Create new admin user.</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="animated fadeInRight">
                                <div class="row">

                                    <form action="{{ urlencode('create-user') }}" method="post" enctype="multipart/form-data" class="form col-12" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">First name:*</label>
                                                                <input type="text" name="first_name" minlength="3" maxlength="30" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Last name:*</label>
                                                                <input type="text" name="last_name" minlength="3" maxlength="30" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Email:*</label>
                                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Password:*</label>
                                                                <input type="password" name="password" minlength="8" class="form-control @error('password') is-invalid @enderror" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">ConfirmPassword:*</label>
                                                                <input type="password" name="password_confirmation" minlength="8" class="form-control @error('password') is-invalid @enderror" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Phone:*</label>
                                                        <input type="text" name="phone" minlength="11" maxlength="11" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                                                    </div>
                                                </div>

                                                <div class="form-group col-12">
                                                    <label class="mr-2">Gender: </label>
                                                    <div class="form-control">
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input @error('gender') is-invalid @enderror" id="male" name="gender" value="male" required @if(old('gender') === 'male') {{ 'checked' }} @endif>
                                                            <label class="form-check-label" for="male">Male</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input @error('gender') is-invalid @enderror" id="female" name="gender" value="female" required @if(old('gender') === 'female') {{ 'checked' }} @endif>
                                                            <label class="form-check-label" for="female">Female</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="date_of_birth">Date of birth:*</label>
                                                        <input type="text" name="dob" id="date_of_birth" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" readonly required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="button">
                                            <button type="submit" class="btn btn-success btn-sm px-5"> Add User</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




    </div>


@stop


@section('Page_Level_script')

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

            $( "#date_of_birth" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                showOtherMonths: true,
                minDate: new Date( minyear,minmonth,minday),
                maxDate: new Date( maxyear,maxmonth,maxday)
            });
        });
    </script>




@stop
