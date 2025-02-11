@extends('base')

@section('title', 'Modifier l\'Utilisateur')

@section('content')

<div class="container mt-5">
    <h1>Modifier l'Utilisateur</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom_complet">Nom complet</label>
            <input type="text" name="nom_complet" class="form-control" value="{{ $user->nom_complet }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="role">Rôle</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="orateur" {{ $user->role == 'orateur' ? 'selected' : '' }}>Orateur</option>
                <option value="sponsor" {{ $user->role == 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                <option value="visiteur" {{ $user->role == 'visiteur' ? 'selected' : '' }}>Visiteur</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning mt-3">Mettre à jour</button>
    </form>
</div>

@endsection
