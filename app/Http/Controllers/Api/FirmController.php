<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class FirmController extends Controller
{
    /**
     * 获取企业列表
     * @param Request $request
     * @return JsonResponse
     */
    public function getEnterpriseList(Request $request)
    {
        $checkTypeId = $request->input('typeId');
        $key         = $request->input('key') ?? '';

        $query = Firm::query();
        $data  = $query->where('check_type', $checkTypeId)
            ->where(function ($query) use ($key) {
                if (!empty($key)) {
                    $query->where('name', 'like', '%' . $key . '%');
                }
            })
            ->select('custom_number as number', 'uuid', 'id', 'name as enterpriseName', 'address')
        ->get();

        return response()->json($data);
    }

    /**
     * 获取检查状态列表
     * @return JsonResponse
     */
    public function getCheckStatusList()
    {
        return response()->json($this->getCheckStatus());
    }

    /**
     * 私有方法，多次调用
     * @return array
     */
    private function getCheckStatus()
    {
        $statusList = Firm::$formatStatusMaps;
        $data       = [];
        foreach ($statusList as $key => $status) {
            $data[] = [
                'id'      => $key,
                'orderBy' => 0,
                'uuid'    => '',
                'name'    => $status,
            ];
        }
        return $data;
    }

    /**
     * 获取单个企业信息以及其它信息
     * @param Request $request
     * @return JsonResponse
     */
    public function getEnterprise(Request $request)
    {
        $uuid = $request->input('uuid');
        $firm = Firm::where('uuid', $uuid)
            ->select(
                'custom_number as number',
                'id',
                'uuid',
                'name as enterpriseName',
                'check_type as checkTypeID',
                'address',
                'area_quantity as businessArea',
                'status as checkStatusID',
                'floor as floorNum',
                'head_man as manager',
                'remark',
                'phone as phoneFull'
            )
            ->first();
        $firm->checkStatusName = Firm::$formatStatusMaps[$firm->checkStatusID];
        $firm->checkTypeName   = Firm::$formatCheckTypeMaps[$firm->checkTypeID];
        // $firm->stopCheck = 1;

        return response()->json([
            'enterprise' => $firm,
            'ctList'     => CheckStandardController::getCheckType(),
            'csList'     => $this->getCheckStatus(),
        ]);
    }

    /**
     * 保存企业信息
     * @param Request $request
     * @return JsonResponse
     */
    public function saveEnterprise(Request $request)
    {
        $uuid = $request->input('uuid', '');
        // $isCheck = $request->input('isCheck', false);

        // todo 参数验证

        $saveData = [
            'name'          => $request->input('enterpriseName'),
            'status'        => $request->input('checkStatusID'),
            'head_man'      => $request->input('manager'),
            'phone'         => $request->input('phone'),
            'floor'         => $request->input('floorNum'),
            'area_quantity' => $request->input('businessArea'),
            'address'       => $request->input('address'),
            'remark'        => $request->input('remark', '') ?? '',
        ];
        if (!empty($uuid)) {
            $save = Firm::where('uuid', $uuid)
                ->update($saveData);
        } else {
            $save = Firm::create($saveData);
        }

        if ($save) {
            $data = ['msg' => '保存成功！', 'status' => 200];
        } else {
            $data = ['msg' => '保存失败！', 'status' => 400];
        }
        return response()->json($data);
    }
}
