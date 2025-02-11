@extends('base')

@section('title', 'Liste des Salles')

@section('content')
<div class="container">
    <h1>Liste des Salles</h1>
    <a href="{{ route('salles.create') }}" class="btn btn-success mb-3">Ajouter une salle</a>

    @if($salles->isEmpty())
        <p>Aucune salle disponible.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Capacité</th>
                    <th>Description</th>
                    <th>Communications</th>  <!-- Nouvelle colonne pour les communications -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salles as $salle)
                    <tr>
                        <td>{{ $salle->nom }}</td>
                        <td>{{ $salle->capacite }}</td>
                        <td>{{ $salle->description }}</td>
                        <td>
                            @if ($salle->communications->isEmpty())
                                Aucune communication
                            @else
                                <ul>
                                    @foreach($salle->communications as $communication)
                                        <li>
                                            <a href="{{ route('communications.show', $communication->id) }}">
                                                {{ $communication->titre }}
                                                ({{ \Carbon\Carbon::parse($communication->date)->format('d/m/Y') }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('salles.edit', $salle->id) }}" class="btn btn-info">Modifier</a>
                            <form action="{{ route('salles.destroy', $salle->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
