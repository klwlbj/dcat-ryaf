

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
                    <div class="weui-flex__item">检查标准</div>
                </div>
                <div class="weui-cells dis" id="checkStandardTpl">
                    @{{# layui.each(d.list, function(index, item){ }}
                    <a class="weui-cell weui-cell_access" href="checkStandardTable?typeId=@{{ item.id }}&typeName=@{{ item.name }}">
                        <div class="weui-cell__bd"><p>@{{ item.name }}（@{{ item.totalScore }}分）</p></div>
                        <div class="weui-cell__ft"></div>
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
<script src="{{ asset('js/checkStandard.js') }}" charset="utf-8"></script>
</body>
</html>
