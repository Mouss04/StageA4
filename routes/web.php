<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SessisController;
use App\Http\Controllers\OrateurController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CommunicationsController;
use App\Http\Controllers\AuthController;

// Routes accessibles aux invités uniquement
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Routes protégées nécessitant une authentification
Route::middleware('auth')->group(function () {
    // Page d'accueil
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

                // Donner accès à toutes les routes sauf celles spécifiques à l'admin
                Route::resource('orateurs', OrateurController::class);
                // Route pour l'index des sessions (sessis)
                Route::get('/sessis', [SessisController::class, 'index'])->name('sessis.index');

                // Route pour l'index des communications
                Route::get('/communications', [CommunicationsController::class, 'index'])->name('communications.index');

                Route::resource('sponsors', SponsorController::class);
                Route::resource('salles', SalleController::class);
                Route::resource('questions', QuestionController::class);
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin.dashboard');


    // Route pour afficher la liste des utilisateurs
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    // Routes pour la gestion des utilisateurs
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');


    // Routes pour la gestion des sessions (sessis)


    // Afficher le formulaire de création d'une nouvelle session
    Route::get('/sessis/create', [SessisController::class, 'create'])->name('sessis.create');

    // Enregistrer une nouvelle session dans la base de données
    Route::post('/sessis', [SessisController::class, 'store'])->name('sessis.store');

    // Afficher une session spécifique
    Route::get('/sessis/{sessi}', [SessisController::class, 'show'])->name('sessis.show');

    // Afficher le formulaire de modification d'une session existante
    Route::get('/sessis/{sessi}/edit', [SessisController::class, 'edit'])->name('sessis.edit');

    // Mettre à jour une session dans la base de données
    Route::put('/sessis/{sessi}', [SessisController::class, 'update'])->name('sessis.update');

    // Supprimer une session
    Route::delete('/sessis/{sessi}', [SessisController::class, 'destroy'])->name('sessis.destroy');


    // Routes pour les sponsors

    Route::get('/sponsors/category/{category}', [SponsorController::class, 'showByCategory'])->name('sponsors.category');

    // Routes pour les questions

    Route::put('questions/updateRejetee/{id}', [QuestionController::class, 'updateRejetee'])->name('questions.updateRejetee');
    Route::put('questions/valider/{id}', [QuestionController::class, 'valider'])->name('questions.valider');
    Route::put('questions/rejeter/{id}', [QuestionController::class, 'rejeter'])->name('questions.rejeter');
    Route::put('questions/traiter/{id}', [QuestionController::class, 'traiter'])->name('questions.traiter');
    Route::post('questions/{id}/repondre', [QuestionController::class, 'repondre'])->name('questions.repondre');

    // Routes pour les communications
    Route::get('communications/create/{sessi_id}', [CommunicationsController::class, 'create'])->name('communications.create');
    Route::get('/communications/{id}', [CommunicationsController::class, 'show'])->name('communications.show');
    Route::post('/communications', [CommunicationsController::class, 'store'])->name('communications.store');
    Route::delete('/communications/{id}', [CommunicationsController::class, 'destroy'])->name('communications.destroy');
    Route::get('communications/{id}/edit', [CommunicationsController::class, 'edit'])->name('communications.edit');
    Route::put('communications/{id}', [CommunicationsController::class, 'update'])->name('communications.update');


});


// Routes accessibles uniquement aux sponsors
Route::middleware('auth', 'role:sponsor')->group(function () {
   Route::get('/sponsor', [HomeController::class, 'sponsor'])->name('sponsor.dashboard');

});

    // Routes accessibles uniquement aux orateurs
    Route::middleware(['auth', 'role:orateur'])->group(function () {
        Route::get('/orateur', [HomeController::class, 'orateur'])->name('orateur.dashboard');

    });

