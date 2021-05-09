@extends('layouts.app_back')

@section('title')
    @php $title = 'Contact Us'; @endphp
    @php $subTitle = 'Send Email'; @endphp
    {{ $title }}
@stop

@section('Admin_Main_Body_Content')

    <div class="wrapper wrapper-content">
        <div class="row">

            @include('layouts.partials.admin.contact_side_nav')

            <div class="col-lg-9 animated fadeInRight">
                <div class="mail-box-header">
                    <h2>
                        Compose mail
                    </h2>
                </div>
                <div class="mail-box">

                    <form action="{{ route('admin.send-email-Intended') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" id="id" name="id" value="" hidden>
                        <div class="mail-body">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Recipient email:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">Subject:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('message_subject') is-invalid @enderror" id="subject" name="message_subject" value="{{ old('message_subject') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mail-text h-200 container">
                            <label for="message_body" class="col-form-label">Message:</label>
                            <textarea class="form-control @error('message_body') is-invalid @enderror" name="message_body" id="message_body" required>{{ old('message_body') }}</textarea>
                            <div class="clearfix"></div>
                        </div>

                        <div class="mail-body text-right">
                            <button class="btn btn-sm btn-primary" title="Send" type="submit"><i class="fa fa-reply"></i> Send</button>
                            <a href="{{ route('admin.inbox') }}" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('Page_Level_script')
    <script>
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
