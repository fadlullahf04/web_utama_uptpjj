<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $userRole = in_array($user->role, ['staf', 'staff'], true) ? 'staf' : $user->role;

        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $trimmed = trim($r);
                if ($trimmed !== '') {
                    $allowedRoles[] = in_array($trimmed, ['staf', 'staff'], true) ? 'staf' : $trimmed;
                }
            }
        }

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Akses Ditolak: Peran akun Anda ('.$user->role.') tidak memiliki izin untuk mengakses modul ini.');
        }

        return $next($request);
    }
}
