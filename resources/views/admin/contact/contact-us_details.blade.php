@extends('layouts.app_back')

@section('title')
    @php $title = 'Contact Us'; @endphp
    @php $subTitle = 'View Message'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content">
        <div class="row">


            @include('layouts.partials.admin.contact_side_nav')


            <div class="col-lg-9 animated fadeInRight">
                <div class="mail-box-header">
                    <h2>
                        View Message
                    </h2>
                    <div class="mail-tools tooltip-demo m-t-md">
                        <h5>
                            <span class="float-right font-normal">{{ date('H:i A M-d-y', strtotime($Message->created_at)) }}</span>
                            <span class="font-normal">From: </span>{{ $Message->name }}, {{ $Message->email }}
                        </h5>
                    </div>
                </div>
                <div class="mail-box">


                    <div class="mail-body">
                        <p>
                            <b>Hello Admin!</b>
                            <br/>
                            <br/>
                        </p>
                        <div>
                            {{ $Message->message }}
                        </div>
                    </div>

                    <div class="mail-body text-right tooltip-demo">
                        <button class="btn btn-sm btn-white" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-reply"></i> Reply</button>
                        <a href="{{ urlencode('delete-message|') . encrypt($Message->id) }}" title="Move to trash" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</a>

                        <div class="float-left alert-info alert">
                            <b>User info: </b>@if($FindUser !== null) User is registered. @else User is not registered. @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>


                </div>
            </div>
        </div>
    </div>





    <div class="modal fade bd-example-modal-lg" id="Semd_Email_Form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.send-email') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Recipient email:</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="{{ encrypt($Message->id) }}" hidden>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $Message->email }}" readonly required>
                            <input type="hidden" class="form-control" id="received_message" name="received_message" value="{{ encrypt($Message->message) }}" hidden required>
                            <input type="hidden" class="form-control" id="name" name="name" value="{{ encrypt($Message->name) }}" hidden required>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-form-label">Subject:</label>
                            <input type="text" class="form-control @error('message_subject') is-invalid @enderror" id="subject" name="message_subject" value="{{ old('message_subject') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="message_body" class="col-form-label">Message:</label>
                            <textarea class="form-control @error('message_body') is-invalid @enderror" name="message_body" id="message_body" required>{{ old('message_body') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('Page_Level_script')
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });


        CKEDITOR.replace('message_body');
    </script>

    @if(session('Error_sending_Email')) // edit for old data show problem ...
    <script>
        $(document).ready(function () {
            $('#Semd_Email_Form').modal('toggle');
        });
    </script>
    @endif
@stop
