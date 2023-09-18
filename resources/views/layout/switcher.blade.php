@if (request()->ajax())
    @yield('switcher')
    @stack('extra-scripts')
    <?php exit(); ?>
@else
    @extends('layout.app')
    @section('content')
        @yield('switcher')
    @endsection
    @section('scripts')
        @stack('extra-scripts')
    @endsection
@endif
