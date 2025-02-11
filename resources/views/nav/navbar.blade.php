<head>
    <style>
        .dropdown-toggle-text {
            color: #ff5733; /* Remplacez cette couleur par celle de votre choix */
        }
    </style>
</head>

<!-- Navbar principale (en haut) -->
<nav class="navbar">
    <div class="container-fluid d-flex align-items-center">
        <!-- Bouton de toggle pour le menu (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Titre de la navbar (au centre) -->
        <div class="text-center flex-grow-1">
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}" style="font-size: 1.8rem; letter-spacing: 1px; color: #e0e0e0;">
                {{ config('app.name') }}
            </a>
        </div>

        <!-- Bouton Se connecter / Se déconnecter (Fixé en haut à droite) -->
        <div class="ms-auto d-flex align-items-center">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Se connecter</a>
            @endguest

            @auth
                <span class="me-3">Bonjour,</span>

                <!-- Dropdown pour l'utilisateur connecté -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="dropdown-toggle-text">{{ Auth::user()->surnom ?: Auth::user()->name }}</span>
                    </button>
                    <!-- Ajout de la classe "dropdown-menu-end" pour inverser le sens du dropdown -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Se déconnecter</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>

    <!-- Menu de navigation (collapsible) -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sessis.index') }}">Programme</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('orateurs.index') }}">Orateurs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('salles.index') }}">Salles</a>
            </li>

            <!-- Lien Gérer les utilisateurs visible seulement pour les admins -->
            @auth
                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Gérer les utilisateurs</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>

<!-- Navbar en bas -->
<div class="navbar-bottom">
    <div class="col text-center">
        <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('sessis.index') }}" class="navbar-link {{ request()->routeIs('sessis.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Programme</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('questions.index') }}" class="navbar-link {{ request()->routeIs('questions.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-question-circle"></i>
                <span>Questions</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('sponsors.index') }}" class="navbar-link {{ request()->routeIs('sponsors.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-users"></i>
                <span>Exposants</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="#" class="navbar-link {{ request()->routeIs('favoris') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-heart"></i>
                <span>Favoris</span>
            </div>
        </a>
    </div>
</div>
