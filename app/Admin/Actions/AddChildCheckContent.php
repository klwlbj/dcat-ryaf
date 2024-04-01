<?php

namespace App\Admin\Actions;

use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Actions\Action;

class AddChildCheckContent extends Action
{
    protected $title = '添加检查标准';

    public function render()
    {
        // 实例化表单类并传递自定义参数
        $form = \App\Admin\Forms\AddChildCheckContent::make();
        // dd($form);
        // dd($this->id);
        // $form->attribute['id'] = $this->id;

        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }
}
