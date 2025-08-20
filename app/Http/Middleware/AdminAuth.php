<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and is admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated or insufficient permissions'], 401);
            }
            
            // Logout if user is authenticated but not admin
            if (Auth::check()) {
                Auth::logout();
            }
            
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        // Update last activity timestamp
        session(['admin_last_activity' => now()]);

        // Regenerate session ID periodically for security
        if (!session('last_regenerated') || now()->diffInMinutes(session('last_regenerated')) > 30) {
            $request->session()->regenerate(false); // false = keep session data
            session(['last_regenerated' => now()]);
        }

        return $next($request);
    }
}
