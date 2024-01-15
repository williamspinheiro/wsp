<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordTemporaryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->password_temporary == 1) {
            return redirect()->action([\App\Http\Controllers\UserController::class, 'profile'])->withErrors('Altere sua senha antes de prosseguir.');
        }

        return $next($request);
    }
}
