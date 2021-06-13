@extends('layouts.app_front')

@section('title')
    @php $title = 'Departments'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')


    <div id="MainContent">
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="{{ config('app.image_url', null) }}/storage/image/web_layout/banner/department.jpg" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }}
            </h1>
        </div>


        <!-- Departments -->
        <div class="our-departments">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="departments-wrap">
                            <h2 class="text-white">Departments</h2>
                            <hr class="bg-white">

                            <div class="row">
                                @if(count($Departments)>0)
                                    @foreach ($Departments as $Department)
                                        <div class="col-12 col-md-6 col-lg-4 hover_Effect_department wow fadeInDown" style="border-radius: 6px;">
                                            <div class="our-departments-cont">
                                                <header class="entry-header d-flex flex-wrap align-items-center">
                                                    <img data-src="{{ config('app.image_url', null) }}{{ '/storage/image/web_layout/icon/'.$Department->icon }}" alt="" height="30px">
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
                                                    <a href="{{ urlencode('department-details|').encrypt($Department->id) }}" class="float-right">read more</a>
                                                </footer>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h5 class="col-12 text-center text-white"><i class="fa fa-frown m-r-6"></i> "No departments is available."</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Departments -->


    </div>

@stop





@section('Page_Level_Script')



@stop
