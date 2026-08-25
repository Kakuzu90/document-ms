<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Only update if it's been more than 1 minute since last update
            // to avoid unnecessary DB writes on every request.
            if ($user->last_seen_at === null || $user->last_seen_at->diffInMinutes(now()) >= 1) {
                // Use DB statement to avoid triggering model events/updated_at
                // if we just want to update last_seen_at.
                // But update() is fine here since it tracks activity.
                $user->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
