<?php

namespace App\Logic\Admin;

use App\Models\Firm;
use App\Logic\BaseLogic;
use App\Models\CheckItem;
use App\Logic\QrCodeLogic;
use App\Models\CheckResult;
use App\Logic\ResponseLogic;
use App\Models\CollectImage;
use App\Models\CheckQuestion;

class CheckReportLogic extends BaseLogic
{
    public function getList($params)
    {
        $list = [
            [
                'id'           => 1,
                "report"       => '123',
                "result"       => "不合格",
                "sn"           => 'XF24042013',
                "company_name" => '华糖社区华糖街49',
                'address'      => '华糖社区华糖街49',
            ],
        ];

        return ResponseLogic::apiResult(0, 'success', ['list' => $list, 'total' => 1]);
    }

    public function getDetail($params)
    {
        $id          = $params['id'];
        $checkResult = CheckResult::where('id', $id)->first();

        $firm = Firm::where('uuid', $checkResult->firm_id)->first();

        $images    = CollectImage::where('firm_id', $checkResult->firm_id)->where('report_code', '')->get();
        $imageList = [];
        foreach ($images as $image) {
            $imageList[] = url($image->file_path) . '/' . $image->file_name;
        }

        $info = [
            'company_name'        => $firm->name,
            'number'              => $firm->custom_number,
            'check_status'        => Firm::$formatStatusMaps[$firm->status],
            'result'              => Firm::$formatCheckResultMaps[$firm->check_result],
            'check_user_name'     => $checkResult->user->name,
            'check_date'          => $checkResult->updated_at,
            'check_score'         => $checkResult->total_point,
            'deduction'           => $checkResult->deduction_point,
            'hidden_danger_count' => $checkResult->rectify_number, // 隐患数
            'address'             => '华糖社区华糖街49',
            'image_list'          => $imageList,
        ];
        $reportImages = CollectImage::where('firm_id', $checkResult->firm_id)->where('report_code', $checkResult->report_code)->get();

        // $reportImageList = [];
        foreach ($reportImages as &$reportImage) {
            $reportImage['url'] = url($reportImage->file_path) . '/' . $reportImage->file_name;
        }

        $reportImages   = $reportImages->groupBy('check_question_id');
        $checkQuestions = CheckQuestion::where('firm_id', $checkResult->firm_id)->where('check_result_uuid', $checkResult->report_code)->get();

        $standardProblem = [];
        $measureList     = [];
        foreach ($checkQuestions as $checkStandardId => $checkQuestion) {
            $standardProblem[$checkQuestion['check_standard_id']][] = $checkQuestion['question'];
            $imageList                                              = $reportImages[$checkQuestion['check_question_id']] ?? collect([]);
            $measureList[$checkQuestion['check_standard_id']][]     = [
                'measure'    => $checkQuestion['question'],
                'difficulty' => CheckItem::$formatDifficultyMaps[$checkQuestion['difficulty']] ?? '',
                'imageList'  => $imageList->pluck('url'),
            ];
        }

        $checkItems = collect(json_decode($checkResult->history_check_item, JSON_OBJECT_AS_ARRAY));

        $list = [];
        // 处理check_type为1和3的节点
        $l1CheckItems = $checkItems->where('type', 1)->keyBy('id');
        $l3CheckItems = $checkItems->where('type', 3)->keyBy('id')->sortByDesc('parent_parent_id');

        foreach ($l3CheckItems as $id => $checkItem) {
            $parentParent = $l1CheckItems[$checkItem['parent_parent_id']] ?? [];
            if ($parentParent) {
                $projectName = $parentParent['title'];
            }
            $isRectify = isset($standardProblem[$id]) ? 1 : 0;
            $list[]    = [
                'project_name'     => $projectName ?? '',
                'standard'         => $checkItem['title'],
                'is_rectify'       => $isRectify,
                'deduction'        => $checkItem['total_score'],
                'standard_problem' => $standardProblem[$id] ?? [],
                'measure_list'     => $measureList[$id] ?? [],
                // 'measure'          => '◉ 方案一：进行建筑改造，将疏散楼梯延伸到屋顶平台；方案二：每层居室通向楼梯间的出入口处设乙级防火门分隔。',
            ];
        }


        if (isset($params['is_qr']) && !empty($params['is_qr'])) {
            $qrCodeUrl          = QrCodeLogic::getInstance()->createQrCodeByUrl('http://' . request()->getHost() . '/admin/report/qr_view?id=' . $params['id'], 'check_report_' . $params['id'] . '.png');
            $info['qrcode_url'] = $qrCodeUrl;
        } else {
            $info['qrcode_url'] = '';
        }

        return ResponseLogic::apiResult(0, 'success', ['list' => $list, 'info' => $info]);
    }
}
