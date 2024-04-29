<?php

namespace App\Admin\Controllers;

use App\Models\Community;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class CommunityController  extends AdminController
{
    public function getList(Request $request){
        $systemItemId = $request->input('q');
        $data = Community::select('name as text', 'id')->where('system_item_id', $systemItemId)->get();
        return response()->json($data);
    }

}
