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
            <div class="container-fluid">
                <div class="row">
                    <div v-for="heater in heating" class="col-sm-2">
                        <heater :data="heater" v-on:temperaturechange="updateTemperature"></heater>
                    </div>
                </div>

                <div class="row">
                    <div v-for="window in windows" class="col-sm-2">
                        <window :data="window"></window>
                    </div>
                </div>

                {{--<open-windows :data="windows"></open-windows>--}}
            </div>
        </div>



        <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
