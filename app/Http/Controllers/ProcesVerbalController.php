<?php

namespace App\Http\Controllers;

use App\Models\ProcesVerbal;
use App\Models\Soutenance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcesVerbalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = ProcesVerbal::with('soutenance')->orderBy('date_pv', 'desc');

        if ($user->isEtudiant()) {
            $query->whereHas('soutenance', fn ($q) => $q->where('etudiant_id', $user->id));
        } elseif ($user->isEnseignant()) {
            $query->whereHas('soutenance.juries', fn ($q) => $q->where('user_id', $user->id));
        }
        // admin : aucun filtre, voit tout

        $pvs = $query->get();
        return view('pvs.index', compact('pvs'));
    }

    public function create()
    {
        $soutenances = $this->soutenancesAutorisees();
        return view('pvs.create', compact('soutenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'soutenance_id' => ['required', 'exists:soutenances,id', $this->regleSoutenanceAutorisee()],
            'note'          => 'required|numeric|min:0|max:20',
            'mention'       => 'required|in:Passable,Assez Bien,Bien,Très Bien',
            'appreciation'  => 'nullable|string',
            'decision'      => 'required|in:Admis,Ajourné,Admis avec réserves',
            'date_pv'       => 'required|date',
        ]);

        ProcesVerbal::create($request->all());
        return redirect()->route('pvs.index')
                         ->with('success', 'PV créé avec succès !');
    }

    public function genererPDF(ProcesVerbal $pv)
    {
        $user = auth()->user();
        if ($user->isEtudiant()) {
            abort_unless($pv->soutenance->etudiant_id === $user->id, 403);
        } elseif ($user->isEnseignant()) {
            $this->autoriserAccesPv($pv);
        }

        $pv->load('soutenance.juries');
        $pdf = Pdf::loadView('pvs.pdf', compact('pv'))
                  ->setPaper('a4', 'portrait');
        return $pdf->download('PV_' . $pv->soutenance->etudiant_nom . '_' . $pv->soutenance->etudiant_prenom . '.pdf');
    }

    public function edit(ProcesVerbal $pv)
    {
        $this->autoriserAccesPv($pv);
        $soutenances = $this->soutenancesAutorisees();
        return view('pvs.edit', compact('pv', 'soutenances'));
    }

    public function update(Request $request, ProcesVerbal $pv)
    {
        $this->autoriserAccesPv($pv);

        $request->validate([
            'soutenance_id' => ['required', 'exists:soutenances,id', $this->regleSoutenanceAutorisee()],
            'note'          => 'required|numeric|min:0|max:20',
            'mention'       => 'required|in:Passable,Assez Bien,Bien,Très Bien',
            'appreciation'  => 'nullable|string',
            'decision'      => 'required|in:Admis,Ajourné,Admis avec réserves',
            'date_pv'       => 'required|date',
        ]);

        $pv->update($request->all());
        return redirect()->route('pvs.index')
                         ->with('success', 'PV modifié avec succès !');
    }

    public function destroy(ProcesVerbal $pv)
    {
        $pv->delete();
        return redirect()->route('pvs.index')
                         ->with('success', 'PV supprimé.');
    }

    /**
     * Soutenances sur lesquelles l'utilisateur connecté a le droit de
     * créer/modifier un PV : toutes pour l'admin, seulement celles où il
     * est membre du jury pour un enseignant.
     */
    private function soutenancesAutorisees()
    {
        $user = auth()->user();
        $query = Soutenance::orderBy('date_soutenance');

        if ($user->isEnseignant()) {
            $query->whereHas('juries', fn ($q) => $q->where('user_id', $user->id));
        }

        return $query->get();
    }

    /**
     * Règle de validation qui rejette un soutenance_id sur lequel
     * l'utilisateur (s'il est enseignant) n'a pas le droit d'intervenir.
     */
    private function regleSoutenanceAutorisee()
    {
        return function ($attribute, $value, $fail) {
            $user = auth()->user();
            if ($user->isEnseignant()) {
                $autorise = Soutenance::where('id', $value)
                    ->whereHas('juries', fn ($q) => $q->where('user_id', $user->id))
                    ->exists();
                if (! $autorise) {
                    $fail("Vous n'êtes pas membre du jury de cette soutenance.");
                }
            }
        };
    }

    /**
     * Vérifie que l'utilisateur connecté a le droit de voir/modifier ce PV
     * précis (403 sinon).
     */
    private function autoriserAccesPv(ProcesVerbal $pv)
    {
        $user = auth()->user();
        if ($user->isEnseignant()) {
            $autorise = $pv->soutenance()
                ->whereHas('juries', fn ($q) => $q->where('user_id', $user->id))
                ->exists();
            abort_unless($autorise, 403, "Vous n'êtes pas membre du jury de cette soutenance.");
        }
    }
}