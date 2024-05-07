<?php

namespace App\Logic\Api;

use App\Logic\BaseLogic;

class CheckItem extends BaseLogic
{
    public static function getCheckTypeList()
    {
        $list       = \App\Models\CheckItem::$formatCheckTypeMaps;
        $totalScore = \App\Models\CheckItem::whereIn('check_type', array_flip($list))
            ->where('type', 1)
            ->selectRaw('SUM(total_score) as total_score, check_type')
            ->groupBy('check_type')
            ->pluck('total_score', 'check_type');
        $data = [];

        foreach ($list as $id => $info) {
            $data[] = [
                'id'         => $id,
                'name'       => $info,
                'totalScore' => $totalScore[$id] ?? 0,
            ];
        }

        return $data;
    }
}
