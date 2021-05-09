@extends('layouts.app_back')

@section('title')
    @php $title = 'Profile'; @endphp
    @php $subTitle = ''; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row m-b-lg m-t-lg">
            <div class="col-md-9">

                <div class="profile-image">
                    <img src="{{ Auth::user()->avatar }}" class="rounded-circle circle-border m-b-md" alt="profile" style="object-fit: cover; object-position: center center;">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                            </h2>
                            <h4></h4>
                            <small>
                                Account details
                            </small>
                            <hr>
                            <div class="col-12">
                                <div><b>Email:</b> {{ Auth::user()->email }}</div><br>
                                <div><b>Phone:</b> {{ Auth::user()->phone }}</div><br>
                                <div><b>Gender:</b> {{ ucwords(Auth::user()->gender) }}</div><br>
                                <div><b>Date of birth:</b> {{ date('d-M-Y', strtotime(Auth::user()->dob)) }}</div><br>
                                <div><b>Location:</b>
                                    @php
                                        if(Auth::user()->location !== null){
                                            $Location = Auth::user()->location;
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
                                    {{ $Location }}</div><br>
                                <div><b>Address:</b> {{ Auth::user()->address }}</div><br>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a class="btn btn-sm btn-default" href="#edit_profile" data-toggle="modal"><i class="fa fa-edit"></i> Edit Profile</a>
                <a class="btn btn-sm btn-default" href="#edit_password" data-toggle="modal"><i class="fa fa-lock"></i> Change Password</a>
            </div>
        </div>
    </div>




    {{-- Edit profile div --}}
    <div id="edit_profile" class="modal fade" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 b-r">
                            <form role="form" id="edit_form" action="{{ route('admin.profile-update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{--@method('PUT')--}}
                                <div id="Show_Form_Content">

                                    <div class="form-group">
                                        <label for="" >Phone*:</label>
                                        <input type="text" name="phone" id="phone" placeholder="019XXXXXXXX" class="form-control required @error('phone') is-invalid @enderror" required  value="{{ old('phone', Auth::user()->phone) }}">
                                    </div>
                                    {{-- Get user location --}}
                                    <label for="">Location:</label>
                                    <div class="form-group input-group">
                                        <input type="text" name="location" placeholder="Location: Country, City, Division" value="{{old('location', $Location)}}" id="location" class="form-control">
                                        <div class="input-group-prepend">
                                            <a id="Autodetect" style="cursor: pointer;">
                                                <span class="input-group-text"> Auto detect </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" >Address:</label>
                                        <input type="text" name="address" id="address" placeholder="Kalabagan dhaka 1250" class="form-control required @error('address') is-invalid @enderror" value="{{ old('address', Auth::user()->address) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="" >Profile image:</label>
                                        <input type="file" name="image" id="image" class="form-control required @error('image') is-invalid @enderror">
                                    </div>

                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit" name="Add_New_Department"><strong>Update profile</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div id="edit_password" class="modal fade" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 b-r">
                            <form role="form" id="edit_form" action="{{ route('admin.change-password') }}" method="post" enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="col-12">
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
                                    <button type="submit" class="btn btn-sm btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop


@section('Page_Level_script')
    @if(session('Error_updateProfile')) // edit for old data show problem ...
    <script>
        $(document).ready(function () {
            $('#edit_profile').modal('toggle');
            createEditor(); // Create CK editor ....
        });
    </script>
    @endif
@if(session('Error_ChangePassword')) // edit for old data show problem ...
    <script>
        $(document).ready(function () {
            $('#edit_password').modal('toggle');
            createEditor(); // Create CK editor ....
        });
    </script>
    @endif

    <script>
        $(document).ready(function () {
            $('#Autodetect').click(function (event) {
                event.preventDefault();
                $('#location').attr('name', 'auto_locate');
                $('#location').fadeOut();
                $('#location').val('');
                $('#location').val("{{ $arr_ip->country .', '. $arr_ip->city .', '.$arr_ip->state_name }}");
                $('#location').fadeIn('slow');
                $("#location").css("background-color", "#fff");
            });
        });
        $("#location").keydown(function(){
            $("#location").css("background-color", "#ddd");
            $('#location').attr('name', 'location');
            if($('#location').val() === ''){
                $("#location").css("background-color", "#888");
            }
        });
    </script>

@stop
