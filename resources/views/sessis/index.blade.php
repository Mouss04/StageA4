@extends('base')

@section('title', 'Programme des Sessions')

@section('content')
<div class="container">
    <h1>Programme des Sessions</h1>

    {{-- Bouton pour créer une nouvelle session --}}
    <a href="{{ route('sessis.create') }}" class="btn btn-success mb-3">Créer une nouvelle session</a>

    @if ($sessis->isEmpty())
        <p>Aucune session n'est disponible pour le moment.</p>
    @else
        <div class="row">
            @foreach ($sessis as $sessi)
                <div class="col-12 mb-3"> {{-- Chaque session occupe toute la largeur --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sessi->nom }}</h5>
                            <p class="card-text">
                                <strong>Date:</strong> {{ $sessi->date }} <br>
                                <strong>Heure Début:</strong> {{ $sessi->heure_debut }} <br>
                                <strong>Heure Fin:</strong> {{ $sessi->heure_fin }} <br>
                            </p>

                            {{-- Afficher les orateurs --}}
                            @if ($sessi->orateurs->isNotEmpty())
                                <strong>Modérateur/s:</strong>
                                <ul>
                                    @foreach ($sessi->orateurs as $orateur)
                                        <li>{{ $orateur->nom_complet }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            {{-- Bouton pour ajouter une communication --}}
                            <a href="{{ route('communications.create', ['sessi_id' => $sessi->id]) }}" class="btn btn-primary mt-3">Ajouter une communication</a>

                            {{-- Actions --}}
                            <a href="{{ route('sessis.edit', $sessi->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('sessis.destroy', $sessi->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>

                            {{-- Afficher les communications sous forme de cartes --}}
                            @if ($sessi->communications->isNotEmpty())
                                <hr> {{-- Séparation visuelle --}}
                                <strong>Communications:</strong>
                                <div class="row mt-3">
                                    @foreach ($sessi->communications as $communication)
                                        <div class="col-12 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $communication->titre }}</h6>
                                                    <p class="card-text">
                                                        {{ $communication->description }}
                                                        <br>
                                                        <strong>Horaire:</strong> {{ $communication->heure_debut }} - {{ $communication->heure_fin }}
                                                    </p>
                                                    {{-- Boutons d'actions pour chaque communication --}}
                                                    <a href="{{ route('communications.show', $communication->id) }}" class="btn btn-info">Voir les détails</a>
                                                    <a href="{{ route('communications.edit', $communication->id) }}" class="btn btn-warning">Modifier</a>
                                                    <form action="{{ route('communications.destroy', $communication->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="mt-3">Aucune communication pour cette session.</p>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
