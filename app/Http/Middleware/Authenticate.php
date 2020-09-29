<?php

namespace App\Http\Middleware;
use App\AnotherClasses\ResponseHandler;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards) === 'authentication_error') {
            return ResponseHandler::getJsonResponse(400, 'Требуется авторизация');
        }

        return $next($request);
    }
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        return 'authentication_error';
    }
}
