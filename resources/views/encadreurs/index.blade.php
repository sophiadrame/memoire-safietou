@extends('layouts.app')
@section('title', 'Encadreurs')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($encadreurs) }} encadreur(s)</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('encadreurs.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Ajouter un encadreur
        </a>
        @endif
    </div>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
        @forelse($encadreurs as $enc)
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="text-align:center; margin-bottom:16px;">
                @if($enc->photo)
                <img src="{{ Storage::url($enc->photo) }}"
                     style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #eff6ff; margin-bottom:10px;">
                @else
                <div style="width:80px; height:80px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:24px; margin:0 auto 10px;">
                    {{ strtoupper(substr($enc->user->name, 0, 2)) }}
                </div>
                @endif
                <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 2px;">{{ $enc->user->name }}</p>
                <p style="font-size:12px; color:#64748b; margin:0 0 8px;">{{ $enc->grade }}</p>
                @php $places = $enc->placesDisponibles(); @endphp
                <span style="background:{{ $places > 0 ? '#f0fdf4' : '#fef2f2' }}; color:{{ $places > 0 ? '#16a34a' : '#dc2626' }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;">
                    {{ $places }}/{{ $enc->max_etudiants }} places
                </span>
            </div>

            <div style="display:flex; flex-direction:column; gap:6px; margin-bottom:14px;">
                @if($enc->specialite)
                <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#64748b;">
                    <i class="fa-solid fa-microscope" style="color:#1e40af; width:14px;"></i>
                    {{ $enc->specialite }}
                </div>
                @endif
                @if($enc->bureau)
                <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#64748b;">
                    <i class="fa-solid fa-door-open" style="color:#1e40af; width:14px;"></i>
                    {{ $enc->bureau }}
                </div>
                @endif
                @if($enc->user->email)
                <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#64748b;">
                    <i class="fa-solid fa-envelope" style="color:#1e40af; width:14px;"></i>
                    {{ $enc->user->email }}
                </div>
                @endif
                @if($enc->telephone)
                <div style="display:flex; align-items:center; gap:8px; font-size:12px; color:#64748b;">
                    <i class="fa-solid fa-phone" style="color:#1e40af; width:14px;"></i>
                    {{ $enc->telephone }}
                </div>
                @endif
            </div>

            <div style="display:flex; gap:6px; padding-top:12px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('encadreurs.show', $enc) }}"
                   style="flex:1; background:#eff6ff; color:#1e40af; border-radius:8px; padding:7px; font-size:12px; font-weight:500; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:5px;">
                    <i class="fa-solid fa-eye"></i> Voir profil
                </a>
                @if($enc->cv_fichier)
                <a href="{{ Storage::url($enc->cv_fichier) }}" target="_blank"
                   style="flex:1; background:#fef2f2; color:#dc2626; border-radius:8px; padding:7px; font-size:12px; font-weight:500; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:5px;">
                    <i class="fa-solid fa-file-pdf"></i> CV
                </a>
                @endif
                @if(auth()->user()->isAdmin())
                <a href="{{ route('encadreurs.edit', $enc) }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:8px; padding:7px 10px; font-size:12px; text-decoration:none;">
                    <i class="fa-solid fa-pen"></i>
                </a>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column:span 3; background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:60px 20px; text-align:center;">
            <i class="fa-solid fa-user-tie" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
            <p style="color:#94a3b8; margin:0;">Aucun encadreur enregistré</p>
        </div>
        @endforelse
    </div>
</div>
@endsection