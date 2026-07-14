@extends('layouts.app')
@section('title', 'Nouvelle soutenance')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('soutenances.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">

        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-calendar-plus" style="color:#1e40af; margin-right:8px;"></i>Planifier une soutenance
        </h2>

        <form action="{{ route('soutenances.store') }}" method="POST" style="display:flex; flex-direction:column; gap:18px;">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nom de l'étudiant <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="etudiant_nom" value="{{ old('etudiant_nom') }}" required
                           placeholder="Nom"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Prénom <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="etudiant_prenom" value="{{ old('etudiant_prenom') }}" required
                           placeholder="Prénom"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Compte étudiant (optionnel)</label>
                <select name="etudiant_id"
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    <option value="">Sélectionner un étudiant inscrit...</option>
                    @foreach($etudiants as $e)
                    <option value="{{ $e->id }}" {{ old('etudiant_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Titre du mémoire <span style="color:#dc2626;">*</span></label>
                <input type="text" name="titre_memoire" value="{{ old('titre_memoire') }}" required
                       placeholder="Titre complet du mémoire"
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Filière <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="filiere" value="{{ old('filiere') }}" required
                           placeholder="Ex: L3 Génie Logiciel"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Salle <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="salle" value="{{ old('salle') }}" required
                           placeholder="Ex: Salle A41"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Date <span style="color:#dc2626;">*</span></label>
                    <input type="date" name="date_soutenance" value="{{ old('date_soutenance') }}" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Heure début <span style="color:#dc2626;">*</span></label>
                    <input type="time" name="heure_debut" value="{{ old('heure_debut') }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Heure fin <span style="color:#dc2626;">*</span></label>
                    <input type="time" name="heure_fin" value="{{ old('heure_fin') }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('soutenances.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-calendar-plus"></i> Planifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection