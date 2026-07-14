<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Autorise l'accès uniquement si le rôle de l'utilisateur connecté
     * fait partie des rôles passés en paramètre.
     *
     * Exemple d'utilisation dans les routes :
     *   Route::middleware('role:admin')->group(...)
     *   Route::middleware('role:admin,enseignant')->group(...)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles, true)) {
            abort(403, "Vous n'avez pas accès à cette page.");
        }

        return $next($request);
    }
}
