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
            <img data-src="{{ config('app.image_url', null) }}/storage/image/web_layout/banner/doc.png" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }} </h1>
        </div>


        <div class="wrapper wrapper-content m-b-40 m-t-40">

            <div class="content container" style="background-color: #eeeeee">
                <div class="row">
                    <div class="col-12">
                        <h2>Search Doctor</h2>
                        <!-- Search FORM -->
                        <form action="#" method="post" class="form" id="Doctor_Search_Form">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 m-b-10">
                                    <label for="SelectDepartment" class="control-label">Department:</label>
                                    <select name="Department" id="SelectDepartment" class="form-control">
                                        <option value="0">All departments</option>
                                        @foreach ($Departments as $Department)
                                        <option value="{{ $Department->id }}">  {{ $Department->department_name }}  </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 m-b-10">
                                    <label for="">Name: </label>
                                    <div class=" form-group input-group">
                                        <input type="text" class="form-control" id="SearchDocName" placeholder="Doctor name .... ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"> <i class="fa fa-search"></i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <style>
                .Loader{
                    display: block;
                    text-align: center;
                    width: 100%;
                    height: 100px;
                    background-position: 50% 50%;
                    background-repeat: no-repeat;
                    background-color: white;
                }
                body .Loader{
                    overflow: hidden;
                }
            </style>

            <!-- Show doctor div -->
            <div class="content container m-t-30" style="min-height: 400px;">
                <h2 class="text-center">Meet our doctors</h2>
                <hr>
                <div class="Loader">
                    <img data-src="storage/image/web_layout/loader.gif" alt="" width="100" height="100">
                </div>
                <div class="row" id="DoctorList">
                    <!-- Loop -->
                    <!-- Ajax load data -->
                    <!-- Loop -->
                </div>
            </div>
        </div>




    </div>
@stop



@section('Page_Level_Script')

    <script>
        $(document).ready(function () {

            function hide_loader(){
                $('.Loader').slideUp();
                $('#DoctorList').fadeIn(1000);
            }
            function show_loader(){
                $('.Loader').slideDown();
                $('#DoctorList').fadeOut();
            }
            show_loader();

            $("#Doctor_Search_Form").on('submit',function(e) {
                e.preventDefault();
            });

            $('.Loader').fadeIn();

            let department = $('#SelectDepartment');
            if(department.val() == 0){ // If departments is 0 show doctors from all department ...
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ urlencode('search-doctors') }}",
                    data: {"department_id" : department.val()}
                }).done(function(result){
                    hide_loader();
                    if (result.error === false){
                        // No errors
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }else{
                        // There is an error
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }
                });
            }
            else if(department.val() != 0){ // if department not equal to 0 the show doctor from specific department ...
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ urlencode('search-doctors') }}",
                    data: {"department_id" : department.val()}
                }).done(function(result){
                    hide_loader();
                    if (result.error === false){
                        // No errors
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }else{
                        // There is an error
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }
                });
            }



            department.change(function() {
                show_loader();
                let department = $('#SelectDepartment');
                $('#SearchDocName').val('');
                let dep_id = $(this).val();
                //$("select#selected").prop('selectedIndex', idx);
                //alert(department.index());
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ urlencode('search-doctors') }}",
                    data: {"department_id" : dep_id}
                }).done(function(result){
                    hide_loader();
                    if (result.error === false){
                        // No errors
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }else{
                        // There is an error
                        //console.log(result);
                        $('#DoctorList').html(result);
                    }
                });
            });


            /// Search Doctor by name ......
            $('#SearchDocName').keyup(function () {
            //$('#SearchDocName').on('change keyup paste', function () {
                show_loader();
                let doctor_name = $('#SearchDocName').val();
                //console.log(doctor_name);
                let dep_id = department.val();
                if(doctor_name.length <= 1 && department.val() == 0){ // if search text is less then 1 // show all doctors from all department ...
                    // Show all doctors....
                    //alert(department.index());
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ urlencode('search-doctors') }}",
                        data: {"department_id" : dep_id}
                    }).done(function(result){
                        hide_loader();
                        if (result.error === false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }else{
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
                else if(doctor_name.length >= 1 && department.val() == 0){// if search text is more then 1 // start search doctors from all department ...
                    // Search doctor name form all department ...
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ urlencode('search-doctors') }}",
                        data: {"doctor_name": doctor_name, "department_id" : dep_id}
                    }).done(function(result){
                        hide_loader();
                        if (result.error === false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }else{
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
                else if(doctor_name.length < 1 && department.val() != 0){ // if search text is less then 1 // show doctors from specific department ....
                    // show all doctors from specific department....
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ urlencode('search-doctors') }}",
                        data: {"department_id" : dep_id}
                    }).done(function(result){
                        hide_loader();
                        if (result.error === false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }else{
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
                else if(doctor_name.length >= 1 && department.val() != 0){ // if search text is more then 1 // start search // show doctors from specific department ....
                    //alert(Blog_title);
                    // Ajax part ...
                    $.ajax({
                        type: 'GET',
                        method: 'GET',
                        url: "{{ urlencode('search-doctors') }}",
                        data: {"department_id" : dep_id, "doctor_name": doctor_name}
                    }).done(function(result){
                        hide_loader();
                        if (result.error === false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }else{
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
            });




        });
    </script>

@stop
