<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::any('/getToken', 'index/getToken');

Route::group('device', function () {
    Route::any('/getGroupList', 'device/getGroupList');
    Route::any('/getDeviceList', 'device/getDeviceList');
    Route::any('/getDevice', 'device/getDevice');
    Route::any('/getRelayList', 'device/getRelayList');
    Route::any('/setRelay', 'device/setRelay');
})->middleware(\app\api\middleware\AuthMiddleware::class);

Route::group('data', function () {
    Route::any('/getRealTimeData', 'data/getRealTimeData');
    Route::any('/getRealTimeDataByDeviceAddr', 'data/getRealTimeDataByDeviceAddr');
    Route::any('/historyList', 'data/historyList');
    Route::any('/delHistory', 'data/delHistory');
    Route::any('/getRelayOptRecord', 'data/getRelayOptRecord');
    Route::any('/alarmRecordList', 'data/alarmRecordList');
})->middleware(\app\api\middleware\AuthMiddleware::class);
