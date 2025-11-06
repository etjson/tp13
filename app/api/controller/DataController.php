<?php

namespace app\api\controller;

use app\api\service\DataService;
use app\BaseController;
use think\App;
use think\Request;

class DataController extends BaseController
{
    private DataService $dataService;

    public function __construct(App $app, DataService $dataService)
    {
        parent::__construct($app);
        $this->dataService = $dataService;
    }

    public function getRealTimeData(Request $request)
    {
        try {
            return success($this->dataService->getRealTimeData($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function getRealTimeDataByDeviceAddr(Request $request)
    {
        try {
            return success($this->dataService->getRealTimeDataByDeviceAddr($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function historyList(Request $request)
    {
        try {
            return success($this->dataService->historyList($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function delHistory(Request $request)
    {
        try {
            return success($this->dataService->delHistory($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function getRelayOptRecord(Request $request)
    {
        try {
            return success($this->dataService->getRelayOptRecord($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }

    public function alarmRecordList(Request $request)
    {
        try {
            return success($this->dataService->alarmRecordList($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }
}
