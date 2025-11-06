<?php

namespace app\api\service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class BaseService
{
    public function userid()
    {
        $request = request();
        $key = env('JWT_KEY');
        $jwt = $request->header('token', '');
        try {
            $decode = (array)JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $decode = [];
        }
        if ($decode['userid'] ?? null) {
            return $decode['userid'];
        }
        return 1;
    }
}
