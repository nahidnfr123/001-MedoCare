@extends('layouts.app_back')

@section('title')
    @php $title = 'Manage User'; @endphp
    @php $subTitle = 'Doctor'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')


    <!-- Website content -->
    <div class="wrapper wrapper-content">


    @if(count($Not_verified_Doctors)>0)
        <div class="row">
            <div class="col-sm-12 white-bg">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>New doctor join request</h5>
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
                        <div class="animated fadeInRight">
                            <div class="row">

                                @foreach ($Not_verified_Doctors as $Doctor)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                        <div class="contact-box center-version">

                                            <div class="Center_content">

                                                <img alt="image" class="rounded-circle" src="{{ $Doctor->avatar }}" style="object-fit: cover; object-position: top center;">

                                                <h3 class="m-b-xs"><strong>{{ $Doctor->first_name . ' ' . $Doctor->last_name }}</strong></h3>

                                                <ul class="UL">
                                                    <li><strong>Work place: </strong> {{ $Doctor->work_place_name }}</li>
                                                    <li><strong>Department: </strong> {{ $Doctor->department_name }}</li>
                                                    <li><strong>Experience: </strong> {{ $Doctor->experience }} Years</li>
                                                    <!-- Job, work place details (image or pdf file...)-->
                                                    <li><a href="{{ urlencode('view-doctor|') . encrypt($Doctor->user_id) }}" class="btn btn-primary col-12">View Details</a></li>
                                                </ul>
                                                <div class="midsection_join_box">
                                                    <div><strong>Email: </strong> {{ $Doctor->email }}</div>
                                                    <div><strong>Phone: </strong> {{ $Doctor->phone }}</div>
                                                </div>
                                            </div>

                                            @if($Doctor->email_sent === 0)
                                            <div class="contact-box-footer">
                                                <div class="m-t-xs btn-group">
                                                    <a href="{{ urlencode('send-token|') . encrypt($Doctor->user_id) }}"  class="btn btn-xs btn-success"> Approve </a>
                                                    <a href="#" data-email="{{ $Doctor->email }}" data-id="{{ $Doctor->user_id }}" class="btn btn-xs btn-danger Ignore_Button"> Ignore </a>
                                                </div>
                                            </div>
                                            @else
                                            <div class="contact-box-footer" style="background-color: #0c5460; color:white;">
                                                <div class="m-t-xs btn-group">
                                                    <span>Email verification code has been sent.</span>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center row" style="position: relative;">
                            <br>
                            <div style="position: absolute;left: 50%;top: 60%;transform: translate(-50%, -50%)">{{ $Not_verified_Doctors->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



        <!-- Data table --><br>
        <div class="animated fadeInRight">
            <div class="row white-bg">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>All approved doctor list</h5>
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

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example Blood_donor_tbl">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px!important;" title="Doctor ID">ID</th>
                                        <th style="min-width: 60px!important;">Name</th>
                                        <th style="min-width: 60px!important;">Department</th>
                                        <th style="min-width: 100px!important;">Work place</th>
                                        <th style="width: 40px!important;">Email/Phone</th>
                                        <th style="width: 20px!important;">Gender</th>
                                        <th style="width: 20px!important;">Fees</th>
                                        <th style="width: 40px!important;">Rating</th>
                                        <th style="width: 40px; min-width: 40px!important;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($Doctors_data) > 0)
                                        @foreach ($Doctors_data as $Doctor)
                                            <tr class="gradeA @if($Doctor->blocked === 1 && $Doctor->user_deleted === null){{ ' bg-warning'}}@elseif($Doctor->user_deleted !== null) ' bg-danger txt-white' @endif" title="@if($Doctor->blocked === 1){{ 'This account is blocked.'}}@elseif($Doctor->user_deleted !== null) {{ 'This account is deleted.' }} @endif">
                                                <td>{{ $Doctor->id }}</td>
                                                <td class="Profile_Image"><img src="{{ $Doctor->avatar }}" alt="Profile"> {{ $Doctor->first_name }} {{ $Doctor->last_name }}</td>
                                                <td>{{ $Doctor->department_name }}</td>
                                                <td>{{ $Doctor->work_place_name }}</td>
                                                {{--<td>
                                                    @php
                                                        $dob = $Doctor->dob;
                                                        $CurrentDate = date("Y-m-d");//today's date
                                                        $DOB = new DateTime($dob);
                                                        $CurrentDate = new DateTime($CurrentDate);
                                                        $interval = $DOB->diff($CurrentDate);
                                                        $Age = $interval->y;
                                                        echo $Age;
                                                    @endphp
                                                </td>--}}
                                                <td>{{ $Doctor->email }}, {{ $Doctor->phone }}</td>
                                                <td>{{ $Doctor->gender }}</td>
                                                <td>@if($Doctor->fees === null) O Tk @else {{ $Doctor->fees }} Tk @endif</td>
                                                <td class="center">
                                                <span>
                                                    {{-- Calculate doctor rating --}}
                                                    @php $Ratings = App\DoctorRating::where('doctor_id','=', $Doctor->doc_id)->get(); $number_of_rating = count($Ratings); $c = 0;@endphp
                                                    @if(count($Ratings)>0)
                                                        @foreach($Ratings as $Rating)
                                                            @php $c += $Rating->rating_value @endphp
                                                        @endforeach
                                                        {{ round($calculate = $c / $number_of_rating, 2) }}
                                                    @else
                                                        {{ 0 }}
                                                    @endif
                                                </span>
                                                    <i class="fa fa-star" style="color: yellow; text-shadow: 0 0 10px black; padding-left: 6px;"></i>
                                                </td>
                                                <td>
                                                    @if($Doctor->user_deleted === null)
                                                        <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"> </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="{{ urlencode('view-doctor|') . encrypt($Doctor->users_id) }}">
                                                                        <i class="fa fa-eye" style="color: dodgerblue;font-size: 16px; margin-right: 5px;"></i> View
                                                                    </a>
                                                                </li>
                                                                @if ($Doctor->blocked === 1)
                                                                    <li><a class="dropdown-item" href="{{ urldecode( 'unblock-user|' . encrypt($Doctor->users_id)) }}">
                                                                        <i class="fa fa-check-square" style="color: limegreen;font-size: 16px; margin-right: 5px;"></i> Unblock
                                                                    </a></li>
                                                                @else
                                                                    <li><a class="dropdown-item Block_user" data-email="{{ $Doctor->email }}" data-id="{{ $Doctor->users_id }}">
                                                                        <i class="fa fa-user-times" style="color: darkorange;font-size: 16px; margin-right: 5px;"></i> Block user
                                                                    </a></li>
                                                                @endif
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item DeleteButton" data-email="{{ $Doctor->email }}" data-id="{{ $Doctor->users_id }}">
                                                                        <i class="fa fa-trash" style="color: coral;font-size: 16px; margin-right: 5px;"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <a href="{{ urldecode( 'restore-user|' . encrypt($Doctor->users_id)) }}" class="btn btn-default btn-sm text-info">
                                                            <i class="fa fa-trash-restore"></i> Restore
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 10px!important;" title="Doctor ID">ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Work place</th>
                                        <th style="width: 40px!important;">Email/Phone</th>
                                        <th style="width: 20px!important;">Gender</th>
                                        <th style="width: 20px!important;">Fees</th>
                                        <th style="width: 40px!important;">Rating</th>
                                        <th style="width: 40px; min-width: 40px!important;">Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        @if(count($Ignore_request) > 0)
            <br>
            <div class="animated fadeInRight">
                <div class="row white-bg">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Not approved doctors list</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-down"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content" style="display: none;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example Blood_donor_tbl">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px!important;" title="Doctor ID">ID</th>
                                            <th style="min-width: 60px!important;">Name</th>
                                            <th style="min-width: 60px!important;">Department</th>
                                            <th style="min-width: 100px!important;">Work place</th>
                                            <th style="width: 40px!important;">Email/Phone</th>
                                            <th style="width: 20px!important;">Gender</th>
                                            <th style="width: 20px!important;">Fees</th>
                                            <th style="width: 40px!important;">Rating</th>
                                            <th style="width: 40px; min-width: 40px!important;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Ignore_request as $Doctor)
                                                <tr class="gradeA @if($Doctor->blocked === 1){{ ' bg-warning'}}@elseif($Doctor->user_deleted !== null) ' bg-danger txt-white' @endif" title="@if($Doctor->blocked === 1){{ 'This account is blocked.'}}@elseif($Doctor->user_deleted !== null) {{ 'This account is deleted.' }} @endif">
                                                    <td>{{ $Doctor->id }}</td>
                                                    <td class="Profile_Image"><img src="{{ $Doctor->avatar }}" alt="Profile"> {{ $Doctor->first_name }} {{ $Doctor->last_name }}</td>
                                                    <td>{{ $Doctor->department_name }}</td>
                                                    <td>{{ $Doctor->work_place_name }}</td>
                                                    {{--<td>
                                                        @php
                                                            $dob = $Doctor->dob;
                                                            $CurrentDate = date("Y-m-d");//today's date
                                                            $DOB = new DateTime($dob);
                                                            $CurrentDate = new DateTime($CurrentDate);
                                                            $interval = $DOB->diff($CurrentDate);
                                                            $Age = $interval->y;
                                                            echo $Age;
                                                        @endphp
                                                    </td>--}}
                                                    <td>{{ $Doctor->email }}, {{ $Doctor->phone }}</td>
                                                    <td>{{ $Doctor->gender }}</td>
                                                    <td>@if($Doctor->fees === null) O Tk @else {{ $Doctor->fees }} Tk @endif</td>
                                                    <td class="center">
                                                        O
                                                        <i class="fa fa-star" style="color: yellow; text-shadow: 0 0 10px black; padding-left: 6px;"></i>
                                                    </td>
                                                    <td>
                                                        @if($Doctor->user_deleted !== null)
                                                            <a href="{{ urldecode( 'restore-user|' . encrypt($Doctor->users_id)) }}" class="btn btn-default btn-sm text-info">
                                                                <i class="fa fa-trash-restore"></i> Restore
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th style="width: 10px!important;" title="Doctor ID">ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Work place</th>
                                            <th style="width: 40px!important;">Email/Phone</th>
                                            <th style="width: 20px!important;">Gender</th>
                                            <th style="width: 20px!important;">Fees</th>
                                            <th style="width: 40px!important;">Rating</th>
                                            <th style="width: 40px; min-width: 40px!important;">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>









    {{-- Floating mail box --}}
    <div id="Float_Box_Form" class="">
        <div id="Close_btn_floatBox">
            <i class="fa fa-times"></i>
        </div>
        <p style="text-align: center;" id="Form_Text">   </p>
        <form action="" method="post" class="forms col-12" id="Floating_Form">
            @csrf
            <input type="hidden" hidden name="ID" value="{{ old('ID') }}">
            <label for="email">Email:  </label>
            <input type="email" id="email" name="Email" readonly required value="{{ old('Email') }}" class="form-control col-12 @error('Email') is-invalid @enderror">
            <br>
            <label for="subject">Subject:  </label>
            <input type="text" id="subject" name="Subject" readonly required value="{{ old('Subject') }}" class="form-control col-12 @error('Subject') is-invalid @enderror">
            <br>
            <label for="message" id="Message_label">Email body:</label><br>
            <textarea name="Message" id="message" cols="30" rows="6" class="form-control col-12 @error('Message') is-invalid @enderror">{{ old('Message') }}</textarea>
            <br>
            <input type="submit" name="OK_Done" class="btn btn-primary col-12" id="Floating_Form_Submit" value="Done">
        </form>
    </div>

@stop


@section('Page_Level_script')

    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                ordering:false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                    extend: 'copy'
                },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]
            });
        });
    </script>



    <script>

        @if($errors->any() || session()->has('Error'))
        $('#Float_Box_Form').fadeIn(500);
        @endif

        // popup form ...
        $('#Close_btn_floatBox').click(200, function () {
            $('#Float_Box_Form').fadeOut(500);
        });

        $(document).ready(function () {
            let Message_label = $('#Message_label');

            let IgnoreButtonSelector = $('.Ignore_Button');
            // get email using data attribute and php ...
            let Email = IgnoreButtonSelector.data('email');


            /*var _get_data = function(element){
            IgnoreButtonSelector.each(function (index) {
                //alert(index+' : ' + $(element).data('email'));
                var Email = $(element).data('email');
                $('#Floating_Form input[type=email][name=Email]').val(Email);
            });
            }*/

            IgnoreButtonSelector.click(200, function (e) {
                //_get_data(this);
                let Email = $(this).data('email');
                let ID = $(this).data('id');
                $('#Form_Text').text( '" Let the doctor know why the join request was ignored. "');
                $('#Floating_Form input[type=hidden][name=ID]').val(ID);
                $('#Floating_Form input[type=email][name=Email]').val(Email);
                $('#Floating_Form input[type=text][name=Subject]').val('Join request not accepted.');
                $('#Floating_Form textarea[name=Message]').val('');
                /* $('#Floating_Form input[type=email][name=Email]').val(Email);*/
                Message_label.html('Why did you ignore the request...?');
                $('#Float_Box_Form').fadeIn(500);

                $('#Floating_Form').attr('action', '{{ route('admin.ignore-join-request') }}');

                //return false;
                e.preventDefault();
            });

            // check input field on form submit ....
            $('#Floating_Form_Submit').click(function () {
                if($('#Floating_Form textarea[name=Message]').val() === ''){
                    alert('You must enter a message. Empty input field not allowed.');
                    return false;
                }
                else{
                    return true;
                }
            });

            $('.DeleteButton').click(200, function (e) {

                let msg = confirm('Are you sure you want to delete this user.');
                if(msg === true){
                    let Email = $(this).data('email');
                    let ID = $(this).data('id');
                    $('#Form_Text').text( '" Let the doctor know why you are deleting this account. "');
                    $('#Floating_Form input[type=hidden][name=ID]').val(ID);
                    $('#Floating_Form input[type=email][name=Email]').val(Email);
                    $('#Floating_Form input[type=text][name=Subject]').val('Account is being deleted.').attr('readonly', true);
                    $('#Floating_Form textarea[name=Message]').val('');
                    Message_label.html('Why are you deleting the account...?');
                    /* $('#Floating_Form input[type=email][name=Email]').val(Email);*/
                    $('#Float_Box_Form').fadeIn(500);

                    $('#Floating_Form').attr('action', '{{ route('admin.delete-user') }}');

                    //return false;
                    e.preventDefault();
                } else{
                    return false;
                }
            });



            $('.Block_user').click(200, function (e) {

                let msg = confirm('Are you sure you want to block this user.');

                if (msg === true) {
                    let ID = $(this).data('id');
                    let Email = $(this).data('email');
                    $('#Floating_Form').attr('action', '{{ route( 'admin.block-user') }}');
                    $('#Form_Text').text('" Let user know why this account will be blocked. "'); // Change form top level text ....
                    $('#Floating_Form input[type=hidden][name=ID]').val(ID); // Get user_id from button to form ....
                    // get email using data attribute and php ...
                    $('#Floating_Form input[type=email][name=Email]').val(Email); // Get Email from button to form ....
                    $('#Floating_Form input[type=text][name=Subject]').val('Account blocked.').attr('readonly', true);
                    Message_label.html('Why are you blocking the account...?');
                    $('#Float_Box_Form').fadeIn(500);
                    e.preventDefault();
                    //return true;
                } else {
                    return false;
                }

            });




        });

    </script>


@stop
