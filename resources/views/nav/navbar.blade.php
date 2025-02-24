<head>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .container-fluid {
            display: flex;
            justify-content: space-between;
            width: 100%;
            align-items: center;
        }

        .navbar .navbar-brand {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.8rem;
            letter-spacing: 1px;
            color: #e0e0e0;
        }

        .dropdown-toggle-text {
            color: #ff5733;
        }
    </style>
</head>
<nav class="navbar">
    <div class="container-fluid d-flex align-items-center">
        <!-- Bouton de toggle pour le menu (mobile) -->
        @if(auth()->check())
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="{{ __('interface.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        @endif

        <!-- Titre de la navbar (centré) -->
        <div class="text-center">
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <!-- Authentification -->
        <div class="ms-auto d-flex align-items-center">
            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary">{{ __('interface.login') }}</a>
            @else
            <span class="me-3">{{ __('interface.hello',['name'=> Auth::user()->nickname ?: Auth::user()->name]) }},</span>

            <!-- Dropdown utilisateur -->
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="dropdown-toggle-text">{{ Auth::user()->nickname ?: Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a href="{{ route('profile.show') }}" class="dropdown-item">{{ __('interface.profile') }}</a></li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">{{ __('interface.logout') }}</button>
                    </form>
                </ul>
            </div>
            @endguest
        </div>
        <div class="dropdown ms-3">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                {{ app()->getLocale() == 'en' ? 'English' : (app()->getLocale() == 'fr' ? 'Français' : 'العربية') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('locale', 'en') }}">English</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('locale', 'fr') }}">Français</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('locale', 'ar') }}">العربية</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth
            @if(auth()->check() && Auth::user()->can('read ProgramSession'))
            <li class="nav-item"><a class="nav-link" href="{{ route('program_sessions.index') }}">{{ __('interface.program') }}</a></li>
            @endif

            @if(auth()->check() && Auth::user()->can('read Speaker'))
            <li class="nav-item"><a class="nav-link" href="{{ route('speakers.index') }}">{{ __('interface.speakers') }}</a></li>
            @endif

            @if(auth()->check() && Auth::user()->can('read Room'))
            <li class="nav-item"><a class="nav-link" href="{{ route('rooms.index') }}">{{ __('interface.rooms') }}</a></li>
            @endif

            @if(auth()->check() && Auth::user()->can('read User'))
            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">{{ __('interface.manage_users') }}</a></li>
            @endif
            @endauth
        </ul>
    </div>
</nav>
