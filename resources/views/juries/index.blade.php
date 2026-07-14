@extends('layouts.app')
@section('title', auth()->user()->role === 'enseignant' ? 'Mes jurys' : 'Composition des jurys')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <div style="display:flex; align-items:center; justify-content:space-between;">
        <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($juries) }} membre(s)</p>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('juries.create') }}"
           style="background:#1e40af; color:#fff; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Ajouter un membre
        </a>
        @endif
    </div>

    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1px solid #f1f5f9;">
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Membre</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Soutenance</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Rôle</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Grade</th>
                    <th style="text-align:left; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Contact</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="text-align:right; padding:14px 20px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($juries as $j)
                <tr style="border-bottom:1px solid #f8fafc;">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                                {{ strtoupper(substr($j->prenom, 0, 1) . substr($j->nom, 0, 1)) }}
                            </div>
                            <p style="font-weight:600; color:#1e293b; margin:0;">{{ $j->prenom }} {{ $j->nom }}</p>
                        </div>
                    </td>
                    <td style="padding:16px 20px; color:#64748b; font-size:12px;">
                        @if($j->soutenance)
                        <p style="margin:0; font-weight:500; color:#475569;">{{ Str::limit($j->soutenance->titre_memoire, 35) }}</p>
                        <p style="margin:2px 0 0; color:#94a3b8;">{{ \Carbon\Carbon::parse($j->soutenance->date_soutenance)->format('d/m/Y') }}</p>
                        @else — @endif
                    </td>
                    <td style="padding:16px 20px;">
                        @php
                        $roles = [
                            'président'   => ['#faf5ff','#7c3aed'],
                            'rapporteur'  => ['#eff6ff','#1e40af'],
                            'examinateur' => ['#f0fdf4','#16a34a'],
                        ];
                        $rc = $roles[$j->role] ?? ['#f8fafc','#64748b'];
                        @endphp
                        <span style="background:{{ $rc[0] }}; color:{{ $rc[1] }}; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;">
                            {{ ucfirst($j->role) }}
                        </span>
                    </td>
                    <td style="padding:16px 20px; color:#64748b; font-size:12px;">{{ $j->grade ?? '—' }}</td>
                    <td style="padding:16px 20px; color:#64748b; font-size:12px;">
                        @if($j->email)<p style="margin:0;">{{ $j->email }}</p>@endif
                        @if($j->telephone)<p style="margin:2px 0 0;">{{ $j->telephone }}</p>@endif
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="padding:16px 20px; text-align:right;">
                        <div style="display:flex; justify-content:flex-end; gap:8px;">
                            <a href="{{ route('juries.edit', $j) }}"
                               style="background:#eff6ff; color:#1e40af; padding:6px 12px; border-radius:8px; font-size:12px; text-decoration:none; font-weight:500;">
                                <i class="fa-solid fa-pen"></i> Modifier
                            </a>
                            <form action="{{ route('juries.destroy', $j) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Supprimer ce membre ?')">
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
                    <td colspan="6" style="text-align:center; padding:60px 20px;">
                        <i class="fa-solid fa-people-group" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
                        <p style="color:#94a3b8; margin:0;">Aucun membre de jury enregistré</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection