<?php

namespace app\api\controller;

use app\api\service\IndedxService;
use app\BaseController;
use think\App;
use think\Request;

class IndexController extends BaseController
{
    private IndedxService $indedxService;

    public function __construct(App $app, IndedxService $indedxService)
    {
        parent::__construct($app);
        $this->indedxService = $indedxService;
    }

    public function getToken(Request $request)
    {
        try {
            return success($this->indedxService->getToken($request));
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
    }
}
