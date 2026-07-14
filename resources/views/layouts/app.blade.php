<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion des Soutenances — ISI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .sidebar-link { transition: all .2s; display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:12px; font-size:13px; color:rgba(255,255,255,0.8); text-decoration:none; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(255,255,255,0.15); color:#fff; }
        .flash { border-radius:12px; padding:12px 16px; font-size:13px; display:flex; align-items:center; gap:10px; margin-bottom:8px; }
        .flash-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
        .flash-error { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
    </style>
    @stack('styles')
</head>
<body style="background:#f8fafc; min-height:100vh; display:flex; margin:0;">

<aside style="width:260px; flex-shrink:0; background:linear-gradient(180deg,#1e3a8a,#1e40af); min-height:100vh; display:flex; flex-direction:column; position:sticky; top:0; height:100vh; overflow-y:auto;">
    <div style="padding:20px 24px; border-bottom:1px solid rgba(255,255,255,0.1);">
        <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
            <div style="width:36px; height:36px; background:rgba(255,255,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-graduation-cap" style="color:#fff; font-size:14px;"></i>
            </div>
            <div>
                <p style="font-family:'Syne',sans-serif; font-weight:700; color:#fff; font-size:13px; margin:0; line-height:1.2;">ISI Soutenances</p>
                <p style="font-size:11px; color:#93c5fd; margin:0;">Groupe ISI</p>
            </div>
        </a>
    </div>

    <div style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.1);">
        <div style="display:flex; align-items:center; gap:10px; background:rgba(255,255,255,0.1); padding:10px 12px; border-radius:12px;">
            <div style="width:36px; height:36px; background:rgba(255,255,255,0.2); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:13px; flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div style="min-width:0;">
                <p style="font-size:13px; font-weight:600; color:#fff; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
                @php
                $roleColors = ['admin'=>'#fbbf24','enseignant'=>'#34d399','etudiant'=>'#a78bfa'];
                $roleColor = $roleColors[auth()->user()->role] ?? '#93c5fd';
                @endphp
                <span style="font-size:11px; color:{{ $roleColor }}; font-weight:500;">
                    <i class="fa-solid fa-circle" style="font-size:7px; margin-right:3px;"></i>
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>
    </div>

    <nav style="flex:1; padding:12px;">
        <p style="font-size:10px; font-weight:600; color:#93c5fd; text-transform:uppercase; letter-spacing:.08em; padding:0 12px; margin:0 0 8px;">Menu principal</p>

        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house" style="width:16px; text-align:center;"></i> Tableau de bord
        </a>

        @if(auth()->user()->isEtudiant())
        <a href="{{ route('sujets.index') }}" class="sidebar-link {{ request()->routeIs('sujets.*') ? 'active' : '' }}">
            <i class="fa-solid fa-folder-open" style="width:16px; text-align:center;"></i> Choisir un sujet
        </a>
        <a href="{{ route('demandes.index') }}" class="sidebar-link {{ request()->routeIs('demandes.*') ? 'active' : '' }}">
            <i class="fa-solid fa-paper-plane" style="width:16px; text-align:center;"></i> Ma demande
        </a>
        <a href="{{ route('soutenances.index') }}" class="sidebar-link {{ request()->routeIs('soutenances.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days" style="width:16px; text-align:center;"></i> Ma soutenance
        </a>
        <a href="{{ route('pvs.index') }}" class="sidebar-link {{ request()->routeIs('pvs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines" style="width:16px; text-align:center;"></i> Mes résultats
        </a>
       
        @endif

        @if(auth()->user()->isEnseignant())
        <a href="{{ route('sujets.index') }}" class="sidebar-link {{ request()->routeIs('sujets.*') ? 'active' : '' }}">
            <i class="fa-solid fa-folder-open" style="width:16px; text-align:center;"></i> Mes sujets
        </a>
        <a href="{{ route('demandes.index') }}" class="sidebar-link {{ request()->routeIs('demandes.*') ? 'active' : '' }}">
            <i class="fa-solid fa-inbox" style="width:16px; text-align:center;"></i> Demandes étudiants
        </a>
        <a href="{{ route('soutenances.index') }}" class="sidebar-link {{ request()->routeIs('soutenances.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days" style="width:16px; text-align:center;"></i> Planning
        </a>
        <a href="{{ route('pvs.index') }}" class="sidebar-link {{ request()->routeIs('pvs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines" style="width:16px; text-align:center;"></i> Procès-verbaux
        </a>
        <a href="{{ route('archives.index') }}" class="sidebar-link {{ request()->routeIs('archives.*') ? 'active' : '' }}">
            <i class="fa-solid fa-box-archive" style="width:16px; text-align:center;"></i> Archivage
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route('sujets.index') }}" class="sidebar-link {{ request()->routeIs('sujets.*') ? 'active' : '' }}">
            <i class="fa-solid fa-folder-open" style="width:16px; text-align:center;"></i> Sujets
        </a>
        <a href="{{ route('encadreurs.index') }}" class="sidebar-link {{ request()->routeIs('encadreurs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-tie" style="width:16px; text-align:center;"></i> Encadreurs
        </a>
        <a href="{{ route('demandes.index') }}" class="sidebar-link {{ request()->routeIs('demandes.*') ? 'active' : '' }}">
            <i class="fa-solid fa-inbox" style="width:16px; text-align:center;"></i> Demandes
        </a>
        <a href="{{ route('soutenances.index') }}" class="sidebar-link {{ request()->routeIs('soutenances.*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days" style="width:16px; text-align:center;"></i> Planning
        </a>
        <a href="{{ route('juries.index') }}" class="sidebar-link {{ request()->routeIs('juries.*') ? 'active' : '' }}">
            <i class="fa-solid fa-people-group" style="width:16px; text-align:center;"></i> Jury
        </a>
        <a href="{{ route('pvs.index') }}" class="sidebar-link {{ request()->routeIs('pvs.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines" style="width:16px; text-align:center;"></i> Procès-verbaux
        </a>
        <a href="{{ route('archives.index') }}" class="sidebar-link {{ request()->routeIs('archives.*') ? 'active' : '' }}">
            <i class="fa-solid fa-box-archive" style="width:16px; text-align:center;"></i> Archivage
        </a>
        <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-circle" style="width:16px; text-align:center;"></i> Mon profil
        </a>
        @endif
    </nav>

    <div style="padding:12px; border-top:1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%; background:none; border:none; cursor:pointer; color:rgba(252,165,165,0.9);">
                <i class="fa-solid fa-right-from-bracket" style="width:16px; text-align:center;"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>

<div style="flex:1; display:flex; flex-direction:column; min-width:0;">
    <header style="background:#fff; border-bottom:1px solid #f1f5f9; padding:14px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:10; box-shadow:0 1px 3px rgba(0,0,0,.04);">
        <div>
            <h1 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:18px; margin:0;">@yield('title', 'Tableau de bord')</h1>
            <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;">@yield('subtitle', '')</p>
        </div>
        <div style="display:flex; align-items:center; gap:16px;">
            <p style="font-size:12px; color:#94a3b8; margin:0;">{{ now()->translatedFormat('l d F Y') }}</p>
            <div style="display:flex; align-items:center; gap:10px; padding:8px 14px; background:#f8fafc; border-radius:12px; border:1px solid #f1f5f9;">
                <div style="width:32px; height:32px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:8px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0;">{{ auth()->user()->name }}</p>
                    @php
                    $badges = ['admin'=>['#eff6ff','#1e40af'],'enseignant'=>['#f0fdf4','#16a34a'],'etudiant'=>['#faf5ff','#7c3aed']];
                    $b = $badges[auth()->user()->role] ?? ['#f8fafc','#64748b'];
                    @endphp
                    <span style="background:{{ $b[0] }}; color:{{ $b[1] }}; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:500;">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>
        </div>
    </header>

    <div style="padding:16px 32px 0;">
        @if(session('success'))
        <div class="flash flash-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flash flash-error">
            <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
        @endif
        @if($errors->any())
        <div class="flash flash-error" style="flex-direction:column; align-items:start; gap:4px;">
            @foreach($errors->all() as $e)
            <p style="margin:0;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;"></i>{{ $e }}</p>
            @endforeach
        </div>
        @endif
    </div>

    <main style="flex:1; padding:24px 32px;">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>