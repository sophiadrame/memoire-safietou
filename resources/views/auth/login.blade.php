<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — ISI Soutenances</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>* { font-family: 'DM Sans', sans-serif; } .font-display { font-family: 'Syne', sans-serif; }</style>
</head>
<body class="min-h-screen flex" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 40%, #eff6ff 100%);">
<div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-graduation-cap text-white text-2xl"></i>
            </div>
            <h1 class="font-display font-bold text-2xl text-white">ISI Soutenances</h1>
            <p class="text-blue-200 text-sm mt-1">Gestion des soutenances académiques</p>
        </div>
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="font-display font-bold text-slate-900 text-xl mb-2">Connexion</h2>
            <p class="text-slate-500 text-sm mb-6">Entrez vos identifiants pour accéder à la plateforme</p>
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-3 mb-5 text-sm flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                {{ $errors->first() }}
            </div>
            @endif
            @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-3 mb-5 text-sm">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Adresse email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                               placeholder="votre@email.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition"
                               placeholder="••••••••">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600">
                        <span class="text-sm text-slate-600">Se souvenir de moi</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Mot de passe oublié ?</a>
                    @endif
                </div>
                <button type="submit"
                        class="w-full text-white font-medium py-2.5 rounded-xl transition text-sm flex items-center justify-center gap-2 mt-2"
                        style="background: linear-gradient(135deg, #1e3a8a, #1e40af);">
                    <i class="fa-solid fa-right-to-bracket"></i> Se connecter
                </button>
            </form>
        </div>
        <p class="text-center text-xs text-blue-200 mt-6">Groupe ISI © {{ date('Y') }} — Plateforme de gestion des soutenances</p>
    </div>
</div>
</body>
</html>