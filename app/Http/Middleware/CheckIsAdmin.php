<?php

namespace App\Http\Middleware;

use App\AnotherClasses\ResponseHandler;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (Auth::user()->role === 2) {
                return $next($request);
            } else {
                return ResponseHandler::getJsonResponse(400, 'Недостаточно прав для просмотра');
            }
        }
        catch (\Exception $e) {
            return ResponseHandler::getJsonResponse(400, 'Требуется авторизация');
        }
    }
}
