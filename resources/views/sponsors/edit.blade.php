@extends('base')

@section('content')
    <div class="container">
        <h1>Modifier l'exposant</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom de l'exposant</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $sponsor->nom) }}" required>
            </div>

            <div class="form-group">
                <label for="category">Catégorie</label>
                <select id="category" name="category" class="form-control">
                    @include('components.category-options', ['category' => old('category', $sponsor->category)])
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $sponsor->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" id="logo" name="logo" class="form-control">
                @if($sponsor->logo)
                    <p>Logo actuel : <img src="{{ asset('storage/' . $sponsor->logo) }}" width="50"></p>
                @endif
            </div>

            <div class="form-group">
                <label for="fichier">Fichiers</label>
                <input type="file" id="fichier" name="fichier[]" class="form-control" multiple>
                @if($sponsor->fichier)
                    <p>Fichiers actuels :</p>
                    @foreach (json_decode($sponsor->fichier) as $fichier)
                        <p>{{ basename($fichier) }}</p>
                    @endforeach
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
        </form>
    </div>

    <!-- Ajouter des styles CSS spécifiques à cette vue -->
    @section('styles')
    <style>
        /* Exemple de styles CSS ajoutés directement dans la vue */
        body {
            background-color: #f9f9f9;  /* Changer la couleur de fond */
        }

        .container {
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Ajouter un style pour l'élément d'alerte des erreurs */
        .alert-danger {
            margin-top: 20px;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
    @endsection
@endsection
