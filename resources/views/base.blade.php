<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> {{ config('app.name') }} - @yield('title') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    </head>

    <body>

        @include('nav/navbar')

        @yield('content')

        @include('script')
    </body>
    <style>
        /* Dégradé du bleu clair au vert clair */
        body {
            background: linear-gradient(to bottom, #4A90E2, #50E3C2);
            height: 100vh; /* Remplir toute la hauteur de la fenêtre */
            margin: 0;
            color: #FFFFFF; /* Texte blanc */
        }

    </style>

</html>
