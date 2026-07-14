<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SoutenanceController;
use App\Http\Controllers\JuryController;
use App\Http\Controllers\ProcesVerbalController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SujetController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\EncadreurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil — admin uniquement
    Route::middleware('role:admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Soutenances
    Route::resource('soutenances', SoutenanceController::class)->only(['index']);
    Route::middleware('role:admin')->group(function () {
        Route::resource('soutenances', SoutenanceController::class)->except(['index']);
    });

    // Jurys
    Route::resource('juries', JuryController::class)->only(['index']);
    Route::middleware('role:admin')->group(function () {
        Route::resource('juries', JuryController::class)->except(['index']);
    });

    // Archives
    Route::resource('archives', ArchiveController::class)->only(['index']);
    Route::get('archives/{archive}/download', [ArchiveController::class, 'download'])->name('archives.download');
    Route::middleware('role:admin')->group(function () {
        Route::resource('archives', ArchiveController::class)->except(['index']);
    });

    // PV
    Route::resource('pvs', ProcesVerbalController::class)->only(['index']);
    Route::get('pvs/{pv}/pdf', [ProcesVerbalController::class, 'genererPDF'])->name('pvs.pdf');
    Route::middleware('role:admin,enseignant')->group(function () {
        Route::resource('pvs', ProcesVerbalController::class)->only(['create', 'store', 'edit', 'update']);
    });
    Route::middleware('role:admin')->group(function () {
        Route::resource('pvs', ProcesVerbalController::class)->only(['destroy']);
    });

    // Sujets — accessible à tous
    Route::resource('sujets', SujetController::class);

    // Encadreurs — accessible à tous
    Route::resource('encadreurs', EncadreurController::class);

    // Demandes
    Route::resource('demandes', DemandeController::class)->only(['index', 'store']);
    Route::patch('/demandes/{demande}/accepter',        [DemandeController::class, 'accepter'])->name('demandes.accepter');
    Route::patch('/demandes/{demande}/refuser',         [DemandeController::class, 'refuser'])->name('demandes.refuser');
    Route::post('/demandes/{demande}/deposer-memoire',  [DemandeController::class, 'deposerMemoire'])->name('demandes.deposer');
    Route::patch('/demandes/{demande}/valider-memoire', [DemandeController::class, 'validerMemoire'])->name('demandes.valider-memoire');
    Route::patch('/demandes/{demande}/refuser-memoire', [DemandeController::class, 'refuserMemoire'])->name('demandes.refuser-memoire');
    Route::get('/demandes/{demande}/telecharger',       [DemandeController::class, 'telechargerMemoire'])->name('demandes.telecharger');

});

require __DIR__.'/auth.php';