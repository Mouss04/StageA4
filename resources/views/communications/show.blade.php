@extends('base')

@section('title', 'Détails de la Communication')

@section('content')
<div class="container mt-4">
    <!-- Titre de la communication -->
    <div class="text-center mb-5">
        <h1 class="display-4">{{ $communication->titre }}</h1>
        <p class="text-muted">{{ $communication->description }}</p>
    </div>

    <!-- Informations sur la communication -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p><strong>Date et horaire :</strong></p>
                    <p>{{ $communication->heure_debut }} - {{ $communication->heure_fin }}</p>
                    <p><strong>Salle :</strong> {{ $communication->salle->nom ?? 'Non spécifiée' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orateurs -->
    <h2 class="mb-4">Orateurs</h2>
    @if ($communication->orateurs->isNotEmpty())
        <div class="d-flex flex-wrap justify-content-start gap-4 mb-5">
            @foreach ($communication->orateurs as $orateur)
                <a href="{{ route('orateurs.show', $orateur->id) }}" class="text-decoration-none text-dark">
                    <div class="text-center">
                        <img
                            src="{{ $orateur->photo ? asset('storage/' . $orateur->photo) : asset('storage/images/avatar2.jpg') }}"
                            alt="{{ $orateur->nom_complet }}"
                            class="rounded-circle mb-2"
                            style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #ddd;">
                        <p class="mb-0">{{ $orateur->nom_complet }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-muted">Aucun orateur pour cette communication.</p>
    @endif

    <!-- Questions traitées -->
    <h2 class="mb-4">Questions traitées</h2>
    @if ($communication->questions->isNotEmpty())
        <div class="row">
            @foreach ($communication->questions as $question)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <p><strong>Question :</strong> {{ $question->contenu }}</p>
                            <p><strong>Réponse :</strong> {{ $question->reponse ?? 'Pas encore de réponse' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Aucune question traitée pour cette communication.</p>
    @endif
</div>
@endsection
