<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();
        
        // Check if user is admin (you can modify this logic)
        if (!$this->isAdmin($user)) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'You are not authorized to access admin panel.']);
        }

        return $next($request);
    }

    private function isAdmin($user)
    {
        // For now, we'll check if email contains 'admin' or you can add a role column
        return str_contains($user->email, 'admin') || $user->email === 'admin@coffeeshop.com';
    }
}