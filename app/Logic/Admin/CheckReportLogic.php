<?php

namespace App\Logic\Admin;

use App\Models\Firm;
use App\Logic\BaseLogic;
use App\Models\CheckItem;
use App\Models\Community;
use App\Logic\QrCodeLogic;
use App\Models\CheckResult;
use App\Logic\ResponseLogic;
use App\Models\CollectImage;
use App\Models\CheckQuestion;

class CheckReportLogic extends BaseLogic
{
    public function getDetail($params, $isWord = false)
    {
        $uuid        = $params['uuid'];
        $checkResult = CheckResult::where('report_code', $uuid)->first();
        if (!$checkResult) {
            return ResponseLogic::apiResult(0, 'fail');
        }

        $firm = Firm::where('uuid', $checkResult->firm_id)->first();

        // todo 查询优化
        $images    = CollectImage::where('firm_id', $checkResult->firm_id)->where('report_code', '')->get();
        $imageList = [];
        foreach ($images as $image) {
            $imageList[] = url($image->file_path) . '/' . $image->file_name;
        }

        $reportImages = CollectImage::where('firm_id', $checkResult->firm_id)->where('report_code', $checkResult->report_code)->get();

        foreach ($reportImages as &$reportImage) {
            $reportImage['url'] = url($reportImage->file_path) . '/' . $reportImage->file_name;
        }

        $reportImageList = $reportImages->groupBy('check_question_id');

        $info = [
            'uuid'                => $uuid,
            'company_name'        => $firm->name,
            'check_type_name'     => Firm::$formatCheckTypeMaps[$firm->check_type],
            'community'           => Community::where('id', $firm->community)->value('name') ?? '',
            'head_man'            => $firm->head_man,
            'phone'               => $firm->phone,
            'area_quantity'       => $firm->area_quantity,
            'floor'               => $firm->floor,
            'number'              => $firm->custom_number,
            'check_status'        => Firm::$formatStatusMaps[$firm->status],
            'result'              => Firm::$formatCheckResultMaps[$firm->check_result],
            'check_user_name'     => $checkResult->user->name,
            'check_date'          => $checkResult->updated_at,
            'check_score'         => $checkResult->total_point,
            'deduction'           => $checkResult->deduction_point,
            'hidden_danger_count' => $checkResult->rectify_number, // 隐患数
            'address'             => $firm->address,
            'image_list'          => $imageList,
        ];
        $checkQuestions = CheckQuestion::where('firm_id', $checkResult->firm_id)
            ->where('check_result_uuid', $checkResult->report_code)
            ->get();
        $checkItems = collect(json_decode($checkResult->history_check_item, JSON_OBJECT_AS_ARRAY));
        if ($isWord) {
            $list = $this->handleWordCheckQuestions($checkQuestions, $checkItems);
            return ['list' => $list, 'info' => $info];
        }
        $list = $this->handleAdminCheckQuestions($checkQuestions, $checkItems, $reportImageList);

        if (!empty($params['is_qr'])) {
            $qrCodeUrl          = QrCodeLogic::getInstance()->createQrCodeByUrl('http://' . request()->getHost() . '/admin/report/qr_view?uuid=' . $params['uuid'], 'check_report_' . $params['uuid'] . '.png');
            $info['qrcode_url'] = $qrCodeUrl;
        } else {
            $info['qrcode_url'] = '';
        }

        return ResponseLogic::apiResult(0, 'success', ['list' => $list, 'info' => $info]);
    }

    private function handleWordCheckQuestions($checkQuestions, $checkItems)
    {
        $l3CheckItems = $checkItems->where('type', 3)->keyBy('id')->sortByDesc('parent_parent_id');

        foreach ($checkQuestions as &$checkQuestion) {
            $checkQuestion['deduction']  = $l3CheckItems[$checkQuestion->check_standard_id]['total_score'] ?? 0;
            $checkQuestion['difficulty'] = CheckItem::$formatDifficultyMaps[$checkQuestion->difficulty] ?? '';
        }
        return $checkQuestions;
    }

    private function handleAdminCheckQuestions($checkQuestions, $checkItems, $reportImageList)
    {
        $standardProblem = [];
        $measureList     = [];
        foreach ($checkQuestions as $checkQuestion) {
            $standardProblem[$checkQuestion['check_standard_id']][] = $checkQuestion['question'];
            $imageList                                              = $reportImageList[$checkQuestion['check_question_id']] ?? collect([]);
            $measureList[$checkQuestion['check_standard_id']][]     = [
                'measure'    => $checkQuestion['rectify'],
                'difficulty' => CheckItem::$formatDifficultyMaps[$checkQuestion['difficulty']] ?? '',
                'imageList'  => $imageList->pluck('url'),
            ];
        }

        $list = $projectNameList = [];
        // 处理check_type为1和3的节点
        $l1CheckItems = $checkItems->where('type', 1)->keyBy('id')->sortBy('id');
        $l3CheckItems = $checkItems->where('type', 3)->keyBy('id')->sortBy('parent_parent_id');

        foreach ($l3CheckItems as $id => $checkItem) {
            $parentParent = $l1CheckItems[$checkItem['parent_parent_id']] ?? [];
            if ($parentParent) {
                // 第一次才显示，否则显示为↳
                $projectName       = in_array($parentParent['title'], $projectNameList) ? '↳' : $parentParent['title'];
                $projectNameList[] = $parentParent['title'];
                $totalScore        = $parentParent['total_score'];
            }
            $isRectify = isset($standardProblem[$id]) ? 1 : 0;
            $list[]    = [
                'project_name'     => $projectName ?? '↳',
                'total_score'      => $totalScore ?? 0,
                'standard'         => $checkItem['title'],
                'is_rectify'       => $isRectify,
                'deduction'        => $checkItem['total_score'],
                'standard_problem' => $standardProblem[$id] ?? [],
                'measure_list'     => $measureList[$id] ?? [],
            ];
        }
        return $list;
    }
}
