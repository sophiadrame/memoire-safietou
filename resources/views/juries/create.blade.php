@extends('layouts.app')
@section('title', 'Ajouter un membre du jury')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('juries.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">

        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-person-chalkboard" style="color:#1e40af; margin-right:8px;"></i>Ajouter un membre du jury
        </h2>

        <form action="{{ route('juries.store') }}" method="POST" style="display:flex; flex-direction:column; gap:18px;">
            @csrf

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Soutenance concernée <span style="color:#dc2626;">*</span></label>
                <select name="soutenance_id" required
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    <option value="">Sélectionner une soutenance...</option>
                    @foreach($soutenances as $s)
                    <option value="{{ $s->id }}" {{ old('soutenance_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->etudiant_prenom }} {{ $s->etudiant_nom }} — {{ \Carbon\Carbon::parse($s->date_soutenance)->format('d/m/Y') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Enseignant inscrit (optionnel)</label>
                <select name="user_id"
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    <option value="">Sélectionner un enseignant...</option>
                    @foreach($enseignants as $e)
                    <option value="{{ $e->id }}" {{ old('user_id') == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Prénom <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nom <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Rôle <span style="color:#dc2626;">*</span></label>
                <select name="role" required
                        style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    @foreach(['président','rapporteur','examinateur'] as $r)
                    <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Grade</label>
                <input type="text" name="grade" value="{{ old('grade') }}"
                       placeholder="Professeur, Maître de conférences..."
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('juries.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-plus"></i> Ajouter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection