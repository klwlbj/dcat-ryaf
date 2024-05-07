<?php

namespace App\Logic\Api;

use App\Models\Firm;
use App\Logic\BaseLogic;
use App\Models\Community;

class FirmLogic extends BaseLogic
{
    /**
     * 多次调用
     * @return array
     */
    public function getCheckStatusList()
    {
        $statusList = Firm::$formatStatusMaps;
        $data       = [];
        foreach ($statusList as $key => $status) {
            $data[] = [
                'id'      => $key,
                'orderBy' => 0, // 暂时写死
                'uuid'    => '',
                'name'    => $status,
            ];
        }
        return $data;
    }

    public function getCommunityList()
    {
        $systemItemId = app('system_item_id') ?? '';
        return Community::where('system_item_id', $systemItemId)->pluck('name');
    }
}
