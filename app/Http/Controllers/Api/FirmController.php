<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\Community;
use App\Models\SystemItem;
use Illuminate\Support\Str;
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
                'phone as phoneFull',
                'community',
                'check_result as checkResult',
            )
            ->first();
        $firm->checkStatusName = Firm::$formatStatusMaps[$firm->checkStatusID];
        $firm->checkTypeName   = Firm::$formatCheckTypeMaps[$firm->checkTypeID];
        $firm->stopCheck       = 1;
        $firm->community       = Community::where('id', $firm->community)->value('name');
        // $firm->checkResult     = Firm::$formatCheckResultMaps[$firm->check_result];
        if (in_array($firm->checkStatusID, [Firm::STATUS_WAIT, Firm::STATUS_CHECKED, Firm::STATUS_REVIEWED])) {
            $firm->stopCheck = 0;
        }

        return response()->json([
            'enterprise' => $firm,
            'ctList'     => CheckStandardController::getCheckType(),
            'csList'     => $this->getCheckStatus(),
            'coList'     => $this->getCommunity(),
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

        $systemItemId = app('system_item_id') ?? 0;

        // todo 参数验证
        $community = $request->input('community', '');

        // 查询 name 是否存在
        $record = Community::where('name', $community)
            ->where('system_item_id', $systemItemId)
            ->first();
        if ($record) {
            $communityId = $record->id;
        } else {
            // 查询社区表中是否存在，不存在则插入
            $newRecord                 = new Community();
            $newRecord->name           = $community;
            $newRecord->system_item_id = $systemItemId;
            $newRecord->save();

            $communityId = $newRecord->id;
        }

        $saveData = [
            'name'           => $request->input('enterpriseName'),
            'status'         => $request->input('checkStatusID'),
            'head_man'       => $request->input('manager'),
            'check_result'   => $request->input('checkResult'),
            'phone'          => $request->input('phone'),
            'floor'          => $request->input('floorNum') ?? 0,
            'area_quantity'  => $request->input('businessArea') ?? 0,
            'address'        => $request->input('address'),
            'remark'         => $request->input('remark', '') ?? '',
            'system_item_id' => $systemItemId,
            'community'      => $communityId,
        ];
        if (!empty($uuid)) {
            $save = Firm::where('uuid', $uuid)
                ->update($saveData);
        } else {
            $saveData['check_type']    = $request->input('checkTypeID');
            $saveData['custom_number'] = Str::random(4) . time();
            $save                      = Firm::create($saveData);
        }

        if ($save) {
            $data = ['msg' => '保存成功！', 'status' => 200];
        } else {
            $data = ['msg' => '保存失败！', 'status' => 400];
        }
        return response()->json($data);
    }

    public function getProjectList()
    {
        $data = SystemItem::select('name', 'id')->get();
        return response()->json($data);
    }

    public function getCommunityList()
    {
        return response()->json($this->getCommunity());
    }

    public function getCommunity()
    {
        $systemItemId = app('system_item_id') ?? '';
        return Community::where('system_item_id', $systemItemId)->pluck('name');
    }
}
