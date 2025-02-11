@extends('base')

@section('content')
    <div class="container">
        <h1>Ajouter un exposant</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nom">Nom de l'exposant</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required>
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" class="form-control">
                    @include('components.category-options', ['category' => old('category')])
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" id="logo" name="logo" class="form-control">
            </div>

            <div class="form-group">
                <label for="fichier">Fichiers</label>
                <input type="file" id="fichier" name="fichier[]" class="form-control" multiple>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Créer</button>
        </form>
    </div>
@endsection
