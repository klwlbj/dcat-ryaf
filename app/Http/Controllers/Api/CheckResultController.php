<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\User;
use App\Models\CheckItem;
use App\Models\CheckResult;
use Illuminate\Support\Str;
use App\Models\CollectImage;
use Illuminate\Http\Request;
use App\Models\CheckQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckResultController extends Controller
{
    /**
     * 获取上次的检查明细
     * @param Request $request
     * @return JsonResponse
     */
    public function getCheckDetailList(Request $request)
    {
        $uuid              = $request->input('uuid');
        $reportCode        = $request->input('reportCode');
        $checkQuestionList = CheckQuestion::where('check_result_uuid', $reportCode)
            ->where('firm_id', $uuid)
            ->get();

        $data = [];
        foreach ($checkQuestionList as $checkQuestion) {
            $data[] = [
                'enterpriseUuid' => $uuid,
                'isPass'         => 0,
                'parentIdType3'  => (int) $checkQuestion->check_standard_id,
                'parentIdType4'  => (int) $checkQuestion->check_question_id,
                'question'       => $checkQuestion->question,
                'rectify'        => $checkQuestion->recitify ?? '',
                'zgnd'           => CheckQuestion::$formatDifficultyMaps[$checkQuestion->difficulty],
            ];
        }
        return response()->json($data);
    }

    /**
     * 获取本次检查的基础信息
     * @param Request $request
     * @return JsonResponse
     */
    public function getCheckBaseInfo(Request $request)
    {
        $rules = [
            'uuid' => ['required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],
        ];

        $input = $this->validateParams($request, $rules);

        $uuid = $input['uuid'];
        $firm = Firm::select(['id', 'name', 'check_type'])
            ->where('uuid', $uuid)
            ->first();

        if (!$firm) {
            return response()->json(['status' => 400]);
        }

        return response()->json([
            "cDate"       => date('Y-m-d H:i:s'),
            "cUser"       => Auth::user()->name,
            "checkTypeID" => $firm->check_type,
            "name"        => $firm->name,
            "ctName"      => CheckItem::$formatCheckTypeMaps[$firm->check_type] ?? '空',
        ]);
    }

    /**
     * 保存检查结果
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function saveCheckResult(Request $request)
    {
        $rules = [
            'uuid'       => ['required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],
            'reportCode' => 'required',
        ];

        $input = $this->validateParams($request, $rules);

        // todo check $list
        $list                  = $request->post();
        $uuid                  = $input['uuid'];
        $reportCode            = $input['reportCode'];
        $saveCheckQuestionList = $deleteCheckQuestionIds = [];

        $new = false;
        if ($reportCode === 'new') {
            // 从数据库中，查找最新的检查中的记录的report_code
            $reportCode = CheckResult::where('firm_id', $uuid)
                ->where('status', CheckResult::STATUS_UNSAVED)
                ->value('report_code');
            if (empty($reportCode)) {
                // 生成新uuid
                $reportCode = (string) Str::uuid();
                $new        = true;
            }

            // 更新图片的report_code
            CollectImage::where('firm_id', $uuid)
                ->where('report_code', 'new')
                ->update(['report_code' => $reportCode]);
        }

        $difficulty = array_flip(CheckQuestion::$formatDifficultyMaps);

        foreach ($list as $checkQuestion) {
            if (!$checkQuestion['isPass']) {
                $saveCheckQuestionList[] = [
                    'check_result_uuid' => $reportCode,
                    'question'          => $checkQuestion['question'] ?? '',
                    'rectify'           => $checkQuestion['rectify'] ?? '',
                    'firm_id'           => $uuid,
                    'difficulty'        => $difficulty[$checkQuestion['zgnd']] ?? CheckQuestion::DIFFICULTY_EASY,
                    'check_standard_id' => $checkQuestion['parentIdType3'],
                    'check_question_id' => $checkQuestion['parentIdType4'],
                ];
            } else {
                $deleteCheckQuestionIds[] = $checkQuestion['parentIdType4'];
            }
        }
        DB::transaction(function () use ($new, $reportCode, $uuid, $saveCheckQuestionList, $deleteCheckQuestionIds) {
            if ($new) {
                CheckResult::create([
                    'report_code'   => $reportCode,
                    'status'        => CheckResult::STATUS_UNSAVED,
                    'firm_id'       => $uuid,
                    'check_user_id' => Auth::user()->id,
                ]);
            } else {
                CheckQuestion::where('check_result_uuid', $reportCode)
                    ->where('firm_id', $uuid)
                    ->delete();

                // 清除旧的图片
                $deleteCollectImages = CollectImage::where('report_code', $reportCode)
                    ->where('firm_id', $uuid)
                    ->whereIn('check_question_id', $deleteCheckQuestionIds)
                    ->get();

                // 遍历并逐个删除
                foreach ($deleteCollectImages as $img) {
                    // 删除文件夹中的图片
                    $img->delete();
                    // 未复用则删除图片
                    (new \App\Logic\Api\CollectImage())->deleteFileIfNotUsed($img, $reportCode);
                }
            }
            CheckQuestion::insert($saveCheckQuestionList);
        });

        return response()->json([
            "status" => 200,
            'msg'    => '保存成功',
        ]);
    }

    /**
     * 最终生成检查报告
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function createReport(Request $request)
    {
        $rules = [
            'enterpriseUuid' => ['required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],

            'rectifyNum'     => 'required|integer',
            'getScore'       => 'required|integer',
            'loseScore'      => 'required|integer',
        ];
        $input = $this->validateParams($request, $rules);

        DB::transaction(function () use ($input) {
            $uuid       = $input['enterpriseUuid'];
            $checkType  = Firm::where('uuid', $uuid)->value('check_type');
            $rectifyNum = $input['rectifyNum'];
            // 计算该单位最新的检查记录的得分
            $checkResult = CheckResult::where('firm_id', $uuid)
                ->where('status', CheckResult::STATUS_UNSAVED)
                ->orderBy('id', 'desc')
                ->first();
            // 保存检查类型到字段里
            $checkItems = CheckItem::where('check_type', $checkType)
                ->whereIn('type', [1, 2, 3])
                ->select(['id', 'title', 'total_score', 'type', 'parent_id'])
                ->get();

            //获取出父id的父id
            (new \App\Logic\Api\CheckResult())->addParentParentIdToChildren($checkItems);
            // 过滤
            $filteredCollection = $checkItems->filter(function ($item) {
                return $item['type'] === 1 || $item['type'] === 3;
            });
            $checkResult->status = $rectifyNum ? CheckResult::STATUS_BAD : CheckResult::STATUS_NORMAL;// 合格or不合格
            // 前端计算分数
            $checkResult->total_point     = $input['getScore'];
            $checkResult->deduction_point = $input['loseScore'];
            $checkResult->rectify_number  = $rectifyNum;

            $checkResult->check_user_id = Auth::user()->id;

            // 检查项目=>检查标准
            $checkResult->history_check_item = $filteredCollection->toJson();
            $checkResult->save();

            $firm = Firm::where('uuid', $uuid)->first();

            $firm->status       = Firm::STATUS_CHECKED; // todo 已复查
            $firm->check_result = $rectifyNum ? Firm::CHECK_RESULT_NOT_PASS : Firm::CHECK_RESULT_PASS;
            $firm->save();
            // 复制多一份，以供复查，防止影响旧数据

            // 保存数据
            $newCheckResult                     = $checkResult->replicate();
            $newCheckResult->status             = CheckResult::STATUS_UNSAVED;
            $newCheckResult->history_check_item = '';
            $newCheckResult->total_point        = 0;
            $newCheckResult->deduction_point    = 0;
            $newCheckResult->rectify_number     = 0;

            $newCheckResult->save();

            $checkQuestionList = CheckQuestion::where('check_result_uuid', $checkResult->report_code)
                ->where('firm_id', $uuid)
                ->get();

            foreach ($checkQuestionList as $checkQuestion) {
                $newCheckQuestion                    = $checkQuestion->replicate();
                $newCheckQuestion->check_result_uuid = $newCheckResult->report_code;
                $newCheckQuestion->save();
            }

            $collectImageList = CollectImage::where('report_code', $checkResult->report_code)
                ->where('firm_id', $uuid)
                ->get();

            foreach ($collectImageList as $collectImage) {
                $newCollectImage              = $collectImage->replicate();
                $newCollectImage->report_code = $newCheckResult->report_code;
                $newCollectImage->uuid        = Str::uuid();
                $newCollectImage->save();
            }
        });

        return response()->json(['status' => 200, 'msg' => '保存成功']);
    }

    /**
     * 中止检查
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function stopCheck(Request $request)
    {
        $rules = [
            'uuid'   => ['required', 'regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/'],
            'status' => 'required|integer',
        ];
        $input = $this->validateParams($request, $rules);

        $uuid   = $input['uuid'];
        $status = $input['status'];

        $firm = Firm::where('uuid', $uuid)->first();

        $firm->status = $status;
        $firm->save();
        return response()->json(['status' => 200, 'msg' => '操作成功']);
    }

    public function findUserCheckResult(Request $request)
    {
        $date = $request->input('reportTime') ?? '';

        $checkResults = CheckResult::select('firm_id', 'check_user_id')
                ->distinct()
                ->with('user')
                ->where('status', '!=', CheckResult::STATUS_UNSAVED)
                ->when($date, function ($query) use ($date) {
                    return $query->whereBetween('updated_at', [$date . ' 00:00:00', $date . ' 23:59:59']);
                })
                ->get();
        $data = [];
        foreach ($checkResults as $checkResult) {
            $data[$checkResult->user->id] = [
                // 'checkNum'  => $checkResult->user()->check_results_count,
                'checkUser' => $checkResult->user->phone,
                'fullName'  => $checkResult->user->name,
            ];
            $data[$checkResult->user->id]['checkNum'] = !isset($data[$checkResult->user->id]['checkNum']) ? 1 : $data[$checkResult->user->id]['checkNum'] + 1;
        }
        return response()->json(array_values($data));
    }

    public function findUserCheckEnterprise(Request $request)
    {
        $checkUserPhone = $request->input('checkUser');
        $user           = User::where('phone', $checkUserPhone)->first();

        $checkResults = CheckResult::select('firm_id', 'updated_at')
            ->distinct()
            ->with('firm')
            ->where('check_user_id', $user->id)
            ->get();

        $data = [];
        foreach ($checkResults as $checkResult) {
            $data[] = [
                'checkNum'       => 0,
                'enterpriseName' => $checkResult->firm->name,
                'enterpriseUuid' => $checkResult->firm_id,
                'reportTime'     => strtotime($checkResult->updated_at) * 1000,
            ];
        }
        return response()->json($data);
    }
}
