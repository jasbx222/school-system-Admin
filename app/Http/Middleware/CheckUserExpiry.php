<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->expires_at && now()->greaterThan($user->expires_at)) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'انتهت صلاحية حسابك.',
            ]);
        }

        return $next($request);
    }

}
