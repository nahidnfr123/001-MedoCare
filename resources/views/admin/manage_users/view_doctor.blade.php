@extends('layouts.app_back')

@section('title')
    @php $title = 'Manage User'; @endphp
    @php $subTitle = 'Doctor / Doctor details'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')


    <div class="wrapper wrapper-content">


        @if (isset($ViewDoctor))
        <div class="row">
            <div class="col-12" style="margin-bottom: 20px;">

                @if($ViewDoctor->email_verified_at === null && $ViewDoctor->email_sent===0 && $ViewDoctor->blocked===0)
                <div class="col-12 text-center txtCenter">
                    <h1>This account is not approved yet by admin.</h1>
                </div>
                @elseif ($ViewDoctor->email_verified_at === null && $ViewDoctor->email_sent===1 && $ViewDoctor->blocked!==1)
                <div class="col-12 text-center txtCenter">
                    <h1>Activation code is sent. Account not activated yet.</h1>
                </div>
                @elseif ($ViewDoctor->blocked===1)
                <div class="col-12 text-center txtCenter">
                    <h1>This account is blocked</h1>
                </div>
                @else
                <div class="col-12 text-center txtCenter">
                    <h1>Account is approved.</h1>
                </div>
                @endif
            </div>
            <div class="col-12 col-md-12 col-lg-5 m-b-20 bg-white">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Profile Detail</h5>
                    </div>
                    <div class="ProfileImage col-12" style="position: relative;">
                        @if($ViewDoctor->status === 1)
                        <div class="rounded" style="position: absolute;top: 6px;left: 6px;background-color: #fff;padding: 0 10px; box-shadow: 0 0 6px rgba(0,0,0,1);">
                            <i class="fa fa-circle" style="color: greenyellow; text-shadow: 0 0 6px rgba(0,0,0,1);"></i>
                            Online
                        </div>
                        @endif
                        <img src="{{ $ViewDoctor->avatar }}" alt="" width="200px" class="rounded">
                    </div>
                    <div class="col-12 doc_details_txt">
                        <h3>Details: </h3>
                        <ul class="UL ProfileDetailsList">
                            <li><strong>Name: </strong> <span>{{$ViewDoctor->first_name . ' ' . $ViewDoctor->last_name}}</span></li>
                            <li><strong>Gender: </strong>  <span>{{ $ViewDoctor->gender }}</span></li>
                            <li><strong>Date of birth: </strong>
                                <span>
                                    {{ date('d.M.Y', strtotime($ViewDoctor->dob)) }}, <b>Age:</b>
                                    @php
                                        $dob = $ViewDoctor->dob;
                                        $CurrentDate = date("Y-m-d");//today's date
                                        $DOB = new DateTime($dob);
                                        $CurrentDate = new DateTime($CurrentDate);
                                        $interval = $DOB->diff($CurrentDate);
                                        $Age = $interval->y;
                                        echo $Age;
                                    @endphp
                                </span>
                            </li>
                            <li><strong>Nationality: </strong>  <span>{{ $ViewDoctor->nationality }}</span></li>
                            <li><strong>Location: </strong>
                                <span>
                                    @php
                                    $Location = $ViewDoctor->location;
                                    try{
                                        $Location_array = decrypt($Location);
                                        echo $Location_array->country .', '. $Location_array->city .', '. $Location_array->state_name;
                                    }catch (Exception $e){
                                        echo $Location;
                                    }
                                    @endphp
                                </span>
                            </li>
                            <li><strong>Education: </strong>  <span>{{ $ViewDoctor->education }}</span></li>
                            <li><strong>Department: </strong>  <span>{{ $ViewDoctor->department_name }}</span></li>
                            <li><strong>Work Place Name: </strong>  <span>{{ $ViewDoctor->work_place_name }}</span></li>
                            <li><strong>Experience: </strong>  <span>{{ $ViewDoctor->experience }} Years</span></li>
                            @if($ViewDoctor->working_days !== null)
                                <li><strong>Working days: </strong>  <span>{{ $ViewDoctor->working_days }}</span></li>
                            @endif
                            {{--<li><strong>Time Per Patient: </strong>  <span>{{ $ViewDoctor->time_per_patient }} min</span></li>--}}
                            <li><strong>Fees: </strong>  <span>@if($ViewDoctor->fees === null) O Tk @else {{ $ViewDoctor->fees }} Tk @endif</span></li>
                            <li><strong>Account created date: </strong>  <span>{{ $ViewDoctor->created_at }}</span></li>
                        </ul>
                        <div class="midsection_join_box">
                            <div><strong>Email: </strong> {{ $ViewDoctor->email }}</div>
                            <div><strong>Phone: </strong> {{ $ViewDoctor->phone }}</div>
                        </div>
                        <hr>
                        @if($ViewDoctor->about !== null)
                        <div class="">
                            <h4>About</h4>
                            <p>{{ $ViewDoctor->about }}</p>
                        </div>
                        <br>
                        @endif

                        @if($ViewDoctor->email_sent===0 && $ViewDoctor->blocked===0)
                        <div class="col-12">
                            <div class="m-t-xs row mar-top-bot-40">
                                <a href="{{ urlencode('send-token|') . encrypt($ViewDoctor->user_id) }}"  class="col-6 btn btn-xs btn-success"><i class="fa fa-user-check"></i> Approve </a>
                                <a href="#" data-email="{{ $ViewDoctor->email }}" data-id="{{$ViewDoctor->user_id}}" class="col-6 btn btn-xs btn-danger Ignore_Button"><i class="fa fa-user-times"></i> Ignore </a>
                            </div>
                        </div>
                        @elseif ($ViewDoctor->blocked===1)
                        <div class="col-12">
                            <div class="m-t-xs row mar-top-bot-40">
                                <a href="#" data-email="{{ $ViewDoctor->email }}" data-id="{{ $ViewDoctor->user_id }}" class="col-6 btn btn-xs btn-primary Send_email"><i class="fa fa-envelope"></i> Send an email </a>
                                <a class="col-6 btn btn-xs btn-warning" href="{{ urldecode( 'unblock-user|' . encrypt($ViewDoctor->user_id)) }}"><i class="fa fa-check-square"></i> Unblock </a>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="m-t-xs row mar-top-bot-40">
                                <a href="#" data-email="{{ $ViewDoctor->email }}" data-id="{{ $ViewDoctor->user_id }}" class="col-6 btn btn-xs btn-primary Send_email"><i class="fa fa-envelope"></i> Send an email </a>
                                <a href="#" data-email="{{ $ViewDoctor->email }}" data-id="{{ $ViewDoctor->user_id }}"  class="col-6 btn btn-xs btn-danger Block_user"><i class="fa fa-user-times"></i> Block user </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <br>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Document</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content no-padding">

                        <div>
                            <iframe src="{{ $ViewDoctor->work_place_document }}" frameborder="0" class="col-12" height="500px"></iframe>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="col-12">
                <h4 class="text-center">User not found.</h4>
            </div>
        @endif
    </div>



    <div id="Float_Box_Form" class="">
        <div id="Close_btn_floatBox">
            <i class="fa fa-times"></i>
        </div>
        <p style="text-align: center;"  id="Form_Text">   </p>
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
            IgnoreButtonSelector.click(200, function (e) {
                $('#Floating_Form').attr('action', '{{ url('admin/ignore-join-request') }}');
                $('#Form_Text').text( '" Let the doctor know why the join request was ignored. "');
                let ID = $(this).data('id');
                $('#Floating_Form input[type=hidden][name=ID]').val(ID);
                $('#Floating_Form input[type=email][name=Email]').val(Email);
                $('#Floating_Form input[type=text][name=Subject]').val('Join request not accepted.');
                Message_label.html('Why did you ignore the request...?');
                $('#Float_Box_Form').fadeIn(500);
                e.preventDefault();
                return false;
            });


            // get email using data attribute and php ...
            let Email = IgnoreButtonSelector.data('email');
            $('#Floating_Form_Submit').click(function () {
                if($('#Floating_Form input[type=text][name=Subject]').val() === ''){
                    alert('You must enter a Subject. Empty input field not allowed.');
                    return false;
                }
                else if($('#Floating_Form textarea[name=Message]').val() === ''){
                    alert('You must enter a Message. Empty input field not allowed.');
                    return false;
                }
                else{
                    return true;
                }
            });


            // Send Email ....
            let OpenForm_To_SendEmail = $('.Send_email');
            OpenForm_To_SendEmail.click(200, function (e) {
                let ID = $(this).data('id');
                let Email = $(this).data('email');
                $('#Floating_Form').attr('action', '{{ url('admin/send-email-to-user') }}');
                $('#Form_Text').text( '" Send Email to user. "'); // Change form top level text ....
                $('#Floating_Form input[type=hidden][name=ID]').val(ID); // Get user_id from button to form ....
                // get email using data attribute and php ...
                $('#Floating_Form input[type=email][name=Email]').val(Email); // Get Email from button to form ....
                $('#Floating_Form input[type=text][name=Subject]').val('').attr('readonly', false);
                Message_label.html('Email Body:');
                $('#Float_Box_Form').fadeIn(500);
                e.preventDefault();
                return false;
            });


            // Send Email ....
            let OpenForm_To_BlockUser = $('.Block_user');
            OpenForm_To_BlockUser.click(200, function (e) {

                let msg = confirm('Are you sure you want to block this user.');

                if(msg === true){
                    let ID = $(this).data('id');
                    let Email = $(this).data('email');
                    $('#Floating_Form').attr('action', '{{ url( 'admin/block-user') }}');
                    $('#Form_Text').text( '" Let user know why this account will be blocked. "'); // Change form top level text ....
                    $('#Floating_Form input[type=hidden][name=ID]').val(ID); // Get user_id from button to form ....
                    // get email using data attribute and php ...
                    $('#Floating_Form input[type=email][name=Email]').val(Email); // Get Email from button to form ....
                    $('#Floating_Form input[type=text][name=Subject]').val('Account blocked').attr('readonly', true);
                    Message_label.html('Why are you blocking this account...?');
                    $('#Float_Box_Form').fadeIn(500);
                    e.preventDefault();
                    return false;
                }
                else{
                    return false;
                }


            });

        });
    </script>

@stop
