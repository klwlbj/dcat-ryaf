<?php

namespace App\Admin\Actions\Tree;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Table;
use Dcat\Admin\Tree\RowAction;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class SetCheckQuestion extends RowAction
{
    /**
     * @return string
     */
    protected $title = '添加标准问题';

    /**
     * @var string
     */
    protected $modalId = 'set-check-question';

    public function render()
    {
        // 实例化表单类并传递自定义参数
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body(\App\Admin\Forms\SetCheckQuestion::make()->payload(['parent_id' => $this->getKey()]))
            ->button($this->title);
    }
}
