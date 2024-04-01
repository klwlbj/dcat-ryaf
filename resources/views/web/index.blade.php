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
                    <div class="weui-flex__item">消防安全隐患排查系统</div>
                </div>
                <div class="weui-flex mtop10">
                    <div class="weui-flex__item">
                        <div class="placeholder">
                            <a href="/web/baseInfo/">
                                <img src="{{ asset('pic/base.png') }}" width="100%"/>
                            </a>
                        </div>
                    </div>
                    <div class="weui-flex__item">
                        <div class="placeholder">
                            <a href="/web/checkStandard">
                                <img src="{{ asset('pic/check.png') }}" width="100%"/>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="weui-flex">
                    <div class="weui-flex__item">
                        <div class="placeholder">
                            <a href="/web/enterprise">
                                <img src="{{ asset('pic/xf.png') }}" width="100%"/>
                            </a>
                        </div>
                    </div>
                    <div class="weui-flex__item">
                        <div class="placeholder">
                            <a href="../checkResult/index">
                                <img src="{{ asset('pic/shu.png') }}" width="100%"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="weui-tabbar fcms-footer">
                @include('..include/footer')
            </div>
        </div>
    </div>
</div>
</body>
</html>
