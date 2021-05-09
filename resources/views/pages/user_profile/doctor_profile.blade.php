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

                                <span style="font-size: 12px!important;" class="text-muted"><b class="m-r-8">Rating:</b>
                                    {{-- Calculate doctor rating --}}
                                    @php $Ratings = $Data->doctor->doctorrating; $number_of_rating = count($Ratings); $c = 0;@endphp
                                    @if(count($Ratings)>0)
                                        @foreach($Ratings as $Rating)
                                            @php $c += $Rating->rating_value @endphp
                                        @endforeach
                                        {{ round($calculate = $c / $number_of_rating, 2) }}
                                    @else
                                        {{ 0 }}
                                    @endif
                                    <i class="fa fa-star m-r-10" style="color: yellow;text-shadow: 0 0 6px rgba(0,0,0,.8);"></i> ( {{ $number_of_rating }} <i class="fa fa-user"></i>)
                                </span>
                            </div>
                            <div class="card-body">
                                {{-- Show patients review --}}
                                @if(count($Ratings)>0)
                                    <h5><u>What patients say about you.</u></h5>
                                    @foreach($Ratings->reverse()->take(3) as $Ratting){{-- show only 5 ratings ... --}}
                                    <div class="" style="padding: 6px 20px 0 20px; margin: 0; background:#9ea6b9; border-radius: 6px;">
                                        <img data-src="{{ $Ratting->patient->user->avatar }}" alt="" height="40" width="40" style="border-radius: 50%;object-fit: cover;object-position: center;">
                                        <span><a href="" style="color: #000!important;"> {{ $Ratting->patient->user->first_name .' '. $Ratting->patient->user->last_name }} </a></span>
                                        <div><p>{{ $Ratting->comments }}</p></div>
                                    </div>
                                    @endforeach
                                    @if(count($Ratings) > 3)
                                        <a href="" class="btn btn-light">Show more</a>
                                    @endif
                                @endif
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>


                    <div class="Div_Slider_Container col-12 col-sm-12 col-md-8 col-lg-8">


                        <div id="tabs">
                            <ul>
                                <li><a href="#Profile_Information_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-user-circle"></i> Profile Info</a></li>
                                <li><a href="#Appointments_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-calendar"></i> Appointments</a></li>
                                <li><a href="#Consultations_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-comments"></i> Consultations</a></li>
                                <li><a href="#Reports_tab" style="font-family: Poppins-SemiBold;font-size: 12px!important;font-weight: bold;"><i class="fa fa-file-pdf m-r-4"></i> Reports</a></li>
                            </ul>

                            {{-- Profile page tabs... --}}





                            {{-- Profile tab --}}
                            <div id="Profile_Information_tab" style="max-height: 560px">
                                <!-- Account information div -->
                                <div class="row">
                                    <div class="col-12 SlideDiv Account_Info active">
                                        <div class="p-t-10 p-b-10 {{-- p-l-5 p-r-5 --}} position-relative">

                                            <a type="submit" href="#Profile_Information_tab" class="btn btn-info btn-sm float-right" id="go-down" style="font-size: 12px; z-index: 3;right: 0;" title="Go down"><i class="fa fa-arrow-alt-circle-down"></i></a>
                                            <button type="submit" class="btn btn-light btn-sm float-right" id="btn_Edit_Profile" style="font-size: 12px;"><i class="fa fa-edit"></i> Edit Profile</button>
                                            <div class="clearfix"></div>

                                        {{--<h4 class="text-center">Account Information</h4>--}}
                                        {{--<hr>--}}<!-- Update profile form -->
                                            <!--  Doctor profile information  -->
                                            <form action="{{ route('user.doctor-profile-update') }}" method="post" enctype="multipart/form-data" class="form User_Frm_Data" id="User_Data_Update_Form" novalidate>
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
                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-flag"></i> <b>Nationality:</b></div>
                                                            <p>{{ $Data->doctor->nationality }}</p>
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
                                                            <input type="text" name="Location" id="Location" disabled class="form-control @error('Location') is-invalid @enderror" maxlength="80" minlength="5" required value="{{ old('Location', $Location) }}">
                                                            <div class="input-group-prepend AutoDetectLocation">
                                                                <a id="Autodetect" style="cursor: pointer;">
                                                                    <span class="input-group-text" title="Auto locate"> <i class="fa fa-map-marked-alt" style="font-size: 24px;"></i> </span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <label for="address" class="FC_999"><i class="fa fa-building"></i> <b>Address:</b></label>
                                                        <div class="form-group input-group">
                                                            <input type="text" name="address" id="address" disabled class="form-control @error('address') is-invalid @enderror" required value="{{ old('address', $Data->address) }}">
                                                        </div>

                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-user-graduate"></i> <b>Education:</b></div>
                                                            <p>{{ $Data->doctor->education }}</p>
                                                        </div>

                                                    </div>

                                                    <!-- Right Content -->
                                                    <div class="col-12 col-md-12 col-lg-6">

                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-network-wired"></i> <b>Department:</b></div>
                                                            <p>{{ $Data->doctor->department->department_name }}</p>
                                                        </div>

                                                        <label for="WorkPlace" class="FC_999"><i class="fa fa-building"></i> <b>Work place:</b></label>
                                                        <div class="form-group input-group">
                                                            <input type="text" name="WorkPlace" id="WorkPlace" disabled class="form-control @error('WorkPlace') is-invalid @enderror" required value="{{ old('WorkPlace', $Data->doctor->work_place_name) }}">
                                                        </div>

                                                        <div class="">
                                                            <div class="FC_999"><i class="fa fa-brain"></i> <b>Experience:</b></div>
                                                            <p>{{ $Data->doctor->experience }} Years</p>
                                                        </div>

                                                        <label for="FeesUpdate" class="FC_999"><i class="fa fa-money-check-alt"></i> <b>Fees:</b></label>
                                                        <div class="form-group input-group">
                                                            <input type="text" name="Fees" id="FeesUpdate" disabled class="form-control @error('Fees') is-invalid @enderror" value="{{ old('Fees', $Data->doctor->fees) }}">
                                                            <div class="input-group-prepend"><span class="input-group-text">.TK</span></div>
                                                        </div>


                                                        <div>
                                                            <div class="FC_999"><i class="fa fa-briefcase"></i> <b>Working days</b> <span style="font-size: 12px;">(min: 2 days, max: 5 days)</span></div>
                                                            <div class="container">
                                                                <div class="col-12 m-l-4 m-r-4">
                                                                    <div class="row">

                                                                        @php
                                                                            if(strlen($Data->doctor->working_days) !== 0 && !session()->has('Error_edit_profile')){
                                                                                $Get_Week_Days_array = explode(', ', $Data->doctor->working_days);
                                                                                //print_r($Get_Week_Days_array);
                                                                            }
                                                                            elseif(session()->has('Error_edit_profile')){
                                                                                $Get_Week_Days_array = array();
                                                                                if (old('Sunday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Sunday'));
                                                                                }if (old('Monday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Monday'));
                                                                                }if (old('Tuesday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Tuesday'));
                                                                                }if (old('Wednesday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Wednesday'));
                                                                                }if (old('Thursday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Thursday'));
                                                                                }if (old('Friday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Friday'));
                                                                                }if (old('Saturday')){
                                                                                    $Get_Week_Days_array[] = ucfirst(old('Saturday'));
                                                                                }
                                                                            }
                                                                            else{
                                                                                $Get_Week_Days_array = array();
                                                                            }
                                                                        @endphp
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch1" name="Sunday" value="Sunday" @if(in_array('Sunday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch1">Sunday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch2" name="Monday" value="Monday" @if(in_array('Monday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch2">Monday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch3" name="Tuesday" value="Tuesday" @if(in_array('Tuesday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch3">Tuesday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch4" name="Wednesday" value="Wednesday" @if(in_array('Wednesday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch4">Wednesday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch5" name="Thursday" value="Thursday" @if(in_array('Thursday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch5">Thursday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch6" name="Friday" value="Friday" @if(in_array('Friday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch6">Friday</label>
                                                                        </div>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox" class="custom-control-input" disabled id="switch7" name="Saturday" value="Saturday" @if(in_array('Saturday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                            <label class="custom-control-label m-r-10" for="switch7">Saturday</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="my-sm-3" id="Password_reset_fields">
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
                                                                        <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" value="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="" class="col-form-label-sm FC_999"><b>New password:</b></label>
                                                                        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" value="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="" class="col-form-label-sm FC_999"><b>Retype password:</b></label>
                                                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="About" class="FC_999"><b>About:</b></label>
                                                        <textarea name="About" disabled id="About" rows="4" class="form-control @error('About') is-invalid @enderror" required placeholder="@if($Data->doctor->about === null)Say something about your self .... @endif">{{ old('About', $Data->doctor->about) }}</textarea>
                                                    </div>
                                                    <br>
                                                    <div class="container m-t-20" id="Update_Profile_buttons" style="width: 280px;">
                                                        <div class="row">
                                                            <button type="submit" class="col-8 btn btn-primary btn-sm" name="Update_Profile" style="font-size: 12px;"><i class="fa fa-edit"></i> Update</button>
                                                            <button type="button" id="Disable_Update_form" class="col-2 btn btn-danger btn-sm m-l-10" style="font-size: 12px;"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Appointment tab --}}
                            <div id="Appointments_tab" style="max-height: 660px">

                                <div class="col-12 SlideDiv Appointments active">
                                    <div class="p-t-10 p-b-10 p-l-10 p-r-10">

                                        <button type="button" class="btn btn-sm btn-light float-right" style="font-size: 12px;" data-toggle="modal" data-target="#CreateAppointmentModal" id="CreateAppointmentBtn"><i class="fa fa-calendar-plus"></i> Create Appointment</button>
                                        <div class="clearfix"></div>
                                        {{-- Create appointment form --}}
                                        <div class="modal fade bd-example-modal-lg" id="CreateAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="min-width: 80%!important;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Create appointment</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="{{ route('appointment-store') }}" method="post" class="Create_appointment" id="Create_appointment" novalidate>
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-12 col-lg-6 m-auto">
                                                                            <label for="Fees" class="FC_999"><b>Start date:</b></label>
                                                                            <div class="form-group input-group">
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i> </span></div>
                                                                                <?php $date = date('Y-m') . '-' . (date('d') + 6);?>
                                                                                <input type="text" name="Start_Date" id="Start_Date" class="form-control bg-white @error('Start_Date') is-invalid @enderror" required placeholder="Year-month-day" value="{{ old('Start_Date', $date)}}">
                                                                                <div class="invalid-tooltip"> Select start date.</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-lg-6 m-auto">
                                                                            <label for="Fees" class="FC_999"><b>End date:</b></label>
                                                                            <div class="form-group input-group">
                                                                                <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i> </span></div>
                                                                                <input type="text" name="End_Date" id="End_Date" class="form-control bg-white @error('End_Date') is-invalid @enderror" required placeholder="Year-month-day" value="{{ old('End_Date') }}">
                                                                                <div class="invalid-tooltip"> Select End date.</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-12 col-lg-6">
                                                                            <div class="row">
                                                                                {{-- Select end time--}}
                                                                                <div class="col-6 col-lg-6">
                                                                                    <label for="Fees" class="FC_999"><b>Start time:</b></label>
                                                                                    <div class="form-group input-group">
                                                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i> </span></div>
                                                                                        <input type="text" name="Start_Time" id="start_time_picker" class="form-control bg-white @error('Start_Time') is-invalid @enderror" readonly required value="{{ old('Start_Time') }}">
                                                                                        <div class="invalid-tooltip"> Select start time.</div>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- Select End time --}}
                                                                                <div class="col-6 col-lg-6">
                                                                                    <label for="Fees" class="FC_999"><b>End time:</b></label>
                                                                                    <div class="form-group input-group">
                                                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i> </span></div>
                                                                                        <input type="text" name="End_Time" id="end_time_picker" class="form-control bg-white @error('End_Time') is-invalid @enderror" readonly required value="{{ old('End_Time') }}">
                                                                                        <div class="invalid-tooltip"> Select End time.</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- Week days --}}
                                                                            <div class="col-12">
                                                                                <div class="FC_999 m-b-6"><b>Select days to attend:</b></div>
                                                                                <div class="row form-content rounded">
                                                                                    @php
                                                                                        if(strlen($Data->doctor->working_days) !== 0 && !session()->has('Error_create_Appointment')){
                                                                                            $Get_Week_Days_array = explode(', ', $Data->doctor->working_days);
                                                                                        }
                                                                                        elseif(session()->has('Error_create_Appointment')){
                                                                                            $Get_Week_Days_array = array();
                                                                                            if (old('Sunday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Sunday'));
                                                                                            }if (old('Monday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Monday'));
                                                                                            }if (old('Tuesday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Tuesday'));
                                                                                            }if (old('Wednesday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Wednesday'));
                                                                                            }if (old('Thursday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Thursday'));
                                                                                            }if (old('Friday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Friday'));
                                                                                            }if (old('Saturday')){
                                                                                                $Get_Week_Days_array[] = ucfirst(old('Saturday'));
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s1" name="Sunday" value="Sunday" @if(in_array('Sunday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s1">Sunday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s2" name="Monday" value="Monday" @if(in_array('Monday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s2">Monday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s3" name="Tuesday" value="Tuesday" @if(in_array('Tuesday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s3">Tuesday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s4" name="Wednesday" value="Wednesday" @if(in_array('Wednesday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s4">Wednesday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s5" name="Thursday" value="Thursday" @if(in_array('Thursday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s5">Thursday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s6" name="Friday" value="Friday" @if(in_array('Friday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s6">Friday</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-switch p-r-10">
                                                                                        <input type="checkbox" class="custom-control-input" id="s7" name="Saturday" value="Saturday" @if(in_array('Saturday', $Get_Week_Days_array, true)) {{ 'checked' }} @endif>
                                                                                        <label class="custom-control-label" for="s7">Saturday</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- Show total duration --}}{{--
                                                                            <div class="col-12 m-b-10 form-control text-center" style="font-size: 10px;" id="TotalDuration"></div>

                                                                            --}}{{-- Time Wheel --}}{{--
                                                                            <div class="text-center text-muted"><span style="font-size: 12px;">Select Time</span>
                                                                                <div id="date_time_piker_wheel"></div>
                                                                            </div>--}}
                                                                        </div>

                                                                        <div class="col-12 col-lg-6">
                                                                            {{-- Patient can book from --}}
                                                                            <div class="">
                                                                                <label for="Fees" class="FC_999"><b>Booking start date:</b></label>
                                                                                <div class="form-group input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i> </span></div>
                                                                                    <?php $date = date('Y-m') . '-' . (date('d') + 1);?>
                                                                                    <input type="text" name="Booking_Start_Date" id="Booking_Start_Date" class="form-control bg-white @error('Booking_Start_Date') is-invalid @enderror" readonly required value="{{ old('Booking_Start_Date', $date) }}" style="z-index: 100000;">
                                                                                    <div class="invalid-tooltip"> Booking start date.</div>
                                                                                </div>
                                                                            </div>

                                                                            {{-- Fees --}}
                                                                            <div class="">
                                                                                <label for="Fees" class="FC_999"><b>Fees:</b></label>
                                                                                <div class="form-group input-group">
                                                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-money-check-alt"></i> </span></div>
                                                                                    <input type="text" pattern="[0-9]{3,}" id="Fees" readonly placeholder="Free" class="form-control @error('Fees') is-invalid @enderror" name="Fees" value="@if($Data->doctor->fees === null || $Data->doctor->fees === 0) {{ '' }} @else {{ $Data->doctor->fees }} @endif">
                                                                                    <div class="input-group-prepend"><span class="input-group-text">.Tk</span></div>
                                                                                    <div class="invalid-tooltip"> Set your consultation fees.</div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{--<div class="col-12 m-b-20">

                                                            </div>--}}
                                                            <input type="submit" class="btn btn-primary btn-sm col-12" id="Create_Appointment" name="Create_Appointment" value="Create Appointment">
                                                        </form>
                                                    </div>
                                                    {{--<div class="modal-footer">
                                                    </div>--}}
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div>
                                            <h4 class="text-center FC_999" id="ShowAppointment_form"><b>Appointment history</b></h4>
                                            <table id="Appointment_Table" class="display cell-border compact stripe hover order-column row-border" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th class="text-center" style="font-size: 12px; max-width: 10px!important;">No.</th>
                                                    <th class="text-center" style="font-size: 12px; max-width: 70px!important;">Date</th>
                                                    <th class="text-center" style="font-size: 12px; max-width: 70px!important;">Time</th>
                                                    <th class="text-center" style="font-size: 12px;">Week days</th>
                                                    <th class="text-center" style="font-size: 12px;">Total booking</th>
                                                    <th class="text-center" style="font-size: 12px;">Fees</th>
                                                    <th class="text-center" style="font-size: 12px;">validity</th>
                                                    <th class="text-center" style="font-size: 12px; width: 80px; max-width: 80px;">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(count($Get_Appointment) > 0 )
                                                    @foreach ($Get_Appointment as $key => $Appointment)
                                                        <tr class="col-12" style="position: relative;font-size: 12px; @if($Appointment->validity === 0) 'background: #fff4b0;" title="Appointment date is over'; @endif ">
                                                            <td>{{ $key+1 }}</td>
                                                            <td class="text-center">{{ date('d M y', strtotime($Appointment->start_date)) }} <br> -- to -- <br> {{ date('d M y', strtotime($Appointment->end_date)) }}</td>
                                                            <td class="text-center">{{ date('h:i a', strtotime($Appointment->start_time)) }} <br> -- to -- <br> {{ date('h:i a', strtotime($Appointment->end_time)) }}</td>
                                                            <td>{{ $Appointment->week_days }}</td>
                                                            <td class="text-center"> {{ count($Appointment->appointmentbooking) }} </td>
                                                            <td class="text-center">@if($Appointment->fees === null) {{ 'Free' }} @else {{ $Appointment->fees . ' .Tk' }} @endif</td>
                                                            @if($Appointment->validity === 1)
                                                                <td class="alert alert-info text-center">
                                                                    <div>Valid</div>
                                                                    <b>Status:</b> {{ $Appointment->booking_status }}</td>
                                                            @else
                                                                <td class="alert alert-danger text-center">Time over</td> @endif

                                                            <td style="width: 100px;">
                                                                <div style="width: 100px; margin-left: 6px;" class="row">
                                                                    {{--<button class="btn btn-sm btn-primary"><i class="fa fa-angle-down"></i></button>--}}
                                                                    <div class="btn-group btn-group-sm">
                                                                        <button type="button" style="font-size: 12px" class="btn btn-info viewBookingkBtn" data-toggle="modal" data-target=".modalBooking" data-id="{{ $Appointment->id }}" data-doc-ID="{{ $Appointment->doctor_id }}" title="View bookings"><i class="fa fa-eye"></i></button>
                                                                        {{--<a href="" style="font-size: 12px" class="col-4 btn btn-outline-info btn-sm VIEW_BOOKINGS" data-id="{{ $Appointment->id }}" data-doc-ID="{{ $Appointment->doctor_id }}" title="View bookings"><i class="fa fa-eye"></i></a>--}}
                                                                        {{--<button href="" style="font-size: 12px" class="col-4 btn btn-outline-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>--}}
                                                                        @if($Appointment->booking_status === 'open' && $Appointment->validity === 1)
                                                                            <a href="{{ url('pause_appointment|'.encrypt($Appointment->id)) }}" style="font-size: 12px" class="btn btn-warning btn-sm text-white" title="No more booking" onclick="return   confirm('Are you sure you want to stop booking for this appointment.')">
                                                                                <i class="fa fa-stop"></i>
                                                                            </a>
                                                                        @elseif($Appointment->booking_status === 'closed' && $Appointment->validity === 1)
                                                                            <a href="{{ url('start_appointment|'.encrypt($Appointment->id)) }}" style="font-size: 12px" class="btn btn-success btn-sm text-white" title="Start Booking" id="">
                                                                                <i class="fa fa-play"></i>
                                                                            </a>
                                                                        @endif
                                                                        <a href="{{ url('delete_appointment|'.encrypt($Appointment->id)) }}" style="font-size: 12px" class="btn btn-danger btn-sm text-white" title="Delete" id="Btn_Appointment_Delete">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th style="font-size: 12px;">No.</th>
                                                    <th style="font-size: 12px;">Date</th>
                                                    <th style="font-size: 12px;">Time</th>
                                                    <th style="font-size: 12px;">Week days</th>
                                                    <th class="text-center" style="font-size: 12px;">Total booking</th>
                                                    <th style="font-size: 12px;">Fees</th>
                                                    <th style="font-size: 12px;">validity</th>
                                                    <th style="font-size: 12px;">Action</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <!-- Modal -->

                                        <div class="modal fade bd-example-modal-lg modalBooking" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Appointment Booking details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="overflow-y: scroll;">
                                                        <div class="row" id="BookingData">
                                                            {{-- Load booking data --}}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <div class="col-12" style="position: relative;">
                                                        <a href="{{ urlencode('chat-box|'.encrypt($C->id)) }}" style="display: block;">
                                                            <div class="row bg-white rounded m-b-4" style="padding: 4px 10px;">
                                                                <div class="m-r-20" style="width: 40px;"><img data-src="{{ $C->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                                                <div style="width: calc(100% - 60px);">
                                                                    <div style="font-size: 12px;"><b>{{ $C->user->first_name.' '.$C->user->last_name }}</b></div>
                                                                    <div style="font-size: 12px;" class='p-l-15'>{{ htmlspecialchars($Message->conversation_text) }}</div>
                                                                    <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($Message->created_at)) }}</div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </a>
                                                        <button type="button" id="Upload_report_button" data-id="{{encrypt($C->user->id)}}" data-ConId="{{ encrypt($C->id) }}">
                                                            <i class="fa fa-file-pdf p-r-8"></i> Add Report
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="col-12 text-center alert-info">No consultations available</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="col-12 text-center alert-info">No consultations available</div>
                                        @endif

                                        <form action="{{ route('user.report') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" name="uid" id="ReportReceiver_ID" hidden value="">
                                            <input type="text" name="Conid" id="Consultation_ID" hidden value="">
                                            <input type="file" name="report" id="select_report" hidden>
                                            <button type="submit" class="btn" id="submit_report" hidden></button>
                                        </form>

                                    </div>
                                </div>
                            </div>


                            <div id="Reports_tab">
                                <div class="col-12 SlideDiv active">
                                    <div class="p-t-10 p-b-10 p-l-10 p-r-10">
                                        @if(count($Consultations) > 0)
                                            @foreach($Consultations as $Consult)
                                                <div class="col-12 bg-white">
                                                    <div class="row bg-white rounded m-b-4" style="padding: 4px 10px;">
                                                        <a href="{{ urlencode('chat-box|'.encrypt($Consult->id)) }}" style="display: block;">
                                                            <div class="m-r-20" style="width: 40px;"><img data-src="{{ $Consult->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                                        </a>
                                                        <div style="width: calc(100% - 60px);">
                                                            <div style="font-size: 12px;" class="m-b-6"><b>{{ $Consult->user->first_name.' '.$Consult->user->last_name }}</b></div>
                                                            <ul style="font-size: 12px;">
                                                                @if(count($Consult->report)>0)
                                                                    @foreach($Consult->report as $key => $GetReport)
                                                                        <li><a href="{{ $GetReport->report_file }}" target="_blank"><i class="fa fa-dot-circle p-r-6"></i> Report: {{ $key + 1 }}</a></li>
                                                                        <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($GetReport->created_at)) }}</div>
                                                                        <hr>
                                                                    @endforeach
                                                                @else
                                                                    <li>No reports created.</li>
                                                                @endif
                                                            </ul>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12 text-center alert-info">No reports created.</div>
                                        @endif

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


{{--// Page level script...--}}
<script defer>
    document.addEventListener("DOMContentLoaded", (event) => {
        @if(session('Error_create_Appointment'))
        $(document).ready(function () {
            $('#CreateAppointmentModal').modal('toggle')
        });
        @endif
        @if(count($Data->doctor->appointment) >= 3)
        $(document).ready(function () { // Disable modal if total appointment count is 3
            $('#CreateAppointmentBtn').removeAttr("data-target");
            $('#CreateAppointmentBtn').click(function () {
                $(this).removeAttr("data-target");
                swal(
                    'OOps!',
                    'You already have created Three appointments, which have validity. You can not create more.',
                    'error'
                )
            });
        });
        @endif
    });
</script>


<script type="text/javascript" src="{{ asset('asset_front/js/kronos-date-picker.js') }}" defer></script>
<script type="text/javascript" src="{{ asset('asset_front/js/mdtimepicker.js') }}" defer></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js" defer></script>
<script src="{{ asset('asset_front/js/time_plugin.js') }}" defer></script>

<!-- date picker -->
<script defer>
    document.addEventListener("DOMContentLoaded", (event) => {

        $('#Start_Date').kronos({
            periodTo: '#End_Date'
        });
        $('#End_Date').kronos({
            periodFrom: '#Start_Date'
        });

        $(document).ready(function () {
            $('#start_time_picker').mdtimepicker();
        });

        $('#start_time_picker').mdtimepicker({
            // format of the time value (data-time attribute)
            timeFormat: 'HH:mm:ss .000',
            // format of the input value
            format: 'h:mm tt',
            // theme of the timepicker
            // 'red', 'purple', 'indigo', 'teal', 'green'
            theme: 'blue',
            // determines if input is readonly
            readOnly: true,
            // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
            hourPadding: false
        });


        $(document).ready(function () {
            $('#end_time_picker').mdtimepicker();
        });

        $('#end_time_picker').mdtimepicker({
            // format of the time value (data-time attribute)
            timeFormat: 'HH:mm:ss.000',
            // format of the input value
            format: 'h:mm tt',
            // theme of the timepicker
            // 'red', 'purple', 'indigo', 'teal', 'green'
            theme: 'teal',
            // determines if input is readonly
            readOnly: true,
            // determines if display value has zero padding for hour value less than 10 (i.e. 05:30 PM); 24-hour format has padding by default
            hourPadding: false
        });

        /*$("#date_time_piker_wheel").timerangewheel({
            width: 180,
            height: 180,
            margin: { top:20, left:20, bottom:20, right:20 },
            offset: 50,
            rangeTotal: 12,
            indicatorWidth: 10,
            handleRadius: 12,
            handleStrokeWidth: 1,
            accentColor: '#2C3E50',
            handleIconColor: "#fff",
            handleStrokeColor: "#fff",
            handleFillColorStart: "#3acbd8",
            handleFillColorEnd: "#3ad896",
            tickColor: "#8a9097",
            indicatorBackgroundColor: "#3a7cd8",
            data: {"start": "{{-- old('Start_Time', '02:00') --}}", "end": "{{-- old('End_Time', '06:00') --}}" },
        onChange: function (timeObj) {
            $("#start_time_picker").val(timeObj.start);
            $("#end_time_picker").val(timeObj.end);
            $("#TotalDuration").html("Total Duration: <b>" + timeObj.duration + " hrs</b>");
        }
    });*/


        $("#Booking_Start_Date").dateTimePicker({
            limitMin: Date(), mode: 'date',
        });

        $('#Create_Appointment').on('click', function (e) {
            if ($('#Start_Date').val() === '' || $('#End_Date').val() === '' || $('#Booking_Start_Date').val() === '') {
                alert('please insert all the date fields.');
                return false;
            } else {
                return true;
            }
        });

    });
</script>

<script defer>
    $(document).ready(function () {


        $('#Btn_Appointment_Delete').on("click", function (e) {
            if (confirm("Are you sure you want to delete this appointment.")) {
                return true;
            } else {
                return false;
            }
            e.preventDefault();
        });


        /*$('#Show_Bookings').hide();

        $("body").on("click", ".VIEW_BOOKINGS", function (e) {
            let Appointment_id = $(this).attr("data-id");
            let Doctor_id = $(this).attr("data-doc-ID");
            //alert(Appointment_id + 'hello');
            $('#Show_Bookings').slideDown("slow");
            e.preventDefault();

            $.ajax({
                type: "GET",
                method: "GET",
                url: "",
                data: {"appointment_id": Appointment_id.val(), "doctor_id": Doctor_id.val()}
            }).done(function (result) {
                if (result.error === false) {
                    // No errors
                    $('#TBody').html(result);
                } else {
                    // There is an error
                    $('#TBody').html(result);
                }
            });
        });*/


        $('body').on('click', ".viewBookingkBtn", function () {
            let Appointment_id = $(this).attr("data-id");
            let Doctor_id = $(this).attr("data-doc-ID");
            $.ajax({
                type: "GET",
                method: "GET",
                url: "{{ url('user/show-appointment-bookings') }}",
                data: {"appointment_id": Appointment_id, "doctor_id": Doctor_id}
            }).done(function (result) {
                if (result.error === false) {
                    // No errors
                    $('#BookingData').html(result);
                } else {
                    // There is an error
                    $('#BookingData').html(result);
                    //console.log(result);
                }
            });
        });


        // Upload report ....
        $('#Upload_report_button').click(function () {
            let id = $(this).attr('data-id');
            let Conid = $(this).attr('data-ConId');
            $('#ReportReceiver_ID').val(id);
            $('#Consultation_ID').val(Conid);
            /*alert(Conid);
            alert(id);*/

            $('#select_report').trigger("click");
        });

        $("#select_report").change(function () {
            $("#submit_report").trigger("click");
        });

        $("#submit_report").click(function () {
            $(this).submit();
        });


    });
</script>
