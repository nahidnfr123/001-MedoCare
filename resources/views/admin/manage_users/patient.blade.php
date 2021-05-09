@extends('layouts.app_back')

@section('title')
    @php $title = 'Manage User'; @endphp
    @php $subTitle = 'Patients'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <!-- Website content -->
    <!-- Data table -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row white-bg">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>All Patient list</h5>
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
                                    <th style="width: 10px!important;" title="Patient ID">ID</th>
                                    <th style="width: 100px!important;">Patient Name</th>
                                    <th style="width: 10px!important;" title="Blood Group">BG</th>
                                    <th style="width: 30px!important;">Age</th>
                                    <th style="width: 60px!important;">Email</th>
                                    <th style="width: 60px!important;">Phone</th>
                                    <th style="width: 40px!important;">Gender</th>
                                    <th style="width: 30px; max-width: 30px!important;">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($Patients_data) > 0)
                                @foreach ($Patients_data as $Patient)
                                    <tr class="gradeA @if($Patient->email_verified_at === null && $Patient->blocked === 0) {{ 'bg-dark' }} @elseif($Patient->blocked === 1){{ ' bg-warning'}}@elseif($Patient->user_deleted !== null) {{ ' bg-danger txt-white' }} @endif" title="@if($Patient->email_verified_at === null && $Patient->blocked === 0) {{ 'Account is not verified.' }} @elseif($Patient->blocked === 1){{ 'This account is blocked.'}}@elseif($Patient->user_deleted !== null) {{ 'This account is deleted.' }} @endif">

                                    {{--<tr class="gradeA @if($Patient->blocked === 1){{ ' bg-warning'}}@endif" title="@if($Patient->blocked === 1){{ 'This account is blocked.'}}@endif">--}}
                                    <td>{{ $Patient->id }}</td>
                                    <td class="Profile_Image"><img src="{{ $Patient->avatar }}" alt="Profile"> {{ $Patient->first_name }} {{ $Patient->last_name }}</td>
                                    <td>{{ $Patient->blood_group }}</td>
                                    <td>
                                        @php
                                        $dob = $Patient->dob;
                                        $CurrentDate = date("Y-m-d");//today's date
                                        $DOB = new DateTime($dob);
                                        $CurrentDate = new DateTime($CurrentDate);
                                        $interval = $DOB->diff($CurrentDate);
                                        $Age = $interval->y;
                                        echo $Age;
                                        @endphp
                                    </td>
                                    <td>{{ $Patient->email }}</td>
                                    <td>{{ $Patient->phone }}</td>
                                    <td>{{ $Patient->gender }}</td>
                                    <td>
                                        @if($Patient->user_deleted === null)
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle"> </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ urlencode('view-patient|') . encrypt($Patient->users_id) }}">
                                                            <i class="fa fa-eye" style="color: dodgerblue;font-size: 16px; margin-right: 5px;"></i> View</a>
                                                    </li>
                                                    @if ($Patient->blocked === 1)
                                                    <a class="dropdown-item" href="{{ urldecode( 'unblock-user|' . encrypt($Patient->users_id)) }}">
                                                        <i class="fa fa-check-square" style="color: limegreen;font-size: 16px; margin-right: 5px;"></i> Unblock
                                                    </a>
                                                    @else
                                                    <a class="dropdown-item Block_user" data-email="{{ $Patient->email }}" data-id="{{ $Patient->users_id }}">
                                                        <i class="fa fa-user-times" style="color: darkorange;font-size: 16px; margin-right: 5px;"></i> Block user
                                                    </a>
                                                    @endif
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item DeleteButton" data-email="{{ $Patient->email }}" data-id="{{ $Patient->users_id }}">
                                                            <i class="fa fa-trash" style="color: coral;font-size: 16px; margin-right: 5px;"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @else
                                            <a href="{{ urldecode( 'restore-user|' . encrypt($Patient->users_id)) }}" class="btn btn-default btn-sm text-info">
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
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>BG</th>
                                    <th>Age</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




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

    <!-- Page-Level Scripts -->
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
                let msg = confirm('Are you sure you want to delete this doctor.');
                if(msg === true){
                    let Email = $(this).data('email');
                    let ID = $(this).data('id');
                    $('#Form_Text').text( '" Let the doctor know why you are deleting this account. "');
                    $('#Floating_Form input[type=hidden][name=ID]').val(ID);
                    $('#Floating_Form input[type=email][name=Email]').val(Email);
                    $('#Floating_Form input[type=text][name=Subject]').val('Account Deleted.');
                    $('#Floating_Form textarea[name=Message]').val('');
                    /* $('#Floating_Form input[type=email][name=Email]').val(Email);*/
                    $('#Float_Box_Form').fadeIn(500);

                    $('#Floating_Form').attr('action', '{{ route('admin.delete-user') }}');

                    //return false;
                    e.preventDefault();
                }
                else{
                    return false;
                }
            });



            $('.Block_user').click(200, function (e) {
                let msg = confirm('Are you sure you want to block this user.');
                if (msg === true) {
                    let ID = $(this).data('id');
                    let Email = $(this).data('email');
                    $('#Floating_Form').attr('action', '{{ route('admin.block-user') }}');
                    $('#Form_Text').text('" Let user know why this account will be blocked. "'); // Change form top level text ....
                    $('#Floating_Form input[type=hidden][name=ID]').val(ID); // Get user_id from button to form ....
                    // get email using data attribute and php ...
                    $('#Floating_Form input[type=email][name=Email]').val(Email); // Get Email from button to form ....
                    $('#Floating_Form input[type=text][name=Subject]').val('Account blocked.').attr('readonly', true);
                    $('#Floating_Form textarea[name=Message]').val('');
                    $('#Float_Box_Form').fadeIn(500);
                    e.preventDefault();
                    //return true;
                }
            });



        });
    </script>

@stop
