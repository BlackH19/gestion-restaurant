<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles; // Ajoutez cette ligne

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        abort(403, 'Non authentifié');
    }

    $user = Auth::user();
    
    // Vérification directe du rôle admin
    if ($user->role === 'admin') {
        return $next($request);
    }

    // Vérification des autres rôles
    if (in_array($user->role, $roles)) {
        return $next($request);
    }

    abort(403, 'Accès non autorisé');
}
}