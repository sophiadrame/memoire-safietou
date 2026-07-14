<?php

namespace App\Http\Controllers;

use App\Models\Soutenance;
use App\Models\Jury;
use App\Models\ProcesVerbal;
use App\Models\Archive;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $soutenanceQuery = Soutenance::query();
        $juryQuery = Jury::query();
        $pvQuery = ProcesVerbal::query();
        $archiveQuery = Archive::query();

        if ($user->isEtudiant()) {
            $soutenanceQuery->where('etudiant_id', $user->id);
            $juryQuery->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
            $pvQuery->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
            $archiveQuery->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
        } elseif ($user->isEnseignant()) {
            $soutenanceQuery->whereHas('juries', fn ($q) => $q->where('user_id', $user->id));
            $juryQuery->where('user_id', $user->id);
            $pvQuery->whereHas('soutenance.juries', fn ($q) => $q->where('user_id', $user->id));
            $archiveQuery->whereHas('soutenance.juries', fn ($q) => $q->where('user_id', $user->id));
        }
        // admin : aucun filtre

        $totalSoutenances = (clone $soutenanceQuery)->count();
        $soutenancesPlanifiees = (clone $soutenanceQuery)->where('statut', 'planifiée')->count();
        $soutenancesTerminees = (clone $soutenanceQuery)->where('statut', 'terminée')->count();
        $totalJury = (clone $juryQuery)->count();
        $totalPV = (clone $pvQuery)->count();
        $totalArchives = (clone $archiveQuery)->count();

        $prochainesSoutenances = (clone $soutenanceQuery)->where('date_soutenance', '>=', now())
            ->orderBy('date_soutenance')
            ->take(5)
            ->get();

        $dernieresArchives = (clone $archiveQuery)->with('soutenance')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSoutenances',
            'soutenancesPlanifiees',
            'soutenancesTerminees',
            'totalJury',
            'totalPV',
            'totalArchives',
            'prochainesSoutenances',
            'dernieresArchives'
        ));
    }
}