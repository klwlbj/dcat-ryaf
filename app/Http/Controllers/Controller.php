<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param Request $request
     * @param array $rules
     * @return mixed
     * @throws Exception
     */
    public function validateParams(Request $request, array $rules)
    {
        $params = $request->input();
        // 创建验证器
        $validator = Validator::make($params, $rules);

        // 检查验证结果
        if ($validator->fails()) {
            // todo
            throw new Exception($validator->errors());
        }
        return $params;
    }
}
