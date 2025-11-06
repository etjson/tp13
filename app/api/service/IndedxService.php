<?php

namespace app\api\service;

use think\Request;

class IndedxService
{
    public function getToken(Request $request)
    {
        $loginName = $request->param('loginName');
        $password = $request->param('password');
        return [
            'expiration' => null,
            'token' => null
        ];
    }
}