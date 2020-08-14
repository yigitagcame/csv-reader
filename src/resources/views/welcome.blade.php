<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            window.Laravel = {csrfToken: '{{ csrf_token() }}'}
        </script>

        <title>Csv Reader</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <message></message>
                <router-view></router-view>
            </div>
        </div>

        <script defer src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
