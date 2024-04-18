<?php

namespace App\Logic\Word;

use App\Logic\QrCodeLogic;
use PhpOffice\PhpWord\SimpleType\Jc;

class CheckReportWordLogic extends BaseWordLogic
{
    public function createWord($params)
    {
        $data = $this->getData($params);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->setDefaultFontName('仿宋');// 字体

        $phpWord->setDefaultFontSize(14);//字号

        #设置页间距
        $section = $phpWord->addSection([
            'marginLeft'  => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.9),
            'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.9),
        ]);

        $Indent = new \PhpOffice\PhpWord\Style\Indentation();
        // 设置首行缩进为2个16字体字符
        $Indent->setFirstLine(2 * 16 * 20);

        $section->addText('火灾隐患整改告知书', ['name' => '仿宋_GB2312', 'size' => 20, 'bold' => true], ['alignment' => 'center']);
        $section->addTextBreak();
        $section->addText($data['info']['company_name'] . '：', ['name' => '仿宋_GB2312', 'size' => 14]);
        $section->addText('经现场检查，发现你单位（场所）存在以下问题不符合《消防安全评估细则》（以下简称《细则》），请在收到整改告知书后立即整改，并采取有效措施确保安全。', ['name' => '仿宋_GB2312', 'size' => 14], [
            'align'       => 'left',
            'indentation' => ['firstLine' => $Indent->getFirstLine()],
        ]);

        $section->addTextBreak();

        #开始添加表格数据
        $center     = ['alignment' => Jc::CENTER];
        $cellCenter = ['valign' => 'center'];
        $table      = $section->addTable([
            'borderSize'  => 1,
            'borderColor' => '999999',
        ]);
        $cellStyle = [
            'name' => '仿宋_GB2312',
            'size' => 12,
            'bold' => true,
        ];

        #第一行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("镇街/社区", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['community'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("得分", $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText($data['info']['check_score'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("编号", $cellStyle, $center);
        $table->addCell(2500, array_merge($cellCenter, ['gridSpan' => 5]))->addText($data['info']['number'], $cellStyle, $center);

        #第二行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("类型", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['check_type_name'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("单位", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($data['info']['company_name'], $cellStyle, $center);

        #第三行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("检查结果", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['result'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("地址", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($data['info']['address'], $cellStyle, $center);

        #第四行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("联系人", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['contact_user'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("号码", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($data['info']['contact_phone'], $cellStyle, $center);

        #第五行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("楼层", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['floor'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("面积(m²)", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($data['info']['area'], $cellStyle, $center);

        #第六行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("危险性和建筑类别", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($data['info']['danger_type'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("检查人", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($data['info']['check_user'], $cellStyle, $center);

        #列表表头
        $table->addRow();
        $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText("序号", $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 3]))->addText('对应检查项序号', $cellStyle, $center);
        $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText("扣分", $cellStyle, $center);
        $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 6]))->addText("存在问题", $cellStyle, $center);
        $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 5]))->addText("整改措施", $cellStyle, $center);
        $table->addCell(800, array_merge($cellCenter, ['gridSpan' => 1]))->addText("整改难度", $cellStyle, $center);

        #列表
        foreach ($data['list'] as $key => $value) {
            if($value['is_rectify'] == 0) {
                continue;
            }

            $table->addRow();
            $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText($key + 1, $cellStyle, $center);
            $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 3]))->addText($value['check_index'], $cellStyle, $center);
            $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText($value['deduction'], $cellStyle, $center);
            $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 6]))->addText($value['standard_problem'], $cellStyle, $center);
            $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 5]))->addText($value['measure'], $cellStyle, $center);
            $table->addCell(800, array_merge($cellCenter, ['gridSpan' => 1]))->addText($value['difficulty'], $cellStyle, $center);
        }

        $table->addRow();
        $table->addCell(1500, array_merge($cellCenter, ['gridSpan' => 4]))->addText("整改期限", $cellStyle, $center);
        $table->addCell(6000, array_merge($cellCenter, ['gridSpan' => 15]))->addText($data['info']['rectify_date'], $cellStyle, ['alignment' => Jc::LEFT]);

        $table->addRow(500);
        $table->addCell(1500, array_merge($cellCenter, ['gridSpan' => 4]))->addText("签收人签名:", $cellStyle, $center);
        $table->addCell(6000, array_merge($cellCenter, ['gridSpan' => 15]))->addTextBreak(3, $cellStyle, ['alignment' => Jc::LEFT]);

        $section->addTextBreak();

        $section->addText('以上内容为现场检查时发现问题，由于多方面的原因，难免有遗漏之处，你单位（场所）要落实“安全自查、隐患自除、责任自负”的主体责任，严格按照《细则》开展自查自纠，加强日常管理，及时消除火灾隐患，确保不发生火灾事故。', ['name' => '仿宋_GB2312', 'size' => 14], [
            'align'       => 'left',
            'indentation' => ['firstLine' => $Indent->getFirstLine()],
        ]);

        $section->addTextBreak();

        $section->addTextBreak(1,[],['alignment' => 'right']);

        $section->addText(date('Y年m月d日',strtotime($data['info']['check_date'])),['name' => '仿宋_GB2312', 'size' => 16,],['alignment' => 'right']);

        $qrCodeUrl = QrCodeLogic::getInstance()->createQrCodeByUrl('http://'. request()->getHost().'/admin/check_report/qr_view?id='.$data['info']['id'],'check_report_'.$data['info']['id'].'.png');

        $section->addImage( 'http://'. request()->getHost().$qrCodeUrl, ['width'=>120, 'height'=>120, 'align'=>'right'] );

        $textRun = $section->addTextRun(['alignment' => 'right']);
        $textRun->addText('扫描', ['name' => '仿宋_GB2312', 'size' => 10]);
        $textRun->addText('二维码查看', ['name' => '仿宋_GB2312', 'size' => 10,'underline' => 'single']);
        $textRun->addText('电子隐患整改告知书 （含隐患图片）',['name' => '仿宋_GB2312', 'size' => 10]);



        return $this->download($phpWord, $data['info']['number'] . $data['info']['company_name'] . '整改告知书');
    }

    public function getData($params)
    {
        $info = [
            'id' => 1,
            'company_name'        => '华糖社区华糖街49',
            'check_type_name'           => '出租屋',
            'community'           => '华糖社区',
            'number'              => 'XF24042013',
            'check_status'        => '已检查',
            'result'              => '不合格',
            'check_user_name'     => '管理员',
            'check_date'          => '2024-04-11 20:06',
            'check_score'         => '25',
            'deduction'           => '75',
            'hidden_danger_count' => '10',
            'address'             => '华糖社区华糖街49',
            'contact_user'        => '',
            'contact_phone'       => '',
            'floor'               => 8,
            'area'                => 0,
            'check_user'          => '',
            'danger_type'         => '消防栓没水，管道老化。',
            'rectify_date'        => '2024年   月   日至2024年   月   日，整改完毕',
        ];

        $list = [
            [
                'check_index'      => 4,
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
                'check_index'      => 4,
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
                'check_index'      => 4,
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

        return ['list' => $list, 'info' => $info];
    }
}
