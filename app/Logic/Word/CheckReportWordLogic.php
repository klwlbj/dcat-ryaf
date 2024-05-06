<?php

namespace App\Logic\Word;

use App\Logic\QrCodeLogic;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use App\Logic\Admin\CheckReportLogic;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Indentation;

class CheckReportWordLogic extends BaseWordLogic
{
    public function createWord($params)
    {
        $data = CheckReportLogic::getInstance()->getDetail($params, true);
        $info = $data['info'];
        $list = $data['list'];

        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('仿宋');// 字体

        $phpWord->setDefaultFontSize(14);//字号

        #设置页间距
        $section = $phpWord->addSection([
            'marginLeft'  => Converter::cmToTwip(1.9),
            'marginRight' => Converter::cmToTwip(1.9),
        ]);

        $Indent = new Indentation();
        // 设置首行缩进为2个16字体字符
        $Indent->setFirstLine(2 * 16 * 20);

        $section->addText('火灾隐患整改告知书', ['name' => '仿宋_GB2312', 'size' => 20, 'bold' => true], ['alignment' => 'center']);
        $section->addTextBreak();
        $section->addText($info['company_name'] . '：', ['name' => '仿宋_GB2312', 'size' => 14]);
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
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['community'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("得分", $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText($info['check_score'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("编号", $cellStyle, $center);
        $table->addCell(2500, array_merge($cellCenter, ['gridSpan' => 5]))->addText($info['number'], $cellStyle, $center);

        #第二行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("类型", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['check_type_name'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("单位", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($info['company_name'], $cellStyle, $center);

        #第三行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("检查结果", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['result'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("地址", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($info['address'], $cellStyle, $center);

        #第四行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("联系人", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['head_man'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("号码", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($info['phone'], $cellStyle, $center);

        #第五行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("楼层", $cellStyle, $center);
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['floor'], $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("面积(m²)", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($info['area_quantity'], $cellStyle, $center);

        #第六行
        $table->addRow();
        $table->addCell(2300, array_merge($cellCenter, ['gridSpan' => 5]))->addText("危险性和建筑类别", $cellStyle, $center);
        // 危险性和建筑类别 不确定在哪拿 todo
        $table->addCell(2000, array_merge($cellCenter, ['gridSpan' => 4]))->addText($info['danger_type'] ?? '', $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 1]))->addText("检查人", $cellStyle, $center);
        $table->addCell(4500, array_merge($cellCenter, ['gridSpan' => 7]))->addText($info['check_user_name'], $cellStyle, $center);

        #列表表头
        $table->addRow();
        $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText("序号", $cellStyle, $center);
        $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 3]))->addText('对应检查项序号', $cellStyle, $center);
        $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText("扣分", $cellStyle, $center);
        $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 6]))->addText("存在问题", $cellStyle, $center);
        $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 5]))->addText("整改措施", $cellStyle, $center);
        $table->addCell(800, array_merge($cellCenter, ['gridSpan' => 1]))->addText("整改难度", $cellStyle, $center);

        #列表
        foreach ($list as $key => $value) {
            $table->addRow();
            $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText($key + 1, $cellStyle, $center);
            $table->addCell(1000, array_merge($cellCenter, ['gridSpan' => 3]))->addText($value['check_question_id'], $cellStyle, $center);
            $table->addCell(500, array_merge($cellCenter, ['gridSpan' => 1]))->addText($value['deduction'], $cellStyle, $center);
            $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 6]))->addText($value['question'], $cellStyle, $center);
            $table->addCell(3000, array_merge($cellCenter, ['gridSpan' => 5]))->addText($value['rectify'], $cellStyle, $center);
            $table->addCell(800, array_merge($cellCenter, ['gridSpan' => 1]))->addText($value['difficulty'], $cellStyle, $center);
        }

        $table->addRow();
        $table->addCell(1500, array_merge($cellCenter, ['gridSpan' => 4]))->addText("整改期限", $cellStyle, $center);
        $table->addCell(6000, array_merge($cellCenter, ['gridSpan' => 15]))->addText('2024年   月   日至2024年   月   日，整改完毕', $cellStyle, ['alignment' => Jc::LEFT]);

        $table->addRow(500);
        $table->addCell(1500, array_merge($cellCenter, ['gridSpan' => 4]))->addText("签收人签名:", $cellStyle, $center);
        $table->addCell(6000, array_merge($cellCenter, ['gridSpan' => 15]))->addTextBreak(3, $cellStyle, ['alignment' => Jc::LEFT]);

        $section->addTextBreak();

        $section->addText('以上内容为现场检查时发现问题，由于多方面的原因，难免有遗漏之处，你单位（场所）要落实“安全自查、隐患自除、责任自负”的主体责任，严格按照《细则》开展自查自纠，加强日常管理，及时消除火灾隐患，确保不发生火灾事故。', ['name' => '仿宋_GB2312', 'size' => 14], [
            'align'       => 'left',
            'indentation' => ['firstLine' => $Indent->getFirstLine()],
        ]);

        $section->addTextBreak();

        $section->addTextBreak(1, [], ['alignment' => 'right']);

        $section->addText(date('Y年m月d日', strtotime($info['check_date'])), ['name' => '仿宋_GB2312', 'size' => 16], ['alignment' => 'right']);

        $qrCodeUrl = QrCodeLogic::getInstance()->createQrCodeByUrl('http://' . request()->getHost() . '/admin/check_report/qr_view?uuid=' . $info['uuid'], 'check_report_' . $info['uuid'] . '.png');

        $section->addImage('http://' . request()->getHost() . $qrCodeUrl, ['width' => 120, 'height' => 120, 'align' => 'right']);

        $textRun = $section->addTextRun(['alignment' => 'right']);
        $textRun->addText('扫描', ['name' => '仿宋_GB2312', 'size' => 10]);
        $textRun->addText('二维码查看', ['name' => '仿宋_GB2312', 'size' => 10, 'underline' => 'single']);
        $textRun->addText('电子隐患整改告知书 （含隐患图片）', ['name' => '仿宋_GB2312', 'size' => 10]);

        return $this->download($phpWord, $info['number'] . $info['company_name'] . '整改告知书');
    }
}
