<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CheckTokenVersion
{
    public function handle(Request $request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate(); // <- обязательно через JWTAuth
        $payload = JWTAuth::parseToken()->getPayload();

        if ($payload->get('token_version') !== $user->token_version) {
            throw new UnauthorizedHttpException('jwt-auth', 'Token revoked');
        }

        return $next($request);
    }
}

