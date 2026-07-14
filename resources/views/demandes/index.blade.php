@extends('layouts.app')
@section('title', auth()->user()->isEtudiant() ? 'Ma demande' : 'Demandes des étudiants')

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    <p style="font-size:13px; color:#94a3b8; margin:0;">{{ count($demandes) }} demande(s)</p>

    <div style="display:flex; flex-direction:column; gap:12px;">
        @forelse($demandes as $demande)
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:20px;">

            <div style="display:flex; align-items:start; justify-content:space-between; gap:16px; margin-bottom:16px;">
                <div style="flex:1;">
                    <p style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 4px;">{{ $demande->sujet->titre }}</p>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:6px;">
                        <span style="background:#eff6ff; color:#1e40af; padding:3px 10px; border-radius:20px; font-size:11px;">{{ $demande->sujet->type }}</span>
                        <span style="background:#f0fdf4; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:11px;">{{ $demande->sujet->filiere }}</span>
                    </div>
                </div>
                @php
                $statuts = [
                    'en_attente'     => ['#fef3c7','#d97706','fa-clock','En attente'],
                    'acceptee'       => ['#f0fdf4','#16a34a','fa-circle-check','Acceptée'],
                    'refusee'        => ['#fef2f2','#dc2626','fa-circle-xmark','Refusée'],
                    'memoire_depose' => ['#eff6ff','#1e40af','fa-file-arrow-up','Mémoire déposé'],
                    'memoire_valide' => ['#f0fdf4','#16a34a','fa-graduation-cap','Mémoire validé'],
                    'memoire_refuse' => ['#fef2f2','#dc2626','fa-file-circle-xmark','Mémoire refusé'],
                ];
                $sc = $statuts[$demande->statut] ?? ['#f1f5f9','#64748b','fa-question','Inconnu'];
                @endphp
                <span style="background:{{ $sc[0] }}; color:{{ $sc[1] }}; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:500; display:inline-flex; align-items:center; gap:6px; flex-shrink:0;">
                    <i class="fa-solid {{ $sc[2] }}" style="font-size:11px;"></i> {{ $sc[3] }}
                </span>
            </div>

            {{-- Infos étudiant (pour encadreur/admin) --}}
            @if(!auth()->user()->isEtudiant())
            <div style="display:flex; align-items:center; gap:10px; padding:10px; background:#f8fafc; border-radius:10px; margin-bottom:12px;">
                <div style="width:36px; height:36px; background:linear-gradient(135deg,#1e3a8a,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:12px; flex-shrink:0;">
                    {{ strtoupper(substr($demande->etudiant->name, 0, 2)) }}
                </div>
                <div>
                    <p style="font-size:13px; font-weight:600; color:#1e293b; margin:0;">{{ $demande->etudiant->name }}</p>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">{{ $demande->etudiant->email }}</p>
                </div>
            </div>
            @endif

            {{-- Message étudiant --}}
            @if($demande->message_etudiant)
            <div style="padding:12px; background:#f8fafc; border-radius:10px; margin-bottom:12px;">
                <p style="font-size:11px; color:#94a3b8; margin:0 0 4px;"><i class="fa-solid fa-comment" style="margin-right:4px;"></i>Message de l'étudiant</p>
                <p style="font-size:13px; color:#475569; margin:0; font-style:italic;">{{ $demande->message_etudiant }}</p>
            </div>
            @endif

            {{-- Message encadreur --}}
            @if($demande->message_encadreur)
            <div style="padding:12px; background:#fef3c7; border-radius:10px; margin-bottom:12px;">
                <p style="font-size:11px; color:#92400e; margin:0 0 4px;"><i class="fa-solid fa-reply" style="margin-right:4px;"></i>Réponse de l'encadreur</p>
                <p style="font-size:13px; color:#92400e; margin:0; font-style:italic;">{{ $demande->message_encadreur }}</p>
            </div>
            @endif

            {{-- Mémoire déposé --}}
            @if($demande->memoire_fichier)
            <div style="display:flex; align-items:center; gap:10px; padding:12px; background:#eff6ff; border-radius:10px; margin-bottom:12px;">
                <i class="fa-solid fa-file-pdf" style="color:#dc2626; font-size:20px;"></i>
                <div style="flex:1;">
                    <p style="font-size:13px; font-weight:500; color:#1e293b; margin:0;">Mémoire déposé</p>
                    <p style="font-size:11px; color:#94a3b8; margin:0;">{{ $demande->date_depot?->format('d/m/Y à H:i') }}</p>
                </div>
                <a href="{{ route('demandes.telecharger', $demande) }}"
                   style="background:#1e40af; color:#fff; border-radius:8px; padding:6px 12px; font-size:12px; font-weight:500; text-decoration:none;">
                    <i class="fa-solid fa-download"></i> Télécharger
                </a>
            </div>
            @endif

            {{-- Actions encadreur --}}
            @if(auth()->user()->isEnseignant() && $demande->encadreur_id === auth()->id())

                @if($demande->isEnAttente())
                <div style="display:flex; gap:8px; padding-top:12px; border-top:1px solid #f1f5f9;" x-data="{ refus: false }">
                    <form action="{{ route('demandes.accepter', $demande) }}" method="POST">
                        @csrf @method('PATCH')
                        <button style="background:#16a34a; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-check"></i> Accepter
                        </button>
                    </form>
                    <button @click="refus = !refus"
                            style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer;">
                        <i class="fa-solid fa-xmark"></i> Refuser
                    </button>
                    <div x-show="refus" style="width:100%; margin-top:10px;">
                        <form action="{{ route('demandes.refuser', $demande) }}" method="POST" style="display:flex; flex-direction:column; gap:8px;">
                            @csrf @method('PATCH')
                            <textarea name="message_encadreur" rows="3" required
                                      placeholder="Motif du refus..."
                                      style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; box-sizing:border-box; resize:none;"></textarea>
                            <button type="submit"
                                    style="background:#dc2626; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; align-self:flex-end;">
                                Confirmer le refus
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @if($demande->isMemoireDepose())
                <div style="display:flex; gap:8px; padding-top:12px; border-top:1px solid #f1f5f9;" x-data="{ refus: false }">
                    <form action="{{ route('demandes.valider-memoire', $demande) }}" method="POST">
                        @csrf @method('PATCH')
                        <button style="background:#16a34a; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-check"></i> Valider le mémoire
                        </button>
                    </form>
                    <button @click="refus = !refus"
                            style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer;">
                        Demander corrections
                    </button>
                    <div x-show="refus" style="width:100%; margin-top:10px;">
                        <form action="{{ route('demandes.refuser-memoire', $demande) }}" method="POST" style="display:flex; flex-direction:column; gap:8px;">
                            @csrf @method('PATCH')
                            <textarea name="message_encadreur" rows="3" required
                                      placeholder="Corrections demandées..."
                                      style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:10px; font-size:13px; outline:none; box-sizing:border-box; resize:none;"></textarea>
                            <button type="submit"
                                    style="background:#dc2626; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; align-self:flex-end;">
                                Envoyer
                            </button>
                        </form>
                    </div>
                </div>
                @endif

            @endif

            {{-- Action étudiant : déposer mémoire --}}
            @if(auth()->user()->isEtudiant() && $demande->isAcceptee())
            <div style="padding-top:12px; border-top:1px solid #f1f5f9;" x-data="{ depot: false }">
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px; margin-bottom:12px;">
                    <p style="font-size:13px; font-weight:600; color:#16a34a; margin:0 0 4px;"><i class="fa-solid fa-circle-check" style="margin-right:6px;"></i>Demande acceptée !</p>
                    <p style="font-size:12px; color:#166534; margin:0;">Vous pouvez maintenant déposer votre mémoire.</p>
                </div>
                <button @click="depot = !depot"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-file-arrow-up"></i> Déposer mon mémoire
                </button>
                <div x-show="depot" style="margin-top:12px;">
                    <form action="{{ route('demandes.deposer', $demande) }}" method="POST"
                          enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
                        @csrf
                        <label style="display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px dashed #e2e8f0; border-radius:12px; padding:24px; cursor:pointer;">
                            <i class="fa-solid fa-file-pdf" style="font-size:28px; color:#dc2626; margin-bottom:8px;"></i>
                            <p style="font-size:13px; color:#64748b; margin:0;">Sélectionner votre mémoire <span style="color:#1e40af; font-weight:500;">(PDF uniquement)</span></p>
                            <p style="font-size:11px; color:#94a3b8; margin:4px 0 0;">Max 20 Mo</p>
                            <input type="file" name="memoire_fichier" accept=".pdf" required style="display:none;">
                        </label>
                        <button type="submit"
                                style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; align-self:flex-end; display:inline-flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-upload"></i> Envoyer le mémoire
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Mémoire refusé : redéposer --}}
            @if(auth()->user()->isEtudiant() && $demande->statut === 'memoire_refuse')
            <div style="padding-top:12px; border-top:1px solid #f1f5f9;" x-data="{ depot: false }">
                <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:14px; margin-bottom:12px;">
                    <p style="font-size:13px; font-weight:600; color:#dc2626; margin:0 0 4px;"><i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>Corrections demandées</p>
                    <p style="font-size:12px; color:#991b1b; margin:0;">Veuillez corriger votre mémoire et le redéposer.</p>
                </div>
                <button @click="depot = !depot"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-file-arrow-up"></i> Redéposer mon mémoire
                </button>
                <div x-show="depot" style="margin-top:12px;">
                    <form action="{{ route('demandes.deposer', $demande) }}" method="POST"
                          enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
                        @csrf
                        <label style="display:flex; flex-direction:column; align-items:center; justify-content:center; border:2px dashed #e2e8f0; border-radius:12px; padding:24px; cursor:pointer;">
                            <i class="fa-solid fa-file-pdf" style="font-size:28px; color:#dc2626; margin-bottom:8px;"></i>
                            <input type="file" name="memoire_fichier" accept=".pdf" required style="display:none;">
                            <p style="font-size:13px; color:#64748b; margin:0;">Sélectionner le nouveau mémoire <span style="color:#1e40af;">(PDF)</span></p>
                        </label>
                        <button type="submit"
                                style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:500; cursor:pointer; align-self:flex-end;">
                            <i class="fa-solid fa-upload"></i> Envoyer
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>
        @empty
        <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; padding:60px 20px; text-align:center;">
            <i class="fa-solid fa-inbox" style="font-size:40px; color:#e2e8f0; display:block; margin-bottom:12px;"></i>
            <p style="color:#94a3b8; margin:0;">Aucune demande</p>
        </div>
        @endforelse
    </div>
</div>
@endsection