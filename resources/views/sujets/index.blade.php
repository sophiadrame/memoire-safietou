@extends('layouts.app')
@section('title', auth()->user()->isEtudiant() ? 'Choisir un sujet' : 'Gestion des sujets')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($sujets) }} sujet(s)</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('sujets.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Nouveau sujet
        </a>
        @endif
    </div>

    <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px;">
        @forelse($sujets as $sujet)
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="display:flex; align-items:start; justify-content:space-between; margin-bottom:12px;">
                <div style="flex:1; min-width:0; padding-right:12px;">
                    <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0;">{{ $sujet->titre }}</p>
                    <div style="display:flex; gap:6px; margin-top:6px; flex-wrap:wrap;">
                        <span style="background:#eff6ff; color:#1e40af; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">{{ $sujet->type }}</span>
                        <span style="background:#f0fdf4; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">{{ $sujet->filiere }}</span>
                        <span style="background:#faf5ff; color:#7c3aed; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500;">{{ $sujet->niveau }}</span>
                    </div>
                </div>
                @php
                $statuts = [
                    'disponible' => ['#f0fdf4','#16a34a'],
                    'pris'       => ['#fef3c7','#d97706'],
                    'archivé'    => ['#f1f5f9','#64748b'],
                ];
                $sc = $statuts[$sujet->statut] ?? ['#f1f5f9','#64748b'];
                @endphp
                <span style="background:{{ $sc[0] }}; color:{{ $sc[1] }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:500; flex-shrink:0;">
                    {{ ucfirst($sujet->statut) }}
                </span>
            </div>

            <p style="font-size:13px; color:#64748b; margin:0 0 12px; line-height:1.6;">
                {{ Str::limit($sujet->description, 100) }}
            </p>

            @if($sujet->mots_cles)
            <p style="font-size:11px; color:#94a3b8; margin:0 0 12px;">
                <i class="fa-solid fa-tags" style="margin-right:4px;"></i>{{ $sujet->mots_cles }}
            </p>
            @endif

            {{-- Encadreur --}}
            @if($sujet->encadreur)
            <div style="display:flex; align-items:center; gap:10px; padding:10px; background:#f8fafc; border-radius:10px; margin-bottom:12px;">
                @if($sujet->encadreur->encadreurProfil?->photo)
                <img src="{{ Storage::url($sujet->encadreur->encadreurProfil->photo) }}"
                     style="width:36px; height:36px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                @else
                <div style="width:36px; height:36px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                    {{ strtoupper(substr($sujet->encadreur->name, 0, 2)) }}
                </div>
                @endif
                <div>
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0;">{{ $sujet->encadreur->name }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">
                        {{ $sujet->encadreur->encadreurProfil?->grade ?? 'Encadreur' }}
                        @if($sujet->encadreur->encadreurProfil)
                        @php $places = $sujet->encadreur->encadreurProfil->placesDisponibles(); @endphp
                        · <span style="color:{{ $places > 0 ? '#16a34a' : '#dc2626' }};">{{ $places }} place(s)</span>
                        @endif
                    </p>
                </div>
            </div>
            @endif

            <div style="display:flex; gap:8px; padding-top:12px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('sujets.show', $sujet) }}"
                   style="background:#eff6ff; color:#1e40af; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                    <i class="fa-solid fa-eye"></i> Voir détails
                </a>
                @if(auth()->user()->isEtudiant() && $sujet->isDisponible())
                <a href="{{ route('sujets.show', $sujet) }}"
                   style="background:#1e40af; color:#fff; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                    <i class="fa-solid fa-hand-pointer"></i> Choisir ce sujet
                </a>
                @endif
                @if(auth()->user()->isAdmin())
                <a href="{{ route('sujets.edit', $sujet) }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:500; text-decoration:none;">
                    <i class="fa-solid fa-pen"></i>
                </a>
                <form action="{{ route('sujets.destroy', $sujet) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Supprimer ce sujet ?')">
                    @csrf @method('DELETE')
                    <button style="background:#fef2f2; color:#dc2626; border:none; border-radius:8px; padding:7px 10px; font-size:12px; cursor:pointer;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column:span 2; background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:60px 20px; text-align:center;">
            <i class="fa-solid fa-folder-open" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
            <p style="color:#94a3b8; margin:0;">Aucun sujet disponible</p>
        </div>
        @endforelse
    </div>
</div>
@endsection