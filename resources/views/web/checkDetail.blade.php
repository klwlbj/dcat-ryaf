<!DOCTYPE html>
<html>
<head>
    @include('..include/head')
</head>
<body ontouchstart="">
<div class="container" id="container">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-tab__panel">
                <div class="header font-weight weui-flex">
                    <div class="back-icon back-page"><i class="weui-icon-back weui-icon_msg color-white"></i></div>
                    <div class="weui-flex__item">消防检查</div>
                </div>
                <div class="weui-panel weui-panel_access weui-cells weui-cells_form fms-form">
                    <div class="weui-panel__hd dis" id="checkBaseInfo">
                        <h3 class="color-black">检查企业: <span>@{{ d.name }}</span></h3>
                        <p class="color-black">
                            检查类型：@{{ d.ctName }}<br>
                            检查人：@{{ d.cUser }}<br>
                            日期：@{{ d.cDate }}<br>
                            检查项: 合计:<span id="totalRes"></span>&nbsp;&nbsp;&nbsp;&nbsp;
                            隐患项:<label id="NGCount"></label>&nbsp;<br>
                        </p>
                    </div>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                <a href="../index/" class="weui-tabbar__item weui-bar__item_on">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/icon_nav_button.png" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label color-white">主页</p>
                </a>
                <a href="javascript:;" class="weui-tabbar__item" id="createReport">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/icon_nav_up.png" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label color-white">生成报告</p>
                </a>
                <a href="javascript:;" class="weui-tabbar__item" id="saveAll">
                    <img src="https://cdn.qiping.cn/fcms/mobile/images/icon_nav_msg.png" class="weui-tabbar__icon">
                    <p class="weui-tabbar__label color-white">保存记录</p>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="weui-flex dis" id="checkDetail-edit">
    <div class="weui-cells weui-cells_form">
        <input type="hidden" id="parentIdType4" value="@{{ d.parentIdType4 }}">
        <div class="weui-cells__title font-weight color-orange">问题描述</div>
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" id="question" placeholder="请输入问题描述"
                              rows="5">@{{ d.question }}</textarea>
                    <div class="weui-textarea-counter"><span></span></div>
                </div>
            </div>
        </div>
        <div class="weui-cells__title font-weight">整改措施</div>
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea color-blue" id="rectify" placeholder="请输入整改措施内容"
                              rows="5">@{{ d.rectify }}</textarea>
                    <div class="weui-textarea-counter"><span></span></div>
                </div>
            </div>
        </div>
        <div class="weui-cells__title font-weight">整改难度</div>
        <div class="weui-cells weui-cells_form weui-cell_select">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <select class="weui-select" name="zgnd" id="zgnd">
                        @{{ d.zgnd }}
                        <option value="容易">容易</option>
                        <option value="中等">中等</option>
                        <option value="困难">困难</option>
                    </select>
                    <script>
                        $("#zgnd").val('@{{ d.zgnd }}')
                    </script>
                </div>
            </div>
        </div>
        <div class="weui-flex">
            <div class="weui-flex__item placeholder">
                <button class="weui-btn weui-btn_primary zgsave">保 存</button>
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
    const uuid = "{{$uuid}}";
    const reportCode = "{{$reportCode}}";
    var checkStandardID = 0;
    const collectInforID = 0;
    const imgJson = getCollectImgList(uuid, reportCode);
</script>
<script src="{{ asset('js/checkDetail.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/uploadImg.js') }}" charset="utf-8"></script>
</body>
</html>
