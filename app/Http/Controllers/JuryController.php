<?php

namespace App\Http\Controllers;

use App\Models\Jury;
use App\Models\Soutenance;
use Illuminate\Http\Request;

class JuryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Jury::with('soutenance')->orderBy('created_at', 'desc');

        if ($user->isEtudiant()) {
            $query->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
        } elseif ($user->isEnseignant()) {
            $query->where('user_id', $user->id);
        }
        // admin : aucun filtre, voit tout

        $juries = $query->get();
        return view('juries.index', compact('juries'));
    }

    public function create()
    {
        $soutenances = Soutenance::orderBy('date_soutenance')->get();
        $enseignants = \App\Models\User::where('role', 'enseignant')->orderBy('name')->get();
        return view('juries.create', compact('soutenances', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'soutenance_id' => 'required|exists:soutenances,id',
            'user_id'       => 'nullable|exists:users,id',
            'nom'           => 'required|string|max:100',
            'prenom'        => 'required|string|max:100',
            'email'         => 'nullable|email|max:150',
            'telephone'     => 'nullable|string|max:20',
            'role'          => 'required|in:président,rapporteur,examinateur',
            'grade'         => 'nullable|string|max:100',
        ]);

        Jury::create($request->all());
        return redirect()->route('juries.index')
                         ->with('success', 'Membre du jury ajouté avec succès !');
    }

    public function edit(Jury $jury)
    {
        $soutenances = Soutenance::orderBy('date_soutenance')->get();
        $enseignants = \App\Models\User::where('role', 'enseignant')->orderBy('name')->get();
        return view('juries.edit', compact('jury', 'soutenances', 'enseignants'));
    }

    public function update(Request $request, Jury $jury)
    {
        $request->validate([
            'soutenance_id' => 'required|exists:soutenances,id',
            'nom'           => 'required|string|max:100',
            'prenom'        => 'required|string|max:100',
            'email'         => 'nullable|email|max:150',
            'telephone'     => 'nullable|string|max:20',
            'role'          => 'required|in:président,rapporteur,examinateur',
            'grade'         => 'nullable|string|max:100',
        ]);

        $jury->update($request->all());
        return redirect()->route('juries.index')
                         ->with('success', 'Membre du jury modifié avec succès !');
    }

    public function destroy(Jury $jury)
    {
        $jury->delete();
        return redirect()->route('juries.index')
                         ->with('success', 'Membre supprimé.');
    }
}