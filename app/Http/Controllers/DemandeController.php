<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Sujet;
use App\Models\Encadreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DemandeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $demandes = Demande::with(['etudiant', 'sujet', 'encadreur'])
                ->latest()->get();
        } elseif ($user->isEnseignant()) {
            $demandes = Demande::with(['etudiant', 'sujet'])
                ->where('encadreur_id', $user->id)
                ->latest()->get();
        } else {
            $demandes = Demande::with(['sujet', 'encadreur'])
                ->where('etudiant_id', $user->id)
                ->latest()->get();
        }

        return view('demandes.index', compact('demandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sujet_id'         => 'required|exists:sujets,id',
            'message_etudiant' => 'nullable|string|max:500',
        ]);

        $sujet = Sujet::findOrFail($request->sujet_id);

        // Vérifier si le sujet est disponible
        if (!$sujet->isDisponible()) {
            return back()->with('error', 'Ce sujet n\'est plus disponible.');
        }

        // Vérifier si l'étudiant n'a pas déjà une demande
        $dejaExiste = Demande::where('etudiant_id', auth()->id())
            ->whereIn('statut', ['en_attente', 'acceptee', 'memoire_depose', 'memoire_valide'])
            ->exists();

        if ($dejaExiste) {
            return back()->with('error', 'Vous avez déjà une demande en cours.');
        }

        // Vérifier si l'encadreur n'est pas complet
        $encadreurProfil = Encadreur::where('user_id', $sujet->encadreur_id)->first();
        if ($encadreurProfil && $encadreurProfil->estComplet()) {
            return back()->with('error', 'Cet encadreur a atteint le maximum de 10 étudiants.');
        }

        Demande::create([
            'etudiant_id'      => auth()->id(),
            'sujet_id'         => $sujet->id,
            'encadreur_id'     => $sujet->encadreur_id,
            'message_etudiant' => $request->message_etudiant,
            'statut'           => 'en_attente',
        ]);

        return redirect()->route('demandes.index')
            ->with('success', 'Demande envoyée ! En attente de validation de votre encadreur.');
    }

    public function accepter(Demande $demande)
    {
        if (!auth()->user()->isEnseignant() || $demande->encadreur_id !== auth()->id()) {
            abort(403);
        }

        $demande->update(['statut' => 'acceptee']);
        $demande->sujet->update(['statut' => 'pris']);

        return back()->with('success', 'Demande acceptée ! L\'étudiant peut maintenant déposer son mémoire.');
    }

    public function refuser(Request $request, Demande $demande)
    {
        if (!auth()->user()->isEnseignant() || $demande->encadreur_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['message_encadreur' => 'required|string|max:500']);

        $demande->update([
            'statut'            => 'refusee',
            'message_encadreur' => $request->message_encadreur,
        ]);

        return back()->with('success', 'Demande refusée.');
    }

    public function deposerMemoire(Request $request, Demande $demande)
    {
        if ($demande->etudiant_id !== auth()->id()) abort(403);
        if ($demande->statut !== 'acceptee') {
            return back()->with('error', 'Vous ne pouvez pas encore déposer votre mémoire.');
        }

        $request->validate([
            'memoire_fichier' => 'required|file|mimes:pdf|max:20480',
        ]);

        if ($demande->memoire_fichier) {
            Storage::disk('public')->delete($demande->memoire_fichier);
        }

        $chemin = $request->file('memoire_fichier')->store('memoires', 'public');

        $demande->update([
            'memoire_fichier' => $chemin,
            'statut'          => 'memoire_depose',
            'date_depot'      => now(),
        ]);

        return back()->with('success', 'Mémoire déposé avec succès ! En attente de validation.');
    }

    public function validerMemoire(Demande $demande)
    {
        if (!auth()->user()->isEnseignant() || $demande->encadreur_id !== auth()->id()) {
            abort(403);
        }

        $demande->update(['statut' => 'memoire_valide']);

        return back()->with('success', 'Mémoire validé ! L\'étudiant est prêt pour la soutenance.');
    }

    public function refuserMemoire(Request $request, Demande $demande)
    {
        if (!auth()->user()->isEnseignant() || $demande->encadreur_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['message_encadreur' => 'required|string|max:500']);

        $demande->update([
            'statut'            => 'memoire_refuse',
            'message_encadreur' => $request->message_encadreur,
        ]);

        return back()->with('success', 'Mémoire refusé. L\'étudiant devra redéposer.');
    }

    public function telechargerMemoire(Demande $demande)
    {
        $user = auth()->user();

        if ($user->isEtudiant() && $demande->etudiant_id !== $user->id) abort(403);
        if ($user->isEnseignant() && $demande->encadreur_id !== $user->id) abort(403);

        return Storage::disk('public')->download(
            $demande->memoire_fichier,
            'Memoire_' . $demande->etudiant->name . '.pdf'
        );
    }
}