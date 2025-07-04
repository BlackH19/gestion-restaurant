<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!$request->user() || !$request->user()->can($permission)) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
