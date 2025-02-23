<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\User;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the favorites.
     */
    public function index()
    {
        $user = auth()->user();

        // Get all the user's favorites and group them by model type
        $favorites = Favorite::where('user_id', $user->id)
            ->get()
            ->groupBy('model_type');

        return view('favorites.index', compact('favorites'));
    }


    /**
     * Show the form for creating a new favorite.
     */
    public function create()
    {
        $users = User::all();
        return view('favorites.create', compact('users'));
    }

    /**
     * Store a newly created favorite in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        Favorite::create($request->all());

        return redirect()->back()->with('success', 'Favori ajouté avec succès.');
    }
    public function toggle($modelType, $modelId)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to favorite items.');
        }

        // Check if the favorite already exists
        $favorite = Favorite::where('user_id', $user->id)
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->first();

        if ($favorite) {
            // If exists, remove it (unfavorite)
            $favorite->delete();
            return redirect()->back()->with('success', 'Removed from favorites.');
        } else {
            // Otherwise, add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'model_type' => $modelType,
                'model_id' => $modelId,
            ]);
            return redirect()->back()->with('success', 'Added to favorites.');
        }
    }

    /**
     * Display the specified favorite.
     */
    public function show(Favorite $favorite)
    {
        return view('favorites.show', compact('favorite'));
    }

    /**
     * Show the form for editing the specified favorite.
     */
    public function edit(Favorite $favorite)
    {
        $users = User::all();
        return view('favorites.edit', compact('favorite', 'users'));
    }

    /**
     * Update the specified favorite in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $favorite->update($request->all());

        return redirect()->route('favorites.index')->with('success', 'Favori mis à jour avec succès.');
    }

    /**
     * Remove the specified favorite from storage.
     */
    public function destroy(Favorite $favorite)
    {
        $favorite->delete();
        return redirect()->route('favorites.index')->with('success', 'Favori supprimé avec succès.');
    }
}
