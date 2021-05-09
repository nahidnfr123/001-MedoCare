@extends('layouts.app_front')

@section('title')
    @php $title = 'Appointment'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

    <div id="MainContent">

        <!-- Banner image -->
        <div class="Banner">
            <div class="filter_color"></div>
            <img data-src="{{ asset('storage/image/web_layout/banner/Appointment.jpg') }}" alt="">
            <h1 class="Banner_Text">
                <a href="{{ route('home') }}" class="ban_Link"><i class="fas fa-home"></i> Home </a> / {{ $title }} </h1>
        </div>


        <div class="container-fluid m-t-40 m-b-40 text-center">
            <h2 class="m-b-20">Book an appointment.</h2>
            <div class="text-center container col-12">
                <!--
                <button id="Online_btn" class="mybtn m-r-10"> Online Appointment </button>
                <button id="Offline_btn" class="mybtn_reverse m-l-10"> Offline Appointment </button>
                -->
            </div>


            <div class="col-12 col-sm-12 col-md-10 col-xs-12 col-lg-8 col-xl-8 pull-left" style="margin: 20px auto;" id="Show_Div_Form_List">

                <form action="{{ route('user.book-appointment') }}" method="post" class="form col-12 bg-info" id="Book_Appointment_Form" style="padding: 20px;border-radius: 10px;">
                    @csrf
                    <div class="Hide_AND_Show">
                        <div class="row m-b-10">
                            <div class="col-12 col-md-6 col-lg-6">
                                <label for="" class="control-label">Select Department:</label>
                                <select name="Department" id="SelectDepartment" class="form-control @error('Department') is-invalid @enderror">
                                    <option value="0" @if(old('Department') == 0) selected @endif>All departments</option>
                                    @if(count($Departments) > 0)
                                        @foreach ($Departments as $Department)
                                            <option value="{{ $Department->id }}" @if(old('Department') == $Department->id) selected @endif> {{ $Department->department_name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <label for="Date_Picker" class="text-center control-label">Select Date: </label>
                                <input type="text" class="form-control @error('appointment_date') is-invalid @enderror" name="appointment_date" id="Date_Picker" required readonly>
                            </div>
                        </div>

                        <div class="m-t-10 row">
                            <input type="hidden" value="" name="App_ID" id="App_ID" hidden>
                            <input type="hidden" value="" name="Doc_ID" id="Doc_ID" hidden>
                            <input type="hidden" value="{{ auth()->id() }}" name="User_ID" id="Patient_ID" hidden>
                            <div class="col-6 col-md-4 col-lg-4">
                                <label for="Doctor_Name" class="text-center control-label">Doctor Name </label>
                                <input type="text" placeholder="----" id="Doctor_Name" name="Doctor_Name" class="form-control Dr_Name @error('Doctor_name') is-invalid @enderror" required readonly>
                            </div>
                            <div class="col-6 col-md-4 col-lg-4">
                                <label for="Start_Time_Input" class="text-center control-label">Start Time </label>
                                <input type="text" name="Start_Time_Input" id="Start_Time_Input" placeholder="----" class="form-control Start_Time_Input @error('Start_Time_Input') is-invalid @enderror" required readonly>
                            </div>
                            <div class="col-6 col-md-4 col-lg-4">
                                <label for="End_Time_Input" class="text-center control-label">End Time </label>
                                <input type="text" placeholder="----" id="End_Time_Input" name="End_Time_Input" class="form-control End_Time_Input @error('End_Time_Input') is-invalid @enderror" required readonly>
                            </div>
                        </div>

                        <input type="hidden" hidden id="Fees_Input" value="">
                        <div class="m-t-20">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" name="Book_Appointment" id="Book_Appointment_btn"><i class="fa fa-calendar-alt"></i> Book Appointment </button>
                                <button type="button" class="btn btn-sm btn-light" id="Reset_fields"><i class="fa fa-redo-alt"></i> Reset </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12 col-md-12 col-lg-12 col-xl-10 m-auto m-t-20 ">
                <div id="DoctorList_Full_Div">
                    <p>Select Doctor and Time from this list.</p>
                    <div id="DoctorList" class="col-12" style="max-height: 500px;overflow-y: scroll;border-radius:6px;box-shadow: 0 0 4px rgba(0,0,0,.4)">
                        <!-- Show doctor list using ajax -->

                    </div>
                </div>
            </div>
        </div>
    </div>



@stop



@section('Page_Level_Script')

    <script type="text/javascript" src="{{ asset('asset_front/js/mdtimepicker.js') }}"></script>

    <script>

        $( window ).on("load", function() {
            @if(!Auth::check())
            let DIV = document.createElement("div");
            DIV.innerHTML = ' <div class="col-12"> ' +
                '<div class="btn-group col-8 m-auto">' +
                '<a href="{{ url('login') }}" class="btn btn-sm btn-warning">Login</a>' +
                '<a href="{{ url('register') }}" class="btn btn-sm btn-danger">Register</a>' +
                '</div>' +
                '<br>' +
                '<a href="{{ url('password/reset') }}" style="font-size:10px;" class="text-info"><u>forget - password</u></a>' +
                ' </div> ';
            swal({
                title: "You are not logged in.",
                text: "Please login first to book appointment.",
                icon: "warning",
                content: DIV,
                closeOnEsc: false,
                button: false,
            });
            @endif
        });

        $(document).ready(function () {
            function ResetAll(){
                Reset();
                $("#Date_Picker").val('');
                $('#SelectDepartment').val(0);
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl,
                    data: {"department": $(this).val()}
                }).done(function (result) {
                    if (result.error == false) {
                        // No errors
                        $('#DoctorList').html(result);
                    } else {
                        // There is an error
                        $('#DoctorList').html(result);
                    }
                });
            }
            // Reset all fields ...
            $('body').on('click','#Reset_fields', function () {
                Reset();
                $("#Date_Picker").val('');
                $('#SelectDepartment').val(0);
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl,
                    data: {"department": $(this).val()}
                }).done(function (result) {
                    if (result.error == false) {
                        // No errors
                        $('#DoctorList').html(result);
                    } else {
                        // There is an error
                        $('#DoctorList').html(result);
                    }
                });
            });

            let myUrl = '{{ url('appointmentLoader') }}';

            $('#DoctorList_Full_Div').slideDown();



            let department = $('#SelectDepartment');
            if (department.val() == 0) {
                //alert(department.index());
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl,
                    data: {"department": $(this).val()}
                }).done(function (result) {
                    if (result.error == false) {
                        // No errors
                        $('#DoctorList').html(result);
                    } else {
                        // There is an error
                        $('#DoctorList').html(result);
                    }
                });
            } else if (department.val() !== 0) {
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl,
                    data: {"department": department.val()}
                }).done(function (result) {
                    if (result.error == false) {
                        // No errors
                        $('#DoctorList').html(result);
                    } else {
                        // There is an error
                        $('#DoctorList').html(result);
                    }
                });
            }


            department.change(function () {
                Reset(); // Reset text fields ...
                let dep_id = $(this).val();
                if($("#Date_Picker").val() == ''){
                    $.ajax({
                        type: "GET",
                        method: "GET",
                        url: myUrl,
                        data: {"department": dep_id}
                    }).done(function (result) {
                        if (result.error == false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        } else {
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
                else{
                    $.ajax({
                        type: "GET",
                        method: "GET",
                        url: myUrl,
                        data: {"department": dep_id, "date": $("#Date_Picker").val()}
                    }).done(function (result) {
                        if (result.error == false){
                            // No errors
                            //console.log(result);
                            $('#DoctorList').html(result);
                        } else {
                            // There is an error
                            //console.log(result);
                            $('#DoctorList').html(result);
                        }
                    });
                }
            });




            let today = new Date();
            let Y = today.getFullYear();
            let M = today.getMonth();
            let D = today.getDate();

            let minyear;
            let maxyear;

            let maxmonth;
            let minmonth;

            let mixday = D + 2;
            let maxday = D + (31 - D);

            minyear = Y;
            maxyear = Y + 1;

            maxmonth = M + (12 - M);
            minmonth = M;

            $( "#Date_Picker" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                showOtherMonths: true,
                minDate: new Date( minyear,minmonth,mixday),
                maxDate: new Date( maxyear,maxmonth,maxday)
            });


            // for request ....
            $( "#Date_Picker_Request" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeYear: true,
                changeMonth: true,
                showOtherMonths: true,
                minDate: new Date( minyear,minmonth,mixday),
                maxDate: new Date( maxyear,maxmonth,maxday)
            });

            $('#start_time_picker').mdtimepicker({
                // format of the time value (data-time attribute)
                timeFormat: 'hh:mm',
                // format of the input value
                format: 'h:mm tt',
                // theme of the timepicker
                // 'red', 'purple', 'indigo', 'teal', 'green'
                theme: 'purple',
                // determines if input is readonly
                readOnly: true,
                // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
                hourPadding: false
            });



            $("body").on("click", ".TimeButton", function () {
                //alert($(this).text($(this).text()));
                let att_ID = $(this).attr("data-appID");
                let att_DocName = $(this).attr("data-name");
                let att_Doc_Id = $(this).attr("data-doc_id");
                let att_Start_Time = $(this).attr("data-Start-time");
                let att_End_Time = $(this).attr("data-End-time");

                $('#App_ID').val(att_ID);
                $('.Dr_Name').val(att_DocName);
                $('#Doc_ID').val(att_Doc_Id);
                $('.Start_Time_Input').val(att_Start_Time);
                $('.End_Time_Input').val(att_End_Time);
                $('.TimeButton').removeClass("disabled");
                $(this).addClass("disabled");
                $('#Fees_Input').val($(this).attr("data-Fees"));
            });


            $("#Date_Picker").change(function(){
                Reset(); // Reset text fields ...
                $('#DoctorList_Full_Div').slideDown("slow");
                let department = $('#SelectDepartment');
                let dep_id = department.val();
                $.ajax({
                    type: "GET",
                    method: "GET",
                    url: myUrl,
                    data: {"date": $(this).val(), "department": dep_id}
                }).done(function (result) {
                    if (result.error == false) {
                        // No errors
                        $('#DoctorList').html(result);
                    } else {
                        // There is an error
                        $('#DoctorList').html(result);
                    }
                });
            });


            function Reset(){
                $('#App_ID').val('');
                $('.Dr_Name').val('');
                $('#Doc_ID').val('');
                $('.Start_Time_Input').val('');
                $('.End_Time_Input').val('');
                $('.TimeButton').removeClass("disabled");
            }



            $('#Book_Appointment_btn').on('click', function (event) {
                if($('#Doctor_Name').val() == '' || $('#Start_Time_Input').val() == '' || $('#End_Time_Input').val() == ''){
                    //alert('You did not select a Time slot. Please select one and try again.');
                    swal({
                        icon: "error",
                        title: "Oops",
                        text: "You did not select a Time slot. Please select one and try again.",
                        button: {
                            text: "OK",
                        },
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                    });
                    return false;
                }
                else{
                    let From = $('.Start_Time_Input').val();
                    let To = $('.End_Time_Input').val();
                    let Doctor_Name = $('.Dr_Name').val();
                    let Date = $("#Date_Picker").val();
                    let Fees = $('#Fees_Input').val();

                    let DIV = document.createElement("div");
                    DIV.innerHTML = ' <div class="col-12"> ' +
                        '<div>Doctor name:-  <span style="color: #0d8ddb;">' + Doctor_Name + '<span></div> ' +
                        '<div>Date:-  <span style="color: #0d8ddb;">'+ Date +'</span> </div> ' +
                        '<div>Time:-  <span style="color: #0d8ddb;">' + From + '</span> to <span style="color: #0d8ddb;">' + To + '</span></div>' +
                        '<div>Fees:-  <span style="color: #0d8ddb;">'+ Fees +'</span> </div> ' +
                        '</div> ';

                    swal({
                        title: "Are you sure?",
                        text: "You want to book this appointment time slot.",
                        icon: "info",
                        content: DIV,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        buttons: [
                            'No, cancel it!',
                            'Yes, I am sure!'
                        ],
                        dangerMode: false,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            $('#Book_Appointment_Form').submit();
                        } else {
                            swal("Cancelled", "Your booking is canceled.", "error");
                            Reset();
                            return false;
                        }
                    });
                }
                event.preventDefault();
            });




        });
    </script>

@stop
