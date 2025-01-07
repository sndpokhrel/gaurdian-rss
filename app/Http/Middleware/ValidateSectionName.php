<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSectionName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $section = $request->route('section');

        if (!preg_match('/^[a-z-]+$/', $section)) {
            return response()->json([
                'error' => 'Invalid section name'
            ], 400);
        }
        return $next($request);
    }
}
