<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $categories = Sponsor::select('category')->distinct()->get();

        $query = Sponsor::query();

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $sponsors = $query->get();

        return view('sponsors.index', compact('sponsors', 'categories'));
    }

    public function create()
    {
        return view('sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'fichier' => 'nullable|array|max:10240', // Permet plusieurs fichiers
            'fichier.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,avi|max:10240', // Acceptation de plusieurs types de fichiers
        ]);

        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null;

        // Gestion des fichiers
        $fichiersPaths = [];
        if ($request->hasFile('fichier')) {
            foreach ($request->file('fichier') as $file) {
                $fichiersPaths[] = $file->store('fichiers', 'public');
            }
        }

        // Crée un nouveau sponsor avec le logo et les fichiers
        $sponsor = Sponsor::create([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'logo' => $logoPath,
            'fichier' => json_encode($fichiersPaths), // Stocke les fichiers sous forme de tableau JSON
        ]);

        return redirect()->route('sponsors.index')->with('success', 'Sponsor créé avec succès!');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'fichier' => 'nullable|array|max:10240', // Permet plusieurs fichiers
            'fichier.*' => 'file|mimes:jpg,jpeg,png,pdf,mp4,avi|max:10240',
        ]);

        // Gestion du logo
        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::delete('public/' . $sponsor->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = $sponsor->logo;
        }

        // Gestion des fichiers
        $fichiersPaths = json_decode($sponsor->fichier, true) ?: [];
        if ($request->hasFile('fichier')) {
        foreach ($fichiersPaths as $fichier) {
            Storage::delete('public/' . $fichier);
            }
        foreach ($request->file('fichier') as $file) {
            $fichiersPaths[] = $file->store('fichiers', 'public');
            }
        }

        $sponsor->update([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'logo' => $logoPath,
            'fichier' => json_encode($fichiersPaths),
        ]);

        return redirect()->route('sponsors.index')->with('success', 'Sponsor mis à jour avec succès!');
    }


    public function destroy(Sponsor $sponsor)
    {
        // Supprimer le logo
        if ($sponsor->logo) {
            Storage::delete('public/' . $sponsor->logo);
        }

        // Supprimer les fichiers
        if ($sponsor->fichier) {
            $fichiersPaths = json_decode($sponsor->fichier, true);
            foreach ($fichiersPaths as $fichier) {
                Storage::delete('public/' . $fichier);
            }
        }

        $sponsor->delete();

        return redirect()->route('sponsors.index')->with('success', 'Sponsor supprimé avec succès!');
    }


    public function showByCategory($category)
    {
        $categories = Sponsor::select('category')->distinct()->get();
        $sponsors = Sponsor::where('category', $category)->get();

        return view('sponsors.index', compact('sponsors', 'categories'));
    }
}
