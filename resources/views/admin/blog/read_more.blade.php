@extends('layouts.app_back')

@php
    $string = strip_tags($Blog->title);
    if (strlen($string) > 2) {
        // truncate string
        $stringCut = substr($string, 0, 40);
        $endPoint = strrpos($stringCut, ' ');
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '... ';
    }
@endphp

@section('title')
    @php $title = 'Blog'; @endphp
    @php $subTitle = $string; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content  animated fadeInRight article">
        <div class="row justify-content-md-center">
            <div class="col-lg-10">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="text-center">
                            <h1 style="font-size: 30px;"><u> {{ $Blog->title }} </u></h1>
                        </div>
                        <div class="text-center">
                            <img src="{{ $Blog->image }}" alt="image nai" width="50%" class="bor-rad-10">
                            <div class="" style="margin: 20px;">
                                <span class="text-muted"><i class="fa fa-user-tie"></i> Author: {{ $Blog->author }}</span> |
                                <span class="text-muted"><i class="fa fa-clock-o"></i> {{ $Blog->publish_date }}</span>
                            </div>
                            <span class="">
                                <span class="m-r-6"> {{ count($Blog->comment) }} <i class="fa fa-comments"></i> Comments </span> |
                                <span class="m-l-6"> {{ count($Blog->view) }} <i class="fa fa-eye"></i> Views </span>
                            </span>
                        </div>


                        <p style="text-align: justify;">
                            {!! $Blog->description !!}
                        </p>
                        <hr>



                        <div id="reply_comment">{{-- Link to the reply btn --}}</div>
                        <!-- Comment Section -->
                        <div class="container col-12 m-b-40"> <!-- Add comment section -->
                            <h4><u>Comment Section</u></h4>
                            @if (Auth::check() && Auth::user()->is_admin === 1 && Auth::user()->email_verified_at !== null)
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
                                {!! '<p class="text-danger">You cannot reply to comment unless you are logged in to your account.</p>' !!}
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
        </div>
    </div>

@stop



@section('Page_Level_script')

    <script>
        $(document).ready(function () {
            $('#Hide').fadeOut();
            $(".comment_form").on('submit', function(e){
                e.preventDefault();
                if($('.CommentSubmitButton').attr('value') === 'Add Comment'){
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
                else if($('.CommentSubmitButton').attr('value') === 'Update Comment'){
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
                $('#parent_comment_id').val('');
                $('#Comment_details').val('');
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
                        if (result.error === false){
                            $("#display_comments").html(result);
                        }else{
                            $("#display_comments").html(result);
                        }
                    });
                }, 2000);
            }

            $(document).on('click', '.Delete_Comment_Btn', function (e) {
                e.preventDefault();
                $('#Message').html('');
                $('#Message').fadeIn(2000);
                let Conf = confirm('Are you sure you want to delete the comment.');
                if(Conf === true){
                    let comment_id =$(this).attr("data-id");
                    $.ajax({
                        method: 'GET',
                        url: "{{ url('/delete-comment|') }}" + comment_id,
                        //data: {"comment_id": comment_id},
                        success: function () {
                            //alert('Comment successfully deleted.');
                            $('#Message').html('Comment successfully deleted.');
                            $('#Message').fadeOut(2000);
                            $('#Hide').fadeOut();
                        },
                        error: function (result) {
                            alert(result);
                        }
                    });
                }
            });


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
                        $('#Comment_To_Name').val('');
                        $('#Hide').fadeOut();
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
