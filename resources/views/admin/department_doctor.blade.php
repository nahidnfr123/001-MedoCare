@extends('layouts.app_back')

@section('title')
    @php $title = 'Department'; @endphp
    @php $subTitle = 'Doctor'; @endphp
    {{ $title }}
@stop


@section('Admin_Main_Body_Content')

    <!-- Website content -->
    <div class="wrapper wrapper-content">

        @if(count($DoctorsByDepartment)>0)
            <div class="row">
                <div class="col-sm-12 white-bg">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>New doctor join request</h5>
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
                                <div style="padding-bottom: 20px;" class="container col-12 col-lg-10">
                                    <h1>{!! htmlspecialchars($Department->department_name) !!}</h1>
                                    <div class="text-justify">
                                        {!! $Department->details !!}
                                    </div>
                                </div>
                                <hr>
                                <h2 class="text-center">Doctors related to {{$Department->department_name}} department.</h2>
                                <div class="row">
                                    @foreach ($DoctorsByDepartment as $Doctor)
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                            <div class="contact-box center-version" style="box-shadow: 0 0 10px rgba(0,0,0,.2)">

                                                <div class="Center_content">

                                                    <img alt="image" class="rounded-circle" src="{{ $Doctor->avatar }}" style="object-fit: cover; object-position: top center;">

                                                    <h3 class="m-b-xs"><strong>{{ $Doctor->first_name . ' ' . $Doctor->last_name }}</strong></h3>

                                                    <ul class="UL">
                                                        <li><strong>Work place: </strong> {{ $Doctor->work_place_name }}</li>
                                                        <li><strong>Department: </strong> {{ $Doctor->department_name }}</li>
                                                        <li><strong>Experience: </strong> {{ $Doctor->experience }} Years</li>
                                                        <!-- Job, work place details (image or pdf file...)-->
                                                        <li><a href="{{ urlencode('view-doctor|') . encrypt($Doctor->user_id) }}" class="btn btn-primary col-12">View Details</a></li>
                                                    </ul>
                                                    <div class="midsection_join_box">
                                                        <div><strong>Email: </strong> {{ $Doctor->email }}</div>
                                                        <div><strong>Phone: </strong> {{ $Doctor->phone }}</div>
                                                    </div>
                                                </div>

                                                @if($Doctor->email_sent !== 0 && $Doctor->email_verified_at === null)
                                                    <div class="contact-box-footer" style="background-color: #0c5460; color:white;padding: 10px 0;">
                                                        <div class="m-t-xs btn-group">
                                                            <span><b>Email verification code has been sent.</b></span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="contact-box-footer">
                                                        <div class="m-t-xs btn-group">
                                                            @if($Doctor->blocked === 0) <div class="text-white">Status: <b> Active Account.</b></div> @else <div class="text-warning txt_bold">Status: <b>Active Blocked.</b></div> @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                           {{-- <div class="text-center row" style="position: relative;">
                                <br>
                                <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $DoctorsByDepartment->links() }}</div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
    @endif

    </div>

@stop


@section('Page_Level_script')





@stop
