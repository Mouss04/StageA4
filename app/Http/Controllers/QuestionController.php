<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        // Comptez les questions selon leur statut
        $en_attente = Question::where('statut', 'en_attente')->count();
        $valides_count = Question::where('statut', 'validée')->count();
        $traitees = Question::where('statut', 'traitée')->count();
        $rejetees = Question::where('statut', 'rejetée')->count();

        // Récupérez les questions selon leur statut
        $questions_en_attente = Question::where('statut', 'en_attente')->with(['communication', 'orateur'])->get();
        $valides = Question::where('statut', 'validée')->with(['communication', 'orateur'])->get();
        $questions_traitees = Question::where('statut', 'traitée')->with(['communication', 'orateur'])->get();
        $questions_rejetees = Question::where('statut', 'rejetée')->with(['communication', 'orateur'])->get();

        // Passez toutes les variables à la vue
        return view('questions.index', compact(
            'en_attente',
            'valides_count',
            'traitees',
            'rejetees',
            'questions_en_attente',
            'valides',
            'questions_traitees',
            'questions_rejetees'
        ));
    }


    public function create(Request $request)
    {
        // Récupère toutes les communications
        $communications = Communication::all();
        $orateurs = collect();  // Initialisation d'une collection vide pour les orateurs

        // Si une communication est sélectionnée, récupérer ses orateurs
        if ($request->has('communication_id') && $request->communication_id) {
            $communication = Communication::find($request->communication_id);
            if ($communication) {
                // Récupère les orateurs associés à la communication sélectionnée
                $orateurs = $communication->orateurs; // Utilisation de la relation many-to-many
            }
        }

        return view('questions.create', compact('communications', 'orateurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contenu' => 'required|string',
            'communication_id' => 'required|exists:communications,id',
            'orateur_id' => 'nullable|exists:orateurs,id',
        ]);

        // Créer la question
        Question::create($validated);

        return redirect()->route('questions.create')->with('success', 'Votre question a été soumise.');
    }

    public function getOrateurs($communicationId)
    {
        // Trouver la communication avec ses orateurs
        $communication = Communication::with('orateurs')->find($communicationId);

        if (!$communication) {
            return response()->json([], 404); // Retourner une réponse vide si la communication n'existe pas
        }

        // Retourner les orateurs au format JSON
        return response()->json($communication->orateurs);
    }

    public function showCommunicationWithOrateurs($id)
    {
        // Récupérer la communication avec ses orateurs associés
        $communication = Communication::with('orateurs')->find($id);

        // Vérifier si la communication existe
        if (!$communication) {
            return redirect()->back()->with('error', 'Communication non trouvée.');
        }

        // Passer la communication et les orateurs à la vue
        return view('communications.show', compact('communication', 'communication->orateurs'));
    }

    public function valider($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Question non trouvée.');
        }

        $question->statut = 'validée';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'Question validée avec succès.');
    }

    public function rejeter($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Question non trouvée.');
        }

        $question->statut = 'rejetée';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'Question rejetée avec succès.');
    }


    public function traiter($id)
    {
        $question = Question::find($id);

        if (!$question || $question->statut != 'validée') {
            return redirect()->back()->with('error', 'Impossible de marquer la question comme traitée.');
        }

        // Stocker la réponse directement
        $question->statut = 'traitée';
        $question->reponse = 'Réponse donnée oralement par l’orateur.'; // La réponse par défaut
        $question->save();

        return redirect()->route('questions.index')->with('success', 'La question a été marquée comme traitée et la réponse a été enregistrée.');
    }

        public function updateRejetee(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question || $question->statut != 'rejetée') {
            return redirect()->back()->with('error', 'Impossible de modifier cette question.');
        }

        // Valider le contenu mis à jour
        $validated = $request->validate([
            'contenu' => 'required|string',
        ]);

        // Mettre à jour la question et la valider
        $question->contenu = $validated['contenu'];
        $question->statut = 'validée';
        $question->save();

        return redirect()->route('questions.index')->with('success', 'La question a été modifiée et validée.');
    }

        public function repondre(Request $request, $id)
    {
        // Récupérer la question
        $question = Question::find($id);

        if (!$question || $question->statut != 'validée') {
            return redirect()->back()->with('error', 'Impossible de répondre à cette question.');
        }

        // Validation de la réponse
        $validated = $request->validate([
            'reponse' => 'required|string',
        ]);

        // Mettre à jour la question avec la réponse manuelle
        $question->reponse = $validated['reponse'];
        $question->statut = 'traitée';  // Marquer la question comme traitée
        $question->save();

        return redirect()->route('questions.index')->with('success', 'La question a été traitée et la réponse a été enregistrée.');
    }


}
