<?php

namespace App\Admin\Actions\Tree;

use App\Models\BaseModel;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Dcat\Admin\Tree\AbstractTool;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CheckItemAction extends AbstractTool
{
    /**
     * @return string
     */
	protected $title = '搜索';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        return $this->response()
            ->success('Processed successfully.')
            ->redirect('/');
    }

    /**
     * @return string|void
     */
    protected function href()
    {
        // return admin_url('auth/users');
    }

    protected function html()
    {
        $list = BaseModel::$formatCheckTypeMaps;
        $html = '<div><select style="width: 200px;height: 30px;" id="check_type" name="check_type">';

        foreach ($list as $key => $value){
            $html .= '<option value='.$key.'>'.$value.'</option>';
        }

        $html .= '</select><button style="color:white;width: 80px;height: 30px;border-radius: 2px;border:0;background:#586cb1;margin-left: 10px" id="search_list">搜索</button></div>';

        return $html;
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		// return ['Confirm?', 'contents'];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }
}
