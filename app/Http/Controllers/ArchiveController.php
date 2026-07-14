<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Archive::with('soutenance');

        if ($user->isEtudiant()) {
            $query->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
        } elseif ($user->isEnseignant()) {
            $query->whereHas('soutenance.juries', fn ($q) => $q->where('user_id', $user->id));
        }
        // admin : aucun filtre, voit tout

        if ($request->filled('annee')) {
            $query->where('annee_universitaire', $request->annee);
        }
        if ($request->filled('type')) {
            $query->where('type_document', $request->type);
        }

        $archives = $query->orderBy('created_at', 'desc')->get();
        $annees = Archive::select('annee_universitaire')->distinct()->pluck('annee_universitaire');
        return view('archives.index', compact('archives', 'annees'));
    }

    public function create()
    {
        $soutenances = Soutenance::orderBy('date_soutenance')->get();
        return view('archives.create', compact('soutenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'soutenance_id'      => 'required|exists:soutenances,id',
            'type_document'      => 'required|string|max:100',
            'annee_universitaire'=> 'required|string|max:20',
            'description'        => 'nullable|string',
            'fichier'            => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $fichier = $request->file('fichier');
        $nomFichier = time() . '_' . $fichier->getClientOriginalName();
        $chemin = $fichier->storeAs('archives', $nomFichier, 'public');

        Archive::create([
            'soutenance_id'       => $request->soutenance_id,
            'nom_fichier'         => $fichier->getClientOriginalName(),
            'chemin_fichier'      => $chemin,
            'type_document'       => $request->type_document,
            'annee_universitaire' => $request->annee_universitaire,
            'description'         => $request->description,
        ]);

        return redirect()->route('archives.index')
                         ->with('success', 'Document archivé avec succès !');
    }

    public function download(Archive $archive)
    {
        $user = auth()->user();
        if ($user->isEtudiant()) {
            abort_unless($archive->soutenance->etudiant_id === $user->id, 403);
        } elseif ($user->isEnseignant()) {
            $autorise = $archive->soutenance->juries()->where('user_id', $user->id)->exists();
            abort_unless($autorise, 403);
        }

        return Storage::disk('public')->download($archive->chemin_fichier, $archive->nom_fichier);
    }

    public function destroy(Archive $archive)
    {
        Storage::disk('public')->delete($archive->chemin_fichier);
        $archive->delete();
        return redirect()->route('archives.index')
                         ->with('success', 'Archive supprimée.');
    }
}