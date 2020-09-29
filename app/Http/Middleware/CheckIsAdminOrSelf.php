<?php

namespace App\Http\Middleware;

use App\AnotherClasses\ResponseHandler;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminOrSelf
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
        $requestedUserId = $request->route()->parameter('id');

        try {
            if (
                Auth::user()->role === 2 ||
                Auth::user()->id == $requestedUserId
            ) {
                return $next($request);
            }
            else {
                return ResponseHandler::getJsonResponse(400, 'Требуется авторизация');
            }
        }
        catch (\Exception $e) {
            return ResponseHandler::getJsonResponse(400, 'Требуется авторизация');
        }
    }
}
