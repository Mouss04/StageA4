@extends('base')

@section('title', 'Ajouter un Orateur')

@section('content')
<div class="container">
    <h1>Ajouter un Orateur</h1>

    <form action="{{ route('orateurs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nom_complet" class="form-label">Nom Complet</label>
            <input type="text" class="form-control" id="nom_complet" name="nom_complet" required>
        </div>

        <div class="mb-3">
            <label for="biographie" class="form-label">Biographie</label>
            <textarea class="form-control" id="biographie" name="biographie" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l'orateur</button>
    </form>
</div>
@endsection
