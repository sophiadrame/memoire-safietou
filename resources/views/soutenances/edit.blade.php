@extends('layouts.app')
@section('title', 'Modifier la soutenance')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('soutenances.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">
        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-pen" style="color:#1e40af; margin-right:8px;"></i>Modifier la soutenance
        </h2>

        <form action="{{ route('soutenances.update', $soutenance) }}" method="POST"
              style="display:flex; flex-direction:column; gap:18px;">
            @csrf @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nom <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="etudiant_nom"
                           value="{{ old('etudiant_nom', $soutenance->etudiant_nom) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Prénom <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="etudiant_prenom"
                           value="{{ old('etudiant_prenom', $soutenance->etudiant_prenom) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Titre du mémoire <span style="color:#dc2626;">*</span></label>
                <input type="text" name="titre_memoire"
                       value="{{ old('titre_memoire', $soutenance->titre_memoire) }}" required
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Filière <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="filiere"
                           value="{{ old('filiere', $soutenance->filiere) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Salle <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="salle"
                           value="{{ old('salle', $soutenance->salle) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Date <span style="color:#dc2626;">*</span></label>
                    <input type="date" name="date_soutenance"
                           value="{{ old('date_soutenance', $soutenance->date_soutenance) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Heure début <span style="color:#dc2626;">*</span></label>
                    <input type="time" name="heure_debut"
                           value="{{ old('heure_debut', $soutenance->heure_debut) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Heure fin <span style="color:#dc2626;">*</span></label>
                    <input type="time" name="heure_fin"
                           value="{{ old('heure_fin', $soutenance->heure_fin) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Statut</label>
                <select name="statut"
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    @foreach(['planifiée','en cours','terminée','annulée'] as $st)
                    <option value="{{ $st }}" {{ old('statut', $soutenance->statut) === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('soutenances.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection