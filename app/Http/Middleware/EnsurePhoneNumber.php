<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePhoneNumber
{
    /**
     * Redirect members with an empty phone number to complete their profile.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->needsPhoneNumber() && ! $request->routeIs('phone.complete', 'phone.complete.store', 'logout')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Phone number is required'], 403);
            }

            return redirect()->route('phone.complete');
        }

        return $next($request);
    }
}
