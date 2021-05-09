@extends('layouts.app_front')

@section('title')
    @php $title = 'Chat Box'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')

    <style>
        div.Time{
            font-size: 10px;
            /*color:greenyellow;*/
            background-color: #dddddd;
            border-radius: 10px;
            width: 120px;
            text-align: center;
            margin-top: 5px;
        }
    </style>


    @if(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Patient')
        <div class="ChatBoxWrapper">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3 p-t-10" id="ShowAllMessages"> {{-- All messages list --}}
                    @if(count($Consultations) > 0)
                        <h5 class="text-center text-info m-b-6">All conversations.</h5>
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
                            @if ($Message != null)
                                @php
                                    $string = strip_tags(htmlspecialchars($Message->conversation_text));
                                   if (strlen($string) > 20) {
                                       // truncate string
                                       $stringCut = substr($string, 0, 100);
                                       $endPoint = strrpos($stringCut, ' ');
                                       //if the string doesn't contain any space then it will cut without word basis.
                                       $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                       $string .= '... ';
                                   }
                                @endphp
                                <a href="{{ urlencode('chat-box|'.encrypt($C->id)) }}">
                                    <div class="row bg-gray rounded m-b-4" style="padding: 4px 10px;">
                                        <div class="m-r-20" style="width: 40px;"><img data-src="{{ $C->doctor->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                        <div style="width: calc(100% - 60px);">
                                            <div style="font-size: 12px;"><b>Dr. {{ $C->doctor->user->first_name.' '.$C->doctor->user->last_name }}</b></div>
                                            <div style="font-size: 12px;" class='p-l-15'>{{ $string }}</div>
                                            <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($Message->created_at)) }}</div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <div class="col-12 text-center alert-info rounder" style="padding: 10px">No conversations available</div>
                    @endif
                </div>

                <div class="col-12 col-md-9 col-lg-9 col-xl-9 bg-muted" id="ChatBoxContainer">{{-- show messages --}}

                    <div class="col-12 ChatHeader">
                        <div class="row vertical-align col-12" style="width:100%;height: 50px;line-height: 50px;padding-top: 6px;">
                            <img data-src="{{ $User_data->avatar }}" class="rounded-circle m-r-20" alt="" height="46" width="46" style="margin:2px;padding:2px; box-shadow: 0 0 4px rgba(20,20,20, .6); object-fit: cover; object-position: center top;">
                            <div class="m-l-10">
                                <a href="{{url('doctors-details|') . encrypt($User_data->id)}}" target="_blank">
                                <div class="font-bold" style="font-size: 14px;">{{ 'Dr. ' . $User_data->first_name.' '.$User_data->last_name  }}</div>
                                </a>
                            </div>
                            <div class="float-right m-l-5">

                                @php
                                    $Get_status = $User_data->doctor->consultation()->findOrFail($Consultation_id);
                                    $URL = urlencode('chat-box|'.encrypt($CheckStatus->id));
                                    //$Date_time = \Carbon\Carbon::parse($RawDate)->format('Y-m-d h:i:s'); // This dosent work
                                //echo $Date_time . '<br>';
                                //echo \Carbon\Carbon::now()->format('Y-m-d H:i:s') . '<br>';
                                //echo \Carbon\Carbon::parse($Date_time)->addMinutes(25)->format('F d Y h:i:s');
                                @endphp
                                @if(\Carbon\Carbon::now()->format('Y-m-d H:i:s') < $Date_time  && $CheckStatus->status == 'pending')
                                    <div class="col-12 text-info Timer text-center" data-countdown="{{ $Date_time }}" data-url="{{ $URL }}"></div>
                                @elseif($CheckStatus->status == 'in progress')
                                    <div class="col-12 text-info Timer text-center" data-countdown="{{ \Carbon\Carbon::parse($Date_time)->addMinutes(25)->format('F d Y H:i:s') }}" data-url="{{ $URL }}"></div>
                                @elseif($CheckStatus->status == 'session end')
                                    <div class="col-12 text-info text-center" style="font-size: 12px">(Session End)</div>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="ChatBody col-12">
                        <div id="MessageContent" style="overflow-y: scroll; max-height: 360px; min-height: 300px">
                            <div class="bg-white" style="padding: 2px;width: 100%;" {{--id="GetMsg"--}}>
                                <ul style="width: 100%;" id="GetMsg">

                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="ChatFooter col-12">
                        @if($CheckStatus !== null)
                            @php
                                $Date = $CheckStatus->booked_date . ' ' . $CheckStatus->booked_time;
                            @endphp
                            @if( \Carbon\Carbon::now()->subMinutes(25)->format('Y-m-d H:i:s') < $Date && \Carbon\Carbon::now()->format('Y-m-d H:i:s') > $Date )
                                <div id="GetMsg"></div>
                                <form action="" method="post" enctype="multipart/form-data" class="SendMessageForm">
                                    @csrf
                                    <div class="inline" style="">
                                        <textarea name="message" id="Message_Textbox" cols="0" rows="3" class="rounded" placeholder="Type your message here ..." ></textarea>
                                    </div>

                                    {{-- Upload report button --}}
                                    <button type="button" class="btn btn-light" style="position:absolute; top: 100%;" id="open_file_Dialog"><i class="fa fa-camera"></i> Upload report </button>
                                </form>

                                <form action="{{ route('user.report_history') }}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="hidden" name="Receiver_id" value="{{ $User_data->id }}" hidden required readonly>
                                    <input type="hidden" name="Consultation_id" value="{{ $Consultation_id }}" hidden required readonly>
                                     {{-- Upload report field --}}
                                    <div style="position:absolute; top: 100%;">
                                        <input type="file" name="Report_file" id="select_report" hidden>
                                        <button type="submit" class="btn" id="submit_report" name="UploadProfilePic" title="Upload report" hidden></button>
                                    </div>
                                </form>

                            @elseif(\Carbon\Carbon::now()->format('Y-m-d H:i:s') < $Date)
                                <div class="alert alert-danger text-center col-12">
                                    Consultation time starts at: {{ \Carbon\Carbon::parse($CheckStatus->booked_date . ' ' . $CheckStatus->booked_time)->format('d-M-y h:i a') }}
                                </div>
                            @else
                                <div class="alert alert-danger text-center col-12">
                                    You cannot talk to the doctor. -- <d>Session Ended</d> at:-
                                    {{--@php
                                        $to = \Carbon\Carbon::now();
                                        $from = \Carbon\Carbon::create(date('Y', strtotime($CheckStatus->booked_date)),date('m', strtotime($CheckStatus->booked_date)),date('d', strtotime($CheckStatus->booked_date)),date('h', strtotime($CheckStatus->booked_time)),date('i', strtotime($CheckStatus->booked_time)), 00);
                                        $diff_in_minutes = $to->diffInSeconds($from);
                                    @endphp--}}
                                    {{ \Carbon\Carbon::parse($CheckStatus->booked_date . ' ' . $CheckStatus->booked_time)->addMinutes(25)->format('d-M-y h:i a') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                {{--<div class="col-3" id="ChatExtraInfo">--}}{{-- message other information --}}{{--
                    other message info
                </div>--}}
            </div>
        </div>




    @elseif(Auth::check() && Auth::user()->role()->pluck('name')->first() == 'Doctor')
        <div class="ChatBoxWrapper">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3 p-t-10" id="ShowAllMessages">
                    @if(count($Consultations) > 0)
                        <h5 class="text-center text-info m-b-6">All Consultations.</h5>
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
                                    <div class="row bg-gray rounded m-b-4" style="padding: 4px 10px;">
                                        <div class="m-r-20" style="width: 40px;"><img data-src="{{ $C->user->avatar }}" alt="" height="40" width="40" class="rounded-circle" style="object-fit: cover;object-position: center top;"></div>
                                        <div style="width: calc(100% - 60px);">
                                            <div style="font-size: 12px;"><b>{{ $C->user->first_name.' '.$C->user->last_name }}</b></div>
                                            <div style="font-size: 12px;" class='p-l-15'>{{ htmlspecialchars($Message->conversation_text) }}</div>
                                            <div class="float-right text-muted" style="font-size: 12px;">{{ date('d-M-y h:i a', strtotime($Message->created_at)) }}</div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <div class="col-12 text-center alert-info">No consultations completed.</div>
                    @endif
                </div>

                <div class="col-12 col-md-9 col-lg-9 col-xl-9 bg-muted" id="ChatBoxContainer">{{-- show messages --}}

                    <div class="col-12 ChatHeader">
                        <div class="row vertical-align col-12" style="width:100%;height: 50px;line-height: 50px;">
                            <img data-src="{{ $User_data->avatar }}" class="rounded-circle m-r-20" alt="" height="46" width="46" style="margin:2px;padding:2px; box-shadow: 0 0 4px rgba(20,20,20, .6); object-fit: cover; object-position: center top;">
                            <div class="m-l-10">
                                <a href="" target="_blank">
                                    <div class="font-bold" style="font-size: 14px;">{{ $User_data->first_name.' '.$User_data->last_name  }}</div>
                                </a>
                            </div>
                            <div class="float-right m-l-10">

                                @php
                                    $Get_status = $User_data->consultation()->findOrFail($Consultation_id);
                                    $URL = urlencode('chat-box|'.encrypt($CheckStatus->id));
                                    //$Date_time = \Carbon\Carbon::parse($RawDate)->format('Y-m-d h:i:s'); // This dosent work
                                /*echo $Date_time . '<br>';
                                echo \Carbon\Carbon::parse($Date_time)->addMinutes(25)->format('F d Y h:i:s');*/
                                @endphp
                                @if(\Carbon\Carbon::now()->format('H:i:s') < $Date_time  && $CheckStatus->status == 'pending')
                                    <div class="col-12 text-info Timer text-center" data-countdown="{{ $Date_time }}" data-url="{{ $URL }}"></div>
                                @elseif($CheckStatus->status == 'session end')
                                    <div class="col-12 text-info text-center" style="font-size: 12px">(Session End)</div>
                                @else
                                    <div class="col-12 text-info Timer text-center" data-countdown="{{ \Carbon\Carbon::parse($Date_time)->addMinutes(25)->format('F d Y H:i:s') }}" data-url="{{ $URL }}"></div>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="ChatBody col-12">
                        <div id="MessageContent" style="overflow-y: scroll; max-height: 300px;">
                            <div class="bg-white" style="padding: 2px;width: 100%;" {{--id="GetMsg"--}}>
                                <ul style="width: 100%;" id="GetMsg">

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="ChatFooter col-12">
                        <form action="" method="post" enctype="multipart/form-data" class="SendMessageForm">
                            @csrf
                            <div class="inline" style="">
                                <textarea name="message" id="Message_Textbox" cols="0" rows="3" class="rounded" placeholder="Type your message here ..." ></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                {{--<div class="col-3" id="ChatExtraInfo">--}}{{-- message other information --}}{{--
                    other message info
                </div>--}}
            </div>
        </div>
    @endif




@stop



@section('Page_Level_Script')
    <script src="{{ asset('js/dscountdown.min.js') }}"></script>
    <script>
        $('[data-countdown]').empty();
        jQuery(document).ready(function($){
            $('[data-countdown]').each(function() {
                var $this = $(this),finalDate = $(this).data('countdown');
                let URL = $(this).data('url');
                $(this).empty();
                $(this).dsCountDown({
                    endDate: new Date(finalDate),
                    theme:'flat',
                    titleDays:'',// Set the title of days
                    titleHours:'',// Set the title of hours
                    titleMinutes:'',// Set the title of minutes
                    titleSeconds:'',// Set the title of seconds
                    onBevoreStart:null,// callback before the count down starts
                    onClocking:null,// callback after the timer just clocked
                    onFinish: function () {
                        location.reload();
                    }
                });
            });
        });


        let username;
        $(document).ready(function () {
            /*$('#MessageContent').scrollTop($('#MessageContent')[0].scrollHeight);*/
            //$('#MessageContent').animate({ scrollTop: $(document).height() }, 2000);

            LoadAllMessage();
            // Autoload message div ... by ajax method
            function LoadAllMessage(){
                let Consultation_id = '{{ $Consultation_id }}';
                //alert(ConsultationId);
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('user/load-all-message') }}",
                    data: {"Consultation_id": Consultation_id}
                }).done(function(result){
                    if (result.error == false){
                        //$("#GetMsg").html(result);
                    }else{
                        $("#GetMsg").html(result);
                        $('#MessageContent').animate({ scrollTop: ($(document).height()+10000) }, 2000);
                        //console.log(result);
                    }
                });
            }

            // Load new message
            setInterval(function(){
                let Consultation_id = '{{ $Consultation_id }}';
                //alert(Consultation_id);
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('user/load-new-message') }}",
                    data: {"Consultation_id": Consultation_id}
                }).done(function(result){
                    if (result.error == false){
                        $("#GetMsg").html(result);
                    }else{
                        $("#GetMsg").append(result);
                        //$("#GetNewMsg").html(result);
                    }
                });
            }, 2000);


            function sentMessage() {
                let Consultation_id = '{{ $Consultation_id }}';
                let Message = $('#Message_Textbox').val();
                let Sender_id = '{{ Auth::id() }}';
                let Receiver_id = '{{ $User_data->id }}';
                $.ajax({
                    type: 'GET',
                    method: 'GET',
                    url: "{{ url('user/send-message') }}",
                    data: {"Consultation_id": Consultation_id, "Message": Message, "Sender_id": Sender_id, "Receiver_id": Receiver_id}
                }).done(function(result){
                    if (result.error == false){
                        $("#GetMsg").html(result);
                    }else{
                        $('#Message_Textbox').val('');
                        LoadAllMessage();
                    }
                });
            }

            let username = $("#username").html();
            $('#Message_Textbox').keydown(function(e){
                if($('#Message_Textbox').val().trim() != ''){
                    if(e.keyCode == 13){
                        sentMessage();
                    }else{
                        //isTyping();
                    }
                }
            });
        });


        // Patient report upload ...
        $(document).ready(function(){
            $(" #open_file_Dialog").click(function(){
                $('#select_report').trigger("click");
            });
            $("#select_report").change(function(){
                $("#submit_report").trigger("click");
            });
            $("#submit_report").click(function(){
                $(this).submit();
            });
        });
    </script>

@stop




