@extends('layouts.app_front')

@section('title')
    @php $title = 'Blog'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')


    <div id="MainContent">
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="storage/image/web_layout/banner/blog-banner.jpg" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }}
            </h1>
        </div>


        <div class="wrapper wrapper-content">
            <div class="container col-12 col-md-12 col-lg-10 m-t-80 m-b-80">
                <h1 class="m-b-20" id="Blog_header">Latest Blog Post</h1>
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <hr style="background: #eee;">
                        <!-- Show Content after search -->
                        <div class="col-12 col-md-12 col-lg-12" id="Search_Result_div">  </div>

                        <!-- Actual content -->
                        <div class="col-12 col-md-12 col-lg-12" id="Blog_div">

                        @if(count($Blog) > 0)
                            @foreach ($Blog as $B)
                            <!-- Loop this section -->
                            <div class="col-12 top blog_bg wow fadeInUp">
                                <div class="blog_view_top">
                                    <h2>{{ $B->title }}</h2>
                                </div>
                                <div class="Blog_View_Content">
                                    <img data-src="{{ $B->image }}" alt="">
                                    <div class="Blog_Description p-t-10">
                                        <!-- Truncate blog description -->
                                        @php
                                        $string = strip_tags($B->description);
                                        if (strlen($string) > 20) {
                                            // truncate string
                                            $stringCut = substr($string, 0, 360);
                                            $endPoint = strrpos($stringCut, ' ');
                                            //if the string doesn't contain any space then it will cut without word basis.
                                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                            $string .= '... ';
                                        }
                                        echo $string;
                                        @endphp
                                    </div>
                                    <a class="btn btn-dark m-t-10" href="{{ urlencode('view-blog|'.encrypt($B->id)) }}">READ MORE</a>
                                </div>
                                <div class="Blog_Footer">
                                    <hr>
                                    <span class="">
                                        <i class="fas fa-user"></i><span class="m-l-6 m-r-6"> Author: {{ $B->author }} </span> |
                                        <i class="fas fa-calendar-alt m-l-6 m-r-6"></i> {{date('M-d-y',strtotime($B->publish_date))}}
                                    </span>
                                    <hr>
                                    <span class="">
                                        <span class="m-r-6"> {{ count($B->comment) }} <i class="fa fa-comments"></i> Comments </span> |
                                        <span class="m-l-6"> {{ count($B->view) }} <i class="fa fa-eye"></i> Views </span>
                                    </span>
                                    <hr>
                                </div>
                            </div>
                            <br>
                            @endforeach
                            @else
                                <div class="col-lg-12">
                                    <h2 class="text-center">
                                        <i class="far fa-frown-open" style="font-size: 20px;"></i>
                                        {{ '"No Blog available...."' }}
                                    </h2>
                                </div>
                            @endif
                            <div class="Pagination">
                                <br>
                                <div class="text-center row" style="position: relative;">
                                    <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $Blog->links() }}</div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 col-md-4 col-lg-4">

                        <!-- Blog search section -->
                        <div class="row bg-dark color-white">
                            <div class="col-12">
                                <form action="#" method="post" class="Search_Form" id="Blog_Search_Form">
                                    <div class="form-group">
                                        <label for="Search_Text" class="col-form-label" style="font-size: 24px; color: white;">Search blog here ...</label>
                                        <br>
                                        <input name="Search_Text" id="Search_Text" class="form-control col-12" placeholder="Search..." type="text" minlength="2" required value="">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 wow fadeInDown m-t-20">
                                <h2 class="text-center m-b-20"><u> Top Blog </u></h2>
                                <div class="TopBlog">

                                    @foreach ($TopBlog as $rows)
                                    <div class="TopBlog_Single">
                                        <a href="{{ urlencode('view-blog|'.encrypt($rows->id)) }}" style="color: #999; height: 60px;">
                                            <span class=""><img data-src="{{ $rows->image }}" alt="" height="60" width="100"></span>
                                            <div style="padding-left: 6px;">
                                                <div style="width: 100%; line-height: 16px;" class="">{{ $rows->title }}</div>
                                                <div class="view_top_Blog">{{ count($rows->view) }} <i class="fa fa-eye"></i> Views </div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop





@section('Page_Level_Script')

    <script>
        $(document).ready(function () {
            $('#Blog_div').fadeIn(100);
            $('#Search_Result_div').fadeOut();
            $('.Search_Form input').attr('id', 'Search_Text').keyup(function () {

                let Blog_title = $('#Search_Text').val();
                if(Blog_title.length <= 1){
                    $('#Blog_div').fadeIn(100);
                    $('#Search_Result_div').fadeOut(100);
                    $('.Pagination').fadeIn(100);

                    $('#Blog_header').fadeIn(function () {
                        $(this).html('Latest Blog Post');
                    });
                }
                else if(Blog_title.length >= 1){
                    $('#Blog_div').fadeOut(100);
                    $('#Search_Result_div').fadeIn(100);
                    $('.Pagination').fadeOut(100);

                    $('#Blog_header').fadeIn(function () {
                        $(this).html('Searching blog .....');
                    });
                    //alert(Blog_title);
                    // Ajax part ...
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ route('blog-search') }}",
                        data: { "blog_title" :  Blog_title }
                    }).done(function(result){
                        if (result.error == false){
                            // No errors
                            //console.log(result);
                            $('#Search_Result_div').html(result);
                        }else{
                            // There is an error
                            //console.log(result);
                            $('#Search_Result_div').html(result);
                        }
                    });
                }
            });


            $("#Blog_Search_Form").on('submit',function(e) {
                e.preventDefault();
            });

        });
    </script>


@stop
