<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Prova Pratica | Treedom</title>
        <link rel="icon" href="/favicon.ico" />

        <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    </head>
    <body>
        @yield('content')
        <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>