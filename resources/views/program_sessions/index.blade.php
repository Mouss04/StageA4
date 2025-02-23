@extends('base')

@section('title', __('interface.manage_sessions'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.manage_sessions') }}</h1>

    <!-- Message de succès -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('program_sessions.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('interface.search_by_name_or_date') }}" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> {{ __('interface.search') }}
            </button>
        </div>
    </form>

    <!-- Bouton pour ajouter une nouvelle session (Admin uniquement) -->
    @if(auth()->check() && auth()->user()->can('create ProgramSession'))
        <a href="{{ route('program_sessions.create') }}" class="btn btn-primary mb-3">{{ __('interface.add_session') }}</a>
    @endif

    @if(auth()->user()?->hasRole('admin'))
        <!-- Table pour les Admins -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('interface.name') }}</th>
                    <th>{{ __('interface.date') }}</th>
                    <th>{{ __('interface.start_time') }}</th>
                    <th>{{ __('interface.end_time') }}</th>
                    <th>{{ __('interface.communications') }}</th>
                    <th>{{ __('interface.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->date }}</td>
                    <td>{{ $session->start_time }}</td>
                    <td>{{ $session->end_time }}</td>
                    <td>
                        @if ($session->communications->isNotEmpty())
                        <ul>
                            @foreach ($session->communications as $communication)
                            <li>
                                <a href="{{ route('communications.show', $communication->id) }}">
                                    {{ $communication->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-muted">{{ __('interface.none') }}</span>
                        @endif
                    </td>
                    <td>
                    @if(auth()->check() && auth()->user()->can('create Favorite'))
                        <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />
                    @endif
                        <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>

                        @if(auth()->check() && auth()->user()->can('update ProgramSession'))
                            <a href="{{ route('program_sessions.edit', $session->id) }}" class="btn btn-warning btn-sm">{{ __('interface.edit') }}</a>
                        @endif

                        @if(auth()->check() && auth()->user()->can('delete ProgramSession'))
                            <form action="{{ route('program_sessions.destroy', $session->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('interface.delete_session_confirmation') }}')">{{ __('interface.delete') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- Affichage en cartes pour Modérateurs et Visiteurs -->
        <div class="row">
            @foreach ($sessions as $session)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $session->name }}</h5>
                        <p class="card-text"><strong>{{ __('interface.date') }} :</strong> {{ $session->date }}</p>
                        <p class="card-text"><strong>{{ __('interface.time') }} :</strong> {{ $session->start_time }} - {{ $session->end_time }}</p>
                        @if(auth()->check() && auth()->user()->can('create Favorite'))
                        <x-favorite-button modelType="App\Models\ProgramSession" :modelId="$session->id" />
                        @endif

                        <a href="{{ route('program_sessions.show', $session->id) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>

                        @if(auth()->check() && auth()->user()->can('create Question'))
                            <a href="{{ route('questions.create', ['session_id' => $session->id]) }}" class="btn btn-primary btn-sm">{{ __('interface.ask_question') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sessions->links() }}
    </div>
</div>

@endsection
