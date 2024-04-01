<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;

class AddChildCheckContent extends Form
{
    public array $attribute = [];

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        // dd($input);
        // todo
        // $id = $this->attribute['id'];

        // return $this->response()->error('Your error message.');

        return $this
				->response()
				->success('Processed successfully.')
				->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // 获取外部传递参数
        $id = $this->attribute['id'] ?? 0;
        $this->hidden('id')->default($id);
        // dd($id);
        $this->text('title')->required();
        // $this->email('email')->rules('email');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'title'  => 'John Doe',
            // 'email' => 'John.Doe@gmail.com',
        ];
    }
}
