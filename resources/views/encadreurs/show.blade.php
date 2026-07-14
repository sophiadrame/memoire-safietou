@extends('layouts.app')
@section('title', 'Profil encadreur')

@section('content')
<div style="max-width:750px;">

    <a href="{{ route('encadreurs.index') }}"
       style="display:inline-flex; align-items:center; gap:8px; background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 16px; font-size:13px; font-weight:500; text-decoration:none; margin-bottom:20px;">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:28px; margin-bottom:16px;">

        <div style="display:flex; align-items:start; gap:20px; margin-bottom:20px;">
            @if($encadreur->photo)
            <img src="{{ Storage::url($encadreur->photo) }}"
                 style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:4px solid #eff6ff; flex-shrink:0;">
            @else
            <div style="width:100px; height:100px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:30px; flex-shrink:0;">
                {{ strtoupper(substr($encadreur->user->name, 0, 2)) }}
            </div>
            @endif
            <div style="flex:1;">
                <p style="font-weight:700; color:#1e293b; font-size:20px; margin:0 0 4px;">{{ $encadreur->user->name }}</p>
                <p style="font-size:14px; color:#64748b; margin:0 0 10px;">{{ $encadreur->grade }}</p>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    @if($encadreur->specialite)
                    <span style="background:#faf5ff; color:#7c3aed; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">
                        <i class="fa-solid fa-microscope" style="margin-right:4px;"></i>{{ $encadreur->specialite }}
                    </span>
                    @endif
                    @php $places = $encadreur->placesDisponibles(); @endphp
                    <span style="background:{{ $places > 0 ? '#f0fdf4' : '#fef2f2' }}; color:{{ $places > 0 ? '#16a34a' : '#dc2626' }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">
                        <i class="fa-solid fa-users" style="margin-right:4px;"></i>{{ $encadreur->nbEtudiantsActuels() }}/{{ $encadreur->max_etudiants }} étudiants
                    </span>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('encadreurs.edit', $encadreur) }}"
               style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:8px 14px; font-size:13px; font-weight:500; text-decoration:none; flex-shrink:0;">
                <i class="fa-solid fa-pen"></i> Modifier
            </a>
            @endif
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
            @if($encadreur->user->email)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 3px;"><i class="fa-solid fa-envelope" style="margin-right:4px;"></i>Email</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $encadreur->user->email }}</p>
            </div>
            @endif
            @if($encadreur->telephone)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 3px;"><i class="fa-solid fa-phone" style="margin-right:4px;"></i>Téléphone</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $encadreur->telephone }}</p>
            </div>
            @endif
            @if($encadreur->bureau)
            <div style="padding:12px; background:#f8fafc; border-radius:10px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 3px;"><i class="fa-solid fa-door-open" style="margin-right:4px;"></i>Bureau</p>
                <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">{{ $encadreur->bureau }}</p>
            </div>
            @endif
        </div>

        @if($encadreur->bio)
        <div style="padding:16px; background:#f8fafc; border-radius:12px; margin-bottom:16px;">
            <p style="font-size:12px; font-weight:500; color:#64748b; margin:0 0 8px;"><i class="fa-solid fa-user" style="margin-right:4px;"></i>Biographie</p>
            <p style="font-size:13px; color:#475569; margin:0; line-height:1.8;">{{ $encadreur->bio }}</p>
        </div>
        @endif

        @if($encadreur->cv_fichier)
        <a href="{{ Storage::url($encadreur->cv_fichier) }}" target="_blank"
           style="display:inline-flex; align-items:center; gap:8px; background:#fef2f2; color:#dc2626; border-radius:10px; padding:10px 18px; font-size:13px; font-weight:500; text-decoration:none;">
            <i class="fa-solid fa-file-pdf"></i> Télécharger le CV
        </a>
        @endif
    </div>

    @if($encadreur->user->sujetsProposer->count() > 0)
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px;">
        <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 16px; padding-bottom:12px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-folder-open" style="color:#1e40af; margin-right:8px;"></i>Sujets proposés ({{ $encadreur->user->sujetsProposer->count() }})
        </p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            @foreach($encadreur->user->sujetsProposer as $sujet)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:#f8fafc; border-radius:10px;">
                <div>
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0 0 4px;">{{ $sujet->titre }}</p>
                    <div style="display:flex; gap:6px;">
                        <span style="background:#eff6ff; color:#1e40af; padding:2px 8px; border-radius:20px; font-size:11px;">{{ $sujet->type }}</span>
                        <span style="background:#f0fdf4; color:#16a34a; padding:2px 8px; border-radius:20px; font-size:11px;">{{ $sujet->filiere }}</span>
                    </div>
                </div>
                @php $sc = ['disponible'=>['#f0fdf4','#16a34a'],'pris'=>['#fef3c7','#d97706'],'archivé'=>['#f1f5f9','#64748b']][$sujet->statut] ?? ['#f1f5f9','#64748b']; @endphp
                <div style="display:flex; align-items:center; gap:8px;">
                    <span style="background:{{ $sc[0] }}; color:{{ $sc[1] }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">{{ ucfirst($sujet->statut) }}</span>
                    <a href="{{ route('sujets.show', $sujet) }}"
                       style="background:#eff6ff; color:#1e40af; border-radius:8px; padding:5px 10px; font-size:12px; text-decoration:none;">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection