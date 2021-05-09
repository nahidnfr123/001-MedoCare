@extends('layouts.app_front')

@section('title')
    @php $title = 'Departments'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')


    <div id="MainContent">
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="storage/image/web_layout/banner/department.jpg" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }} / {{ $Departments->department_name }}
            </h1>
        </div>


        <div class="container">
            <div class="row m-t-40 m-b-40">
                <div class="col-xs-12 col-12 col-sm- 12 col-md-10 col-lg-8">
                    @isset($Departments)
                        <div class="m-b-20">
                            <h2> <u> {{ $Departments->department_name }} </u> </h2>
                        </div>
                        <div class="text-justify" style="font-size: 12px!important;">
                            {!! $Departments->details !!}
                        </div>
                        <br>
                        {{-- Department related doctors --}}
                        <div class="">
                            <h5><u>Doctors related to {{ $Departments->department_name }} department.</u></h5>

                            @if(count($Departments->doctor) > 0)
                                @php $Doctors = $Departments->doctor; @endphp
                                @foreach($Doctors as $Doc)
                                    @if($Doc->user->blocked == 0 && $Doc->user->email_verified_at !== null)
                                        <div class="col-12 col-md-6 col-lg-4 m-t-10 m-b-10 Doc_Each wow fadeIn">
                                            <div class="p-t-10 p-b-10 rounded" style="box-shadow: 0 2px 2px rgba(0,0,0,.2);">
                                                <div class="col-12 text-center doc_img_div" style="position: relative;">
                                                    @if($Doc->user->status == 1)
                                                        <div class="online_ab rounded"><i class="fa fa-circle" style="color: greenyellow;"></i> online now</div>
                                                    @endif
                                                    <img data-src="{{ $Doc->user->avatar }}" alt="" class="Doc_Each_Img">
                                                    <div class="filter_cover text-center">
                                                        <a href="{{ urlencode('doctors-details|') . encrypt($Doc->user->id)}}" class="btn btn-primary btn-sm Doc_Details_btn">More Details</a>
                                                        <div class="display_doc_details">
                                                            <div>Hospital: <span style="color: #ffffff;">{{ $Doc->work_place_name }}</span></div>
                                                            <div>Experience: <span style="color: #ffffff;">{{ $Doc->experience }} Years</span></div>
                                                            <div>Ratting: <span style="color: #ffffff;">
                                                                {{-- Calculate doctor rating --}}
                                                                @php $Ratings = $Doc->doctorrating; $number_of_rating = count($Ratings); $c = 0;@endphp
                                                                @if(count($Ratings)>0)
                                                                    @foreach($Ratings as $Ratting)
                                                                        @php $c += $Ratting->rating_value @endphp
                                                                    @endforeach
                                                                    {{ round($calculate = $c / $number_of_rating, 2) }}
                                                                @else
                                                                    {{ 0 }}
                                                                @endif
                                                                <i class="fa fa-star" style="color: yellow;"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <div>Name: <a href="{{ urlencode('doctors-details|') . encrypt($Doc->user->id)}}"><span style="color: #0d8ddb;">{{ $Doc->user->first_name .' '. $Doc->user->last_name }}</span></a></div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-12 text-center"><i class="fa fa-frown" style="font-size: 30px;"></i><p>Sorry Not Available.</p></div>
                            @endif

                        </div>
                    @endisset
                </div>
            </div>
        </div>


    </div>

@stop





@section('Page_Level_Script')



@stop
