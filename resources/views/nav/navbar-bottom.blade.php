<!-- Navbar en bas -->
<div class="navbar-bottom">
    <div class="col text-center">
        <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-home"></i>
                <span>{{ __('interface.home') }}</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('program_sessions.index') }}" class="navbar-link {{ request()->routeIs('program_sessions.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ __('interface.program') }}</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('questions.index') }}" class="navbar-link {{ request()->routeIs('questions.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-question-circle"></i>
                <span>{{ __('interface.questions') }}</span>
            </div>
        </a>
    </div>

    <div class="col text-center">
        <a href="{{ route('sponsors.index') }}" class="navbar-link {{ request()->routeIs('sponsors.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-users"></i>
                <span>{{ __('interface.exhibitors') }}</span>
            </div>
        </a>
    </div>

    @auth
    @if(auth()->check() && Auth::user()->can('read Favorite'))
    <div class="col text-center">
        <a href="{{ route('favorites.index') }}" class="navbar-link {{ request()->routeIs('favorites.index') ? 'active' : '' }}">
            <div class="navbar-item">
                <i class="fas fa-heart"></i>
                <span>{{ __('interface.favorites') }}</span>
            </div>
        </a>
    </div>
    @endif
    @endauth
</div>
