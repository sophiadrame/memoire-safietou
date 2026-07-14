<?php

namespace App\Http\Controllers;

use App\Models\Sujet;
use App\Models\User;
use Illuminate\Http\Request;

class SujetController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $sujets = Sujet::with(['encadreur.encadreurProfil'])->latest()->get();
        } elseif ($user->isEnseignant()) {
            $sujets = Sujet::with(['encadreur.encadreurProfil'])
                ->where('encadreur_id', $user->id)->latest()->get();
        } else {
            $sujets = Sujet::with(['encadreur.encadreurProfil'])
                ->where('statut', 'disponible')->latest()->get();
        }

        return view('sujets.index', compact('sujets'));
    }

    public function show(Sujet $sujet)
    {
        $sujet->load('encadreur.encadreurProfil');
        $dejaDemandeParEtudiant = false;

        if (auth()->user()->isEtudiant()) {
            $dejaDemandeParEtudiant = $sujet->demandes()
                ->where('etudiant_id', auth()->id())
                ->exists();
        }

        return view('sujets.show', compact('sujet', 'dejaDemandeParEtudiant'));
    }

    public function create()
    {
        $encadreurs = User::where('role', 'enseignant')->get();
        return view('sujets.create', compact('encadreurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'filiere'     => 'required|string|max:100',
            'niveau'      => 'required|string|max:50',
            'type'        => 'required|in:PFE,Mémoire,Thèse',
            'encadreur_id'=> 'required|exists:users,id',
            'mots_cles'   => 'nullable|string|max:255',
        ]);

        Sujet::create($request->all());

        return redirect()->route('sujets.index')
            ->with('success', 'Sujet créé avec succès !');
    }

    public function edit(Sujet $sujet)
    {
        $encadreurs = User::where('role', 'enseignant')->get();
        return view('sujets.edit', compact('sujet', 'encadreurs'));
    }

    public function update(Request $request, Sujet $sujet)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'filiere'     => 'required|string|max:100',
            'niveau'      => 'required|string|max:50',
            'type'        => 'required|in:PFE,Mémoire,Thèse',
            'encadreur_id'=> 'required|exists:users,id',
            'statut'      => 'required|in:disponible,pris,archivé',
            'mots_cles'   => 'nullable|string|max:255',
        ]);

        $sujet->update($request->all());

        return redirect()->route('sujets.index')
            ->with('success', 'Sujet mis à jour.');
    }

    public function destroy(Sujet $sujet)
    {
        $sujet->delete();
        return redirect()->route('sujets.index')
            ->with('success', 'Sujet supprimé.');
    }
}