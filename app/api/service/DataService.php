<?php

namespace app\api\service;

use think\facade\Db;
use think\Request;

class DataService extends BaseService
{
    public function getRealTimeData(Request $request)
    {
        $groupId = $request->param('groupId', '');

        $query = db('app_device');
        if (!empty($groupId)) {
            $query->where('group_id', $groupId);
        }
        $deviceAddrs = $query->column('device_addr');

        if (empty($deviceAddrs)) {
            return [];
        }

        $realtimeDataList = [];
        foreach ($deviceAddrs as $deviceAddr) {
            $realtime = db('app_realtime_data')
                ->where('device_addr', $deviceAddr)
                ->field([
                    'system_code' => 'systemCode',
                    'device_addr' => 'deviceAddr',
                    'device_name' => 'deviceName',
                    'lat' => 'lat',
                    'lng' => 'lng',
                    'device_status' => 'deviceStatus',
                    'relay_status' => 'relayStatus',
                    'time_stamp' => 'timeStamp'
                ])
                ->order('time_stamp', 'desc')
                ->find();
            if ($realtime) {
                $realtimeDataList[] = $realtime;
            }
        }

        $result = [];
        foreach ($realtimeDataList as $realtime) {
            $deviceAddr = $realtime['deviceAddr'];
            $timeStamp = $realtime['timeStamp'];

            $items = db('app_realtime_data_item')
                ->where('device_addr', $deviceAddr)
                ->where('time_stamp', $timeStamp)
                ->field([
                    'node_id' => 'nodeId',
                    'register_id' => 'registerId',
                    'register_name' => 'registerName',
                    'data' => 'data',
                    'value' => 'value',
                    'alarm_level' => 'alarmLevel',
                    'alarm_color' => 'alarmColor',
                    'alarm_info' => 'alarmInfo',
                    'unit' => 'unit'
                ])
                ->order('node_id', 'asc')
                ->order('register_id', 'asc')
                ->select();

            $dataItem = [];
            $nodeMap = [];
            foreach ($items as $item) {
                $nodeId = $item['nodeId'];
                if (!isset($nodeMap[$nodeId])) {
                    $nodeMap[$nodeId] = [
                        'nodeId' => $nodeId,
                        'registerItem' => []
                    ];
                }
                unset($item['nodeId']);
                $nodeMap[$nodeId]['registerItem'][] = $item;
            }
            $realtime['dataItem'] = array_values($nodeMap);
            $result[] = $realtime;
        }

        return $result;
    }

    public function getRealTimeDataByDeviceAddr(Request $request)
    {
        $deviceAddrsStr = $request->param('deviceAddrs', '');
        if (empty($deviceAddrsStr)) {
            return [];
        }

        $deviceAddrs = explode(',', $deviceAddrsStr);
        $deviceAddrs = array_map('trim', $deviceAddrs);
        $deviceAddrs = array_filter($deviceAddrs);

        if (empty($deviceAddrs)) {
            return [];
        }

        $realtimeDataList = [];
        foreach ($deviceAddrs as $deviceAddr) {
            $realtime = db('app_realtime_data')
                ->where('device_addr', $deviceAddr)
                ->field([
                    'system_code' => 'systemCode',
                    'device_addr' => 'deviceAddr',
                    'device_name' => 'deviceName',
                    'lat' => 'lat',
                    'lng' => 'lng',
                    'device_status' => 'deviceStatus',
                    'relay_status' => 'relayStatus',
                    'time_stamp' => 'timeStamp'
                ])
                ->order('time_stamp', 'desc')
                ->find();
            if ($realtime) {
                $realtimeDataList[] = $realtime;
            }
        }

        $result = [];
        foreach ($realtimeDataList as $realtime) {
            $deviceAddr = $realtime['deviceAddr'];
            $timeStamp = $realtime['timeStamp'];

            $items = db('app_realtime_data_item')
                ->where('device_addr', $deviceAddr)
                ->where('time_stamp', $timeStamp)
                ->field([
                    'node_id' => 'nodeId',
                    'register_id' => 'registerId',
                    'register_name' => 'registerName',
                    'data' => 'data',
                    'value' => 'value',
                    'alarm_level' => 'alarmLevel',
                    'alarm_color' => 'alarmColor',
                    'alarm_info' => 'alarmInfo',
                    'unit' => 'unit'
                ])
                ->order('node_id', 'asc')
                ->order('register_id', 'asc')
                ->select();

            $dataItem = [];
            $nodeMap = [];
            foreach ($items as $item) {
                $nodeId = $item['nodeId'];
                if (!isset($nodeMap[$nodeId])) {
                    $nodeMap[$nodeId] = [
                        'nodeId' => $nodeId,
                        'registerItem' => []
                    ];
                }
                unset($item['nodeId']);
                $nodeMap[$nodeId]['registerItem'][] = $item;
            }
            $realtime['dataItem'] = array_values($nodeMap);
            $result[] = $realtime;
        }

        return $result;
    }

    public function historyList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $nodeId = $request->param('nodeId', -1);
        $startTime = $request->param('startTime');
        $endTime = $request->param('endTime');

        if (empty($deviceAddr) || empty($startTime) || empty($endTime)) {
            throw new \Exception('参数不完整');
        }

        $startTimestamp = strtotime($startTime) * 1000;
        $endTimestamp = strtotime($endTime) * 1000;

        $query = db('app_history_record')
            ->where('device_addr', $deviceAddr)
            ->where('record_time', '>=', $startTimestamp)
            ->where('record_time', '<', $endTimestamp);

        if ($nodeId != -1) {
            $query->where('node_id', $nodeId);
        }

        $records = $query->field([
            'record_id' => 'recordId',
            'device_addr' => 'deviceAddr',
            'node_id' => 'nodeId',
            'lat' => 'lat',
            'lng' => 'lng',
            'record_time' => 'recordTime',
            'record_time_str' => 'recordTimeStr'
        ])
            ->order('record_time', 'desc')
            ->select();

        $result = [];
        foreach ($records as $record) {
            $recordId = $record['recordId'];
            $dataItems = db('app_history_record_data')
                ->where('record_id', $recordId)
                ->field([
                    'register_id' => 'registerId',
                    'register_name' => 'registerName',
                    'value' => 'value',
                    'text' => 'text',
                    'alarm_level' => 'alarmLevel'
                ])
                ->order('register_id', 'asc')
                ->select();

            $record['data'] = $dataItems ?: [];
            $result[] = $record;
        }

        return $result;
    }

    public function delHistory(Request $request)
    {
        $id = $request->param('id');
        if (empty($id)) {
            throw new \Exception('参数错误');
        }

        $record = db('app_history_record')->where('record_id', $id)->find();
        if (!$record) {
            throw new \Exception('历史记录不存在');
        }

        Db::startTrans();
        try {
            db('app_history_record_data')->where('record_id', $id)->delete();
            db('app_history_record')->where('record_id', $id)->delete();
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    public function getRelayOptRecord(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $beginTime = $request->param('beginTime');
        $endTime = $request->param('endTime');

        if (empty($deviceAddr) || empty($beginTime) || empty($endTime)) {
            throw new \Exception('参数不完整');
        }

        $records = db('app_relay_opt_record')
            ->where('device_addr', $deviceAddr)
            ->where('create_time', '>=', $beginTime)
            ->where('create_time', '<=', $endTime)
            ->field([
                'record_id' => 'recordId',
                'device_addr' => 'deviceAdd',
                'relay_no' => 'relayNo',
                'relay_name' => 'relayName',
                'create_time' => 'createTime',
                'opt' => 'opt',
                'opt_user_id' => 'optUserId',
                'opt_login_name' => 'optLoginName'
            ])
            ->order('create_time', 'desc')
            ->select();

        return $records ?: [];
    }

    public function alarmRecordList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $nodeId = $request->param('nodeId', -1);
        $startTime = $request->param('startTime');
        $endTime = $request->param('endTime');

        if (empty($deviceAddr) || empty($startTime) || empty($endTime)) {
            throw new \Exception('参数不完整');
        }

        $startTimestamp = strtotime($startTime) * 1000;
        $endTimestamp = strtotime($endTime) * 1000;

        $query = db('app_alarm_record')
            ->where('device_addr', $deviceAddr)
            ->where('record_time', '>=', $startTimestamp)
            ->where('record_time', '<', $endTimestamp);

        if ($nodeId != -1) {
            $query->where('node_id', $nodeId);
        }

        $records = $query->field([
            'record_id' => 'recordId',
            'device_addr' => 'deviceAddr',
            'node_id' => 'nodeId',
            'factor_id' => 'factorId',
            'factor_name' => 'factorName',
            'alarm_level' => 'alarmLevel',
            'data_value' => 'dataValue',
            'data_text' => 'dataText',
            'alarm_range' => 'alarmRange',
            'lat' => 'lat',
            'lng' => 'lng',
            'record_time' => 'recordTime',
            'handled' => 'handled',
            'handle_msg' => 'handleMsg',
            'handle_user' => 'handleUser',
            'handle_time' => 'handleTime'
        ])
            ->order('record_time', 'desc')
            ->select();

        return $records ?: [];
    }
}

