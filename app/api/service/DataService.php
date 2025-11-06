<?php

namespace app\api\service;

use think\Request;

class DataService extends BaseService
{
    public function getRealTimeData(Request $request)
    {
        $groupId = $request->param('groupId');
        return [
            [
                'systemCode' => null,
                'deviceAddr' => null,
                'deviceName' => null,
                'lat' => null,
                'lng' => null,
                'deviceStatus' => null,
                'relayStatus' => null,
                'dataItem' => [
                    [
                        'nodeId' => null,
                        'registerItem' => [
                            [
                                'registerId' => null,
                                'registerName' => null,
                                'data' => null,
                                'value' => null,
                                'alarmLevel' => null,
                                'alarmColor' => null,
                                'alarmInfo' => null,
                                'unit' => null
                            ]
                        ]
                    ]
                ],
                'timeStamp' => null
            ]
        ];
    }

    public function getRealTimeDataByDeviceAddr(Request $request)
    {
        $deviceAddrs = $request->param('deviceAddrs');
        return [
            [
                'systemCode' => null,
                'deviceAddr' => null,
                'deviceName' => null,
                'lat' => null,
                'lng' => null,
                'deviceStatus' => null,
                'relayStatus' => null,
                'dataItem' => [
                    [
                        'nodeId' => null,
                        'registerItem' => [
                            [
                                'registerId' => null,
                                'registerName' => null,
                                'data' => null,
                                'value' => null,
                                'alarmLevel' => null,
                                'alarmColor' => null,
                                'alarmInfo' => null,
                                'unit' => null
                            ]
                        ]
                    ]
                ],
                'timeStamp' => null
            ]
        ];
    }

    public function historyList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $nodeId = $request->param('nodeId');
        $startTime = $request->param('startTime');
        $endTime = $request->param('endTime');
        return [
            [
                'deviceAddr' => null,
                'nodeId' => null,
                'data' => [
                    [
                        'registerId' => null,
                        'registerName' => null,
                        'value' => null,
                        'text' => null,
                        'alarmLevel' => null
                    ]
                ],
                'lat' => null,
                'lng' => null,
                'recordTime' => null,
                'recordId' => null,
                'recordTimeStr' => null
            ]
        ];
    }

    public function delHistory(Request $request)
    {
        $id = $request->param('id');
        return true;
    }

    public function getRelayOptRecord(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $beginTime = $request->param('beginTime');
        $endTime = $request->param('endTime');
        return [
            [
                'recordId' => null,
                'deviceAdd' => null,
                'relayNo' => null,
                'relayName' => null,
                'createTime' => null,
                'opt' => null,
                'optUserId' => null,
                'optLoginName' => null
            ]
        ];
    }

    public function alarmRecordList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $nodeId = $request->param('nodeId');
        $startTime = $request->param('startTime');
        $endTime = $request->param('endTime');
        return [
            [
                'deviceAddr' => null,
                'nodeId' => null,
                'factorId' => null,
                'factorName' => null,
                'alarmLevel' => null,
                'dataValue' => null,
                'dataText' => null,
                'alarmRange' => null,
                'lat' => null,
                'lng' => null,
                'recordTime' => null,
                'handled' => null,
                'handleMsg' => null,
                'handleUser' => null,
                'handleTime' => null,
                'recordId' => null
            ]
        ];
    }
}

