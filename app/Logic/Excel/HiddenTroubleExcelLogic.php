<?php

namespace App\Logic\Excel;

class HiddenTroubleExcelLogic extends BaseExcelLogic
{
    public function createExcel($params)
    {
        $list       = $this->getData($params);
        $exportData = [['编号', '社区', '单位名称', '地址', '负责人', '联系方式', '排查状态', '检查标准', '主要存在问题', '整改措施', '隐患问题个数', '扣分', '检查类型', '楼层', '营业面积(m²)', '检查人', '检查时间', '备注']];

        foreach ($list as $key => $value) {
            $exportData[] = [
                $value['report_code'],
                $value['community'],
                $value['company'],
                $value['address'],
                $value['head_man'],
                $value['head_man_phone'],
                $value['check_status'],
                $value['check_standard'],
                $value['question'],
                $value['rectify'],
                $value['question_count'],
                $value['deduction_point'],
                $value['check_type_name'],
                $value['floor'],
                $value['area'],
                $value['check_user'],
                $value['check_date'],
                $value['remark'],
            ];
        }

        $fileName = '单位隐患汇总-' . date('ymdHis') . '.xlsx';

        $config = [
            'column_width' => ['A' => 15, 'B' => 15, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15, 'G' => 15, 'H' => 15, 'I' => 15, 'J' => 15, 'K' => 15, 'L' => 15, 'M' => 15, 'N' => 15, 'O' => 15, 'P' => 15, 'Q' => 15, 'R' => 15],
            'row_height'   => [1 => 20],
            'font_size'    => ['A1:R1' => 14],
            'bold'         => ['A1:R1' => true],
            'horizontal'   => ['A1:R1' => 'center'],
        ];
        return $this->export($exportData, $fileName, 'data', $config);
    }

    protected function getData($params)
    {
        $list = [
            [
                'report_code'     => 'XF24042031',
                'community'       => '团结社区',
                'company'         => ' 团结社区松南路27号（松南路大院）',
                'address'         => ' 团结社区松南路27号（松南路大院）',
                'head_man'        => '',
                'head_man_phone'  => '',
                'check_status'    => '已检查',
                'check_standard'  => '1、建筑高度大于54m（含）的出租屋建筑，未设有两部不同方向的疏散楼梯，扣30分；未设有两部不同方向的疏散楼梯的建筑高度大于27m（含）、小于54m的出租屋建筑，外窗、阳台上的防盗网未设置长宽净尺寸不小于1米、0.8米且向外开启的紧急逃生口且未在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施，扣30分；未设有两部不同方向的疏散楼梯的建筑高度小于27m的出租屋建筑，外窗、阳台上的防盗网未设置长宽净尺寸不小于1米、0.8米且向外开启的紧急逃生口或未在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施，扣30分。
2、疏散通道、安全出口符合以下情形之一，扣30分。
3、疏散楼梯和疏散走道的设置符合以下情形之一，每项扣10分。
4、疏散楼梯、疏散走道内未配置消防应急照明，或消防应急照明灯安装不符合要求、不能正常工作使用，扣10分。
5、公共区域未设置独立式感烟火灾探测报警器，或独立式感烟火灾探测报警器安装不符合要求、不能正常工作的，扣10分。
6、未按每层公共区域至少配置2具4kgABC手提式干粉灭火器或配备的灭火器不能正常使用，扣10分。
7、出租屋建筑存在以下情形之一，扣20分
8、出租屋建筑存在以下情形之一，扣20分
9、出租屋建筑存在以下情形之一，扣20分
',
                'question'        => '1、未设有两部不同方向的疏散楼梯的建筑高度大于27m、小于54m的出租屋建筑，外窗、阳台上的防盗网未设置紧急逃生口且未在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施。
2、疏散通道、安全出口未保持畅通无阻，存在堵塞、占用和锁闭。
3、建筑高度30m（含）以上的出租屋建筑，疏散楼梯不能直通屋顶平台。
4、疏散楼梯、疏散走道内未配置消防应急照明。
5、公共区域未设置独立式感烟火灾探测报警器。
6、未按每层公共区域至少配置2具4kgABC手提式干粉灭火器。
7、出租屋建筑未设置消防疏散指示标志。
8、消防栓无法正常使用
9、建筑高度大于21m（含）的出租屋建筑，公共部位未设置具有语音功能的火灾声警报装置或应急广播。
',
                'rectify'         => '1、方案一：增设疏散楼梯，使其满足有两部不同方向的疏散楼梯的要求；方案二：在外窗、阳台上的防盗网设置紧急逃生口且或在公共区域外设置逃生软梯、逃生缓降器、消防逃生梯或辅助爬梯等辅助疏散逃生设施。
2、清理杂物、打开锁具，保持畅通无阻。
3、建筑高度30m（含）以上的出租屋建筑，疏散楼梯应能直通屋顶平台（现状无法通往屋灯平台的建筑，可设计避难层替代，避难层的设计须由专业消防设计公司设计，并交由社区工作站备案）。
4、在疏散走道、楼梯间等处的墙面设置应急照明灯。
5、公共区域应设置独立式感烟火灾探测报警器。
6、在每层公共区域至少配置2具4kg ABC手提式干粉灭火器。
7、在安全出口正上方设置安全出口标志，疏散走道及其转角处距地面高度1.0m以下的墙面或地面上设置灯光型疏散指示标志。
8、加强设施设备的维护保养，确保室内消火栓系统、消防软管卷盘、自动灭火系统、火灾自动报警系统、火灾探测器、火灾声警报装置或应急广播等均能正常使用。
9、在公共部位增设具有语音功能的火灾声光警报装置或应急广播。
',
                'question_count'  => 9,
                'deduction_point' => 70,
                'check_type_name' => '出租屋',
                'floor'           => 9,
                'area'            => 3000,
                'check_user'      => '管理员',
                'check_date'      => '2024-04-10 17:28:45',
                'remark'          => '',
            ],
        ];

        return $list;
    }
}
