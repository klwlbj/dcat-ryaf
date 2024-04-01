

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
                    <div class="weui-flex__item">用户信息详情</div>
                    <button type="button" class="weui-btn weui-btn_mini weui-btn_warn edit-icon loginOut">退出</button>
                </div>
                <div class="weui-form ptop10">
                    <div class="weui-form__control-area mtop10">
                        <div class="weui-cells__group weui-cells__group_form">
                            <div class="weui-cells">
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">用户名</span></div>
                                    <div class="weui-cell__bd">
                                        18024592219
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">姓名</span></div>
                                    <div class="weui-cell__bd">
                                        李工
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">联系方式</span></div>
                                    <div class="weui-cell__bd">
                                        <a href="tel:18024592219">18024592219</a>
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">岗位信息</span></div>
                                    <div class="weui-cell__bd">
                                        监督
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">用户类型</span></div>
                                    <div class="weui-cell__bd">
                                        督导组
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">账号状态</span></div>
                                    <div class="weui-cell__bd">
                                        正常
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">用户角色</span></div>
                                    <div class="weui-cell__bd">
                                        检查员
                                    </div>
                                </div>
                                <div class="weui-cell">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">修改密码</span></div>
                                    <div class="weui-cell__bd">
                                        <button class="weui-btn weui-btn_default weui-vcode-btn open-popup" title="修改密码" data-target="user-passWord">修改密码</button>
                                    </div>
                                </div>
                                <div class="weui-cell weui-cell_select">
                                    <div class="weui-cell__hd"><span class="weui-label font-weight">切换项目</span></div>
                                    <div class="weui-cell__bd">
                                        <select class="weui-select" style="width: auto" id="projectId" onchange="changeProjectId(this.value)"></select>
                                        <script>getProjectList("#projectId","5","默认项目");</script>
                                    </div>
                                </div>
                            </div>
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
<div class="weui-form ptop5 dis" id="user-passWord">
    <div class="weui-form__control-area mtop5">
        <div class="weui-cells__group weui-cells__group_form">
            <div class="weui-cells">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label">原密码<i class="color-red">*</i></span></div>
                    <div class="weui-cell__bd">
                        <input id="oldPassword" name="oldPassword" class="weui-input" maxlength="12" placeholder="请输入原来密码">
                    </div>
                </div>
                <div class="weui-cell">
                    <div class="weui-cell__hd"><span class="weui-label">新密码<i class="color-red">*</i></span></div>
                    <div class="weui-cell__bd">
                        <input id="newPassword" name="newPassword" class="weui-input" maxlength="12" placeholder="请输入新密码长度6到12位">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="weui-form__tips-area">
        <p class="weui-form__tips color-red">
        </p>
    </div>
    <div class="weui-half-screen-dialog__ft">
        <button class="weui-btn weui-btn_primary" id="savepw">保存修改</button>
    </div>
</div>
</body>
</html>
