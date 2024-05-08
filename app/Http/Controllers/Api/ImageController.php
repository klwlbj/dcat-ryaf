<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\CollectImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * 图片上传说明，暂时写死
     * @return JsonResponse
     */
    public function getCollectInfoList()
    {
        $data = [[
            'content' => '仅支持jpg,jpeg,png文件,单图，建筑整体正位照片，统一使用横向拍照，内容清晰',
            'name'    => '排查相关图片汇集',
        ]];
        return response()->json($data);
    }

    /**
     * 获取图片列表
     * @param Request $request
     * @return JsonResponse
     */
    public function getCollectImgList(Request $request)
    {
        $firmId     = $request->input('uuid');
        $reportCode = $request->input('reportCode') ?? '';

        if ($reportCode === 'new') {
            return response()->json();
        }

        $images = CollectImage::where('firm_id', $firmId)
            ->where('report_code', $reportCode)
            ->select('file_name', 'uuid', 'firm_id', 'file_path', 'check_question_id')
            ->get();
        $data = [];
        foreach ($images as $image) {
            $data[] = [
                'imgName'         => $image->file_name,
                'uuid'            => $image->uuid,
                'enterpriseUuid'  => $image->firm_id,
                'imgUrl'          => url($image->file_path),
                'checkStandardID' => $image->check_question_id,
            ];
        }
        return response()->json($data);
    }

    /**
     * 删除图片
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $uuid = $request->input('imgUuid');

        $image = CollectImage::query()->where('uuid', $uuid)->first();

        if (!$image) {
            return response()->json(['message' => '图片未找到'], 404);
        }
        // 删除文件夹中的图片
        (new \App\Logic\Api\CollectImage)->deleteFileIfNotUsed($image);

        // 删除数据库中的图片记录
        $image->delete();

        return response()->json(['message' => '图片删除成功', 'status' => 200], 200);
    }

    /**
     * 上传图片
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $firmId          = $request->input('uuid');
        $reportCode      = $request->input('reportCode') ?? '';
        $checkQuestionId = $request->input('checkStandardID') ?? '';
        $file            = $request->file('files');
        $date            = date('ymdHis');
        // $fileName      = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $imageUuid     = Str::uuid(); // 生成唯一标识符
        $directory     = 'storage/xf/upload/' . date('Y/m');

        $imagePath = $file->storePubliclyAs($directory, $date . $imageUuid . '.' . $fileExtension);
        if (!$imagePath) {
            return response()->json([
                'status' => 400,
                'msg'    => '图片上传失败',
            ]);
        }

        // 创建新的图片记录
        $image                    = new CollectImage();
        $image->file_name         = $date . $imageUuid . '.' . $fileExtension;
        $image->uuid              = $imageUuid;
        $image->file_path         = $directory;
        $image->file_extension    = $fileExtension;
        $image->firm_id           = $firmId;
        $image->report_code       = $reportCode;
        $image->check_question_id = $checkQuestionId;
        $image->save();

        // 返回接口格式数据
        $response = [
            'imgUrl'  => url($directory), // 图片目录URL
            'imgName' => date('ymdHis') . $imageUuid . '.' . $fileExtension,
            'msg'     => '图片上传成功',
            'status'  => 200,
            'imgUuid' => $imageUuid,
        ];

        return response()->json($response);
    }
}
