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
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / <a href="{{ route('blog') }}"  class="ban_Link">{{ $title }}</a> / Blog details view
            </h1>
        </div>



        <div class="wrapper wrapper-content m-t-60">
            <div class="container col-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">

                <div class="row">
                    <div class="col-12">
                        <div>
                            <h2>{{ $Blog->title }}</h2>
                        </div>
                        <div class="Single_blog_viewTop">
                            <img data-src="{{ $Blog->image }}" alt="Blog Image" width="100%">
                            <div class="float_date">
                                <h3>{{ date('M', strtotime($Blog->publish_date)) }}</h3>
                                {{ date('d - Y', strtotime($Blog->publish_date)) }}
                            </div>
                        </div>
                        <div class="View_Full_Blog_Description">
                            <div class="m-t-10 m-b-10" style="font-size: 12px; color: #aaaaaa;">
                                <span class="m-l-6 m-r-6"> <i class="fas fa-user"> </i> By: {{ $Blog->author }} </span> |
                                <span class="m-l-6 m-r-6">{{ count($Blog->view) }} <i class="fas fa-eye"></i> views</span>
                            </div>
                            <div style="text-align: justify; color: #666;">
                                {!! $Blog->description  !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>


                <div id="reply_comment">{{-- Link to the reply btn --}}</div>
                <!-- Comment Section -->
                <div class="container col-12 m-b-40"> <!-- Add comment section -->
                    <h4><u>Comment Section</u></h4>

                    @if (Auth::check() && Auth::user()->is_admin !== 1 && Auth::user()->email_verified_at !== null)
                        {{--@if($errors->any())
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        @endif--}}
                        <form action="{{ url('add-comment') }}" method="post" enctype="multipart/form-data" class="form col-12 comment_form">
                            @csrf
                            <input type="hidden" hidden name="user_id" id="user_id" value="{{ encrypt(Auth::user()->id) }}">
                            <input type="hidden" hidden name="blog_id" id="blog_id" value="{{ encrypt($Blog->id) }}">
                            <input type="hidden" hidden id="parent_comment_id" name="parent_comment_id" value="">
                            <div id="Hide" class="row">
                                <label style="line-height: 30px;color: dodgerblue;margin-right: 10px;">Comment to: </label>
                                <input type="text" disabled id="Comment_To_Name" name="name" class="form-control col-4" value="">
                                <button class="btn btn-danger btn-sm" id="Hide_btn" type="button"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="form-group">
                                <label for="Comment_details" class="control-label"></label>
                                <textarea name="Comment_details" id="Comment_details" cols="30" rows="4" placeholder="Write your comment..." style="resize: none" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Add Comment" name="Submit_Comment" class="CommentSubmitButton btn btn-primary col-12" id="Comment_btn">
                            </div>
                        </form>
                    @else
                        {!! '<p class="text-danger">You cannot see or reply to comment unless you are logged in to your account with verified email.</p>' !!}
                    @endif
                </div>
                <div id="Message" class="text-center" style="color: green; font-size: 16px;"></div>
                <!-- Comment view section -->
                <div id="display_comments" class="m-b-40" style="background-color: #eee; padding: 20px; box-shadow: inset 0 0 4px rgba(0,0,0,.2);border-radius: 10px;overflow-y: scroll; max-height: 500px;">
                    <!--// Display comment here ....-->
                </div>
            </div>
        </div>




    </div>

@stop





@section('Page_Level_Script')
    <script>
        $(document).ready(function () {
            $('#Hide').fadeOut();
            $(".comment_form").on('submit', function(e){
                e.preventDefault();
                if($('.CommentSubmitButton').attr('value') == 'Add Comment'){
                    let comment = $('#Comment_details').val();
                    if($.trim(comment).length < 1){
                        alert('Your comment is empty.');
                    }else{
                        let p_c_id = $('#parent_comment_id').val();
                        let u_id = $('#user_id').val();
                        let b_id = $('#blog_id').val();
                        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('add-comment') }}",
                            data: {
                                "Comment_details": comment,
                                "parent_comment_id": p_c_id,
                                "user_id": u_id,
                                "blog_id": b_id,
                            },
                            success:function (data) {
                                LoadComment();
                                $('#Message').html('Your comment is added.');
                                $('#Message').fadeOut(2000);
                                $('#Hide').fadeOut();
                                $('#Comment_details').val('');
                                $('#parent_comment_id').val('');
                            }
                        });
                        $('#Message').html('');
                        $('#Message').fadeIn(2000);
                    }
                }
                else if($('.CommentSubmitButton').attr('value') == 'Update Comment'){
                    let comment = $('#Comment_details').val();
                    if($.trim(comment).length < 1){
                        alert('Your comment is empty.');
                    }else{
                        let p_c_id = $('#parent_comment_id').val();
                        let u_id = $('#user_id').val();
                        let b_id = $('#blog_id').val();
                        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                        $.ajax({
                            type: 'POST',
                            url: "{{ url('update-comment') }}",
                            data: {
                                "Comment_details": comment,
                                "comment_id": p_c_id,
                                "user_id": u_id,
                                "blog_id": b_id,
                            },
                            success:function (data) {
                                LoadComment();
                                $('#Message').html('Your comment is updated.');
                                $('#Message').fadeOut(2000);
                                $('#Hide').fadeOut();
                                $('#Comment_details').val('');
                                $('#parent_comment_id').val('');
                                $('.CommentSubmitButton').attr('value', 'Add Comment');
                            }
                        });
                        $('#Message').html('');
                        $('#Message').fadeIn(2000);
                    }
                }
            });



            $('#Hide').fadeOut(); /// Hide comment to div ...

            // Click reply button to show reply to name div ...
            $(document).on('click', '.Reply', function () {
                let comment_id = $(this).attr("data-id");
                let Comment_To_Name = $(this).attr("data-name");

                $('#parent_comment_id').val(comment_id);
                $('#Comment_To_Name').val(Comment_To_Name);
                $('#Hide').fadeIn();
                $('#Comment_details').val('');
                $('#Comment_details').focus();
            });

            // click on hide button to hide comment to.. div..
            $('#Hide_btn').click(function () {
                $('#Comment_details').val('');
                $('#parent_comment_id').val('');
                $('#Comment_To_Name').val('');
                $('#Hide').fadeOut();
            });


            LoadComment();
            // Autoload comments div ... by ajax method
            function LoadComment(){
                setInterval(function(){
                    let blog_id = "{{ $Blog->id }}";
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ route('load-comment') }}",
                        data: {"bid": blog_id}
                    }).done(function(result){
                        if (result.error == false){
                            $("#display_comments").html(result);
                        }else{
                            $("#display_comments").html(result);
                        }
                    });
                }, 2000);
            }




            $(document).on('click', '.Edit_Comment_Btn', function (e) {
                e.preventDefault();
                $("html, body").animate({
                    scrollTop: $('#reply_comment').offset().top - 150
                }, 400);
                /*let u_id = $('#user_id').val();
                let b_id = $('#blog_id').val();*/
                let comment_id = $(this).attr("data-id");
                $('#parent_comment_id').val(comment_id);
                $('.CommentSubmitButton').attr('value', 'Update Comment');
                $('#Comment_details').val('');


                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
                $.ajax({
                    type: 'GET',
                    url: "{{ url('edit-comment|') }}" + comment_id,
                    data: {
                        "comment_id": comment_id,
                    },
                    success:function (data) {
                        $('#Comment_details').val(data.Comment);
                        $('#Comment_details').focus();
                    }
                });
            });




            $(document).on('click', '.Reply', function (e) {
                $("html, body").animate({
                    scrollTop: $('#reply_comment').offset().top - 150
                }, 400);
                e.preventDefault();
            });

        });
    </script>

@stop
