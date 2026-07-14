@extends('layouts.app')
@section('title', 'Détail du sujet')

@section('content')
<div style="max-width:750px;">

    <a href="{{ route('sujets.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    {{-- Sujet --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px; margin-bottom:16px;">
        <div style="display:flex; align-items:start; justify-content:space-between; margin-bottom:16px;">
            <div>
                <p style="font-weight:700; color:#1e293b; font-size:18px; margin:0 0 8px;">{{ $sujet->titre }}</p>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <span style="background:#eff6ff; color:#1e40af; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">{{ $sujet->type }}</span>
                    <span style="background:#f0fdf4; color:#16a34a; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">{{ $sujet->filiere }}</span>
                    <span style="background:#faf5ff; color:#7c3aed; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">{{ $sujet->niveau }}</span>
                </div>
            </div>
            @php
            $statuts = ['disponible'=>['#f0fdf4','#16a34a'],'pris'=>['#fef3c7','#d97706'],'archivé'=>['#f1f5f9','#64748b']];
            $sc = $statuts[$sujet->statut] ?? ['#f1f5f9','#64748b'];
            @endphp
            <span style="background:{{ $sc[0] }}; color:{{ $sc[1] }}; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:500;">
                {{ ucfirst($sujet->statut) }}
            </span>
        </div>

        <div style="padding:16px; background:#f8fafc; border-radius:12px; margin-bottom:16px;">
            <p style="font-size:13px; color:#475569; margin:0; line-height:1.8;">{{ $sujet->description }}</p>
        </div>

        @if($sujet->mots_cles)
        <div style="margin-bottom:16px;">
            <p style="font-size:12px; font-weight:500; color:#64748b; margin:0 0 6px;">Mots-clés</p>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                @foreach(explode(',', $sujet->mots_cles) as $mot)
                <span style="background:#f1f5f9; color:#475569; padding:4px 10px; border-radius:20px; font-size:12px;">{{ trim($mot) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Fiche encadreur --}}
    @if($sujet->encadreur)
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px; margin-bottom:16px;">
        <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-user-tie" style="color:#1e40af; margin-right:8px;"></i>Fiche de l'encadreur
        </p>

        <div style="display:flex; align-items:start; gap:16px; margin-bottom:16px;">
            @if($sujet->encadreur->encadreurProfil?->photo)
            <img src="{{ Storage::url($sujet->encadreur->encadreurProfil->photo) }}"
                 style="width:80px; height:80px; border-radius:50%; object-fit:cover; flex-shrink:0; border:3px solid #eff6ff;">
            @else
            <div style="width:80px; height:80px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:24px; flex-shrink:0;">
                {{ strtoupper(substr($sujet->encadreur->name, 0, 2)) }}
            </div>
            @endif
            <div style="flex:1;">
                <p style="font-weight:700; color:#1e293b; font-size:17px; margin:0 0 4px;">{{ $sujet->encadreur->name }}</p>
                @if($sujet->encadreur->encadreurProfil)
                @php $profil = $sujet->encadreur->encadreurProfil; @endphp
                <p style="font-size:13px; color:#64748b; margin:0 0 8px;">{{ $profil->grade }}</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    @php $places = $profil->placesDisponibles(); @endphp
                    <span style="background:{{ $places > 0 ? '#f0fdf4' : '#fef2f2' }}; color:{{ $places > 0 ? '#16a34a' : '#dc2626' }}; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;">
                        {{ $places }}/{{ $profil->max_etudiants }} places disponibles
                    </span>
                    @if($profil->specialite)
                    <span style="background:#faf5ff; color:#7c3aed; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;">{{ $profil->specialite }}</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        @if($sujet->encadreur->encadreurProfil)
        @php $profil = $sujet->encadreur->encadreurProfil; @endphp
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
            @if($profil->bureau)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 2px;"><i class="fa-solid fa-door-open" style="margin-right:4px;"></i>Bureau</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $profil->bureau }}</p>
            </div>
            @endif
            @if($profil->telephone)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 2px;"><i class="fa-solid fa-phone" style="margin-right:4px;"></i>Téléphone</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $profil->telephone }}</p>
            </div>
            @endif
            @if($sujet->encadreur->email)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 2px;"><i class="fa-solid fa-envelope" style="margin-right:4px;"></i>Email</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $sujet->encadreur->email }}</p>
            </div>
            @endif
        </div>

        @if($profil->bio)
        <div style="padding:14px; background:#f8fafc; border-radius:10px; margin-bottom:16px;">
            <p style="font-size:12px; font-weight:500; color:#64748b; margin:0 0 6px;">Biographie</p>
            <p style="font-size:13px; color:#475569; margin:0; line-height:1.7;">{{ $profil->bio }}</p>
        </div>
        @endif

        @if($profil->cv_fichier)
        <a href="{{ Storage::url($profil->cv_fichier) }}" target="_blank"
           style="display:inline-flex; align-items:center; gap:8px; background:#fef2f2; color:#dc2626; border-radius:10px; padding:9px 16px; font-size:13px; font-weight:500; text-decoration:none;">
            <i class="fa-solid fa-file-pdf"></i> Télécharger le CV
        </a>
        @endif
        @endif
    </div>
    @endif

    {{-- Action étudiant --}}
    @if(auth()->user()->isEtudiant() && $sujet->isDisponible())
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:24px;">
        @if($dejaDemandeParEtudiant)
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:16px; text-align:center;">
            <i class="fa-solid fa-circle-check" style="color:#16a34a; font-size:24px; display:block; margin-bottom:8px;"></i>
            <p style="font-weight:600; color:#16a34a; margin:0;">Vous avez déjà soumis une demande pour ce sujet !</p>
        </div>
        @else
        <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 16px;">Faire une demande pour ce sujet</p>
        <form action="{{ route('demandes.store') }}" method="POST" style="display:flex; flex-direction:column; gap:14px;">
            @csrf
            <input type="hidden" name="sujet_id" value="{{ $sujet->id }}">
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Message pour l'encadreur (optionnel)</label>
                <textarea name="message_etudiant" rows="4"
                          placeholder="Présentez-vous et expliquez pourquoi ce sujet vous intéresse..."
                          style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box; resize:none;">{{ old('message_etudiant') }}</textarea>
            </div>
            <div style="display:flex; justify-content:flex-end;">
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:11px 24px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-paper-plane"></i> Envoyer ma demande
                </button>
            </div>
        </form>
        @endif
    </div>
    @endif

</div>
@endsection