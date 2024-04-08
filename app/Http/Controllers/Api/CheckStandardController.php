<?php

namespace App\Http\Controllers\Api;

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
                $data = [];
                $list = CheckItem::$formatCheckTypeMaps;
                foreach ($list as $id => $info) {
                    $data[] = [
                        'id'         => $id,
                        'name'       => $info,
                        'totalScore' => 100,
                    ];
                }

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

}
