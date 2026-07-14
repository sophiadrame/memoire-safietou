<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — ISI Soutenances</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>* { font-family: 'DM Sans', sans-serif; } .font-display { font-family: 'Syne', sans-serif; }</style>
</head>
<body style="min-height:100vh; display:flex; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 40%, #eff6ff 100%);">
<div style="flex:1; display:flex; align-items:center; justify-content:center; padding:16px;">
    <div style="width:100%; max-width:440px;">

        <div style="text-align:center; margin-bottom:24px;">
            <div style="width:64px; height:64px; background:rgba(255,255,255,0.2); border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="fa-solid fa-graduation-cap" style="color:#fff; font-size:24px;"></i>
            </div>
            <h1 style="font-family:'Syne',sans-serif; font-weight:800; font-size:22px; color:#fff; margin:0 0 4px;">ISI Soutenances</h1>
            <p style="font-size:13px; color:#bfdbfe; margin:0;">Gestion des soutenances académiques</p>
        </div>

        <div style="background:#fff; border-radius:20px; padding:32px; box-shadow:0 25px 50px rgba(0,0,0,0.25);">
            <h2 style="font-family:'Syne',sans-serif; font-weight:700; color:#1e293b; font-size:20px; margin:0 0 4px;">Créer un compte</h2>
            <p style="font-size:13px; color:#64748b; margin:0 0 20px;">Remplissez le formulaire pour vous inscrire</p>

            @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; border-radius:12px; padding:12px; margin-bottom:16px; font-size:13px;">
                @foreach($errors->all() as $e)
                <p style="margin:0 0 2px;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $e }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:14px;">
                @csrf

                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#475569; margin-bottom:6px;">Nom complet <span style="color:#dc2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa-solid fa-user" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="Votre nom complet"
                               style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#475569; margin-bottom:6px;">Adresse email <span style="color:#dc2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa-solid fa-envelope" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="votre@email.com"
                               style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#475569; margin-bottom:6px;">Rôle <span style="color:#dc2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa-solid fa-user-tag" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <select name="role" required
                                style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; outline:none; box-sizing:border-box; color:#475569; appearance:none;">
                            <option value="etudiant" {{ old('role') === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                            <option value="enseignant" {{ old('role') === 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#475569; margin-bottom:6px;">Mot de passe <span style="color:#dc2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa-solid fa-lock" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:500; color:#475569; margin-bottom:6px;">Confirmer le mot de passe <span style="color:#dc2626;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa-solid fa-lock" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
                        <input type="password" name="password_confirmation" required
                               placeholder="••••••••"
                               style="width:100%; padding:10px 16px 10px 40px; border:1px solid #e2e8f0; border-radius:12px; font-size:14px; outline:none; box-sizing:border-box;">
                    </div>
                </div>

                <button type="submit"
                        style="width:100%; padding:11px; border:none; border-radius:12px; color:#fff; font-size:14px; font-weight:500; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; margin-top:4px; background:linear-gradient(135deg,#1e3a8a,#1e40af);">
                    <i class="fa-solid fa-user-plus"></i> S'inscrire
                </button>

                <div style="text-align:center; padding-top:10px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('login') }}" style="font-size:13px; color:#1e40af; text-decoration:none;">
                        Déjà inscrit ? Se connecter
                    </a>
                </div>
            </form>
        </div>

        <p style="text-align:center; font-size:11px; color:#bfdbfe; margin-top:20px;">
            Groupe ISI © {{ date('Y') }} — Plateforme de gestion des soutenances
        </p>
    </div>
</div>
</body>
</html>