@extends('base')

@section('content')
    <div class="container">
        <h1>Exposants</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Formulaire combiné de recherche et filtrage -->
        <form method="GET" action="{{ route('sponsors.index') }}" class="mb-4">
            <div class="row">
                <!-- Champ de recherche -->
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un exposant"
                           value="{{ request()->get('search') }}">
                </div>

                <!-- Menu déroulant pour les catégories -->
                <div class="col-md-4">
                    <select name="category" class="form-control">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category }}"
                                    @if(request()->get('category') == $category->category) selected @endif>
                                {{ $category->category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Bouton de soumission -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>

        <!-- Boutons de catégorie sous forme de bulles -->
        <div class="category-buttons mb-4">
            <h4>Catégories rapides</h4>
            <div class="d-flex flex-wrap">
                <!-- Lien pour afficher tous les sponsors -->
                <a href="{{ route('sponsors.index') }}" class="btn btn-warning btn-sm m-2 {{ request()->get('category') ? '' : 'active' }}">
                    Toutes les catégories
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('sponsors.index', ['category' => $category->category]) }}"
                       class="btn btn-info btn-sm m-2 {{ request()->get('category') == $category->category ? 'active' : '' }}">
                        {{ $category->category }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Lien pour ajouter un sponsor -->
        <a href="{{ route('sponsors.create') }}" class="btn btn-primary mb-3">Ajouter un exposant</a>

        <!-- Tableau des sponsors -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sponsors as $sponsor)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($sponsor->logo)
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="Logo"
                                         style="width: 120px; height: 120px; object-fit: contain; margin-right: 10px;" />
                                @else
                                    <span class="badge badge-secondary"
                                          style="width: 120px; height: 120px; display: block; margin-right: 10px;">
                                        No Logo
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $sponsor->nom }}</td>
                        <td>{{ $sponsor->category }}</td>
                        <td>{{ $sponsor->description }}</td>
                        <td>
                            <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce sponsor?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucun exposant trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
