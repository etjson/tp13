<?php

namespace app\api\service;

use Firebase\JWT\JWT;
use think\Request;

class IndedxService extends BaseService
{
    public function getToken(Request $request)
    {
        $loginName = $request->param('loginName');
        $password = $request->param('password', '');
        $userid = db('app_user')->where([
            'name' => $loginName,
            'pwd' => md5($password)
        ])->find();
        if (!$userid) {
            throw new \Exception('检查用户名和密码');
        }
        $key = env('JWT_KEY');
        $payload = [
            'userid' => $userid,
            'ctime' => time()
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return [
            'expiration' => time() + 3600 * 2,
            'token' => $jwt
        ];
    }
}