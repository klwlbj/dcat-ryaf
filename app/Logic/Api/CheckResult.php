<?php

namespace App\Logic\Api;

use App\Logic\BaseLogic;

class CheckResult extends BaseLogic
{
    public function addParentParentIdToChildren(&$data, $parentId = 0, $parentParentId = 0)
    {
        foreach ($data as &$item) {
            if ($item['parent_id'] === $parentId) {
                $item['parent_parent_id'] = $parentParentId;

                // 递归调用，将相应的 parent_parent_id 传递给子节点
                $this->addParentParentIdToChildren($data, $item['id'], $item['parent_id']);
            }
        }
    }
}
