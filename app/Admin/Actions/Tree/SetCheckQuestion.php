<?php

namespace App\Admin\Actions\Tree;

use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Tree\RowAction;

class SetCheckQuestion extends RowAction
{
    /**
     * @return string
     */
    protected $title = 'add';

    /**
     * @var string
     */
    protected $modalId = 'set-check-question';

    public function render()
    {
        $row = $this->getRow();
        // 实例化表单类并传递自定义参数
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body(\App\Admin\Forms\SetCheckQuestion::make()->payload(['parent_id' => $this->getKey(), 'type' => $row->type]))
            ->button($this->title);
    }
}
