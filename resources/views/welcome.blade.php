<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Smart Tablet</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <dashboard :heating="heating"
                       :windows="windows"
                       :virtuals="virtuals"
                       v-on:temperaturechange="updateTemperature">
            </dashboard>
        </div>

        <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
