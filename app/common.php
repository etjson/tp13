<?php
// 应用公共文件

//1000接口执行成功，具体参考各个接口
//1001接口执行失败，具体参考各个接口，原因参考Message
//1002参数错误
//1003程序内部异常，异常信息参考Message
//1004鉴权失败

if (!function_exists('success')) {
    function success($data = null, $code = 1000, $msg = 'ok')
    {
        $data = jsonencode([
            'code' => $code,
            'data' => $data,
            'message' => $msg
        ]);
        $headers = [
            'Content-Type' => 'application/json',
        ];
        return response($data, 200, $headers);
    }
}

if (!function_exists('error')) {
    function error($msg = 'err', $code = 1003, $data = null)
    {
        $data = jsonencode([
            'code' => $code,
            'data' => $data,
            'msg' => $msg
        ]);
        $headers = [
            'Content-Type' => 'application/json',
        ];
        return response($data, 200, $headers);
    }
}

if (!function_exists('jsonencode')) {
    function jsonencode($data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
    }
}