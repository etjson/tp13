<?php

namespace app\api\service;

use think\Request;

class DeviceService extends BaseService
{
    public function getGroupList(Request $request)
    {
        return db('app_device_group')->field([
            'group_id' => 'groupId',
            'parent_id' => 'parentId',
            'group_name' => 'groupName'
        ])->order('id', 'desc')->select();
    }

    public function getDeviceList(Request $request)
    {
        $groupId = $request->param('groupId', '');
        $query = db('app_device');
        if (!empty($groupId)) {
            $query->where('group_id', $groupId);
        }
        $devices = $query->field([
            'device_addr' => 'deviceAddr',
            'group_id' => 'groupId',
            'device_name' => 'deviceName',
            'offline_interval' => 'offlineinterval',
            'save_data_interval' => 'savedatainterval',
            'alarm_switch' => 'alarmSwitch',
            'alarm_record' => 'alarmRecord',
            'lng' => 'lng',
            'lat' => 'lat',
            'use_mark_location' => 'useMarkLocation',
            'sort' => 'sort',
            'device_code' => 'deviceCode'
        ])->order('sort', 'desc')->select();

        $result = [];
        foreach ($devices as $device) {
            $deviceAddr = $device['deviceAddr'];
            $factors = db('app_device_factor')->where('device_addr', $deviceAddr)
                ->field([
                    'factor_id' => 'factorId',
                    'device_addr' => 'deviceAddr',
                    'node_id' => 'nodeId',
                    'register_id' => 'registerId',
                    'factor_name' => 'factorName',
                    'factor_icon' => 'factorIcon',
                    'coefficient' => 'coefficient',
                    'offset' => 'offset',
                    'alarm_delay' => 'alarmDelay',
                    'alarm_rate' => 'alarmRate',
                    'back_to_normal_delay' => 'backToNormalDelay',
                    'digits' => 'digits',
                    'unit' => 'unit',
                    'enabled' => 'enabled',
                    'sort' => 'sort',
                    'max_voice_alarm_times' => 'maxVoiceAlarmTimes',
                    'max_sms_alarm_times' => 'maxSmsAlarmTimes'
                ])->order('sort', 'desc')->select();
            $device['factors'] = $factors ?: [];
            $result[] = $device;
        }
        return $result;
    }

    public function getDevice(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $device = db('app_device')->where('device_addr', $deviceAddr)
            ->field([
                'device_addr' => 'deviceAddr',
                'group_id' => 'groupId',
                'device_name' => 'deviceName',
                'offline_interval' => 'offlineinterval',
                'save_data_interval' => 'savedatainterval',
                'alarm_switch' => 'alarmSwitch',
                'alarm_record' => 'alarmRecord',
                'lng' => 'lng',
                'lat' => 'lat',
                'use_mark_location' => 'useMarkLocation',
                'sort' => 'sort',
                'device_code' => 'deviceCode'
            ])->find();

        if (!$device) {
            throw new \Exception('设备不存在');
        }

        $factors = db('app_device_factor')->where('device_addr', $deviceAddr)
            ->field([
                'factor_id' => 'factorId',
                'device_addr' => 'deviceAddr',
                'node_id' => 'nodeId',
                'register_id' => 'registerId',
                'factor_name' => 'factorName',
                'factor_icon' => 'factorIcon',
                'coefficient' => 'coefficient',
                'offset' => 'offset',
                'alarm_delay' => 'alarmDelay',
                'alarm_rate' => 'alarmRate',
                'back_to_normal_delay' => 'backToNormalDelay',
                'digits' => 'digits',
                'unit' => 'unit',
                'enabled' => 'enabled',
                'sort' => 'sort',
                'max_voice_alarm_times' => 'maxVoiceAlarmTimes',
                'max_sms_alarm_times' => 'maxSmsAlarmTimes'
            ])->order('sort', 'desc')->select();

        $device['factors'] = $factors ?: [];
        return $device;
    }

    public function getRelayList(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $device = db('app_device')->where('device_addr', $deviceAddr)->find();
        if (!$device) {
            throw new \Exception('设备不存在');
        }

        $relays = db('app_device_relay')->where('device_addr', $deviceAddr)
            ->field([
                'device_addr' => 'deviceAddr',
                'relay_no' => 'relayNo',
                'relay_name' => 'relayName',
                'enabled' => 'enabled',
                'relay_status' => 'relayStatus'
            ])->order('relay_no', 'asc')->select();

        $result = [];
        foreach ($relays as $relay) {
            $relay['deviceName'] = $device['device_name'];
            $result[] = $relay;
        }
        return $result;
    }

    public function setRelay(Request $request)
    {
        $deviceAddr = $request->param('deviceAddr');
        $opt = $request->param('opt');
        $relayNo = $request->param('relayNo');

        $relay = db('app_device_relay')->where([
            'device_addr' => $deviceAddr,
            'relay_no' => $relayNo
        ])->find();

        if (!$relay) {
            throw new \Exception('继电器不存在');
        }

        $userId = $this->userid();
        $user = db('app_user')->where('id', $userId)->find();

        $recordId = uniqid('relay_', true);
        $createTime = time() * 1000;

        db('app_relay_opt_record')->insert([
            'record_id' => $recordId,
            'device_addr' => $deviceAddr,
            'relay_no' => $relayNo,
            'relay_name' => $relay['relay_name'],
            'opt' => $opt,
            'opt_user_id' => $userId ? (string)$userId : null,
            'opt_login_name' => $user['name'] ?? null,
            'create_time' => $createTime
        ]);

        return true;
    }
}
