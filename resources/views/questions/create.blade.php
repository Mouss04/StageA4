@extends('base')

@section('title', 'Poser une Question')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Poser une Question</h1>

    <!-- Affichage des messages de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulaire -->
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf

        <!-- Sélection de la communication -->
        <div class="mb-3">
            <label for="communication_id" class="form-label">Communication</label>
            <select class="form-control" id="communication_id" name="communication_id" required>
                <option value="" disabled selected>-- Sélectionnez une communication --</option>
                @foreach ($communications as $communication)
                    <option value="{{ $communication->id }}"
                            @if (old('communication_id') == $communication->id) selected @endif>
                        {{ $communication->titre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Affichage des orateurs disponibles pour la communication sélectionnée -->
        <div class="mb-3">
            <label for="orateur_id" class="form-label">Orateur</label>
            <select class="form-control" id="orateur_id" name="orateur_id">
                <option value="" disabled selected>-- Sélectionnez un orateur (optionnel) --</option>

                <!-- Vérification si des orateurs sont associés à la communication sélectionnée -->
                @if($orateurs->isEmpty())
                    <p>Aucun orateur trouvé pour cette communication.</p>
                @else
                    @foreach ($orateurs as $orateur)
                        <option value="{{ $orateur->id }}"
                                @if (old('orateur_id') == $orateur->id) selected @endif>
                            {{ $orateur->nom_complet }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Contenu de la question -->
        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu de la Question</label>
            <textarea class="form-control" id="contenu" name="contenu" rows="5" required>{{ old('contenu') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
@endsection
