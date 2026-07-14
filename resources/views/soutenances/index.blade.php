@extends('layouts.app')
@section('title', auth()->user()->role === 'etudiant' ? 'Ma soutenance' : 'Planning des soutenances')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($soutenances) }} soutenance(s)</p>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('soutenances.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Nouvelle soutenance
        </a>
        @endif
    </div>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1px solid #f1f5f9;">
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Étudiant</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Titre du mémoire</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Filière</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Date</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Horaire</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Salle</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Statut</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="text-align:right; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.05em;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($soutenances as $s)
                <tr style="border-bottom:1px solid #f8fafc;">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                                {{ strtoupper(substr($s->etudiant_prenom, 0, 1) . substr($s->etudiant_nom, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; color:#1e293b; margin:0;">{{ $s->etudiant_prenom }} {{ $s->etudiant_nom }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 20px; color:#475569; max-width:200px;">
                        <p style="margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Str::limit($s->titre_memoire, 40) }}</p>
                    </td>
                    <td style="padding:16px 20px;">
                        <span style="background:#eff6ff; color:#1e40af; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;">{{ $s->filiere }}</span>
                    </td>
                    <td style="padding:16px 20px; color:#475569; font-weight:500;">
                        {{ \Carbon\Carbon::parse($s->date_soutenance)->format('d/m/Y') }}
                    </td>
                    <td style="padding:16px 20px; color:#64748b; font-size:12px;">
                        {{ $s->heure_debut }} – {{ $s->heure_fin }}
                    </td>
                    <td style="padding:16px 20px; color:#475569;">{{ $s->salle }}</td>
                    <td style="padding:16px 20px;">
                        @php
                        $statuts = [
                            'planifiée' => ['#eff6ff','#1e40af','fa-clock'],
                            'en cours'  => ['#fffbeb','#d97706','fa-spinner'],
                            'terminée'  => ['#f0fdf4','#16a34a','fa-circle-check'],
                            'annulée'   => ['#fef2f2','#dc2626','fa-circle-xmark'],
                        ];
                        $sc = $statuts[$s->statut] ?? ['#f8fafc','#64748b','fa-question'];
                        @endphp
                        <span style="background:{{ $sc[0] }}; color:{{ $sc[1] }}; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500; display:inline-flex; align-items:center; gap:5px;">
                            <i class="fa-solid {{ $sc[2] }}" style="font-size:10px;"></i> {{ ucfirst($s->statut) }}
                        </span>
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="padding:16px 20px; text-align:right;">
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <a href="{{ route('soutenances.edit', $s) }}"
                               style="background:#eff6ff; color:#1e40af; padding:6px 12px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                                <i class="fa-solid fa-pen"></i> Modifier
                            </a>
                            <form action="{{ route('soutenances.destroy', $s) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Supprimer cette soutenance ?')">
                                @csrf @method('DELETE')
                                <button style="background:#fef2f2; color:#dc2626; border:none; padding:6px 12px; border-radius:8px; font-size:12px; cursor:pointer; font-weight:500;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:60px 20px;">
                        <i class="fa-solid fa-calendar-xmark" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
                        <p style="color:#94a3b8; margin:0;">Aucune soutenance planifiée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection