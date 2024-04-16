<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\CheckItem;
use App\Models\CheckResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CheckQuestion;
use App\Http\Controllers\Controller;

class checkResultController extends Controller
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
                'rectify'        => $checkQuestion->recitify,
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
            "cUser"       => "李工", // user()->name todo
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
            // 生成新uuid
            $reportCode = (string) Str::uuid();
            $new        = true;
        }

        $difficulty = array_flip(CheckQuestion::$formatDifficultyMaps);

        foreach ($list as $checkQuestion) {
            $saveCheckQuestionList[] = [
                'check_result_uuid' => $reportCode,
                'question'          => $checkQuestion['question'] ?? '',
                'rectify'           => $checkQuestion['rectify'] ?? '',
                'firm_id'           => $uuid,
                'difficulty'        => $difficulty[$checkQuestion['zgnd']],
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
            ]);

        } else {
            CheckQuestion::where('check_result_uuid', $reportCode)
                ->where('firm_id', $uuid)
                ->delete();
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
        $uuid = $request->input('enterpriseUuid');
        // 计算该单位最新的检查记录的得分
        $checkResult                  = CheckResult::where('firm_id', $uuid)->orderBy('id', 'desc')->first();
        $checkResult->status          = CheckResult::STATUS_BAD;// 合格or不合格
        // todo 后端计算分数
        $checkResult->total_point     = 100;
        $checkResult->deduction_point = 10;
        $checkResult->save();
        return response()->json(['status' => 200]);
    }
}
