<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

        <!-- Styles -->
    </head>
    <body>

        <link rel="stylesheet" href="/css/app.css">

        <div id="app">
            @yield("page")
        </div>

        <script src="/js/app.js"></script>

    </body>
</html>
