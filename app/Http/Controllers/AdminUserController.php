<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupérer la valeur de la recherche
        $search = $request->query('search');

        // Filtrer les utilisateurs en fonction de la recherche (par nom, email ou rôle)
        $users = User::when($search, function ($query, $search) {
            return $query->where('nom_complet', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%')
                         ->orWhere('role', 'like', '%' . $search . '%');
        })->get();

        // Passer les utilisateurs filtrés à la vue
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'motdepasse' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,orateur,sponsor,visiteur', // Assure-toi que le rôle est valide
        ]);

        User::create([
            'nom_complet' => $request->nom_complet,
            'email' => $request->email,
            'motdepasse' => bcrypt($request->motdepasse),
            'role' => $request->role, // Attribue le rôle choisi
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::find($id);

        if (!$user) {
            // Gérer l'erreur si l'utilisateur n'existe pas
            return redirect()->route('admin.users.index')->with('error', 'Utilisateur non trouvé.');
        }

        // Passer la variable $user à la vue
        return view('admin.users.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Récupérer l'utilisateur avec l'ID donné
        $user = User::find($id);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'Utilisateur non trouvé.');
        }

        // Valider les données de la requête
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Assurer l'unicité sauf pour l'utilisateur actuel
            'role' => 'required|string|in:admin,orateur,sponsor,visiteur',
            // Ajoute d'autres règles si nécessaire
        ]);

        // Mettre à jour l'utilisateur
        $user->update([
            'nom_complet' => $request->input('nom_complet'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            // Ajoute d'autres champs à mettre à jour si nécessaire
        ]);

        // Rediriger après la mise à jour
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
