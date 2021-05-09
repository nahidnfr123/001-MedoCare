@extends('layouts.app_front')

{{--<link rel="stylesheet" href="{{ asset('asset_back/css/join_us_form.css') }}">--}}

@section('title')
    @php $title = 'Join Us'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')
    <!-- Body content -->
    <div id="MainContent">


        <div class="container">
            <br>
            <div class="card bg-light" style="min-height: 300px;">


                <!-- Doctor join in form -->
                <article class="card-body mx-auto col-12" id="Doctor_form">
                    <h4 class="card-title text-center col-12">Hey 'Doctor' join us now</h4>
                    <p class="text-center">Get started with your free account. Fill out the form...</p>
                    <p class="divider-text">
                        <span class="bg-light"> | </span>
                    </p>
                    <form action="{{ route('join_doctor') }}" method="post" enctype="multipart/form-data" class="form doctor-needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class=" col-12 col-md-6 col-lg-6">

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <div class="input-group-prepend"><span class="input-group-text">Dr. </span></div>
                                    <input id="name" name="full_name" pattern="[a-zA-Z ]{6,}" title="Please enter your full name" class="form-control" placeholder="Full name...." minlength="3" type="text" required value="{{ old('full_name') }}">
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                    </div>
                                    <input name="email" class="form-control" pattern="[a-zA-Z0-9_]{3,}@[a-zA-Z]{3,}[.]{1}[a-zA-Z]{2,}" placeholder="Email address...." type="email" required value="{{ old('email') }}">
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="password" class="form-control" placeholder="Password...." minlength="8" maxlength="60" type="password" required>
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input name="password_confirmation" class="form-control" placeholder="Re-type password...." minlength="8" maxlength="60" type="password" required>
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-birthday-cake"></i> </span>
                                    </div>
                                    <label for=""></label>
                                    <input class="form-control" placeholder="Date of birth...." name="dob" maxlength="10" type="text" id="datepicker_doc" required  value="{{ old('dob') }}">
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                    </div>
                                    <input name="phone" class="form-control" pattern="[0-9]{11,}" placeholder="Phone number...." type="text" minlength="11" maxlength="11" required  value="{{ old('phone') }}">
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-restroom"></i> </span>
                                    </div>
                                    <div class="widget form-control" style="height: 46px;">
                                        <fieldset>
                                            <label for="radio-3"><i class="fa fa-male"></i> Male </label>
                                            <input type="radio" name="gender" value="male" id="radio-3" class="Gender" required @if(old('gender') === 'male') {{ 'checked' }} @endif>
                                            <label for="radio-4"><i class="fa fa-female"></i> Female </label>
                                            <input type="radio" name="gender" value="female" id="radio-4" class="Gender" required @if(old('gender') === 'female') {{ 'checked' }} @endif>
                                        </fieldset>
                                    </div>
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-image"></i> </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="Profile_Image" id="select_image_doc" required onchange="document.getElementById('pro_img_doc').src = window.URL.createObjectURL(this.files[0]); Validate_preview_image_doc();">
                                        <label class="custom-file-label" type="text" id="trigger_image_doc" for="select_image_doc">Profile image .... </label>
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 col-lg-6 col-md-6" style="clear:both;">

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-flag"></i> </span>
                                    </div>
                                    <input type="text" name="nationality" placeholder="Nationality" value="{{ old('nationality') }}" id="Nationality" required class="form-control">
                                </div>


                                {{-- Get user location --}}
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-globe-americas"></i> </span>
                                    </div>
                                    <input type="text" name="location" placeholder="Location: Country, City, Division" value="{{ old('auto_locate') }}{{old('location')}}" id="location" required class="form-control">
                                    <div class="input-group-prepend">
                                        <a id="Autodetect" style="cursor: pointer;">
                                            <span class="input-group-text"> Auto detect </span>
                                        </a>
                                    </div>
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user-graduate"></i> </span>
                                    </div>
                                    <input name="education" class="form-control" placeholder="Educational qualification: MBBS, PHD etc" type="text" minlength="3" required value="{{ old('education') }}">
                                </div>

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                    </div>
                                    <input name="work_place_name" class="form-control" placeholder="Work place name: Dhaka Medical Hospital" type="text" minlength="5" required value="{{ old('work_place_name') }}">
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-network-wired"></i> </span>
                                    </div>
                                    <label for="Department_lbl"></label>
                                    <select class="form-control" name="department" id="Department_lbl" required>
                                        <option value="" disabled @if(old('department') === null) {{ 'selected' }}@endif> Select department </option>
                                        @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if(old('department') === $department->id) {{ 'selected' }}@endif>{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-brain"></i> </span>
                                    </div>
                                    <input name="experience" class="form-control" pattern="[0-9]{2,}" placeholder="Experience in years...." type="number" minlength="2" required value="{{ old('experience') }}">
                                </div>

                                <!--
                                <div class="form-group input-group" style="margin-bottom: 22px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-file-pdf"></i> </span>
                                    </div>
                                    <label for=""></label>
                                    <label class="form-control" type="text" id="trigger_file" for="select_file">Work place document (.pdf)....</label>
                                    <input name="Work_Document" class="form-control" type="file" hidden id="select_file" required onchange="Validate_preview_file();">
                                    <div class="col-12" style="font-size: 12px; color: coral;">
                                        (*) This is most important. Your join request approval depends on this document.
                                        <a href="question/why_join_as_doc.php" target="_blank">Learn more</a>
                                    </div>
                                </div>
                                -->

                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-file-pdf"></i> </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="Work_Document" hidden id="select_file" required onchange="Validate_preview_file();">
                                        <label class="custom-file-label" type="text" id="trigger_file" for="select_file">Work place document (.pdf)....</label>
                                    </div>
                                    <div class="col-12" style="font-size: 11.5px; color: coral;">
                                        (*) This is most important. Your join request approval depends on this document.
                                        <a href="{{ route('work-document') }}" target="_blank">Learn more</a>
                                    </div>
                                </div>

                            </div>
                            <div class="container row preview_doc">
                                <div class="col-12 col-md-6 col-lg-6">Preview:<br> <img src="" id="pro_img_doc" alt=""></div>
                                <div class="col-12 col-md-6 col-lg-6"><br><iframe id="document_viewer" scrolling="no"></iframe></div>
                            </div>
                        </div>
                        <br>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="terms_doc" value="Accepted" name="terms_and_condition"  required @if(old('terms_and_condition') === 'Accepted') {{ 'checked' }} @endif>
                                <label class="custom-control-label" for="terms_doc">I have agreed to the terms and conditions. <a href="{{ route('terms-condition') }}" target="_blank">Terms and condition.</a></label>
                                <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                            </div>

                            <!--
                            <div class="col-12 col-lg-12 col-md-12">
                                <input type="checkbox" value="Accepted" name="terms_and_condition" id="terms_doc" required <?php //if(isset($_SESSION['Doc_Join_Form_Data']) && $_SESSION['Doc_Join_Form_Data']['Agreed']==='Accepted'){echo 'checked';}?>>
                                <label for="terms_doc"> I have agreed to the terms and conditions. <a href="terms_doc.php" target="_blank">Terms and condition.</a></label>
                            </div>
                            -->
                            <button type="submit" class="btn btn-primary btn-block" id="Create_doc_btn" name="Create_Doctor_Account"> Create Account  </button>
                        </div> <!-- form-group// -->
                        <p class="text-center">Have an account? <a href="{{ url('login') }}">Log In</a> </p>
                    </form>
                </article>

            </div>
        </div>
        <br>
    </div>
@stop


@section('Page_Level_Script')

    <script>
        // form validation ...
        // Trim text field value ....
        /*$(document).ready(function(){
            $('.doctor-needs-validation').submit(function(){
                $(':input').each(function(){
                    $(this).val($.trim($(this).val()))
                }, false);
            });
        });*/
        // Bootstrap validation ....
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.getElementsByClassName('doctor-needs-validation');
                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        $(':input').each(function(){
                            $(this).val($.trim($(this).val()))
                        }, false);
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>


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
