<?php

namespace app\api\controller;

use app\api\service\DeviceService;
use app\BaseController;
use think\App;
use think\Request;

class DeviceController extends BaseController
{
    private DeviceService $deviceService;

    public function __construct(App $app, DeviceService $deviceService)
    {
        parent::__construct($app);
        $this->deviceService = $deviceService;
    }

    public function getGroupList(Request $request)
    {
        try {
            return success($this->deviceService->getGroupList($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function getDeviceList(Request $request)
    {
        try {
            return success($this->deviceService->getDeviceList($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function getDevice(Request $request)
    {
        try {
            return success($this->deviceService->getDevice($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function getRelayList(Request $request)
    {
        try {
            return success($this->deviceService->getRelayList($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function setRelay(Request $request)
    {
        try {
            return success($this->deviceService->setRelay($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }
}
