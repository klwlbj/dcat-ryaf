<?php

namespace App\Logic;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeLogic extends BaseLogic
{
    /**生成二维码
     * @param $url
     * @param null $fileName
     * @return bool|string
     */
    public function createQrCodeByUrl($url, $fileName = null): bool|string
    {
        $datePath = 'qrcode';
        $path = $this->getPath($datePath);
        if(!ToolsLogic::createDir($path)){
            ResponseLogic::setMsg('创建文件夹失败');
            return false;
        }

        if(empty($fileName)){
            $fileName =  md5(time()) .mt_rand(0,9999).'.png';
        }

        $pathName = $path.'/'.$fileName;
        QrCode::format('png')->size(200)->margin(1)->generate($url,$pathName);
        return '/storage/'.$datePath.'/'.$fileName;
    }

    /**获取二维码目录
     * @param $path
     * @return string
     */
    protected function getPath($path){
        return storage_path('app/public/'.$path);
    }
}
