<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" locale="{{ session('applocale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles.css') }}"> <!-- Nouveau fichier pour le CSS -->

    <!-- Bootstrap (si nécessaire) -->
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/css/bootstrap.css') }}">
</head>

<body>

    <!-- Conteneur principal -->
    <div class="app-container">
        <!-- Navbar -->
        @include('nav/navbar')

        <!-- Contenu principal -->
        <main class="content">
            @yield('content')
        </main>

        <!-- Navbar sticky en bas -->
        @include('nav/navbar-bottom')
    </div>

    <!-- Scripts -->
    @include('script')

</body>
</html>
