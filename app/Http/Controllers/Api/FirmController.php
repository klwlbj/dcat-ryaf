<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\Community;
use App\Models\SystemItem;
use Illuminate\Support\Str;
use App\Logic\Api\CheckItem;
use App\Logic\Api\FirmLogic;
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
        $rules = [
            'typeId' => 'required|numeric',
        ];

        $input       = $this->validateParams($request, $rules);
        $checkTypeId = $input['typeId'];
        $key         = $input['key'] ?? '';

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
        return response()->json((new FirmLogic())->getCheckStatusList());
    }

    /**
     * 获取单个企业信息以及其它信息
     * @param Request $request
     * @return JsonResponse
     */
    public function getEnterprise(Request $request)
    {
        $rules = [
            'uuid' => ['required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],
        ];

        $input = $this->validateParams($request, $rules);
        $uuid  = $input['uuid'];
        $firm  = Firm::where('uuid', $uuid)
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

        if (in_array($firm->checkStatusID, [Firm::STATUS_WAIT, Firm::STATUS_CHECKED, Firm::STATUS_REVIEWED])) {
            $firm->stopCheck = 0;
        }

        return response()->json([
            'enterprise' => $firm,
            'ctList'     => (new CheckItem())::getCheckTypeList(),
            'csList'     => (new FirmLogic())->getCheckStatusList(),
            'coList'     => (new FirmLogic())->getCommunityList(),
        ]);
    }

    /**
     * 保存企业信息
     * @param Request $request
     * @return JsonResponse
     */
    public function saveEnterprise(Request $request)
    {
        $rules = [
            'uuid'           => ['nullable', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],
            'community'      => 'required',
            'enterpriseName' => 'required',
            'checkStatusID'  => 'required|integer',
            'manager'        => 'required',
            'checkResult'    => 'nullable|integer',
            'phone'          => 'required|integer|digits_between:1,30',
            'floorNum'       => 'required|integer',
            'businessArea'   => 'required|integer',
            'address'        => 'required',
            'remark'         => 'nullable|string',
            'checkTypeID'    => 'nullable|integer',
            '',
        ];

        $input = $this->validateParams($request, $rules);

        $uuid = $input['uuid'] ?? '';
        $systemItemId = app('system_item_id') ?? 0;
        $community = $input['community'];

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
            'name'           => $input['enterpriseName'],
            'status'         => $input['checkStatusID'],
            'head_man'       => $input['manager'],
            'check_result'   => $input['checkResult'] ?? Firm::CHECK_RESULT_DEFAULT,
            'phone'          => $input['phone'],
            'floor'          => $input['floorNum'] ?? 0,
            'area_quantity'  => $input['businessArea'] ?? 0,
            'address'        => $input['address'],
            'remark'         => $input['remark'] ?? '',
            'system_item_id' => $systemItemId,
            'community'      => $communityId,
        ];
        if (!empty($uuid)) {
            $save = Firm::where('uuid', $uuid)
                ->update($saveData);
        } else {
            $saveData['check_type']    = $input['checkTypeID'];
            $saveData['custom_number'] = Str::random(4) . time(); // 随机编号
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
        return response()->json((new FirmLogic())->getCommunityList());
    }
}
