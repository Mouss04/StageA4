@extends('base')

@section('title', 'Ajouter un Utilisateur')

@section('content')

<div class="container mt-5">
    <h1>Ajouter un Utilisateur</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom_complet">Nom complet</label>
            <input type="text" name="nom_complet" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Rôle</label>
            <select name="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="orateur">Orateur</option>
                <option value="sponsor">Sponsor</option>
                <option value="visiteur">Visiteur</option>
            </select>
        </div>
        <div class="form-group">
            <label for="motdepasse">Mot de passe</label>
            <input type="password" name="motdepasse" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="motdepasse_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="motdepasse_confirmation" class="form-control" required>
        </div>


        <button type="submit" class="btn btn-success mt-3">Ajouter</button>
    </form>
</div>

@endsection
