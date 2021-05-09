<!-- doctor profile data -->
<div id="MainContent">
    <!-- Main Container -->
    <div class="wrapper wrapper-content">
        <div class="m-t-40 m-b-40" style="padding: 10px;">
            <div class="col-12 col-md-12 col-lg-12 col-xs-12 col-sm-12">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 m-b-20">
                        <div class="card">
                            <div class="card-header">
                                <div class="ProfilePicBox">
                                    <img data-src="{{ $Data->avatar }}" alt="" id="my_profile_picture">

                                    <!-- Image upload button -->
                                    <div class="UploadProfilePhotofrm">
                                        <button class="btn" id="open_file_Dialog_2"><i class="fa fa-camera"></i></button>
                                    </div>

                                    <!-- Hidden Form for uploading profile image... -->
                                    <form action="{{ route('user.avatar-update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="text" name="uid" hidden value="{{ $Data->id }}">
                                        <input type="file" name="Profile_image" id="select_Profile_Pic_file" hidden>
                                        <button type="submit" class="btn" id="submit_profile_image_file" name="UploadProfilePic" title="Upload Profile Image" hidden></button>
                                    </form>
                                </div>
                                <hr>
                                <h4 class=" text-left"> {{ $Data->first_name . ' ' . $Data->last_name }} </h4>
                            </div>
                            <div class="card-body">

                            </div>
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>


                    <div class="Div_Slider_Container col-12 col-sm-12 col-md-8 col-lg-8">
                        <div id="tabs">
                            <ul>
                                <li><a href="#Profile_Information_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-user-circle m-r-4"></i> Profile Info</a></li>
                                <li><a href="#Appointments_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-calendar m-r-4"></i> Appointments</a></li>
                                <li><a href="#Consultations_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-comments m-r-4"></i> Consultations</a></li>
                                <li><a href="#Reports_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-file-pdf m-r-4"></i> Reports</a></li>
                            </ul>

                            {{-- Profile tab --}}
                            <div id="Profile_Information_tab" style="max-height: 560px">
                                <!-- Account information div -->
                                <div class="row">
                                    <div class="col-12 SlideDiv Account_Info active">
                                        <div class="p-t-20 p-b-20 {{-- p-l-5 p-r-5 --}} position-relative">

                                            <a type="submit" href="#Profile_Information_tab" class="btn btn-info btn-sm float-right" id="go-down" style="font-size: 12px; z-index: 3;right: 0;" title="Go down"><i class="fa fa-arrow-alt-circle-down"></i></a>
                                            <button type="submit" class="btn btn-light btn-sm float-right" id="btn_Edit_Profile" style="font-size: 12px;"><i class="fa fa-edit"></i> Edit Profile</button>
                                            <div class="clearfix"></div>

                                        {{--<h4 class="text-center">Account Information</h4>
                                        <hr><!-- Update profile form -->--}}
                                        <!--  Doctor profile information  -->
                                            <form action="{{ route('user.patient-profile-update') }}" method="post" enctype="multipart/form-data" class="form User_Frm_Data" id="User_Data_Update_Form" novalidate>
                                                @csrf
                                                <input type="text" hidden value="{{ $Data->id }}" name="id">
                                                <div class="row m-t-10 m-b-10"><!-- Main div -->
                                                    <!-- Left content -->
                                                    <div class="col-12 col-md-12 col-lg-6">
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-envelope"></i> <b>Email:</b></div>
                                                            <p>{{ $Data->email }}</p>
                                                        </div>
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-phone"></i> <b>Phone:</b></div>
                                                            <p>{{ $Data->phone }}</p>
                                                        </div>
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-restroom"></i> <b>Gender:</b></div>
                                                            <p>{{ $Data->gender }}</p>
                                                        </div>
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-tint"></i> <b>Blood Group:</b></div>
                                                            <p>{{ $Data->blood_group }}</p>
                                                        </div>
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-birthday-cake"></i> <b>Date of birth:</b></div>
                                                            <p>
                                                                {{ date('d.M.Y', strtotime($Data->dob)) }}, <b>Age:</b>
                                                                @php
                                                                    $dob = $Data->dob;
                                                                    $CurrentDate = date("Y-m-d");//today's date
                                                                    $DOB = new DateTime($dob);
                                                                    $CurrentDate = new DateTime($CurrentDate);
                                                                    $interval = $DOB->diff($CurrentDate);
                                                                    $Age = $interval->y;
                                                                    echo $Age;
                                                                @endphp
                                                            </p>
                                                        </div>
                                                        @php
                                                            if($Data->location !== null){
                                                                $Location = $Data->location;
                                                                try{
                                                                    $Location_array = decrypt($Location);
                                                                    $Location = $Location_array->country .', '. $Location_array->city .', '. $Location_array->state_name;
                                                                }catch (Exception $e){
                                                                    $Location;
                                                                }
                                                            }
                                                            else{
                                                                $Location = '';
                                                            }
                                                        @endphp
                                                        <label for="Location" class="FC_999"><i class="fa fa-location-arrow"></i> <b>Location:</b></label>
                                                        <div class="form-group input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-location-arrow"></i></span></div>
                                                            <input type="text" name="Location" id="Location" disabled class="form-control" maxlength="80" minlength="5" required value="{{ old('Location', $Location) }}">
                                                            <div class="input-group-prepend AutoDetectLocation">
                                                                <a id="Autodetect" style="cursor: pointer;">
                                                                    <span class="input-group-text" title="Auto locate"> <i class="fa fa-map-marked-alt" style="font-size: 24px;"></i> </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-12 col-lg-6">
                                                        <label for="address" class="FC_999"><i class="fa fa-building"></i> <b>Address:</b></label>
                                                        <div class="form-group input-group">
                                                            <input type="text" name="address" id="address" disabled class="form-control @error('address') is-invalid @enderror" required value="{{ old('address', $Data->address) }}">
                                                        </div>


                                                        <div class="" id="Password_reset_fields">
                                                            <div class="card">
                                                                <div class="card-header text-center FC_999">
                                                                    {{--<b><input type="checkbox" name="change_password" value="change_password" id="change_password_chk">Edit password</b>--}}
                                                                    <div class="custom-control custom-checkbox mr-sm-2">
                                                                        <input type="checkbox" class="custom-control-input" id="change_password_chk" name="change_password" value="change_password" @if(old('change_password') === 'change_password') {{ 'checked' }} @endif>
                                                                        <label class="custom-control-label" for="change_password_chk">Edit password</label>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body" id="password_textbox">
                                                                    <div class="form-group">
                                                                        <label for="" class="col-form-label-sm FC_999"><b>Old password:</b></label>
                                                                        <input type="password" name="old_password" id="old_password" class="form-control" value="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="" class="col-form-label-sm FC_999"><b>New password:</b></label>
                                                                        <input type="password" name="new_password" id="new_password" class="form-control" value="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="" class="col-form-label-sm FC_999"><b>Retype password:</b></label>
                                                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <br>
                                                    <div class="container m-t-20" id="Update_Profile_buttons" style="width: 280px;">
                                                        <div class="row">
                                                            <button type="submit" class=" col-8 btn btn-primary btn-sm" name="Update_Profile"><i class="fa fa-edit"></i> Update</button>
                                                            <button type="button" id="Disable_Update_form" class=" col-2 btn btn-danger btn-sm m-l-10"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div id="Appointments_tab" style="max-height: 660px">
                                <div class="col-12 {{--SlideDiv--}} Appointments active">
                                    <div class="p-t-10 p-b-10 p-l-10 p-r-10">

                                        <a href="{{ route('appointment') }}" target="_blank" class="btn btn-sm btn-light float-right" style="font-size: 12px;"><i class="fa fa-calendar-plus"></i> Book New Appointment</a>
                                        <div class="clearfix"></div>

                                        @if(count($Data->consultation) > 0)
                                            <h5 class="text-center text-info">Booked Appointments.</h5>
                                            <hr>
                                            <div class="row m-b-20">
                                                @foreach($ConsultationsNotDone as $Consultation)
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 rounded m-t-8">
                                                        <div class="card m-xl-0">
                                                            <div class="card-header">

                                                                @php
                                                                    $RawDate = strtotime($Consultation->appointmentbooking->booked_date); $RawTime = date('H:i:s', strtotime($Consultation->appointmentbooking->booked_time));
                                                                    $Date_time = date('F', $RawDate).' '.date('d', $RawDate).' '.date('Y', $RawDate) .' '. $RawTime;
                                                                    $URL = urlencode('chat-box|'.encrypt($Consultation->id));
                                                                    //$Date_time = \Carbon\Carbon::parse($Date_time)->format('Y-m-d H:i:s');
                                                                @endphp
                                                                @if(\Carbon\Carbon::now()->format('F d Y H:i:s') < $Date_time  && $Consultation->status === 'pending')
                                                                    <div class="col-12 text-info Timer text-center" data-countdown="{{ $Date_time }}" data-url="{{ $URL }}"></div>
                                                                @elseif($Consultation->status === 'in progress')
                                                                    <div class="col-12 text-info text-center" style="font-size: 12px">In progress</div>
                                                                @elseif($Consultation->status === 'session end')
                                                                    <div class="col-12 text-info text-center" style="font-size: 12px">Session End</div>
                                                                @endif


                                                                {{--<div class="col-12 text-info Timer text-center" data-countdown="{{date('F', $RawDate).' '."9".' '.date('Y', $RawDate) .' '. '03:21:00' }}"></div>--}}
                                                                {{--<div class="col-12 text-info Timer text-center" data-countdown="{{date('m-d-Y', $RawDate).' '. $RawTime }}"></div>--}}
                                                            </div>
                                                            <div class="card-body">
                                                                <div style="font-size: 12px;" class="row">
                                                                    <div class="m-r-10">
                                                                        <img data-src="{{$Consultation->doctor->user->avatar}}" alt="" class="rounded-circle" width="60" height="60" style="object-fit: cover; object-position: center top;">
                                                                    </div>
                                                                    <div class="">
                                                                        <div style="font-size: 12px;">
                                                                            <strong>Doctor Name: </strong>
                                                                            <span class="text-info"><a href="{{url('doctors-details|') . encrypt($Consultation->doctor->user->id)}}" class="text-info">Dr. {{$Consultation->doctor->user->first_name . ' ' . $Consultation->doctor->user->last_name}}</a></span>
                                                                        </div>
                                                                        <div style="font-size: 12px;">
                                                                            <strong>Booked Date: </strong>
                                                                            <span class="text-info">{{$Consultation->appointmentbooking->booked_date }}</span>
                                                                        </div>
                                                                        <div style="font-size: 12px;">
                                                                            <strong>Booked Time: </strong>
                                                                            <span class="text-info">{{date('h:i a', strtotime($Consultation->appointmentbooking->booked_time))}}</span>
                                                                        </div>
                                                                        <div style="font-size: 12px;">
                                                                            <strong>Status: </strong>
                                                                            <span class="text-danger">{{ucwords($Consultation->status)}}</span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <a href="{{ urlencode('chat-box|'.encrypt($Consultation->id)) }}" class="btn btn-sm btn-outline-info" style="font-size: 12px;"><i class="fa fa-comment m-r-4"></i> Conversation</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>


                                            @if(count($ConsultationsDone)>0)
                                                <div class="text-center col-12">
                                                    <h5 class="text-center text-info">Booking History.</h5>
                                                    <button type="button" style="font-size: 12px;" id="Custom_DropDown" class="btn btn-sm btn-light float-right rounded"><i class="fa fa-angle-down"></i></button>
                                                </div>
                                                <hr>
                                                <div class="clearfix"></div>
                                                <div class="row m-t-10" id="Booking_History">
                                                    @foreach($ConsultationsDone as $Consultation)
                                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 rounded ">
                                                            <div class="card m-xl-0">
                                                                <div class="card-header">

                                                                </div>
                                                                <div class="card-body">
                                                                    <div style="font-size: 12px;" class="row">
                                                                        <div class="m-r-10">
                                                                            <img data-src="{{$Consultation->doctor->user->avatar}}" alt="" class="rounded-circle" width="60" height="60" style="object-fit: cover; object-position: center top;">
                                                                        </div>
                                                                        <div class="">
                                                                            <div style="font-size: 12px;">
                                                                                <strong>Doctor Name: </strong>
                                                                                <span class="text-info"><a href="{{url('doctors-details|') . encrypt($Consultation->doctor->user->id)}}" class="text-info">Dr. {{$Consultation->doctor->user->first_name . ' ' . $Consultation->doctor->user->last_name}}</a></span>
                                                                            </div>
                                                                            <div style="font-size: 12px;">
                                                                                <strong>Booked Date: </strong>
                                                                                <span class="text-info">{{$Consultation->appointmentbooking->booked_date }}</span>
                                                                            </div>
                                                                            <div style="font-size: 12px;">
                                                                                <strong>Booked Time: </strong>
                                                                                <span class="text-info">{{$Consultation->appointmentbooking->booked_time}}</span>
                                                                            </div>
                                                                            <div style="font-size: 12px;">
                                                                                <strong>Status: </strong>
                                                                                <span class="text-danger">{{ucwords($Consultation->status)}}</span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <a href="{{ urlencode('chat-box|'.encrypt($Consultation->id)) }}" class="btn btn-sm btn-outline-info" style="font-size: 12px;"><i class="fa fa-comment m-r-4"></i> Conversation</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-info" role="alert">You don't have any bookings yet.</div>
                                        @endif

                                    </div>
                                </div>
                            </div>


                            <div id="Consultations_tab">
                                <div class="col-12 SlideDiv active">
                                    <div class="p-t-10 p-b-10 p-l-10 p-r-10">
                                        @if(count($Consultations) > 0)
                                            <h5 class="text-center text-info">All Consultations.</h5>
                                            @foreach($Consultations as $C)
                                                @php
                                                    /*$Message = \App\Conversation::where('consultation_id', '=', $C->id)->orderBy('id', 'DESC')
                                                    ->join('users', 'users.id', 'consultations.user_id')
                                                    ->first();*/
                                                $Message = $C->conversation()->orderBy('conversations.created_at', 'DESC')
                                                /*->join('users', 'users.id', 'conversations.sender_id')*/
                                                ->first();
                                                //dd($Message);
                                                @endphp
                                                @if($Message !== null)
                                                    <a href="{{ urlencode('chat-box|'.encrypt($C->id)) }}">
                                                        <div class="row bg-white rounded m-b-4" style="padding: 4px 10px;">
                                                            <div class="m-r-20" style="width: 40px;"><img data-src="{{ $C->doctor->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                                            <div style="width: calc(100% - 60px);">
                                                                <div style="font-size: 12px;"><b>Dr. {{ $C->doctor->user->first_name.' '.$C->doctor->user->last_name }}</b></div>
                                                                <div style="font-size: 12px;" class='p-l-15'>{{ htmlspecialchars($Message->conversation_text) }}</div>
                                                                <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($Message->created_at)) }}</div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </a>
                                                @else
                                                    <div class="col-12 text-center alert-info">No consultations completed.</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="col-12 text-center alert-info">No consultations completed.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div id="Reports_tab">
                                <div class="col-12 SlideDiv active">
                                    <div class="p-t-10 p-b-10 p-l-10 p-r-10">

                                        <h5 class="text-center text-info">Your medical reports.</h5>

                                        @foreach($Consultations as $Consult)
                                            <div class="col-12 bg-white">
                                                <div class="row bg-white rounded m-b-4" style="padding: 4px 10px;">
                                                    <a href="{{ urlencode('chat-box|'.encrypt($Consult->id)) }}" style="display: block;">
                                                        <div class="m-r-20" style="width: 40px;"><img data-src="{{ $Consult->doctor->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                                    </a>
                                                    <div style="width: calc(100% - 60px);">
                                                        <div style="font-size: 12px;" class="m-b-6"><b>{{ $Consult->doctor->user->first_name.' '.$Consult->doctor->user->last_name }}</b></div>
                                                        <ul style="font-size: 12px;">
                                                            @if(count($Consult->report)>0)
                                                                @foreach($Consult->report as $key => $GetReport)
                                                                    <li><a href="{{ $GetReport->report_file }}" target="_blank"><i class="fa fa-dot-circle p-r-6"></i> Report: {{ $key + 1 }}</a></li>
                                                                    <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($GetReport->created_at)) }}</div>
                                                                    <hr>
                                                                @endforeach
                                                            @else
                                                                <li>No reports available.</li>
                                                            @endif
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
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
    </div>

</div>

<script src="{{ asset('js/dscountdown.min.js') }}" defer></script>

