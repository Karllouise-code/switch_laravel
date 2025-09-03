<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Switch Laravel</title>

        <!-- VITE -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        {{-- @vite(['resources/js/app.js', 'resources/sass/app.scss']) --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
    </head>
    <body>
        <div id="app"></div>
        {{-- <script async defer src="{{ url('/public/js/app.js?'.date('Ymdhis')) }}"></script> --}}
        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
