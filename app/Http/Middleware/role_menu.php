<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class role_menu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::user();

            // Periksa apakah user ada dan apakah role serta akses menu tersedia
            if (!$user || !$user->role) {
                abort(403, "User atau role tidak ditemukan.");
            }

            // Periksa apakah user memiliki akses ke menu berdasarkan nama permission
            $hasAccess = $user->role->menus()
                ->where('menu.name', $permission)
                ->wherePivot('can_access', true)
                ->exists();

            if (!$hasAccess) {
                abort(403, "Tidak ada akses ke menu ini.");
            }

            return $next($request);
        }
}
