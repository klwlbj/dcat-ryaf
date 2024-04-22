<!DOCTYPE html>
<html>
<head>
    @include('..include/head')
</head>
<body ontouchstart="">
<div class="header font-weight weui-flex">
    <div class="weui-flex__item">消防安全隐患排查系统</div>
</div>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="https://cdn.qiping.cn/fcms/mobile/images/swiper-1.jpg"/></div>
    </div>
</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机号: </label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="userName" id="phone" type="text" placeholder="请输入手机号"
                   maxlength="20"/>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码: </label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="passWord" id="password" type="password" placeholder="请输入密码"
                   maxlength="20"/>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">排查项目: </label></div>
        <div class="weui-cell__bd weui-cell_select">
            <select class="weui-select" id="projectId"></select>
        </div>
    </div>
    <div class="weui-btn-area">
        <button class="weui-btn weui-btn_primary login">登录</button>
    </div>
</div>
<div class="weui-footer weui-footer_fixed-bottom">
    <p class="weui-footer__text">Copyright © <span id="time_year"></span> 中国消防</p>
</div>
<script src="https://cdn.qiping.cn/fcms/mobile/js/swiper.min.js"></script>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
