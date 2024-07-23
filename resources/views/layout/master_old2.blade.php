<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('storage/favicon.ico') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bivaco - Quản trị</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('asset_admin/dist/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_admin/src/bonus.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/plugins/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset_admin/src/jquery-ui/jquery-ui.css') }}">
    <!-- END: CSS Assets-->
    @yield('css')
</head>
<!-- END: Head -->

<body class="py-5">

    @include('partials.menu-mobile')

    <div class="flex mt-[4.7rem] md:mt-0">

        @include('layout.sidebar')

        @yield('content')

    </div>

    <!-- BEGIN: JS Assets-->

    <script src="{{ asset('asset_admin/dist/js/app.js') }}"></script>
    <script src="{{ asset('asset_admin/plugins/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset_admin/src/common.js') }}"></script>
    <script src="{{ asset('asset_admin/plugins/js/toastr.min.js') }}"></script>
    <script src="{{ asset('asset_admin/src/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('asset_admin/src/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('asset_admin/plugins/js/deleteRecord.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/b2vtb365nn7gj3ia522w5v4dm1wcz2miw5agwj55cejtlox1/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script type="module">
        // Show alert
        @if (session('status_succeed'))
            toastr.success('{{ session('status_succeed') }}', {
                timeOut: 5000
            })
        @elseif (session('status_failed'))
            toastr.error('{{ session('status_failed') }}', {
                timeOut: 5000
            })
        @endif
    </script>
    @yield('js')
    <!-- END: JS Assets-->
</body>

</html>
