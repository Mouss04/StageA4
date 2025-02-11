<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Sessi;
use App\Models\Salle;
use App\Models\Orateur;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CommunicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($sessi_id)
    {
        $sessi = Sessi::findOrFail($sessi_id);  // Trouve la session avec l'ID
        $communications = Communication::where('sessis_id', $sessi_id)->distinct()->get(); // Récupère les communications de cette session

        return view('communications.index', compact('communications', 'sessi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sessi_id)
    {
        $sessi = Sessi::findOrFail($sessi_id); // Vérifie si la session existe
        $salles = Salle::all();
        $orateurs = Orateur::all();

        return view('communications.create', compact('sessi', 'salles', 'orateurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255|unique:communications,titre,NULL,id,sessis_id,' . $request->sessis_id,
            'description' => 'nullable|string',
            'type' => 'required|string|in:communication,symposium,atelier,pause',
            'salle_id' => 'required|exists:salles,id',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i|before:heure_fin',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'sessis_id' => 'required|exists:sessis,id',  // Valider l'ID de la session
            'orateurs' => 'array|nullable', // Valider un tableau d'IDs d'orateurs
            'orateurs.*' => 'exists:orateurs,id', // Chaque ID doit exister dans la table orateurs
        ]);

        $communication = Communication::create($validated);

        // Associer les orateurs à la communication
        if (!empty($validated['orateurs'])) {
            $communication->orateurs()->sync($validated['orateurs']);
        }

        // Trouver la session avec l'ID
        $sessi = Sessi::findOrFail($validated['sessis_id']);

        // Le fuseau horaire de la session
        $sessionTimezone = $sessi->timezone ?? 'UTC';  // Par défaut 'UTC' si le fuseau horaire n'est pas défini

        // Conversion de la date et heure de début de la communication dans le fuseau horaire de la session
        $communicationDateDebut = Carbon::parse($validated['date'] . ' ' . $validated['heure_debut'])
                                       ->setTimezone($sessionTimezone); // Convertir dans le fuseau horaire de la session

        // Convertir l'heure de fin de la communication dans le fuseau horaire de la session
        $communicationDateFin = Carbon::parse($validated['date'] . ' ' . $validated['heure_fin'])
                                      ->setTimezone($sessionTimezone); // Convertir dans le fuseau horaire de la session

        // Comparer la date de la communication avec celle de la session
        $sessionDate = Carbon::parse($sessi->date)->setTimezone($sessionTimezone)->startOfDay();

        // Vérifier que la date de la communication est la même que celle de la session (juste la date sans l'heure)
        if (!$communicationDateDebut->isSameDay($sessionDate)) {
            return redirect()->back()->withErrors(['date_mismatch' => 'La date de la communication doit être la même que celle de la session.']);
        }

        // Vérifier si une communication avec les mêmes paramètres existe déjà
        $existingCommunication = Communication::where('titre', $validated['titre'])
                                              ->where('date', $validated['date'])
                                              ->where('sessis_id', $validated['sessis_id'])
                                              ->first();

        if ($existingCommunication) {
            return redirect()->back()->withErrors(['duplicate' => 'Cette communication existe déjà pour cette session.']);
        }

        // Créer la communication si elle n'existe pas
        $communication = new Communication();
        $communication->titre = $validated['titre'];
        $communication->description = $validated['description'];
        $communication->type = $validated['type'];
        $communication->date = $validated['date'];
        $communication->heure_debut = $validated['heure_debut'];
        $communication->heure_fin = $validated['heure_fin'];
        $communication->salle_id = $validated['salle_id'];
        $communication->sessis_id = $validated['sessis_id'];
        $communication->save();

        // Rediriger vers la page des communications de la session
        return redirect()->route('sessis.communications', $validated['sessis_id'])->with('success', 'Communication créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer la communication avec les questions traitées et les relations nécessaires
        $communication = Communication::with([
            'orateurs',
            'salle',
            'questions' => function ($query) {
                $query->where('statut', 'traitée'); // Filtrer uniquement les questions traitées
            }
        ])->findOrFail($id);

        // Retourner la vue avec les données nécessaires
        return view('communications.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $communication = Communication::findOrFail($id);
        $sessi = Sessi::all(); // Récupère toutes les sessions
        $salles = Salle::all();   // Récupère toutes les salles
        $orateurs = Orateur::all(); // Récupère tous les orateurs

        return view('communications.edit', compact('communication', 'sessi', 'salles', 'orateurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'type' => 'required|in:communication,symposium,atelier,pause',
            'sessis_id' => 'required|exists:sessis,id',
            'salle_id' => 'required|exists:salles,id',
            'orateurs' => 'array|nullable',
            'orateurs.*' => 'exists:orateurs,id',
        ]);

        // Trouver la communication par ID
        $communication = Communication::findOrFail($id);

        // Mise à jour de la communication
        $communication->update($validated);

        // Mettre à jour les orateurs associés
        if (!empty($validated['orateurs'])) {
            $communication->orateurs()->sync($validated['orateurs']);
        } else {
            $communication->orateurs()->detach(); // Supprimer tous les orateurs si aucun n'est fourni
        }

        // Rediriger avec un message de succès
        return redirect()->route('communications.index', $communication->sessis_id)
            ->with('success', 'Communication mise à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Récupérer la communication par son ID
        $communication = Communication::findOrFail($id);

        // Supprimer la communication
        $communication->delete();

        // Rediriger vers la page de la session ou la liste des communications
        return redirect()->route('sessis.show', $communication->sessis_id)
                         ->with('success', 'Communication supprimée avec succès.');
    }
}
