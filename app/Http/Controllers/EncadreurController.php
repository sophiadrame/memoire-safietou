<?php

namespace App\Http\Controllers;

use App\Models\Encadreur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EncadreurController extends Controller
{
    public function index()
    {
        $encadreurs = Encadreur::with('user')->get();
        return view('encadreurs.index', compact('encadreurs'));
    }

    public function show(Encadreur $encadreur)
    {
        $encadreur->load(['user', 'user.sujetsProposer']);
        return view('encadreurs.show', compact('encadreur'));
    }

    public function create()
    {
        $enseignants = User::where('role', 'enseignant')
            ->doesntHave('encadreurProfil')->get();
        return view('encadreurs.create', compact('enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'grade'        => 'required|string|max:100',
            'specialite'   => 'required|string|max:100',
            'bureau'       => 'nullable|string|max:100',
            'telephone'    => 'nullable|string|max:20',
            'bio'          => 'nullable|string',
            'cv_fichier'   => 'nullable|file|mimes:pdf|max:5120',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'max_etudiants'=> 'required|integer|min:1|max:10',
        ]);

        $data = $request->except(['cv_fichier', 'photo']);

        if ($request->hasFile('cv_fichier')) {
            $data['cv_fichier'] = $request->file('cv_fichier')->store('cvs', 'public');
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Encadreur::create($data);

        return redirect()->route('encadreurs.index')
            ->with('success', 'Profil encadreur créé avec succès !');
    }

    public function edit(Encadreur $encadreur)
    {
        $enseignants = User::where('role', 'enseignant')->get();
        return view('encadreurs.edit', compact('encadreur', 'enseignants'));
    }

    public function update(Request $request, Encadreur $encadreur)
    {
        $request->validate([
            'grade'        => 'required|string|max:100',
            'specialite'   => 'required|string|max:100',
            'bureau'       => 'nullable|string|max:100',
            'telephone'    => 'nullable|string|max:20',
            'bio'          => 'nullable|string',
            'cv_fichier'   => 'nullable|file|mimes:pdf|max:5120',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'max_etudiants'=> 'required|integer|min:1|max:10',
        ]);

        $data = $request->except(['cv_fichier', 'photo']);

        if ($request->hasFile('cv_fichier')) {
            if ($encadreur->cv_fichier) {
                Storage::disk('public')->delete($encadreur->cv_fichier);
            }
            $data['cv_fichier'] = $request->file('cv_fichier')->store('cvs', 'public');
        }

        if ($request->hasFile('photo')) {
            if ($encadreur->photo) {
                Storage::disk('public')->delete($encadreur->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $encadreur->update($data);

        return redirect()->route('encadreurs.index')
            ->with('success', 'Profil encadreur mis à jour.');
    }

    public function destroy(Encadreur $encadreur)
    {
        if ($encadreur->cv_fichier) Storage::disk('public')->delete($encadreur->cv_fichier);
        if ($encadreur->photo) Storage::disk('public')->delete($encadreur->photo);
        $encadreur->delete();
        return redirect()->route('encadreurs.index')
            ->with('success', 'Profil supprimé.');
    }
}