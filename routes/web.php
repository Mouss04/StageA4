<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ProgramSessionController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\App;

Route::get('/', function () {
    return view('home.home');
})->name('home');

// Authentication Routes (Registration & Login)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Users
Route::resource('users', UserController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update/{user}', [UserController::class, 'updateProfile'])->name('profile.update');
});

// Sponsors
Route::resource('sponsors', SponsorController::class);

// Speakers
Route::resource('speakers', SpeakerController::class);

// Rooms
Route::resource('rooms', RoomController::class);

// Questions
Route::resource('questions', QuestionController::class);

Route::prefix('questions')->name('questions.')->group(function () {
    Route::post('/{id}/validate', [QuestionController::class, 'validateQuestion'])->name('validate'); // Validate question
    Route::post('/{id}/reject', [QuestionController::class, 'reject'])->name('reject'); // Reject question
    Route::post('/{id}/process', [QuestionController::class, 'process'])->name('process'); // Process question (answered verbally)
    Route::put('/{id}/update-rejected', [QuestionController::class, 'updateRejected'])->name('update-rejected'); // Edit rejected question
    Route::post('/{id}/respond', [QuestionController::class, 'respond'])->name('respond'); // Provide an answer to a validated question
});


// Program Sessions
Route::resource('program_sessions', ProgramSessionController::class);

// Favorites
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
Route::get('/favorites/toggle/{modelType}/{modelId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Communications
Route::resource('communications', CommunicationController::class);


Route::get('/verify-qr/{id}', function ($id) {
    $user = User::find($id);

    if (!$user) {
        return view('verification.error', ['message' => 'Invalid QR Code!']);
    }

    if ($user->scanned) {
        return view('verification.checked', compact('user'));
    }

    // Update the scanned field to true
    $user->update(['scanned' => true]);

    return view('verification.success', compact('user'));
})->name('verify.qr');

Route::get('locale/{lang}', function ($lang) {
    session(['applocale' => $lang]);
    App::setLocale($lang);
    return back();
})->name('locale');
