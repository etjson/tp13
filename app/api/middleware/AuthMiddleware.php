<?php

namespace app\api\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\Request;

class AuthMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        $key = env('JWT_KEY');
        $jwt = $request->header('authorization', '');
        try {
            $decode = (array)JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $decode = [];
        }
        if (!($decode['userid'] ?? null) && !env('APP_DEBUG')) {
            return error('token err', 1004);
        }
        return $next($request);
    }
}