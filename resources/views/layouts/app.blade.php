<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Invoices')</title>

    @yield('meta')

    @stack('before-styles')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    @stack('after-styles')
</head>
<body>
@include('header')
<div class="container-fluid col-md-12">
    <div id="app">
        @yield('content')
    </div>
</div>
@include('footer')


@stack('before-scripts')

<script src="{{asset('js/app.js')}}"></script>

@stack('after-scripts')
</body>
</html>
