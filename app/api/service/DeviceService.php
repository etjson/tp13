<?php

namespace app\api\service;

use think\Request;

class DeviceService extends BaseService
{
    public function getGroupList(Request $request)
    {
        return [
            [
                'groupId' => null,
                'parentId' => null,
                'groupName' => null
            ]
        ];
    }

    public function getDeviceList(Request $request)
    {
        $groupId = $request->param('groupId');
        return [
            [
                'deviceAddr' => null,
                'groupId' => null,
                'deviceName' => null,
                'offlineinterval' => null,
                'savedatainterval' => null,
                'alarmSwitch' => null,
                'alarmRecord' => null,
                'lng' => null,
                'lat' => null,
                'useMarkLocation' => null,
                'sort' => null,
                'deviceCode' => null,
                'factors' => [
                    [
                        'factorId' => null,
                        'deviceAddr' => null,
                        'nodeId' => null,
                        'registerId' => null,
                        'factorName' => null,
                        'factorIcon' => null,
                        'coefficient' => null,
                        'offset' => null,
                        'alarmDelay' => null,
                        'alarmRate' => null,
                        'backToNormalDelay' => null,
                        'digits' => null,
                        'unit' => null,
                        'enabled' => null,
                        'sort' => null,
                        'maxVoiceAlarmTimes' => null,
                        'maxSmsAlarmTimes' => null
                    ]
                ]
            ]
        ];
    }

    public function getDevice(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        return [
            'deviceAddr' => null,
            'groupId' => null,
            'deviceName' => null,
            'offlineinterval' => null,
            'savedatainterval' => null,
            'alarmSwitch' => null,
            'alarmRecord' => null,
            'lng' => null,
            'lat' => null,
            'useMarkLocation' => null,
            'sort' => null,
            'deviceCode' => null,
            'factors' => [
                [
                    'factorId' => null,
                    'deviceAddr' => null,
                    'nodeId' => null,
                    'registerId' => null,
                    'factorName' => null,
                    'factorIcon' => null,
                    'coefficient' => null,
                    'offset' => null,
                    'alarmDelay' => null,
                    'alarmRate' => null,
                    'backToNormalDelay' => null,
                    'digits' => null,
                    'unit' => null,
                    'enabled' => null,
                    'sort' => null,
                    'maxVoiceAlarmTimes' => null,
                    'maxSmsAlarmTimes' => null
                ]
            ]
        ];
    }

    public function getRelayList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        return [
            [
                'deviceAddr' => null,
                'deviceName' => null,
                'enabled' => null,
                'relayName' => null,
                'relayNo' => null,
                'relayStatus' => null
            ]
        ];
    }

    public function setRelay(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $opt = $request->param('opt');
        $relayNo = $request->param('relayNo');
        return true;
    }
}

