@extends('layouts.app')
@section('title', auth()->user()->role === 'etudiant' ? 'Mes résultats' : 'Procès-verbaux')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($pvs) }} PV</p>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'enseignant')
        <a href="{{ route('pvs.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Nouveau PV
        </a>
        @endif
    </div>

    <div style="display:flex; flex-direction:column; gap:12px;">
        @forelse($pvs as $pv)
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="display:flex; align-items:start; justify-content:space-between; gap:16px; margin-bottom:16px;">
                <div style="flex:1;">
                    <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0;">
                        {{ $pv->soutenance->etudiant_prenom ?? '' }} {{ $pv->soutenance->etudiant_nom ?? '' }}
                    </p>
                    <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
                        {{ Str::limit($pv->soutenance->titre_memoire ?? '', 60) }}
                    </p>
                    <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">
                        PV du {{ \Carbon\Carbon::parse($pv->date_pv)->format('d/m/Y') }}
                    </p>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <p style="font-size:28px; font-weight:700; color:#1e40af; margin:0;">{{ $pv->note }}/20</p>
                    @php
                    $mentions = [
                        'Passable'   => ['#f8fafc','#64748b'],
                        'Assez Bien' => ['#fffbeb','#d97706'],
                        'Bien'       => ['#eff6ff','#1e40af'],
                        'Très Bien'  => ['#f0fdf4','#16a34a'],
                    ];
                    $mc = $mentions[$pv->mention] ?? ['#f8fafc','#64748b'];
                    @endphp
                    <span style="background:{{ $mc[0] }}; color:{{ $mc[1] }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500; display:inline-block; margin-top:6px;">
                        {{ $pv->mention }}
                    </span>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 2fr; gap:12px; padding:12px; background:#f8fafc; border-radius:12px; margin-bottom:16px;">
                <div>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">Décision</p>
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:4px 0 0;">{{ $pv->decision }}</p>
                </div>
                @if($pv->appreciation)
                <div>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">Appréciation</p>
                    <p style="font-size:13px; color:#475569; margin:4px 0 0; font-style:italic;">{{ Str::limit($pv->appreciation, 80) }}</p>
                </div>
                @endif
            </div>

            <div style="display:flex; gap:8px; padding-top:16px; border-top:1px solid #f1f5f9;">
                <a href="{{ route('pvs.pdf', $pv) }}"
                   style="background:#1e40af; color:#fff; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-file-pdf"></i> Télécharger PDF
                </a>
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'enseignant')
                <a href="{{ route('pvs.edit', $pv) }}"
                   style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:8px; padding:7px 14px; font-size:12px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-pen"></i> Modifier
                </a>
                @endif
                @if(auth()->user()->role === 'admin')
                <form action="{{ route('pvs.destroy', $pv) }}" method="POST" style="display:inline;"
                      onsubmit="return confirm('Supprimer ce PV ?')">
                    @csrf @method('DELETE')
                    <button style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:8px; padding:7px 14px; font-size:12px; cursor:pointer; font-weight:500;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:60px 20px; text-align:center;">
            <i class="fa-solid fa-file-circle-xmark" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
            <p style="color:#94a3b8; margin:0;">Aucun procès-verbal enregistré</p>
        </div>
        @endforelse
    </div>
</div>
@endsection