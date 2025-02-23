<?php

namespace App\Http\Controllers;

use App\Models\ProgramSession;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $programSessions = ProgramSession::all();
        return view('home.home', compact('programSessions'));
    }
}
