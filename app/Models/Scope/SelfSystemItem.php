<?php

namespace App\Models\Scope;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SelfSystemItem implements Scope
{
    /**
     * 将作用域应用于给定的 Eloquent 查询构建器。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $systemItemId = app('system_item_id') ?? '';
        $builder->where('system_item_id', $systemItemId);
    }
}
