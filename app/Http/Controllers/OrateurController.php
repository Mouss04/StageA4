<?php

namespace App\Http\Controllers;
use App\Models\Orateur;

use Illuminate\Http\Request;

class OrateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupérer le terme de recherche depuis le champ "search" (s'il existe)
        $search = $request->input('search');

        // Filtrer les orateurs par nom complet si un terme de recherche est présent
        $orateurs = Orateur::when($search, function ($query, $search) {
            return $query->where('nom_complet', 'like', "%{$search}%");
        })->get();

        // Retourner la vue avec les orateurs filtrés et la variable de recherche
        return view('orateurs.index', compact('orateurs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'biographie' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gestion du fichier photo (s'il y en a un)
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos_orateurs', 'public');
        }

        // Créer un nouvel orateur
        Orateur::create([
            'nom_complet' => $validated['nom_complet'],
            'biographie' => $validated['biographie'],
            'photo' => $photoPath,
        ]);

        return redirect()->route('orateurs.index')->with('success', 'Orateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $orateur = Orateur::with('communications')->findOrFail($id);

        return view('orateurs.show', compact('orateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orateur = Orateur::findOrFail($id);
        return view('orateurs.edit', compact('orateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Valider les données
    $validated = $request->validate([
        'nom_complet' => 'required|string|max:255',
        'biographie' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Récupérer l'orateur
    $orateur = Orateur::findOrFail($id);

    // Si une nouvelle photo est téléchargée
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo du disque si elle existe
        if ($orateur->photo && file_exists(storage_path('app/public/' . $orateur->photo))) {
            unlink(storage_path('app/public/' . $orateur->photo));
        }

        // Enregistrer la nouvelle photo
        $photoPath = $request->file('photo')->store('photos_orateurs', 'public');
        $validated['photo'] = $photoPath; // Ajouter le chemin de la photo dans les données validées
    } else {
        // Si aucune nouvelle photo n'est téléchargée, conserver l'ancienne photo
        $validated['photo'] = $orateur->photo;
    }

    // Mettre à jour les données de l'orateur
    $orateur->update($validated);

    // Rediriger avec un message de succès
    return redirect()->route('orateurs.index')->with('success', 'Orateur mis à jour avec succès');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orateur = Orateur::findOrFail($id);
        $orateur->delete();

        return redirect()->route('orateurs.index')->with('success', 'Orateur supprimé avec succès');
    }
}
