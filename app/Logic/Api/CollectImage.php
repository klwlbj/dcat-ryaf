<?php

namespace App\Logic\Api;

use App\Logic\BaseLogic;
use Illuminate\Support\Facades\Storage;

class CollectImage extends BaseLogic
{
    public function deleteFileIfNotUsed($img): void
    {
        $exists = \App\Models\CollectImage::where('uuid', $img->uuid)
            ->where('report_code', '!=', $img->report_code)
            ->exists();

        if (!$exists) {
            // 图片未复用
            // $img->file_path = 'public/xf/upload/2024/05';
            // $img->filename = '240507091502099b7204-ca2d-4ade-be18-bb5ad331e7c3.png';
            Storage::disk()->delete($img->file_path . '/' . $img->file_name);
        }
    }
}
