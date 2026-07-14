@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('subtitle', 'Vue d\'ensemble de l\'activité')

@section('content')
<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Cartes statistiques cliquables --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">
        <a href="{{ route('soutenances.index') }}" style="text-decoration:none;">
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px; transition:all .2s; cursor:pointer;" onmouseover="this.style.boxShadow='0 4px 12px rgba(30,64,175,0.15)'; this.style.borderColor='#bfdbfe';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'; this.style.borderColor='#f1f5f9';">
                <div style="width:40px; height:40px; background:#eff6ff; color:#1e40af; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <p style="font-size:28px; font-weight:700; color:#0f172a; margin:0;">{{ $totalSoutenances }}</p>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Soutenances</p>
                <p style="font-size:11px; color:#1e40af; margin:6px 0 0;">Voir tout →</p>
            </div>
        </a>

        <a href="{{ route('juries.index') }}" style="text-decoration:none;">
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px; transition:all .2s; cursor:pointer;" onmouseover="this.style.boxShadow='0 4px 12px rgba(22,163,74,0.15)'; this.style.borderColor='#bbf7d0';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'; this.style.borderColor='#f1f5f9';">
                <div style="width:40px; height:40px; background:#f0fdf4; color:#16a34a; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                    <i class="fa-solid fa-people-group"></i>
                </div>
                <p style="font-size:28px; font-weight:700; color:#0f172a; margin:0;">{{ $totalJury }}</p>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Membres jury</p>
                <p style="font-size:11px; color:#16a34a; margin:6px 0 0;">Voir tout →</p>
            </div>
        </a>

        <a href="{{ route('pvs.index') }}" style="text-decoration:none;">
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px; transition:all .2s; cursor:pointer;" onmouseover="this.style.boxShadow='0 4px 12px rgba(217,119,6,0.15)'; this.style.borderColor='#fde68a';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'; this.style.borderColor='#f1f5f9';">
                <div style="width:40px; height:40px; background:#fffbeb; color:#d97706; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <p style="font-size:28px; font-weight:700; color:#0f172a; margin:0;">{{ $totalPV }}</p>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">PV générés</p>
                <p style="font-size:11px; color:#d97706; margin:6px 0 0;">Voir tout →</p>
            </div>
        </a>

        <a href="{{ route('archives.index') }}" style="text-decoration:none;">
            <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px; transition:all .2s; cursor:pointer;" onmouseover="this.style.boxShadow='0 4px 12px rgba(124,58,237,0.15)'; this.style.borderColor='#ddd6fe';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.04)'; this.style.borderColor='#f1f5f9';">
                <div style="width:40px; height:40px; background:#faf5ff; color:#7c3aed; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                    <i class="fa-solid fa-box-archive"></i>
                </div>
                <p style="font-size:28px; font-weight:700; color:#0f172a; margin:0;">{{ $totalArchives }}</p>
                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Archives</p>
                <p style="font-size:11px; color:#7c3aed; margin:6px 0 0;">Voir tout →</p>
            </div>
        </a>
    </div>

    {{-- État des soutenances --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
        <p style="font-weight:700; color:#1e293b; margin:0 0 16px;">
            <i class="fa-solid fa-chart-pie" style="color:#1e40af; margin-right:8px;"></i>État des soutenances
        </p>
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; text-align:center;">
            <div style="background:#eff6ff; border-radius:12px; padding:16px;">
                <p style="font-size:32px; font-weight:700; color:#1e40af; margin:0;">{{ $soutenancesPlanifiees }}</p>
                <p style="font-size:13px; color:#64748b; margin:4px 0 0;">Planifiées</p>
            </div>
            <div style="background:#f0fdf4; border-radius:12px; padding:16px;">
                <p style="font-size:32px; font-weight:700; color:#16a34a; margin:0;">{{ $soutenancesTerminees }}</p>
                <p style="font-size:13px; color:#64748b; margin:4px 0 0;">Terminées</p>
            </div>
            <div style="background:#f8fafc; border-radius:12px; padding:16px;">
                <p style="font-size:32px; font-weight:700; color:#64748b; margin:0;">{{ $totalSoutenances - $soutenancesPlanifiees - $soutenancesTerminees }}</p>
                <p style="font-size:13px; color:#64748b; margin:4px 0 0;">Autres</p>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- Prochaines soutenances --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="font-weight:700; color:#1e293b; margin:0;">
                    <i class="fa-solid fa-calendar-check" style="color:#1e40af; margin-right:8px;"></i>Prochaines soutenances
                </p>
                <a href="{{ route('soutenances.index') }}" style="color:#1e40af; font-size:12px; text-decoration:none;">Voir tout →</a>
            </div>
            @forelse($prochainesSoutenances as $s)
            <div style="display:flex; align-items:center; gap:16px; padding:12px; background:#f8fafc; border-radius:12px; margin-bottom:8px;">
                <div style="width:44px; height:44px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:12px; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#fff; flex-shrink:0;">
                    <span style="font-size:12px; font-weight:700; line-height:1;">{{ \Carbon\Carbon::parse($s->date_soutenance)->format('d') }}</span>
                    <span style="font-size:10px; opacity:0.8;">{{ strtoupper(\Carbon\Carbon::parse($s->date_soutenance)->format('M')) }}</span>
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $s->etudiant_prenom }} {{ $s->etudiant_nom }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Str::limit($s->titre_memoire, 35) }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:1px 0 0;">{{ $s->heure_debut }} – {{ $s->heure_fin }} · {{ $s->salle }}</p>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:32px 0;">
                <i class="fa-solid fa-calendar-xmark" style="font-size:32px; color:#e2e8f0; display:block; margin-bottom:8px;"></i>
                <p style="font-size:13px; color:#94a3b8; margin:0;">Aucune soutenance à venir</p>
            </div>
            @endforelse
        </div>

        {{-- Dernières archives --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="font-weight:700; color:#1e293b; margin:0;">
                    <i class="fa-solid fa-box-archive" style="color:#7c3aed; margin-right:8px;"></i>Dernières archives
                </p>
                <a href="{{ route('archives.index') }}" style="color:#1e40af; font-size:12px; text-decoration:none;">Voir tout →</a>
            </div>
            @forelse($dernieresArchives as $archive)
            <div style="display:flex; align-items:center; gap:12px; padding:12px; background:#f8fafc; border-radius:12px; margin-bottom:8px;">
                <div style="width:36px; height:36px; background:#fef2f2; color:#dc2626; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Str::limit($archive->nom_fichier, 30) }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:2px 0 0;">{{ $archive->soutenance->etudiant_nom ?? '' }}</p>
                </div>
                <a href="{{ route('archives.download', $archive) }}" style="color:#1e40af; font-size:12px; text-decoration:none; flex-shrink:0;">
                    <i class="fa-solid fa-download"></i>
                </a>
            </div>
            @empty
            <div style="text-align:center; padding:32px 0;">
                <i class="fa-solid fa-box-open" style="font-size:32px; color:#e2e8f0; display:block; margin-bottom:8px;"></i>
                <p style="font-size:13px; color:#94a3b8; margin:0;">Aucune archive récente</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection