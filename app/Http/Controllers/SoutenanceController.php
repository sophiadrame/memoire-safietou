<?php

namespace App\Http\Controllers;

use App\Models\Soutenance;
use Illuminate\Http\Request;

class SoutenanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Soutenance::orderBy('date_soutenance');

        if ($user->isEtudiant()) {
            $query->where('etudiant_id', $user->id);
        } elseif ($user->isEnseignant()) {
            $query->whereHas('juries', fn ($q) => $q->where('user_id', $user->id));
        }
        // admin : aucun filtre, voit tout

        $soutenances = $query->get();
        return view('soutenances.index', compact('soutenances'));
    }

    public function create()
    {
        $etudiants = \App\Models\User::where('role', 'etudiant')->orderBy('name')->get();
        return view('soutenances.create', compact('etudiants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id'     => 'nullable|exists:users,id',
            'titre_memoire'   => 'required|string|max:255',
            'etudiant_nom'    => 'required|string|max:100',
            'etudiant_prenom' => 'required|string|max:100',
            'filiere'         => 'required|string|max:100',
            'date_soutenance' => 'required|date',
            'heure_debut'     => 'required',
            'heure_fin'       => 'required|after:heure_debut',
            'salle'           => 'required|string|max:50',
        ]);

        Soutenance::create($request->all());
        return redirect()->route('soutenances.index')
                         ->with('success', 'Soutenance planifiée avec succès !');
    }

    public function edit(Soutenance $soutenance)
    {
        return view('soutenances.edit', compact('soutenance'));
    }

    public function update(Request $request, Soutenance $soutenance)
    {
        $request->validate([
            'titre_memoire'   => 'required|string|max:255',
            'etudiant_nom'    => 'required|string|max:100',
            'etudiant_prenom' => 'required|string|max:100',
            'filiere'         => 'required|string|max:100',
            'date_soutenance' => 'required|date|after:today',
            'heure_debut'     => 'required',
            'heure_fin'       => 'required|after:heure_debut',
            'salle'           => 'required|string|max:50',
            'statut'          => 'required',
        ]);

        $soutenance->update($request->all());
        return redirect()->route('soutenances.index')
                         ->with('success', 'Soutenance modifiée avec succès !');
    }

    public function destroy(Soutenance $soutenance)
    {
        $soutenance->delete();
        return redirect()->route('soutenances.index')
                         ->with('success', 'Soutenance supprimée.');
    }
}