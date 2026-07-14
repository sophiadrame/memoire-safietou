@extends('layouts.app')
@section('title', 'Archiver un document')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('archives.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">

        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-box-archive" style="color:#7c3aed; margin-right:8px;"></i>Archiver un document
        </h2>

        <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data"
              style="display:flex; flex-direction:column; gap:18px;">
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

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Type de document <span style="color:#dc2626;">*</span></label>
                    <select name="type_document" required
                            style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                        @foreach(['Mémoire','PV','Rapport','Autre'] as $t)
                        <option value="{{ $t }}" {{ old('type_document') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Année universitaire <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="annee_universitaire"
                           value="{{ old('annee_universitaire', date('Y').'-'.(date('Y')+1)) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Description</label>
                <textarea name="description" rows="3"
                          placeholder="Description optionnelle..."
                          style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; resize:none;">{{ old('description') }}</textarea>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Fichier (PDF, DOC, DOCX) <span style="color:#dc2626;">*</span></label>
                <label style="display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px dashed #e2e8f0; border-radius:12px; padding:32px; cursor:pointer; transition:border .2s;">
                    <i class="fa-solid fa-file-arrow-up" style="font-size:32px; color:#cbd5e1; margin-bottom:10px;"></i>
                    <p style="font-size:13px; color:#64748b; margin:0;">Glissez votre fichier ou <span style="color:#1e40af; font-weight:500;">parcourir</span></p>
                    <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">PDF, DOC, DOCX · Max 10 Mo</p>
                    <input type="file" name="fichier" accept=".pdf,.doc,.docx" required style="display:none;">
                </label>
                @error('fichier')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('archives.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#7c3aed; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-box-archive"></i> Archiver
                </button>
            </div>
        </form>
    </div>
</div>
@endsection