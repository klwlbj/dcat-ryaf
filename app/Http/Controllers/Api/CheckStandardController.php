<?php

namespace App\Http\Controllers\Api;

use App\Models\Firm;
use App\Models\CheckItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckStandardController extends Controller
{
    public function getCheckStandard(Request $request)
    {
        // 获取单个GET参数
        $action = $request->query('act');
        switch ($action) {
            case 'list':
                $data = self::getCheckType();
                break;

            case 'info':
                $typeId = $request->post('typeId');
                $l1Data = CheckItem::select(['id', 'check_type', 'title', 'order_by as orderBy', 'total_score as totalScore', 'type'])
                ->where('check_type', $typeId)
                    ->where('type', 1)
                    ->orderBy('order_by')
                    ->get()
                    ->map(function ($checkItem) {
                        $checkItem->checkTypeName = CheckItem::$formatCheckTypeMaps[$checkItem->check_type] ?? '空';
                        return $checkItem;
                    });

                $l2Data = CheckItem::select(['id', 'check_type', 'title  as content', 'order_by as orderBy', 'total_score as totalScore', 'type', 'parent_id as parentId'])
                    ->where('check_type', $typeId)
                    ->where('type', 2)
                    ->orderBy('order_by')
                    ->get()
                    ->map(function ($checkItem) {
                        $checkItem->checkTypeName = CheckItem::$formatCheckTypeMaps[$checkItem->check_type] ?? '空';
                        return $checkItem;
                    });

                $l3Data = CheckItem::select(['id', 'check_type', 'title as content', 'order_by as orderBy', 'total_score as totalScore', 'type', 'parent_id as parentId'])
                    ->where('check_type', $typeId)
                    ->where('type', 3)
                    ->orderBy('order_by')
                    ->get()
                    ->map(function ($checkItem) {
                        $checkItem->checkTypeName = CheckItem::$formatCheckTypeMaps[$checkItem->check_type] ?? '空';
                        return $checkItem;
                    });

                $l4Data = CheckItem::select(['id', 'check_type', 'title as content', 'check_method as checkMethod', 'rectify_content as rectifyContent', 'order_by as orderBy', 'total_score as totalScore', 'type', 'parent_id as parentId', 'difficulty'])
                    ->where('check_type', $typeId)
                    ->where('type', 4)
                    ->orderBy('order_by')
                    ->get()
                    ->map(function ($checkItem) {
                        $checkItem->checkTypeName = CheckItem::$formatCheckTypeMaps[$checkItem->check_type] ?? '空';
                        $checkItem->zgnd          = CheckItem::$formatDifficultyMaps[$checkItem->difficulty] ?? '无';
                        return $checkItem;
                    });
                $data = $l1Data->concat($l2Data)
                    ->concat($l3Data)
                    ->concat($l4Data);
                break;
        }
        return response()->json(['list' => $data]);
    }

    public function getCheckTypeEnterpriseList(Request $request)
    {
        $list       = CheckItem::$formatCheckTypeMaps;
        $checkTypeEnterpriseNum = Firm::whereIn('check_type', array_flip($list))
            ->selectRaw('count(id) as num, check_type')
            ->groupBy('check_type')
            ->pluck('num', 'check_type');
        $data = [];

        foreach ($list as $id => $info) {
            $data[] = [
                'id'         => $id,
                'name'       => $info,
                'num' => $checkTypeEnterpriseNum[$id] ?? 0,
            ];
        }

        return response()->json($data);
    }

    public static function getCheckType(){
        $list       = CheckItem::$formatCheckTypeMaps;
        $totalScore = CheckItem::whereIn('check_type', array_flip($list))
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
