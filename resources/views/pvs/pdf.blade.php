<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PV — {{ $pv->soutenance->etudiant_prenom }} {{ $pv->soutenance->etudiant_nom }}</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 0; }
        body { font-size: 12px; color: #1e293b; padding: 40px; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 20px; color: #1e3a8a; font-weight: bold; margin-bottom: 5px; }
        .header p { color: #64748b; font-size: 11px; }
        .titre-pv { text-align: center; font-size: 16px; font-weight: bold; color: #1e40af; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 11px; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 10px; }
        .row { display: flex; margin-bottom: 8px; }
        .label { width: 160px; font-weight: bold; color: #475569; flex-shrink: 0; }
        .value { color: #1e293b; flex: 1; }
        .note-box { text-align: center; border: 2px solid #1e40af; border-radius: 8px; padding: 15px; margin: 20px 0; }
        .note-box .note { font-size: 36px; font-weight: bold; color: #1e40af; }
        .note-box .mention { font-size: 14px; color: #64748b; margin-top: 5px; }
        .decision-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 12px; text-align: center; font-weight: bold; color: #166534; font-size: 14px; }
        .jury-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .jury-table th { background: #f8fafc; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; color: #64748b; border: 1px solid #e2e8f0; }
        .jury-table td { padding: 8px; border: 1px solid #e2e8f0; font-size: 11px; }
        .signatures { display: flex; justify-content: space-between; margin-top: 50px; }
        .signature-box { text-align: center; width: 45%; }
        .signature-line { border-top: 1px solid #94a3b8; margin-top: 40px; padding-top: 5px; font-size: 11px; color: #64748b; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>

<div class="header">
    <h1>GROUPE ISI — Institut Supérieur d'Informatique</h1>
    <p>Dakar, Sénégal · www.groupeisi.com</p>
</div>

<div class="titre-pv">Procès-Verbal de Soutenance</div>

<div class="section">
    <div class="section-title">Informations sur l'étudiant</div>
    <div class="row">
        <div class="label">Nom & Prénom :</div>
        <div class="value">{{ $pv->soutenance->etudiant_prenom }} {{ $pv->soutenance->etudiant_nom }}</div>
    </div>
    <div class="row">
        <div class="label">Filière :</div>
        <div class="value">{{ $pv->soutenance->filiere }}</div>
    </div>
    <div class="row">
        <div class="label">Titre du mémoire :</div>
        <div class="value">{{ $pv->soutenance->titre_memoire }}</div>
    </div>
    <div class="row">
        <div class="label">Date de soutenance :</div>
        <div class="value">
            {{ \Carbon\Carbon::parse($pv->soutenance->date_soutenance)->format('d/m/Y') }}
            de {{ $pv->soutenance->heure_debut }} à {{ $pv->soutenance->heure_fin }}
        </div>
    </div>
    <div class="row">
        <div class="label">Salle :</div>
        <div class="value">{{ $pv->soutenance->salle }}</div>
    </div>
</div>

<div class="note-box">
    <div class="note">{{ $pv->note }}/20</div>
    <div class="mention">Mention : {{ $pv->mention }}</div>
</div>

<div class="section">
    <div class="section-title">Décision du jury</div>
    <div class="decision-box">{{ $pv->decision }}</div>
    @if($pv->appreciation)
    <p style="margin-top: 10px; color: #475569; font-style: italic;">{{ $pv->appreciation }}</p>
    @endif
</div>

@if($pv->soutenance->juries->count() > 0)
<div class="section">
    <div class="section-title">Composition du jury</div>
    <table class="jury-table">
        <thead>
            <tr>
                <th>Nom & Prénom</th>
                <th>Grade</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pv->soutenance->juries as $j)
            <tr>
                <td>{{ $j->prenom }} {{ $j->nom }}</td>
                <td>{{ $j->grade ?? '—' }}</td>
                <td>{{ ucfirst($j->role) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="signatures">
    <div class="signature-box">
        <div class="signature-line">Le Président du Jury</div>
    </div>
    <div class="signature-box">
        <div class="signature-line">Le Directeur des études</div>
    </div>
</div>

<div class="footer">
    Document généré le {{ \Carbon\Carbon::parse($pv->date_pv)->format('d/m/Y') }} · ISI Soutenances
</div>

</body>
</html>