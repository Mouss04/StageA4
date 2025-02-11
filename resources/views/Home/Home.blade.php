@extends('base')

@section('title', 'Accueil')

@section('content')

<!-- Image stockée localement dans le dossier public -->
<div class="text-center">
    <a href="{{ asset('images/plan.jpg') }}" data-lightbox="image-1" data-title="Plan général du SIPHAL 2025">
        <img src="{{ asset('images/plan.jpg') }}" alt="Description de l'image" style="margin-top: 20px; width: 500px; height: 300px;">
    </a>
</div>

<!-- Contenu principal -->
<div class="container text-center" style="margin-top: 50px; padding-bottom: 80px;">
    <!-- Grille pour les boutons -->
    <div class="row justify-content-center">
        <!-- Colonne 1 -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="{{ route('sessis.index') }}" class="btn btn-outline-primary w-100">
                    <i class="fas fa-calendar-alt"></i> Le programme de l'évènement
                </a>
            </div>
        </div>

        <!-- Colonne 2 -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="{{ route('orateurs.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-microphone-alt"></i> Les orateurs
                </a>
            </div>
        </div>

        <!-- Colonne 3 -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="{{ route('sponsors.index') }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-users"></i> Les exposants
                </a>
            </div>
        </div>

        <!-- Colonne 4 -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="{{ route('salles.index') }}" class="btn btn-outline-danger w-100">
                    <i class="fas fa-building"></i> Les salles
                </a>
            </div>
        </div>

        <!-- Colonne 5 (pour les questions) -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="{{ route('questions.index') }}" class="btn btn-warning w-100">
                    <i class="fas fa-question-circle"></i> Questions
                </a>
            </div>
        </div>

        <!-- Colonne 6 (pour Siphal TV) -->
        <div class="col-sm-6 col-md-5 mb-5">
            <div class="card-body">
                <a href="https://www.youtube.com/@siphaltv" class="btn btn-dark w-100" target="_blank">
                    <i class="fas fa-tv"></i> Siphal TV
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
