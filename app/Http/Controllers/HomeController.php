<?php

namespace App\Http\Controllers;
use App\Models\Sessi; // Importer le modèle

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $sessis = Sessi::all(); // Récupérer toutes les sessions
        return view('home.home', compact('sessis'));
    }
}
