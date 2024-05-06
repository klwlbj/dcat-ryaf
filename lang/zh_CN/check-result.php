<?php

$menuName = '检查报告';
return [
    'labels'  => [
        'CheckResult'   => $menuName,
        'check-result'  => $menuName,
        'check_results' => $menuName,
    ],
    'fields'  => [
        'report_code'     => '检查报告唯一识别码',
        'status'          => '企业状态',
        'check_result'    => '检查结果',
        'total_point'     => '总分',
        'deduction_point' => '扣分',
        'firm_id'         => '企业id',
    ],
    'options' => [
    ],
];
