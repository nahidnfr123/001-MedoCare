@extends('layouts.app_back')

@section('title')
    @php $title = 'Dashboard'; @endphp
    @php $subTitle = ''; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content">
        <!-- Section 1 -->
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-success float-right"> </span>
                        <h5>Total Doctors</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $countVerified_Doctors }}</h1>
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        <small>Total doctors online.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-info float-right"> </span>
                        <h5>Total patients</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $countPatient }}</h1>
                        <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                        <small>Total donors online.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-primary float-right"> </span>
                        <h5>Appointments</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">100</h1>
                        <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                        <small>Total appointments this week.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-danger float-right"> </span>
                        <h5>Consultation</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">40</h1>
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                        <small>Total consultation this week.</small>
                    </div>
                </div>
            </div>
        </div>


        <!-- Section 2 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">

                    <div class="ibox-content">
                        <div class="row">
                            <a href="" class="col-lg-3 link_red">
                                <div class="widget red-bg p-lg text-center color_change_red">
                                    <div class="m-b-md">
                                        <i class="fa fa-envelope-o fa-4x"></i>
                                        <h1 class="m-xs">0</h1>
                                        <h3 class="font-bold no-margins">
                                            New blood request
                                        </h3>
                                        <small>Total 0 request.</small>
                                    </div>
                                </div>
                            </a>

                            <div class="col-lg-9">
                                <div class="flex_box_S2">
                                    <div class="box align-middle">
                                        <div class=""><a href=""><span class="btn btn-default m-r-sm btn_50">0</span><span>Notifications</span></a></div>
                                        <div class=""><a href="{{ route('admin.inbox') }}"><span class="btn btn-primary m-r-sm btn_50">{{ $Count_Msg }}</span><span>Message</span></a></div>
                                        <div class=""><a href=""><span class="btn btn-info m-r-sm btn_50">0</span><span>Comments</span></a></div>
                                    </div>
                                    <div class="box">
                                        <div class=""><a href=""><span class="btn btn-warning m-r-sm btn_50">0</span><span>Mail</span></a></div>
                                        <div class=""><a href="{{ route('admin.manage-doctor') }}"><span class="btn btn-danger m-r-sm btn_50">{{ $countNot_verified_Doctors }}</span><span>Join request</span></a></div>
                                        <div class=""><a href=""><span class="btn btn-success m-r-sm btn_50">0</span><span>Likes</span></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="row">
            <!-- Message Section -->
            @if(count($Dashboard_Msg) > 0)
                <div class="col-lg-4">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Messages</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content ibox-heading">
                            <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                            <small><i class="fa fa-tim"></i> You have {{ $Count_Msg }} new messages.</small>
                        </div>
                        <div class="ibox-content">
                            <div class="feed-activity-list">

                                @foreach($Dashboard_Msg as $Ms)
                                    <div @if($Ms->seen === 1) style="background-color: #d0d0d0;transition: all 200ms; padding: 4px;" @endif >
                                        <a href="{{ url('admin/message-details|' . encrypt($Ms->id)) }}" style="font-size: 12px;">
                                            <div class="feed-element" >
                                                <div>
                                                    <small class="float-right text-navy">{{-- eg: 10 min ago--}}
                                                        @php
                                                            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i'));
                                                            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:s:i', strtotime($Ms->created_at)));
                                                            $diff_in_hours = $to->diffInHours($from);
                                                        @endphp
                                                        @if($diff_in_hours === 0)
                                                            {{ 'Less then an hr ago' }}
                                                        @else
                                                            {{ $diff_in_hours . 'hr ago' }}
                                                        @endif
                                                    </small>
                                                    <strong>{{ ucwords($Ms->name) }}</strong>
                                                    <div>
                                                        @php
                                                            $string = strip_tags($Ms->message);
                                                            if (strlen($string) > 20) {
                                                                // truncate string
                                                                $stringCut = substr($string, 0, 100);
                                                                $endPoint = strrpos($stringCut, ' ');
                                                                //if the string doesn't contain any space then it will cut without word basis.
                                                                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                $string .= '... ';
                                                            }
                                                            echo $string;
                                                        @endphp
                                                    </div>
                                                    <small class="text-muted">{{ date('d.M.Y H:i:s a', strtotime($Ms->created_at)) }}</small>
                                                    <small class="text-muted float-right"> @if($Ms->seen === 1) {{ 'seen' }} @endif</small>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                            <a href="{{ route('admin.inbox') }}" class="dropdown-item text-center col-12">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-8">
                <!-- Section 3 Right -->
                <div class="row">

                    <!--  -->
                    <div class="col-lg-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Top Doctors list</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content table-responsive divScroll">
                                <table class="table table-hover no-margins ">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th style="width: 60px;">Ratting</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Verified_Doctors->take(10) as $Doctors)
                                        <tr>
                                            <td><a href="">Dr. {{ $Doctors->first_name }}</a></td>
                                            <td>{{ $Doctors->department_name }}</td>
                                            <td class="text-navy"> <i class="fa fa-star"></i>

                                                @php
                                                    $Ratings = App\DoctorRating::where('doctor_id', '=', $Doctors->doc_id)->get();
                                                    $number_of_rating = count($Ratings);
                                                    $c = 0;
                                                    if (count($Ratings) > 0) {
                                                        foreach ($Ratings as $Ratting) {
                                                            $c += $Ratting->rating_value;
                                                        }
                                                        $rating = round($calculate = $c / $number_of_rating, 2);
                                                    } else {
                                                        $rating = 0;
                                                    }
                                                @endphp
                                                {{ $rating }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!--  -->
                    <div class="col-lg-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Top Donor list</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content table-responsive divScroll">
                                <table class="table table-hover no-margins ">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th style="width: 60px;">Ratting</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="">Dummy</a></td>
                                        <td>Dhaka</td>
                                        <td class="text-navy"> <i class="fa fa-star"></i> 0 </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Blog -->
                @if(count($Blog)>0)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Blog section</h5>
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

                                    <div class="row">
                                        <!-- Loop this div col-lg-6-->
                                        @foreach($Blog as $B)
                                            <div class="col-lg-6">
                                                <div class="Blog">
                                                    <img src="{{ $B->image }}" alt="">
                                                    <div class="Details  truncate fh-200">
                                                        <h3>{{ $B->title }}</h3>
                                                        <p>
                                                            @php
                                                                $string = strip_tags($B->description);
                                                                if (strlen($string) > 20) {
                                                                    // truncate string
                                                                    $stringCut = substr($string, 0, 400);
                                                                    $endPoint = strrpos($stringCut, ' ');
                                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                    $string .= '... ';
                                                                }
                                                                echo $string;
                                                            @endphp
                                                        </p>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <span> <a href="{{ urlencode('blog-read-more|'.encrypt($B->id)) }}"class="btn btn-primary btn-xs"><i class="fa fa-book-reader"></i> Read more</a> </span><br>
                                                            <span>{{ date('M-d-Y', strtotime($B->publish_date)) }}</span>
                                                        </div>
                                                        <div class="col-4">
                                                            <span style="float: right; cursor:default;"> {{ count($B->view) }} views</span><br>
                                                            <span style="float: right; cursor:default;"> {{ count($B->comment) }} Comments </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-12 viewMoreBtn" style="text-align: center; margin-top: 20px;"> <a href="{{ route('admin.view-blog') }}"> View more </a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop

@section('Page_Level_script')
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function (){

            $(".truncate").dotdotdot({
                watch: 'window'
            });

            $(".truncate1").dotdotdot({
                watch: 'window',
                ellipsis: ' ///...'
            });

            $(".truncate2").dotdotdot({
                watch: 'window',
                wrap: 'letter'
            });

        });

    </script>

    <script>
        /*
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 2000
                };
                toastr.success('Welcome to MedoCare');

            }, 1000);


            var data1 = [
                [0, 4],
                [1, 8],
                [2, 5],
                [3, 10],
                [4, 4],
                [5, 16],
                [6, 5],
                [7, 11],
                [8, 6],
                [9, 11],
                [10, 30],
                [11, 10],
                [12, 13],
                [13, 4],
                [14, 3],
                [15, 3],
                [16, 6]
            ];
            var data2 = [
                [0, 1],
                [1, 0],
                [2, 2],
                [3, 0],
                [4, 1],
                [5, 3],
                [6, 1],
                [7, 5],
                [8, 2],
                [9, 3],
                [10, 2],
                [11, 1],
                [12, 0],
                [13, 2],
                [14, 8],
                [15, 0],
                [16, 0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ], {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis: {},
                yaxis: {
                    ticks: 4
                },
                tooltip: false
            });

            var doughnutData = {
                labels: ["App", "Software", "Laptop"],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: ["#a3e1d4", "#dedede", "#9CC3DA"]
                }]
            };


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {
                type: 'doughnut',
                data: doughnutData,
                options: doughnutOptions
            });

            var doughnutData = {
                labels: ["App", "Software", "Laptop"],
                datasets: [{
                    data: [70, 27, 85],
                    backgroundColor: ["#a3e1d4", "#dedede", "#9CC3DA"]
                }]
            };


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
            new Chart(ctx4, {
                type: 'doughnut',
                data: doughnutData,
                options: doughnutOptions
            });

        });
         */
    </script>
@stop
