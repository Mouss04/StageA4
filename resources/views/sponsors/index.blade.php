@extends('base')

@section('title', __('interface.sponsor_management'))

@section('content')

<div class="container mt-5">
    <h1>{{ __('interface.sponsor_management') }}</h1>

    <!-- Message de succès -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('sponsors.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ __('interface.search_sponsor') }}" value="{{ request()->query('search') }}">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search"></i> {{ __('interface.search') }}
            </button>
        </div>
    </form>

    @if(auth()->check() && auth()->user()->can('create Sponsor'))
    <a href="{{ route('sponsors.create') }}" class="btn btn-primary mb-3">{{ __('interface.add_sponsor') }}</a>
    @endif

    @if(auth()->check() && auth()->user()->hasRole('admin'))
    <!-- Table des sponsors pour les admins -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.category') }}</th>
                <th>{{ __('interface.description') }}</th>
                <th>{{ __('interface.logo') }}</th>
                <th>{{ __('interface.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sponsors as $sponsor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sponsor->name }}</td>
                <td>{{ $sponsor->category ?? __('interface.not_available') }}</td>
                <td>{{ Str::limit($sponsor->description, 50, '...') }}</td>
                <td>
                    @if ($sponsor->getFirstMediaUrl('logo'))
                    <img src="{{ $sponsor->getFirstMediaUrl('logo') }}" alt="Logo" width="50">
                    @else
                    <span>{{ __('interface.no_logo') }}</span>
                    @endif
                </td>
                <td>
                    @if(auth()->check() && auth()->user()->can('create Favorite'))
                    <x-favorite-button modelType="App\Models\Sponsor" :modelId="$sponsor->id" />
                    @endif

                    @if(auth()->check() && auth()->user()->can('update Sponsor'))
                    <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn btn-warning btn-sm">{{ __('interface.edit') }}</a>
                    @endif

                    @if(auth()->check() && auth()->user()->can('delete Sponsor'))
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSponsorModal{{ $sponsor->id }}">
                        {{ __('interface.delete') }}
                    </button>

                    <!-- Modal de confirmation -->
                    <div class="modal fade" id="deleteSponsorModal{{ $sponsor->id }}" tabindex="-1" aria-labelledby="deleteSponsorLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteSponsorLabel">{{ __('interface.confirm_delete') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ __('interface.confirm_delete_message', ['name' => $sponsor->name]) }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('interface.cancel') }}</button>
                                    <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">{{ __('interface.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <!-- Vue en cartes pour les visiteurs et modérateurs -->
    <div class="row">
        @foreach ($sponsors as $sponsor)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                @if ($sponsor->getFirstMediaUrl('logo'))
                <img src="{{ $sponsor->getFirstMediaUrl('logo') }}" class="card-img-top" alt="Logo">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $sponsor->name }}</h5>
                    <p class="card-text"><strong>{{ __('interface.category') }}:</strong> {{ $sponsor->category ?? __('interface.not_available') }}</p>
                    <p class="card-text">{{ Str::limit($sponsor->description, 80, '...') }}</p>
                    @if(auth()->check() && auth()->user()->can('create Favorite'))
                    <x-favorite-button modelType="App\Models\Sponsor" :modelId="$sponsor->id" />
                    @endif
                    <a href="{{ route('sponsors.show', $sponsor->id) }}" class="btn btn-info btn-sm">{{ __('interface.view') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Pagination -->
    <div class="mt-3">
        {{ $sponsors->appends(['search' => request()->query('search')])->links() }}
    </div>
</div>

@endsection
