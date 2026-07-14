@extends('layouts.app')
@section('title', 'Archivage')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($archives) }} document(s)</p>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('archives.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Archiver un document
        </a>
        @endif
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('archives.index') }}"
          style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:16px; display:flex; gap:12px; align-items:center;">
        <select name="annee" style="flex:1; padding:9px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; color:#475569;">
            <option value="">Toutes les années</option>
            @foreach($annees as $a)
            <option value="{{ $a }}" {{ request('annee') === $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>
        <select name="type" style="flex:1; padding:9px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; color:#475569;">
            <option value="">Tous les types</option>
            @foreach(['Mémoire','PV','Rapport','Autre'] as $t)
            <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
        <button type="submit"
                style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
            <i class="fa-solid fa-filter"></i> Filtrer
        </button>
        <a href="{{ route('archives.index') }}"
           style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none;">
            Réinitialiser
        </a>
    </form>

    {{-- Grille archives --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
        @forelse($archives as $archive)
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="display:flex; align-items:start; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; background:#fef2f2; color:#dc2626; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:16px;">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-weight:600; color:#1e293b; font-size:13px; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $archive->nom_fichier }}</p>
                    <p style="font-size:12px; color:#94a3b8; margin:3px 0 0;">{{ $archive->type_document }}</p>
                </div>
            </div>
            @if($archive->soutenance)
            <div style="font-size:12px; color:#64748b; margin-bottom:12px;">
                <p style="margin:0;"><i class="fa-solid fa-user-graduate" style="margin-right:6px; color:#94a3b8;"></i>{{ $archive->soutenance->etudiant_prenom }} {{ $archive->soutenance->etudiant_nom }}</p>
                <p style="margin:4px 0 0;"><i class="fa-solid fa-calendar" style="margin-right:6px; color:#94a3b8;"></i>{{ \Carbon\Carbon::parse($archive->soutenance->date_soutenance)->format('d/m/Y') }}</p>
            </div>
            @endif
            @if($archive->description)
            <p style="font-size:12px; color:#64748b; font-style:italic; margin:0 0 12px;">{{ Str::limit($archive->description, 60) }}</p>
            @endif
            <div style="display:flex; align-items:center; justify-content:space-between; padding-top:12px; border-top:1px solid #f1f5f9;">
                <span style="background:#eff6ff; color:#1e40af; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:500;">{{ $archive->annee_universitaire }}</span>
                <div style="display:flex; gap:6px;">
                    <a href="{{ route('archives.download', $archive) }}"
                       style="background:#1e40af; color:#fff; border-radius:8px; padding:6px 12px; font-size:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa-solid fa-download"></i> Télécharger
                    </a>
                    @if(auth()->user()->role === 'admin')
                    <form action="{{ route('archives.destroy', $archive) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Supprimer cette archive ?')">
                        @csrf @method('DELETE')
                        <button style="background:#fef2f2; color:#dc2626; border:none; border-radius:8px; padding:6px 10px; font-size:12px; cursor:pointer;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:span 3; background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:60px 20px; text-align:center;">
            <i class="fa-solid fa-box-open" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
            <p style="color:#94a3b8; margin:0;">Aucun document archivé</p>
        </div>
        @endforelse
    </div>
</div>
@endsection