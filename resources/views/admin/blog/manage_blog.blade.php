@extends('layouts.app_back')

@section('title')
    @php $title = 'Blog'; @endphp
    @php $subTitle = ''; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <br>
    <!-- Add blog form -->
    <div class="row white-bg">
        <div class="col-lg-12">
            <div class="ibox @if(!session()->has('Error_create')) border-bottom @endif">
                <div class="ibox-title">
                    <h5>Add new blog post</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content" style="@if(!session()->has('Error_create'))display: none;@endif">


                <form id="form" action="{{ route('admin.add-blog') }}" class="wizard-big" method="post" enctype="multipart/form-data">
                    <h1>Blog Details</h1>

                    <div class="row">
                        @csrf
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="StaffName"> Blog Title: * </label>
                                <input id="StaffName" name="title" type="text" class="form-control required @error('title') is-invalid @enderror" required minlength="5" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="Blog_Description"> Blog description: * </label>
                                <textarea name="description" id="Blog_Description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror text-areas required" required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Author_Name"> Author name: * </label>
                                <input id="Author_Name" name="author" type="text" class="form-control required @error('author') is-invalid @enderror" required minlength="3" value="{{ old('author') }}">
                            </div>

                            <div class="form-group" id="data_3">
                                <label  for="datepicker" class="font-normal"> Publish date: * </label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input id="datepicker" name="publish_date" type="text" class="form-control @error('publish_date') is-invalid @enderror required" value="{{ old('publish_date', date('m/d/Y')) }}" readonly required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label  for="date_picker" class="font-normal"> Blog image: * </label>
                                <div class="custom-file">
                                    <input id="Blog_Image" name="image" type="file" class="form-control @error('image') is-invalid @enderror custom-file-input required report" required onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])" value="">
                                    <label for="Blog_Image" class="custom-file-label">Choose file...</label>
                                </div>
                            </div>

                            <div>
                                <img src="" alt="" height="160" id="image_preview">
                            </div>

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"> Add blog </button>
                </form>
            </div>
        </div>
    </div>
    </div>



    <!-- All blog post -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row white-bg">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>All blog posts ...</h5>
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

                        <!-- block view of data -->
                        <div  id="Block_View"><!-- Toggle block view -->

                            <div class="wrapper wrapper-content">
                                <div class="col-lg-12 blog_search_field">
                                    <form action="#" method="post" class="Search_Form" id="Blog_Search_Form">
                                        <div class="form">
                                            <div class="row">
                                                <label for="Search_Text"></label>
                                                <input type="text" id="Search_Text" placeholder="search here....." required class="form-control col-lg-8">
                                                <button type="submit" name="Blog_Search" class="btn btn-primary col-lg-4" id="Search_btn">
                                                    <i class="fa fa-search"> </i>
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="row" id="Blog_div">
                                @if(count($Blog) > 0)
                                @foreach ($Blog as $B)
                                <div class="col-lg-6 hideOnSearch">
                                    <div class="Blog bg-muted bor-rad-10" style="padding: 10px; margin: 10px 0;">
                                        <img src="{{ $B->image }}" alt="blog image">
                                        <div class="Details truncate fh-200">
                                            <h3 class="text-left">{{ $B->title }}</h3>
                                            <p>By <a href="#">{{ $B->author }}</a> | {{ date('M-d-Y H:i', strtotime($B->publish_date)) }}</p>
                                            <p>
                                                <!-- Truncate blog description -->
                                                @php
                                                $string = strip_tags($B->description);
                                                if (strlen($string) > 20) {
                                                    // truncate string
                                                    $stringCut = substr($string, 0, 480);
                                                    $endPoint = strrpos($stringCut, ' ');
                                                    //if the string doesn't contain any space then it will cut without word basis.
                                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                    $string .= '... ';
                                                }
                                                echo $string;
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="panel-footer">
                                            <span> <a href="{{ urlencode('blog-read-more|'.encrypt($B->id)) }}" class="btn btn-primary btn-xs"><i class="fa fa-book-reader"></i> Read more</a></span>
                                            <span style="margin-top: 2px!important; float: right; margin-bottom: 16px!important; display: block;">
                                                <a href="#edit-form-modal" data-toggle="modal" data-id="{{encrypt($B->id)}}" class="btn btn-warning btn-xs Btn_Edit_Blog"><i class="fa fa-edit"></i> Edit</a> |
                                                <a href="{{ urlencode('soft-delete-blog|'.encrypt($B->id)) }}" onclick="return confirm('Are you sure you want to delete this block.')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                                            </span>
                                        </div>

                                        <div class="Comment_view_Show">
                                            <span> {{ count($B->comment) }} <i class="fa fa-comments"></i> Comments </span>
                                            <span> {{ count($B->view) }} <i class="fa fa-eye"></i> Views </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                    <div class="col-lg-12">
                                        <h2 class="text-center">
                                            <i class="far fa-frown-open" style="font-size: 20px;"></i>
                                            {{ '"No Blog available...."' }}
                                        </h2>
                                    </div>
                                @endif
                            </div>


                            <div class="Pagination">
                                <br>
                                <br>
                                <div class="text-center row" style="position: relative;">
                                    <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $Blog->links() }}</div>
                                </div>
                            </div>

                            <!-- Search Result Div -->
                            <div id="Search_Result_div">
                                <div class="row" id="Blog_div2">

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





    {{-- Edit Blog Popup --}}
    <div id="edit-form-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit blog.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 b-r">

                            <form id="edit_blog_form" action="{{ route('admin.update-blog') }}" class="wizard-big" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" hidden value="{{ old('id') }}" name="id">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="StaffName"> Blog Title: * </label>
                                            <input id="StaffName" name="title" type="text" class="form-control @error('title') is-invalid @enderror required" required minlength="5" value="{{ old('title') }}">
                                        </div>

                                        <div class="form-group" id="data_3">
                                            <label  for="datepicker2" class="font-normal"> Publish date: * </label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input id="datepicker2" name="publish_date" type="text" class="form-control @error('publish_date') is-invalid @enderror required" value="{{ old('publish_date', date('m/d/Y')) }}" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Author_Name"> Author name: * </label>
                                            <input id="Author_Name" name="author" type="text" class="form-control @error('author') is-invalid @enderror required" required minlength="3" value="{{ old('author') }}">
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label  for="date_picker" class="font-normal"> Blog image: * </label>
                                                    <div class="custom-file">
                                                        <input id="Blog_Image" name="image" type="file" class="form-control @error('image') is-invalid @enderror custom-file-input required report" onchange="document.getElementById('image_preview2').src = window.URL.createObjectURL(this.files[0])" value="">
                                                        <label for="Blog_Image" class="custom-file-label">Choose file...</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-8 text-center">
                                                <img src="{{ old('image') }}" alt="hello" id="image_preview2" style="padding: 4px; width: 80%; border-radius: 10px;">
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="edit_description"> Blog description: * </label>
                                            <textarea name="edit_description" id="edit_description" cols="30" rows="10" class="form-control @error('edit_description') is-invalid @enderror text-areas required" required>{{ old('edit_description') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary"> Update blog </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit blog Popup End --}}






    {{-- Show Deleted content --}}
    @if(count($Soft_Deleted_Blog) > 0 )
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row white-bg">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{'Deleted Blog'}}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content" style="display: none">
                            <div class="animated fadeInRight">
                                <div class="row">
                                    @foreach ($Soft_Deleted_Blog as $SDB)
                                        <div class="col-lg-6 hideOnSearch">
                                            <div class="Blog bg-muted bor-rad-10" style="padding: 10px; margin: 10px 0;">
                                                <img src="{{ $SDB->image }}" alt="blog image">
                                                <div class="Details  truncate fh-200" style="height: 220px;">
                                                    <h3 class="text-left">{{ $SDB->title }}</h3>
                                                    <p>By <a href="#">{{ $SDB->author }}</a> | {{ date('M-d-Y H:i', strtotime($SDB->publish_date)) }}</p>
                                                    <p>
                                                        <!-- Truncate blog description -->
                                                        @php
                                                            $string = strip_tags($SDB->description);
                                                            if (strlen($string) > 20) {
                                                                // truncate string
                                                                $stringCut = substr($string, 0, 480);
                                                                $endPoint = strrpos($stringCut, ' ');
                                                                //if the string doesn't contain any space then it will cut without word basis.
                                                                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                $string .= '... ';
                                                            }
                                                            echo $string;
                                                        @endphp
                                                    </p>
                                                </div>
                                                <div class="panel-footer" style="height: 40px;">
                                                    {{--<span> <a href="{{ urlencode('blog-read-more|'.encrypt($SDB->id)) }}" class="btn btn-primary btn-xs">Read more</a></span>--}}
                                                    <span style="margin-top: 2px!important; float: right; margin-bottom: 16px!important; display: block;">
                                                        <a href="{{ urlencode('restore-blog|'.encrypt($SDB->id)) }}" class="btn btn-success btn-xs"><i class="fa fa-trash-restore"></i> Restore </a> |
                                                        <a href="{{ urlencode('destroy-blog|'.encrypt($SDB->id)) }}" onclick="return confirm('Are you sure you want to delete this block.')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Destroy </a>
                                                    </span>
                                                </div>

                                                {{--<div class="Comment_view_Show">
                                                    <span> {{ count($SDB->comment) }} <i class="fa fa-comments"></i> Comments </span>
                                                    <span> {{ count($SDB->view) }} <i class="fa fa-eye"></i> Views </span>
                                                </div>--}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="Pagination">
                                    <br>
                                    <br>
                                    <div class="text-center row" style="position: relative;">
                                        <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $Soft_Deleted_Blog->links() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('Page_Level_script')

    <script>
        $(document).ready(function () {
            $('#Blog_div').fadeIn(200);
            $('.Search_Form input').attr('id', 'Search_Text').keyup(function () {

                let Blog_title = $('#Search_Text').val();
                if(Blog_title.length <= 1){
                    $('#Blog_div').fadeIn(200);
                    $('#Search_Result_div').fadeOut(200);
                    $("#Search_btn").html('<i class="fa fa-search"></i> Search');
                    $('.Pagination').fadeIn(200);
                }
                else if(Blog_title.length >= 1){
                    $('#Blog_div').fadeOut(200);
                    $('#Search_Result_div').fadeIn(200);
                    $("#Search_btn").html('<i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i> Searching...');
                    $('.Pagination').fadeOut(200);
                    //alert(Blog_title);
                    // Ajax part ...
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ route('admin.blog-search') }}",
                        data: { "blog_title" :  Blog_title },
                        success:function (data) {
                            $('#Search_Result_div #Blog_div2').html(data);
                        },
                        error:function (jqXHR, textStatus, errorThrown) {
                            console.log("Ajax error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                }
            });

            $("#Blog_Search_Form").on('submit',function(e) {
                e.preventDefault();
            });

        });
    </script>

    <script src="{{ asset('asset_back/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('Blog_Description');
    </script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function (){
            ///* Truncate text *///
            /*$(".truncate").dotdotdot({
                watch: 'window'
            });
            */
            /*
            $(".truncate1").dotdotdot({
                watch: 'window',
                ellipsis: ' ///...'
            });
            */
            $(".truncate").dotdotdot({
                watch: 'window',
                wrap: 'letter'
            });
        });
    </script>

    {{-- Date picker --}}
    <script>
        let today = new Date();
        let Y = today.getFullYear();
        let M = today.getMonth();
        let D = today.getDate();

        let minyear;
        let maxyear;

        let maxmonth;
        let minmonth;

        let minday = D + 1;
        let maxday = D + (31 - D);

        minyear = Y;
        maxyear = Y + 1;

        maxmonth = M + (12-M);
        minmonth = M;

        $("#datepicker").datepicker({
            dateFormat: "y/m/d",
            changeYear: true,
            changeMonth: true,
            showOtherMonths: true,
            minDate: new Date( minyear,minmonth,minday),
            maxDate: new Date( maxyear,maxmonth,maxday)
        });

        $("#datepicker2").datepicker({
            dateFormat: "y/m/d",
            changeYear: true,
            changeMonth: true,
            showOtherMonths: true,
            minDate: new Date( minyear,minmonth,minday),
            maxDate: new Date( maxyear,maxmonth,maxday)
        });
    </script>





    {{-- Edit blog script--}}
    <script type= "text/javascript" >
        function createEditor() {
            let hEd = CKEDITOR.instances['edit_description'];
            if(hEd){
                CKEDITOR.instances['edit_description'].destroy();
            }
            hEd = CKEDITOR.replace('edit_description');
        }
        function destroyEditor(){
            let hEd = CKEDITOR.instances['edit_description'];
            if(hEd){
                //CKEDITOR.instances['txt1'] = false;
                //CKEDITOR.remove(hEd);
                CKEDITOR.instances['edit_description'].destroy();
            }
        }

        $(document).ready(function(){
            $('.Btn_Edit_Blog').click(function(e){
                e.preventDefault();
                let ID = $(this).data('id');

                destroyEditor();

                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
                $.ajax({
                    type:'GET',
                    url: "{{ route('admin.blog-edit') }}",
                    data: { "blog_id" :  ID },
                    success:function(data) {
                        //console.log(data);
                        let Id = data.Id;
                        let Title = data.Title;
                        let Author = data.Author;
                        let Date = data.Publish_Date;
                        let Image = data.Image;
                        let Description = data.Description;

                        $('#edit_blog_form input[name="id"]').val(Id);
                        $('#edit_blog_form input[name="title"]').val(Title);
                        $('#image_preview2').attr('src', Image);
                        $('#edit_blog_form input[name="publish_date"]').val(Date);
                        $('#edit_blog_form input[name="author"]').val(Author);
                        $('#edit_blog_form textarea[name="edit_description"]').val(Description);

                        createEditor();
                    }
                });
            });
        });


        {{-- Confirmation for delete after search --}}
        function deleteConfirmation() {
            //let Ask = confirm("Are you sure you want to delete the blog?");
            return confirm("Are you sure you want to delete the blog?");
        }

        function fazil(id) {
            //let ID = $('.Btn_Edit_Blog').data('id');
            let ID = id;
            //alert(ID);

            destroyEditor();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                url: "{{ route('admin.blog-edit') }}",
                data: { "blog_id" :  ID },
                success:function(data) {

                    //console.log(data);
                    let Id = data.Id;
                    let Title = data.Title;
                    let Author = data.Author;
                    let Date = data.Publish_Date;
                    let Image = data.Image;
                    let Description = data.Description;

                    $('#edit_blog_form input[name="id"]').val(Id);
                    $('#edit_blog_form input[name="title"]').val(Title);
                    $('#image_preview2').attr('src', Image);
                    $('#edit_blog_form input[name="publish_date"]').val(Date);
                    $('#edit_blog_form input[name="author"]').val(Author);
                    $('#edit_blog_form textarea[name="edit_description"]').val(Description);

                    createEditor();
                    $('#edit-form-modal').modal('toggle');
                }
            });
        }
    </script>


    @if(session('Error_update')) // edit for old data show problem ...
    <script>
        $(document).ready(function () {
            $('#edit-form-modal').modal('toggle');
            createEditor(); // Create CK editor ....
        });
    </script>
    @endif

@stop
