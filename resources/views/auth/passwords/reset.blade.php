@extends('layouts.app_front')

@section('title')
    @php $title = 'Reset Password'; @endphp
    {{ $title }}
@stop

@section('Main_Body_Content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}" class="my_forms">
                    <h2><u>{{ __('Reset Password') }}</u></h2>
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="rowss">
                        <label for="email">{{ __('E-Mail') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required readonly autocomplete="email">
                        {{--@error('email')
                            <span class="alert alert-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror--}}
                    </div>

                    <div class="rowss">
                        <label for="password_field">{{ __('Password') }}</label>
                        <label class="label_pass"><i class="far fa-eye sign_up_eye" id="lgo_eye"></i></label>
                        <input id="password_field" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>
                        {{--@error('password')
                            <span class="alert alert-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror--}}
                    </div>

                    <div class="rowss">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    {{--
                    <div class="form-group row mb-0">
                        <button type="submit" class="mybtn">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                    --}}

                    <div class="rowss" style="text-align: center; margin-top: 16px;">
                        <button type="submit" class="mybtn" name="Reset_Password" style="flex: 1;">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Show floating error message --}}
{{--@if ($errors->any())
    <div class="Float_MSG_Error animated fadeInDownBig" style="animation-delay: 1.5s!important;">
        <div id="Close_Btn" onclick="close_div()">
            <i class="fas fa-times"></i>
        </div>
        <strong style="color: red;">Error:</strong>
        <ul class="Error_Ul">
            @foreach($errors->all() as $err)
                <li><strong>- {{ $err }}</strong></li>
            @endforeach
        </ul>
        <div style="color: black;text-align: center;">Fill the form correctly and try again.</div>
    </div>
@endif--}}

@endsection


@section('Page_Level_Script')
    <script src="{{ asset('asset_front/js/form.js') }}"></script>

    {{--<script>
        function close_div_warning(){
            document.querySelector('.Warning_Review').style.display = 'none';
        }
        function close_div(){
            document.querySelector('.Float_MSG_Error').style.display = 'none';
        }
    </script>--}}

@endsection
