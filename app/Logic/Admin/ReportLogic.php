<?php

namespace App\Logic\Admin;

use App\Logic\BaseLogic;
use App\Logic\QrCodeLogic;
use App\Logic\ResponseLogic;

class ReportLogic extends BaseLogic
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
        $info = [
            'company_name'        => '华糖社区华糖街49',
            'number'              => '	XF24042013',
            'check_status'        => '已检查',
            'result'              => '不合格',
            'check_user_name'     => '管理员',
            'check_date'          => '2024-04-11 20:06',
            'check_score'         => '25',
            'deduction'           => '75',
            'hidden_danger_count' => '10',
            'address'             => '华糖社区华糖街49',
            'image_list'          => [],
        ];

        $list = [
            [
                'project_name'     => '一、平面布置最高扣10分',
                'standard'         => '1、出租屋与生产、储存、经营易燃易爆危险品的场所设置在同一建筑物内，扣100分（一票否决项）。',
                'is_rectify'       => 1,
                'deduction'        => '10',
                'standard_problem' => '◉ 建筑高度大于21m（含），不大于30m的出租屋建筑，疏散楼梯间不能直通屋顶平台或未能直通屋顶平台，且在每层居室通向楼梯间的出入口处未设乙级防火门分隔。',
                'measure'          => '◉ 方案一：进行建筑改造，将疏散楼梯延伸到屋顶平台；方案二：每层居室通向楼梯间的出入口处设乙级防火门分隔。',
                'difficulty'       => '难',
                'imageList'        => [],
            ],
            [
                'project_name'     => '↳',
                'standard'         => '2、既有出租屋的建筑之间或与其他耐火等级建筑之间的防火间距应符合下列要求之一，扣10分。',
                'is_rectify'       => 0,
                'deduction'        => 0,
                'standard_problem' => '',
                'measure'          => '',
                'difficulty'       => '',
                'imageList'        => [],
            ],
            [
                'project_name'     => '↳',
                'standard'         => '3、建筑高度不大于15m的出租屋建筑密集区防火间距不满足要求时，未采取以下措施，扣10分。',
                'is_rectify'       => 1,
                'deduction'        => '5',
                'standard_problem' => '◉ 未设有两部不同方向的疏散楼梯的建筑高度小于27m的出租屋建筑，外窗、阳台上的防盗网未设置紧急逃生口或未在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施。',
                'measure'          => '◉ 方案一：增设疏散楼梯，使其满足有两部不同方向的疏散楼梯的要求；方案二：在外窗、阳台上的防盗网设置紧急逃生口且或在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施。',
                'difficulty'       => '容易',
                'imageList'        => [
                    "https://fuss10.elemecdn.com/8/27/f01c15bb73e1ef3793e64e6b7bbccjpeg.jpeg",
                    "https://fuss10.elemecdn.com/1/8e/aeffeb4de74e2fde4bd74fc7b4486jpeg.jpeg",
                ],
            ],
        ];
        if(isset($params['is_qr']) && !empty($params['is_qr'])){
            $qrCodeUrl = QrCodeLogic::getInstance()->createQrCodeByUrl('http://'. request()->getHost().'/admin/report/qr_view?id='.$params['id'],'check_report_'.$params['id'].'.png');
            $info['qrcode_url'] = $qrCodeUrl;
        }else{
            $info['qrcode_url'] = '';
        }

        return ResponseLogic::apiResult(0, 'success', ['list' => $list, 'info' => $info]);
    }
}
