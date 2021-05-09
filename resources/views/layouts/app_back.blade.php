<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- Page Header --}}
@include('layouts.partials.admin.head')

<body>

<div id="wrapper">

    <!-- Navigation bar -->
    @include('layouts.partials.admin.side_nav')

    <div id="page-wrapper" class="gray-bg">
        <!-- Top bar -->
        @include('layouts.partials.admin.top_bar')



        {{-- Breadcrumb --}}
        @if($title != 'Dashboard')
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-12">
                <h2>{{ $title }}</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a>{{ $title }}</a>
                    </li>
                    @if($subTitle != '')
                    <li class="breadcrumb-item active">
                        <strong>{{ $subTitle }}</strong>
                    </li>
                    @endif
                </ol>
            </div>
            {{--<div class="col-sm-4">
                <!--<div class="title-action">
                    <a href="" class="btn btn-primary">This is action area</a>
                </div>-->
            </div>--}}
        </div>
        @endif



        <!-- main body content -->
        @yield('Admin_Main_Body_Content')


        {{-- Footer area --}}
        @include('layouts.partials.admin.footer')
    </div>


    @include('layouts.partials.popup_msg')

</div>

<!-- Mainly scripts -->
@include('layouts.partials.admin.script')


<script>
    $.ajaxSetup({headers: {'csrftoken' : '{{ csrf_token() }}' } });
</script>

@yield('Page_Level_script')

</body>
</html>
