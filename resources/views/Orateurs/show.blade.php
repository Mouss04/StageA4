@extends('base')

@section('title', 'Détails de l\'Orateur')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Détails de l'Orateur</h1>

    <div class="text-center mb-4">
        <!-- Photo circulaire -->
        <img
            src="{{ $orateur->photo ? asset('storage/' . $orateur->photo) : asset('storage/images/avatar2.jpg') }}"
            alt="Photo de l'orateur"
            class="rounded-circle"
            style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">

        <!-- Nom complet -->
        <h2 class="mt-3">{{ $orateur->nom_complet }}</h2>

        <!-- Biographie -->
        <p class="text-muted">{{ $orateur->biographie }}</p>
    </div>

    <!-- Boutons Modifier et Supprimer -->
    <div class="text-center mt-4">
        <a href="{{ route('orateurs.edit', $orateur->id) }}" class="btn btn-primary mr-2">Modifier</a>

        <!-- Formulaire de suppression -->
        <form action="{{ route('orateurs.destroy', $orateur->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet orateur ?');">Supprimer</button>
        </form>
    </div>

    <!-- Communications associées -->
    <h2 class="mt-5">Communications associées</h2>

    @if ($orateur->communications->isEmpty())
        <p>Aucune communication pour cet orateur.</p>
    @else
        <div class="list-group">
            @foreach ($orateur->communications as $communication)
                <!-- Carte horizontale -->
                <a href="{{ route('communications.show', $communication->id) }}" class="text-decoration-none text-dark">
                    <div class="card mb-3 shadow-sm" style="display: flex; flex-direction: row; align-items: center;">
                        <div class="card-body d-flex flex-column justify-content-center" style="flex: 1;">
                            <h5 class="card-title mb-2">{{ $communication->titre }}</h5>
                            <p class="card-text mb-1">
                                <strong>Date :</strong>
                                @if ($communication->date)
                                    {{ \Carbon\Carbon::parse($communication->date)->format('d/m/Y') }}
                                @else
                                    Non spécifiée
                                @endif
                            </p>
                            <p class="card-text mb-1">
                                <strong>Horaire :</strong> {{ $communication->heure_debut }} - {{ $communication->heure_fin }}
                            </p>
                            <p class="card-text">
                                <strong>Salle :</strong> {{ $communication->salle->nom ?? 'Non spécifiée' }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
