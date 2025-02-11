@extends('base')

@section('title', 'Questions')

@section('content')
<div class="container text-center mt-5">
    <!-- Titre -->
    <div class="mb-4">
        <h1 class="text-white p-3" style="background-color: #56B947; border-radius: 10px;">Questions</h1>
    </div>
    <a href="{{ route('questions.create') }}" class="btn btn-success mb-3">Poser une Question</a>

    <!-- Statistiques des questions -->
    <div class="d-flex justify-content-center mb-4">
        <div class="p-3 me-2" style="background-color: #F2A341; border-radius: 10px;">
            <h5>En attente</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $en_attente }}</span>
        </div>
        <div class="p-3 me-2" style="background-color: #56A6B4; border-radius: 10px;">
            <h5>Validée</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $valides_count }}</span>
        </div>
        <div class="p-3 me-2" style="background-color: #4CAF50; border-radius: 10px;">
            <h5>Traitée</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $traitees }}</span>
        </div>
        <div class="p-3 ms-2" style="background-color: #E74C3C; border-radius: 10px;">
            <h5>Rejetée</h5>
            <span style="font-size: 1.5rem; font-weight: bold;">{{ $rejetees }}</span>
        </div>
    </div>

    <!-- Questions en attente -->
    <div class="p-4 mb-4" style="background-color: #F2A341; border-radius: 10px;">
        <h5 class="text-white">Questions en attente :</h5>
        @if($questions_en_attente->isEmpty())
            <p>Aucune question en attente pour le moment...</p>
        @else
            <div class="row">
                @foreach($questions_en_attente as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <strong>{{ $question->contenu }}</strong>
                                <br>
                                <small>Communication : {{ $question->communication->titre ?? 'Non spécifiée' }}</small>
                                @if ($question->orateur)
                                    <br><small>Orateur : {{ $question->orateur->nom }}</small>
                                @endif
                                <div class="mt-2">
                                    <form action="{{ route('questions.valider', $question->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                    </form>
                                    <a href="{{ route('questions.rejeter', $question->id) }}" class="btn btn-danger btn-sm">Rejeter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Questions validées -->
    <div class="p-4 mb-4" style="background-color: #56A6B4; border-radius: 10px;">
        <h5 class="text-white">Questions validées :</h5>
        @if($valides->isEmpty())
            <p>Aucune question validée pour le moment...</p>
        @else
            <div class="row">
                @foreach($valides as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <strong>{{ $question->contenu }}</strong>
                                <br>
                                <small>Communication : {{ $question->communication->titre ?? 'Non spécifiée' }}</small>
                                @if ($question->orateur)
                                    <br><small>Orateur : {{ $question->orateur->nom }}</small>
                                @endif
                                <div class="mt-2">
                                    <form action="{{ route('questions.traiter', $question->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">Marquer comme traitée</button>
                                    </form>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reponseModal{{ $question->id }}">Répondre</button>
                                    <!-- Bouton Rejeter -->
                                    <form action="{{ route('questions.rejeter', $question->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Questions traitées -->
    <div class="p-4" style="background-color: #4CAF50; border-radius: 10px;">
        <h5 class="text-white">Questions traitées :</h5>
        @if($questions_traitees->isEmpty())
            <p>Aucune question traitée pour le moment...</p>
        @else
            <div class="row">
                @foreach($questions_traitees as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <strong>{{ $question->contenu }}</strong>
                                <br>
                                <small>Communication : {{ $question->communication->titre ?? 'Non spécifiée' }}</small>
                                @if ($question->orateur)
                                    <br><small>Orateur : {{ $question->orateur->nom }}</small>
                                @endif
                                <div class="mt-3">
                                    <strong>Réponse donnée :</strong>
                                    <p>{{ $question->reponse ?? 'Aucune réponse donnée.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Questions rejetées -->
    <div class="p-4 mb-4" style="background-color: #E74C3C; border-radius: 10px;">
        <h5 class="text-white">Questions rejetées :</h5>
        @if($questions_rejetees->isEmpty())
            <p>Aucune question rejetée pour le moment...</p>
        @else
            <div class="row">
                @foreach($questions_rejetees as $question)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <form action="{{ route('questions.updateRejetee', $question->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <strong>Question :</strong>
                                    <textarea name="contenu" class="form-control mb-2">{{ $question->contenu }}</textarea>
                                    <small>Communication : {{ $question->communication->titre ?? 'Non spécifiée' }}</small>
                                    @if ($question->orateur)
                                        <br><small>Orateur : {{ $question->orateur->nom }}</small>
                                    @endif
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-success btn-sm">Valider après modification</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

