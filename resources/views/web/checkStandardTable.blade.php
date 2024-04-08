

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
                <div class="weui-tab__panel">
                    <table class="fms-table">
                    </table>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
<script>const typeId ="{{$typeId}}";</script>
<script src="{{ asset('js/checkStandard.js') }}" charset="utf-8"></script>
</body>
</html>
