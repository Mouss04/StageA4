@extends('base')

@section('title', 'Liste des Orateurs')

@section('content')
<div class="container">
    <h1>Liste des Orateurs</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('orateurs.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Rechercher un orateur par nom complet"
                   value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>

    <!-- Bouton pour créer un nouvel orateur -->
    <a href="{{ route('orateurs.create') }}" class="btn btn-success mb-3">Créer un nouvel orateur</a>

    <!-- Liste des orateurs en format "bulles" -->
    @if ($orateurs->isEmpty())
        <p>Aucun orateur n'est disponible pour le moment.</p>
    @else
        <div class="row">
            @foreach ($orateurs as $orateur)
                <div class="col-md-3 col-sm-4 col-6 text-center mb-4">
                    <a href="{{ route('orateurs.show', $orateur->id) }}" style="text-decoration: none; color: inherit;">
                        <div style="width: 120px; height: 120px; margin: 0 auto; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            @if ($orateur->photo)
                                <img src="{{ asset('storage/' . $orateur->photo) }}" alt="{{ $orateur->nom_complet }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/images/avatar2.jpg') }}" alt="{{ $orateur->nom_complet }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <p class="mt-2 font-weight-bold">{{ $orateur->nom_complet }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
