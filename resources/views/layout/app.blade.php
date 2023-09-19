<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon.ico') }}">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Job Helper</title>
    {{-- Panel Assets --}}
    @auth
        <link href="{{ asset('assets/plugins/c3/c3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/jquery-jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/pdfjs/css/pdfjs.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    @endauth
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        @auth
            @include('layout.partials.header')
            @include('layout.partials.aside')
        @endauth
        <div class="page-wrapper" style="display: block;">
            <div class="container-fluid">
                <div class="page-content" id="content">
                    @yield('content')
                </div>
            </div>
            @auth
                @include('layout.partials.footer')
            @endauth
        </div>
    </div>
    @include('layout.modals.open')
    @include('layout.modals.file')
    <script src="{{ asset('assets/plugins/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.bundle.min.js') }}"></script>
    @auth
        <script src="{{ asset('assets/plugins/c3/c3.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/chartist/chartist.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('assets/plugins/ckeditor/config.js') }}"></script>
        <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/pdfjs/js/pdfjs.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    @endauth
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
