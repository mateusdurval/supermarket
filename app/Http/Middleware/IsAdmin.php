<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

/**
 * Middleware responsável por desviar bots para outro servidor
 */
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illumiate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAdmin = auth()->user()->isAdmin;
        if (!$isAdmin) {
            abort(401);
        }

        return $next($request);
    }
}