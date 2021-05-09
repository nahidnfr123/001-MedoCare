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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="my_forms">
                    <h2><u>{{ __('Reset Password') }}</u></h2>
                    @csrf
                    <div class="rowss">
                        <label for="email" class="">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        {{--@error('email')
                        <span class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror--}}
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="mybtn">
                            {{ __('Send Password Reset Link') }}
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

    {{--<script>
        function close_div_warning(){
            document.querySelector('.Warning_Review').style.display = 'none';
        }
        function close_div(){
            document.querySelector('.Float_MSG_Error').style.display = 'none';
        }
    </script>--}}

@endsection
