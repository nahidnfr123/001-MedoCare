<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MedoCare.com') . ' / ' }} @yield('title', config('app.name', 'MedoCare.com'))</title>

    <link rel="icon" href="/storage/image/web_layout/MedocareMini.png">


    <meta data-n-head="ssr" data-hid="description" name="description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta name="description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta data-n-head="ssr" data-hid="og:description" name="og:description" property="og:description" content="Hey there, I am Nahid Ferodus. This is a project demondtration demo. It is an online medical service, built using laravel-6, JQuery, Ajax, etc.">
    <meta name="keywords" content="Nahid Ferdous, nahid, nahid_ferdous, nahid ferdous, Nahid, Ferdous, Nahidnfr, nfr, NFR, web, web development, designer, developer, bangladesh, art, design, laravel, vue js, vuejs, vue.js, php, laravel developer, project demo, project demonstration">
    <meta name="author" content="Nahid Ferdous">

    <meta data-n-head="ssr" data-hid="charset" charset="utf-8">
    <meta data-n-head="ssr" data-hid="mobile-web-app-capable" name="mobile-web-app-capable" content="yes">
    <meta data-n-head="ssr" data-hid="apple-mobile-web-app-title" name="apple-mobile-web-app-title" content="nahid ferdous">
    <meta data-n-head="ssr" data-hid="og:type" name="og:type" property="og:type" content="website">
    <meta data-n-head="ssr" data-hid="og:title" name="og:title" property="og:title" content="Nahid Ferdous! Project demonstration MedoCare.">
    <meta data-n-head="ssr" data-hid="og:site_name" name="og:site_name" property="og:site_name" content="Nahid Ferdous">


    <link href="{{ asset('asset_back/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_back/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('asset_back/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('asset_back/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_back/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_back/css/main.css') }}" rel="stylesheet">

    <!-- Data tables -->
    <link href="{{ asset('asset_back/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    <!-- Form -->
    <link href="{{ asset('asset_back/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_back/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('asset_back/css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">


    <!-- Advanced form -->

    <link href="{{ asset('asset_back/css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <link href="{{ asset('asset_back/css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">

    <script src="//kit.fontawesome.com/9fa86b6888.js"></script>  {{--fontawsome link using kit--}}

</head>
