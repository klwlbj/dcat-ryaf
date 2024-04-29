<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\CheckItem;
use App\Models\CheckResult;
use Illuminate\Support\Str;
use App\Models\CollectImage;
use Illuminate\Http\Request;
use App\Models\CheckQuestion;
use Illuminate\Http\JsonResponse;
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
                'parentIdType3'  => $checkQuestion->check_standard_id,
                'parentIdType4'  => $checkQuestion->check_question_id,
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
        $uuid = $request->input('uuid');
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
     */
    public function saveCheckResult(Request $request)
    {
        $list                  = $request->post();
        $uuid                  = $request->get('uuid');
        $reportCode            = $request->get('reportCode');
        $saveCheckQuestionList = [];
        // todo check

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
            $saveCheckQuestionList[] = [
                'check_result_uuid' => $reportCode,
                'question'          => $checkQuestion['question'] ?? '',
                'rectify'           => $checkQuestion['rectify'] ?? '',
                'firm_id'           => $uuid,
                'difficulty'        => $difficulty[$checkQuestion['zgnd']] ?? CheckQuestion::DIFFICULTY_EASY,
                'check_standard_id' => $checkQuestion['parentIdType3'],
                'check_question_id' => $checkQuestion['parentIdType4'],
            ];
        }
        if ($new) {
            // todo 事务
            CheckResult::create([
                'report_code' => $reportCode,
                'status'      => CheckResult::STATUS_UNSAVED,
                'firm_id'     => $uuid,
                'check_user_id' => Auth::user()->id,
            ]);
        } else {
            CheckQuestion::where('check_result_uuid', $reportCode)
                ->where('firm_id', $uuid)
                ->delete();
            // 清除旧的图片 todo
        }
        CheckQuestion::insert($saveCheckQuestionList);

        return response()->json([
            "status" => 200,
            'msg'    => '保存成功',
        ]);
    }

    /**
     * 最终生成检查报告
     * @param Request $request
     * @return JsonResponse
     */
    public function createReport(Request $request)
    {
        $uuid       = $request->input('enterpriseUuid');
        $checkType  = Firm::where('uuid', $uuid)->value('check_type');
        $rectifyNum = $request->input('rectifyNum');

        // 计算该单位最新的检查记录的得分
        $checkResult         = CheckResult::where('firm_id', $uuid)->orderBy('id', 'desc')->first();
        $checkResult->status = $rectifyNum ? CheckResult::STATUS_BAD : CheckResult::STATUS_NORMAL;// 合格or不合格
        // todo 后端计算分数
        $checkResult->total_point     = $request->input('getScore');
        $checkResult->deduction_point = $request->input('loseScore');
        $checkResult->rectify_number  = $request->input('rectifyNum');

        // 保存检查类型到字段里
        $checkItems = CheckItem::where('check_type', $checkType)
            ->whereIn('type', [1, 2, 3])
            ->select(['id', 'title', 'total_score', 'type', 'parent_id'])
            ->get();

        //获取出父id的父id
        $this->addParentParentIdToChildren($checkItems);
        // 过滤
        $filteredCollection = $checkItems->filter(function ($item) {
            return $item['type'] === 1 || $item['type'] === 3;
        });
        $checkResult->check_user_id = Auth::user()->id;

        // 检查项目=>检查标准
        $checkResult->history_check_item = $filteredCollection->toJson();
        $checkResult->save();
        return response()->json(['status' => 200, 'msg' => '保存成功']);
    }

    private function addParentParentIdToChildren(&$data, $parentId = 0, $parentParentId = 0)
    {
        foreach ($data as &$item) {
            if ($item['parent_id'] === $parentId) {
                $item['parent_parent_id'] = $parentParentId;

                // 递归调用，将相应的 parent_parent_id 传递给子节点
                $this->addParentParentIdToChildren($data, $item['id'], $item['parent_id']);
            }
        }
    }

    /**
     * 中止检查
     * @param Request $request
     * @return JsonResponse
     */
    public function stopCheck(Request $request)
    {
        $uuid   = $request->input('uuid');
        $status = $request->input('status');

        $firm = Firm::where('uuid', $uuid)->first();

        $firm->status = $status;
        $firm->save();
        return response()->json(['status' => 200, 'msg' => '操作成功']);
    }
}
