<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Job Helper</title>
    <link href="{{ asset('assets/plugins/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/jquery-jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    @auth
        @include('layout.partials.header')
        @include('layout.partials.aside')
    @endauth
    <div class="container-fluid">
        <div class="page-content" id="content">
            @yield('content')
        </div>
        @auth
            @include('layout.partials.footer')
        @endauth
    </div>
    <script src="{{ asset('assets/plugins/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/c3/c3.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
