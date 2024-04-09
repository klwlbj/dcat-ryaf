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
                <div class="weui-cells dis" id="weui-cells">
                    @{{# layui.each(d, function(index, item){ }}
                    <a class="weui-cell weui-cell_access" href="/web/enterpriseList?typeId=@{{ item.id }}&typeName=@{{ item.name }}">
                        <div class="weui-cell__bd"><p>@{{ item.name }}</p></div>
                        <div class="weui-cell__ft">@{{ item.num }}家</div>
                    </a>
                    @{{# }); }}
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
<script>layui.use('laytpl', function () {
        var json = ajaxGet("/api/getCheckTypeEnterpriseList", {}, false, "post");
        var tpl = $("#weui-cells").html();
        layui.laytpl(tpl).render(json, function (html) {
            $("#weui-cells").html(html).show();
        });
    });</script>
</body>
</html>
