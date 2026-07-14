@extends('layouts.app')
@section('title', 'Mon Profil')

@section('content')
<div style="max-width:700px; display:flex; flex-direction:column; gap:20px;">

    {{-- Informations du profil --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px;">
        <h5 style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 4px;">Informations du profil</h5>
        <p style="font-size:13px; color:#64748b; margin:0 0 20px;">Mettez à jour votre nom et votre adresse email.</p>

        <form method="POST" action="{{ route('profile.update') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf @method('patch')
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nom</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                @error('name')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                @error('email')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            @if(session('status') === 'profile-updated')
            <p style="color:#16a34a; font-size:13px; margin:0;"><i class="fa-solid fa-check" style="margin-right:4px;"></i> Enregistré !</p>
            @endif
            <div style="display:flex; justify-content:flex-end; padding-top:12px; border-top:1px solid #f1f5f9;">
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:9px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    {{-- Mot de passe --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px;">
        <h5 style="font-weight:700; color:#1e293b; font-size:15px; margin:0 0 4px;">Mettre à jour le mot de passe</h5>
        <p style="font-size:13px; color:#64748b; margin:0 0 20px;">Utilisez un mot de passe long et aléatoire.</p>

        <form method="POST" action="{{ route('password.update') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf @method('put')
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Mot de passe actuel</label>
                <input type="password" name="current_password"
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                @error('current_password', 'updatePassword')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Nouveau mot de passe</label>
                <input type="password" name="password"
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                @error('password', 'updatePassword')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation"
                       style="width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>
            @if(session('status') === 'password-updated')
            <p style="color:#16a34a; font-size:13px; margin:0;"><i class="fa-solid fa-check" style="margin-right:4px;"></i> Enregistré !</p>
            @endif
            <div style="display:flex; justify-content:flex-end; padding-top:12px; border-top:1px solid #f1f5f9;">
                <button type="submit"
                        style="background:#1e40af; color:#fff; border:none; border-radius:10px; padding:9px 20px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    {{-- Suppression du compte --}}
    <div style="background:#fff; border-radius:16px; border:1px solid #fecaca; box-shadow:0 1px 3px rgba(0,0,0,.04); padding:24px;" x-data="{ open: false }">
        <h5 style="font-weight:700; color:#dc2626; font-size:15px; margin:0 0 4px;">Supprimer le compte</h5>
        <p style="font-size:13px; color:#64748b; margin:0 0 16px;">Une fois supprimé, toutes vos données seront définitivement perdues.</p>
        <button @click="open = true"
                style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-trash"></i> Supprimer mon compte
        </button>

        <div x-show="open" style="margin-top:16px; padding:16px; background:#fef2f2; border-radius:12px; border:1px solid #fecaca;">
            <form method="POST" action="{{ route('profile.destroy') }}" style="display:flex; flex-direction:column; gap:12px;">
                @csrf @method('delete')
                <p style="font-size:13px; font-weight:600; color:#dc2626; margin:0;">Êtes-vous sûr ? Cette action est irréversible.</p>
                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#64748b; margin-bottom:6px;">Mot de passe</label>
                    <input type="password" name="password"
                           style="width:100%; padding:10px 14px; border:1px solid #fecaca; border-radius:10px; font-size:14px; outline:none; box-sizing:border-box;">
                    @error('password', 'userDeletion')<p style="color:#dc2626; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="submit"
                            style="background:#dc2626; color:#fff; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-trash"></i> Confirmer la suppression
                    </button>
                    <button type="button" @click="open = false"
                            style="background:#f8fafc; color:#475569; border:1px solid #e2e8f0; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:500; cursor:pointer;">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
<form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>
@endsection