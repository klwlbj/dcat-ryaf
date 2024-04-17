<!DOCTYPE html>
<html>
<head>
    @include('..include/head')
</head>
<body ontouchstart="">
<div class="container" id="container">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-cells" id="weui-cells">
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__bd fsize14"><p>排查相关图片汇集</p></div>
                    <div class="weui-cell__ft fms-cell-ft">
                        <span class="green" id="imgNum">0</span>
                    </div>
                    <div class="weui-cell__ft fms-cell-ft">
                        <img src="https://cdn.qiping.cn/fcms/mobile/images/camera.png" width="35" height="30"
                             collectInforID="6" class="collectInfor-images" data-target="collectInfor-images"/>
                    </div>
                </a>
                <div class="color-red fsize12 pding15">
                    仅支持jpg,jpeg,png文件,单图，建筑整体正位照片，统一使用横向拍照，内容清晰
                </div>
            </div>
        </div>
    </div>
</div>
<div class="weui-flex dis" id="collectInfor-images">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <div class="weui-uploader">
                    <div class="weui-uploader__hd">
                        <div class="weui-uploader__info"></div>
                    </div>
                    <div class="weui-uploader__bd">
                        <ul class="weui-uploader__files" id="uploaderFiles">
                        </ul>
                        <div class="weui-uploader__input-box">
                            <input id="uploadImg" name="files" class="weui-uploader__input" type="file" accept="image/*"
                                   multiple="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<div class="weui-gallery" style="display: none;z-index: 19891025;">
    <span class="weui-gallery__img"></span>
    <div class="weui-gallery__opr">
        <a href="javascript:" class="weui-gallery__del">
            <i class="weui-icon-delete weui-icon_gallery-delete" imguuid=""></i>
        </a>
    </div>
</div>
<script>
    const uuid = "27cd995d1159480fb0e87705c822ce42";
    const reportCode = "";
    const checkTypeID = "1";
    // var collectInforID = 0;
    const checkStandardID = 0;
    const parentIdType4 = 0;
</script>
<script src="{{ asset('js/collectInfo.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/uploadImg.js') }}" charset="utf-8"></script>
</body>
</html>
