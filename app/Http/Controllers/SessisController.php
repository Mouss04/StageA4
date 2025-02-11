<?php

namespace App\Http\Controllers;

use App\Models\Sessi;
use App\Models\Orateur;
use App\Models\Salle;
use App\Http\Controllers\SalleController;

use Illuminate\Http\Request;

class SessisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Charger les sessions avec les orateurs et les communications, triées par date et heure de début
        $sessis = Sessi::with(['orateurs', 'communications.salle'])
                       ->orderBy('date', 'asc')
                       ->orderBy('heure_debut', 'asc')
                       ->get();

        // Charger toutes les salles disponibles
        $salles = Salle::all();

        // Passer les données à la vue
        return view('sessis.index', compact('sessis', 'salles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Récupérer tous les orateurs
        $orateurs = Orateur::all();

        // Retourner la vue de création avec les orateurs
        return view('sessis.create', compact('orateurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'orateurs' => 'nullable|array',
            'orateurs.*' => 'exists:orateurs,id',
            'communications' => 'nullable|array',
            'communications.*.titre' => 'required|string|max:255',
            'communications.*.description' => 'nullable|string',
            'communications.*.date' => 'required|date',
            'communications.*.heure_debut' => 'required|date_format:H:i',
            'communications.*.heure_fin' => 'required|date_format:H:i|after:communications.*.heure_debut',
            'communications.*.type' => 'required|in:communication,symposium,atelier,pause',
            'communications.*.salle_id' => 'required|exists:salles,id',
        ]);

        $sessi = Sessi::create($validated);

        if (isset($validated['orateurs'])) {
            $sessi->orateurs()->attach($validated['orateurs']);
        }

        if (isset($validated['communications'])) {
            foreach ($validated['communications'] as $communication) {
                $sessi->communications()->create($communication);
            }
        }

        return redirect()->route('sessis.index')->with('success', 'Session et communications créées avec succès.');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupérer la session à modifier
        $sessi = Sessi::findOrFail($id);

        // Formater les heures pour le bon format (H:i)
        $sessi->heure_debut = date('H:i', strtotime($sessi->heure_debut));
        $sessi->heure_fin = date('H:i', strtotime($sessi->heure_fin));

        $sessi = Sessi::with('communications')->findOrFail($id); // Récupérer la session avec ses communications
        $salles = Salle::all(); // Récupérer toutes les salles

        // Récupérer tous les orateurs
        $orateurs = Orateur::all();

        // Retourner la vue de modification avec les orateurs et la session
        return view('sessis.edit', compact('sessi', 'salles', 'orateurs'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    // Validation des données
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'date' => 'required|date',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i|after:heure_debut',
        'orateurs' => 'nullable|array',
    ]);

    // Trouver la session par ID et la mettre à jour
    $sessi = Sessi::findOrFail($id);
    $sessi->update([
        'nom' => $validated['nom'],
        'date' => $validated['date'],
        'heure_debut' => $validated['heure_debut'],
        'heure_fin' => $validated['heure_fin'],
    ]);

    // Mettre à jour les orateurs
    if (isset($validated['orateurs'])) {
        $sessi->orateurs()->sync($validated['orateurs']);
    }

    return redirect()->route('sessis.index')->with('success', 'Session mise à jour avec succès');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer la session à supprimer
        $sessi = Sessi::findOrFail($id);

        // Supprimer la session
        $sessi->delete();

        // Rediriger vers la liste des sessions avec un message de succès
        return redirect()->route('sessis.index')->with('success', 'Session supprimée avec succès.');
    }
}
