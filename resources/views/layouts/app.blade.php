<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Project AIMl">
    <meta name="description" content="Project AIMl">

    <title>Chatbot Untar</title>

    <link rel="icon" href="{{ asset('assets/images/logo-untar.png') }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet'>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>

    <body class="{{ $class ?? '' }}">
        <div class="min-height-80 bg-primary position-absolute w-100"></div>
        @include('layouts.sidebar')
        <main class="main-content border-radius-lg">
            @yield('content')
        </main>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>
