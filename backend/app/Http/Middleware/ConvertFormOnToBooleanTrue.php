<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertFormOnToBooleanTrue {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        collect($request->all())->each(function ($value, $key) use ($request) {
            if ($value === "on") {
                $request->merge([$key => true]);
            }
        });
        return $next($request);
    }
}
