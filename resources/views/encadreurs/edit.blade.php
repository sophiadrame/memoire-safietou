@extends('layouts.app')
@section('title', 'Modifier l\'encadreur')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('encadreurs.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">
        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-user-pen" style="color:#1e40af; margin-right:8px;"></i>Modifier le profil encadreur
        </h2>

        <form action="{{ route('encadreurs.update', $encadreur) }}" method="POST" enctype="multipart/form-data"
              style="display:flex; flex-direction:column; gap:18px;">
            @csrf @method('PUT')

            <div style="padding:12px; background:#f8fafc; border-radius:10px; display:flex; align-items:center; gap:12px;">
                @if($encadreur->photo)
                <img src="{{ Storage::url($encadreur->photo) }}"
                     style="width:50px; height:50px; border-radius:50%; object-fit:cover;">
                @else
                <div style="width:50px; height:50px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:16px;">
                    {{ strtoupper(substr($encadreur->user->name, 0, 2)) }}
                </div>
                @endif
                <div>
                    <p style="font-weight:600; color:#1e293b; font-size:14px; margin:0;">{{ $encadreur->user->name }}</p>
                    <p style="font-size:12px; color:#94a3b8; margin:0;">{{ $encadreur->user->email }}</p>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Grade <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="grade" value="{{ old('grade', $encadreur->grade) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Spécialité <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="specialite" value="{{ old('specialite', $encadreur->specialite) }}" required
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Bureau</label>
                    <input type="text" name="bureau" value="{{ old('bureau', $encadreur->bureau) }}"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $encadreur->telephone) }}"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Biographie</label>
                <textarea name="bio" rows="4"
                          style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; resize:none;">{{ old('bio', $encadreur->bio) }}</textarea>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nombre max d'étudiants</label>
                <input type="number" name="max_etudiants" value="{{ old('max_etudiants', $encadreur->max_etudiants) }}"
                       min="1" max="10" required
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nouvelle photo</label>
                    @if($encadreur->photo)
                    <p style="font-size:11px; color:#16a34a; margin:0 0 6px;"><i class="fa-solid fa-check" style="margin-right:4px;"></i>Photo existante</p>
                    @endif
                    <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nouveau CV (PDF)</label>
                    @if($encadreur->cv_fichier)
                    <p style="font-size:11px; color:#16a34a; margin:0 0 6px;"><i class="fa-solid fa-check" style="margin-right:4px;"></i>CV existant</p>
                    @endif
                    <input type="file" name="cv_fichier" accept=".pdf"
                           style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('encadreurs.index') }}"
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