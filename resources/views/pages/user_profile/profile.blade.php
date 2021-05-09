@extends('layouts.app_front')

@section('title')
    @php $title = 'Profile'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')


    @if(Auth::check() && Auth::user()->role()->pluck('name')->first() === 'Patient')
        @include('pages.user_profile.patient_profile', ['data' => $Data])
    @elseif(Auth::check() && Auth::user()->role()->pluck('name')->first() === 'Doctor')
        @include('pages.user_profile.doctor_profile', ['data' => $Data])
    @endif


@stop



@section('Page_Level_Script')

    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <script src="{{ asset('asset_front/js/Cross-browser-Date-Time-Selector-For-jQuery-dateTimePicker/dist/date-time-picker.min.js') }}" defer></script>

    {{--<script src="{{ asset('js/jquery.countdown.min.js') }}" defer></script>--}}
    <script src="{{ asset('js/dscountdown.min.js') }}" defer></script>
    {{--<script src="{{ asset('js/jquery.downCount.js') }}"></script>--}}
    <script defer>
        $(function () {
            $("#tabs").tabs({
                heightStyle: "fill",
                collapsible: false,
                /*hide:"slideUp",*/
                /*event:"mouseover",*/
                active: 1,
                @if(session('Error_edit_profile')) active: 0, @endif
                    @if(session('Error_create_Appointment')) active: 1, @endif
            });
        });

        $("#go-down").click(function (e) {
            e.preventDefault();
            var aid = $(this).attr("href");
            $('html,body').animate({scrollTop: ($(aid).offset().top) - 100}, 'slow');
            $('#Profile_Information_tab').animate({scrollTop: ($(aid).offset().top) + 300}, 'slow');
        });


        $('[data-countdown]').empty();
        jQuery(document).ready(function ($) {
            $('[data-countdown]').each(function () {
                var $this = $(this), finalDate = $(this).data('countdown');
                let URL = $(this).data('url');
                $(this).empty();
                $(this).dsCountDown({
                    endDate: new Date(finalDate),
                    theme: 'white',
                    titleDays: 'Days',// Set the title of days
                    titleHours: 'hr',// Set the title of hours
                    titleMinutes: 'min',// Set the title of minutes
                    titleSeconds: 'sec',// Set the title of seconds
                    onBevoreStart: null,// callback before the count down starts
                    onClocking: null,// callback after the timer just clocked
                    onFinish: function () {
                        window.location.href = URL;
                    }
                });
            });
        });


        /*$('.countdown').downCount({
            date: '08/27/2013 12:00:00',
            offset: -5
        }, function () {
            alert('WOOT WOOT, done!');
        });*/
        /*$(function(){
            $('[data-countdown]').each(function() {
                var $this = $(this), finalDate = $(this).data('countdown');
                $this.countdown(finalDate, function(event) {
                    $this.html(event.strftime('%D days %H:%M:%S'))}).on('finish.countdown', function() {
                    alert("Finish");
                });
            });
        });*/

    </script>


    <!-- page level script -->
    <script defer>
        // profile picture upload ...
        $(document).ready(function () {
            //$("#my_profile_picture").load("includes/get_profile-pic.php");

            $(" #open_file_Dialog_2").click(function () {
                $('#select_Profile_Pic_file').trigger("click");
            });

            $("#select_Profile_Pic_file").change(function () {
                $("#submit_profile_image_file").trigger("click");
            });

            $("#submit_profile_image_file").click(function () {
                $(this).submit();
            });

            /*$("#submit_profile_image_file").submit(function(){
                $("#my_profile_picture").load("includes/get_profile-pic.php");
            });*/
        });
    </script>

    <script defer> // Auto locate button
        $(document).ready(function () {
            $('#Autodetect').click(function (event) {
                event.preventDefault();
                $('#Location').attr('name', 'auto_locate');
                $('#Location').fadeOut();
                $('#Location').val('');
                $('#Location').val("{{ $arr_ip->country .', '. $arr_ip->city .', '.$arr_ip->state_name }}");
                $('#Location').fadeIn('slow');
                $("#Location").css("background-color", "#fff");
            });
        });
        $("#Location").keydown(function () {
            $("#Location").css("background-color", "#ddd");
            $('#Location').attr('name', 'Location');
            if ($('#Location').val() === '') {
                $("#Location").css("background-color", "#888");
            }
        });


        $('#password_textbox').slideUp('slower');

        function Show_Password_Form() {
            if ($('#change_password_chk').is(':checked')) {
                $('#password_textbox').slideDown('slower');
            } else {
                $('#password_textbox').slideUp('slower');
                $('#old_password').val('');
                $('#new_password').val('');
                $('#new_password_confirmation').val('');
            }
        }

        Show_Password_Form();
        $('#change_password_chk').on("click", function () {
            Show_Password_Form();
        });
    </script>

    <script defer>

        /*$(document).ready(function () {

            let Account = $('.Account_Info');
            let Appointment = $('.Appointments');
            let Consultation = $('.Consultation');

            Account.fadeIn(300).addClass('active');

            $('#btn_Account_Info').click(function () {
                Account.fadeIn(300).addClass('active');
                Appointment.fadeOut(300).removeClass('active');
                Consultation.fadeOut(300).removeClass('active');
            });
            $('#btn_Appointment').click(function () {
                Appointment.fadeIn(300).addClass('active');
                Account.fadeOut(300).removeClass('active');
                Consultation.fadeOut(300).removeClass('active');
            });
            $('#btn_Consultation').click(function () {
                Consultation.fadeIn(300).addClass('active');
                Account.fadeOut(300).removeClass('active');
                Appointment.fadeOut(300).removeClass('active');
            });
        });*/


        $('#Update_Profile_buttons').hide();
        $('#Password_reset_fields').hide();
        $(".AutoDetectLocation").hide();
        //Enable text-box and upload button on clicking edit button ...
        $('#btn_Edit_Profile').click(function () {
            $('#User_Data_Update_Form :input').each(function () {
                $(this).removeAttr('disabled');
                $('#About').removeAttr('disabled');
                $('#Update_Profile_buttons').fadeIn("slower");
                $('#Password_reset_fields').fadeIn("slower");
                $(".AutoDetectLocation").fadeIn("slower");
            });
        });

        // disable update form
        $('#Disable_Update_form').click(function () {
            $('#User_Data_Update_Form :input').each(function () {
                $(this).attr('disabled', 'disabled');
                $('#About').attr('disabled');
                $('#Update_Profile_buttons').fadeOut("slower");
                $('#Password_reset_fields').fadeOut("slower");
                window.location.href = '{{ route('user.user-profile') }}';
            });
        });

        // if error occurs while updating the profile ....
        @if(session()->has('Error_edit_profile'))
        $('#User_Data_Update_Form :input').each(function () {
            $(this).removeAttr('disabled');
            $('#About').removeAttr('disabled');
            $('#Update_Profile_buttons').fadeIn("slower");
            $(".AutoDetectLocation").fadeIn("slower");
            $('#Password_reset_fields').fadeIn("slower");

            $('.Account_Info').fadeIn(300).addClass('active');
            $('.Appointments').fadeOut(300).removeClass('active');
            $('.Consultation').fadeOut(300).removeClass('active');
        });
        @endif


        // form validation ...
        // Trim text field value ....
        $(document).ready(function () {
            $('.User_Frm_Data').submit(function () {
                $(':input').each(function () {
                    $(this).val($.trim($(this).val()))
                }, false);
            });
        });
        // Bootstrap form validation ....
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.getElementsByClassName('User_Frm_Data');
                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();


        // Create appointment part ...
        $(document).ready(function () {
            @if($errors->any() || session()->has('Error'))
            /*$('#Create_appointment :input').each(function () {
                $('.Account_Info').fadeOut(300).removeClass('active');
                $('.Appointments').fadeIn(300).addClass('active');
                $('.Consultation').fadeOut(300).removeClass('active');

                $("#AppointmentType").val(' //$_SESSION['CreateAppointment']['App_type']?>');
                $('.Create_appointment').slideToggle(0);
                $('.Appointment_Input_fields').slideDown(0);
            });*/
            @endif



            $(document).ready(function () {
                $('#Appointment_Table').DataTable({
                    ordering: false,
                    responsive: true,
                });
            });


            /*$('.Appointment_Input_fields').hide();
            // Show form fields on changing online and offline appointment ....
            $('#AppointmentType').change(function () {
                let Fees = $('#Fees');
                if($(this).val() === 0){
                    $('.Appointment_Input_fields').hide();
                }
                else if($(this).val() == 1){
                    $('.Appointment_Input_fields').slideDown("slow");
                    Fees.attr('disabled','disabled');
                    Fees.val('000.Tk   Online consultations are generally free.');
                }
                else if($(this).val() == 2){
                    $('.Appointment_Input_fields').slideDown("slow");
                    Fees.removeAttr('disabled');
                    Fees.val('');
                }
            });*/
        });


        // form validation ...
        // Trim text field value ....
        $(document).ready(function () {
            $('.Create_appointment').submit(function () {
                $(':input').each(function () {
                    $(this).val($.trim($(this).val()))
                }, false);
            });
        });
        // Bootstrap validation ....
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.getElementsByClassName('Create_appointment');
                // Loop over them and prevent submission
                let validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        // Bootstrap ///// form validation ...

    </script>


    <script defer>
        $("#Booking_History").hide();
        $(document).ready(function () {
            $("#Custom_DropDown").click(function () {
                $("#Booking_History").toggle(function () {
                    if ($("#Custom_DropDown").html() == '<i class="fa fa-angle-up"></i>') {
                        $("#Custom_DropDown").html('<i class="fa fa-angle-down"></i>');
                    } else {
                        $("#Custom_DropDown").html('<i class="fa fa-angle-up"></i>');
                    }
                    $("this").slideDown('slow');
                });
            });
        });
    </script>
@stop
