@extends('layouts.app')
@section('title', 'Nouveau sujet')

@section('content')
<div style="max-width:700px;">

    <a href="{{ route('sujets.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px;">
        <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:17px; margin:0 0 20px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-folder-plus" style="color:#1e40af; margin-right:8px;"></i>Nouveau sujet
        </h2>

        <form action="{{ route('sujets.store') }}" method="POST" style="display:flex; flex-direction:column; gap:18px;">
            @csrf

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Titre du sujet <span style="color:#dc2626;">*</span></label>
                <input type="text" name="titre" value="{{ old('titre') }}" required
                       placeholder="Ex: Conception d'une application de gestion..."
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Description <span style="color:#dc2626;">*</span></label>
                <textarea name="description" rows="5" required
                          placeholder="Décrivez le sujet en détail..."
                          style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; resize:none;">{{ old('description') }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Type <span style="color:#dc2626;">*</span></label>
                    <select name="type" required style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                        @foreach(['PFE','Mémoire','Thèse'] as $t)
                        <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Filière <span style="color:#dc2626;">*</span></label>
                    <select name="filiere" required style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                        <option value="">Sélectionner...</option>
                        @foreach([
                            'Génie Logiciel',
                            'Réseaux et Télécommunications',
                            'Systèmes Informatiques',
                            'Intelligence Artificielle',
                            'Sécurité Informatique',
                            'Base de Données',
                            'Développement Web',
                            'Développement Mobile',
                            'Cloud Computing',
                            'Data Science',
                            'Cybersécurité',
                            'Systèmes Embarqués',
                            'Informatique de Gestion',
                            'Administration Systèmes et Réseaux',
                            'Multimédia et Design',
                        ] as $f)
                        <option value="{{ $f }}" {{ old('filiere') === $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Niveau <span style="color:#dc2626;">*</span></label>
                    <select name="niveau" required style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                        @foreach(['L1','L2','L3','M1','M2','Doctorat'] as $n)
                        <option value="{{ $n }}" {{ old('niveau') === $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Encadreur <span style="color:#dc2626;">*</span></label>
                <select name="encadreur_id" required style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; color:#475569;">
                    <option value="">Sélectionner un encadreur...</option>
                    @foreach($encadreurs as $enc)
                    <option value="{{ $enc->id }}" {{ old('encadreur_id') == $enc->id ? 'selected' : '' }}>
                        {{ $enc->name }}
                        @if($enc->encadreurProfil)
                        ({{ $enc->encadreurProfil->grade }} · {{ $enc->encadreurProfil->placesDisponibles() }} places)
                        @endif
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Mots-clés</label>
                <input type="text" name="mots_cles" value="{{ old('mots_cles') }}"
                       placeholder="Ex: Laravel, PHP, Base de données (séparés par des virgules)"
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('sujets.index') }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; text-decoration:none;">
                    Annuler
                </a>
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Créer le sujet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection