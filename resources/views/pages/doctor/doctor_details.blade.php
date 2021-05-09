@extends('layouts.app_front')

@section('title')
    @php $title = 'Doctors'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

    <!-- Body content -->
    <div id="MainContent">

        <!-- Banner image -->
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="{{('/storage/image/web_layout/banner/DOCTOR-2-1700x470-opt.jpg')}}" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }} / Doctor details</h1>
        </div>

        @isset($Doctor_Data)
        <div class="wrapper wrapper-content m-t-40 m-b-40">
            <div class="container content">
                <div class="row m-b-20">
                    <!-- Left side -->
                    <div class="col-12 col-md-4 col-lg-3 m-b-20">
                        <div class="col text-center p-t-10 p-b-10 rounded relative" style="background: #eeeeee; position: relative!important;"><!-- Image div -->

                            @if($Doctor_Data->userIsOnline())
                            <div class="online_ab rounded"><i class="fa fa-circle" style="color: greenyellow;"></i> Online now</div>
                            @else
                            <div class="online_ab rounded"><i class="fa fa-circle" style="color: coral;"></i> Offline</div>
                            @endif

                            <img class="m-b-20" src="{{ $Doctor_Data->avatar }}" alt="" style="width:100%;box-shadow: 0 0 2px rgba(0,0,0,.4);min-height: 260px;max-height:300px;object-fit: cover;object-position: center top;">
                            <h4 class="text-left">{{ $Doctor_Data->first_name . ' ' . $Doctor_Data->last_name }}</h4>
                            <div class="text-left"><b class="m-r-10">Speciality: </b> {{ $Doctor_Data->doctor->department->department_name }}</div>
                            <div class="text-left"><b class="m-r-10">Education: </b> {{ $Doctor_Data->doctor->education }}</div>
                            <div class="text-left"><b class="m-r-10">Nationality: </b> {{ $Doctor_Data->doctor->nationality }}</div>
                            <div class="text-left"><b class="m-r-10">Work place: </b> {{ $Doctor_Data->doctor->work_place_name }}</div>
                            <div class="text-left"><b class="m-r-10">Experience: </b> {{ $Doctor_Data->doctor->experience }} Years</div>
                        </div>
                    </div>
                    <!-- Right side -->
                    <div class="col-12 col-md-8 col-lg-9 m-b-20">
                        <div class="col-12">
                            <div class="col-12">
                                <h4>About {{ $Doctor_Data->first_name }}</h4>
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="m-b-20">
                                    {!! $Doctor_Data->doctor->about !!}
                                </div>
                                <div class="m-b-20">
                                    <h5><u>Working days</u></h5>
                                    <div>{{ $Doctor_Data->doctor->working_days }}</div>
                                </div>
                                <div class="m-b-20" style="color: #aaa;">
                                    <h5><u>Rating</u></h5>
                                    <div>
                                        {{-- Calculate doctor rating --}}
                                        @php $Ratings = $Doctor_Data->doctor->doctorrating; $number_of_rating = count($Ratings); $c = 0;@endphp
                                        @if(count($Ratings)>0)
                                            @foreach($Ratings as $Rating)
                                                @php $c += $Rating->rating_value @endphp
                                            @endforeach
                                            {{ round($calculate = $c / $number_of_rating, 2) }}
                                        @else
                                            {{ 0 }}
                                        @endif
                                        <i class="fa fa-star m-r-10" style="color: yellow;text-shadow: 0 0 6px rgba(0,0,0,.8);"></i> ( {{ $number_of_rating }} <i class="fa fa-user"></i>)
                                    </div>
                                </div>

                                <div class="m-b-20">
                                    @if(count($Ratings)>0)
                                        <h5><u>What patients say about {{ $Doctor_Data->first_name }}</u></h5>
                                        @foreach($Ratings->reverse()->take(5) as $Rating){{-- show only 5 ratings ... --}}
                                            <div class="" style="padding: 6px 20px 0 20px; margin: 0; background:#9ea6b9; border-radius: 6px;">
                                                <img data-src="{{ $Rating->patient->user->avatar }}" alt="" height="40" width="40" style="border-radius: 50%;object-fit: cover;object-position: center;">
                                                <span><a href="" style="color: #000!important;"> {{ $Rating->patient->user->first_name .' '. $Rating->patient->user->last_name }} </a></span>
                                                <div><p>{{ $Rating->comments }}</p></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr>
                            @if(count($Check_appointment) > 0 )
                                @if(Auth::check() && $Doctor_Data->id !== auth()->user()->id)
                                    <div class="col-12">
                                        <a href="{{ route('appointment') }}" class="btn btn-primary float-right">Book Appointment</a>
                                    </div>
                                @elseif(Auth::guest())
                                    <div class="col-12">
                                        <a href="{{ route('appointment') }}" class="btn btn-primary float-right">Book Appointment</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>




                <!-- Show doctors related to this department -->
                <div class="content col-12 text-center">
                    <h5>Related doctor list</h5>
                    <hr>
                    <div class="row">
                        @if(count($Related_Doctor) > 0)
                            @foreach($Related_Doctor as $R_D)
                                @if($R_D->availableUser !== null)
                                    <div class="col-12 col-md-4 col-lg-3 m-t-10 m-b-10 Doc_Each wow fadeIn">
                                        <div class="p-t-10 p-b-10 rounded" style="box-shadow: 0 2px 2px rgba(0,0,0,.2);">
                                            <div class="col-12 text-center doc_img_div">

                                                @if($R_D->availableUser->status === 1)
                                                <div class="online_ab rounded"><i class="fa fa-circle" style="color: greenyellow;"></i> online now</div>
                                                @endif

                                                <img data-src="{{ $R_D->availableUser->avatar }}" alt="" class="Doc_Each_Img">
                                                <div class="filter_cover text-center">
                                                    <a href="{{ urlencode('doctors-details|') . encrypt($R_D->availableUser->id)}}" class="btn btn-primary btn-sm Doc_Details_btn">More Details</a>
                                                    <div class="display_doc_details">
                                                        <div>Hospital: <span style="color: #ffffff;">{{ $R_D->work_place_name }}</span></div>
                                                        <div>Experience: <span style="color: #ffffff;">{{ $R_D->experience }} Years</span></div>
                                                        <div>Rating: <span style="color: #ffffff;">
                                                            {{-- Calculate doctor rating --}}
                                                            @php $Ratings = $R_D->doctorrating; $number_of_rating = count($Ratings); $c = 0;@endphp
                                                            @if(count($Ratings)>0)
                                                                @foreach($Ratings as $Rating)
                                                                    @php $c += $Rating->rating_value @endphp
                                                                @endforeach
                                                                    {{ round($calculate = $c / $number_of_rating, 2) }}
                                                            @else
                                                                {{ 0 }}
                                                            @endif
                                                            <i class="fa fa-star" style="color: yellow;"></i>
                                                        </span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="col-12">
                                                <div>Name: <a href="{{ urlencode('doctors-details|') . encrypt($R_D->availableUser->id)}}"><span style="color: #0d8ddb;">{{ $R_D->availableUser->first_name .' '. $R_D->availableUser->first_name }}</span></a></div>
                                                <div>Department: <span style="color: #0d8ddb;">{{ $R_D->department->department_name }}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>No related doctors found.</p></div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>No related doctors found.</p></div>
                        @endif
                    </div>
                </div>



            </div>
        </div>
        @endisset


    </div>
@stop



@section('Page_Level_Script')



@stop
