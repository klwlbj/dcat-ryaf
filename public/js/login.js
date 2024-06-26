
function setCookie(name, value, days) {
    var expires = "";

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + value + expires + "; path=/";
}
$(function () {
    $("#time_year").text(new Date().getFullYear());
    $(".swiper-container").swiper({loop: false, autoplay: 3000});
    getProjectList("#projectId", "", '');
    $(".login").click(function () {
        var c = $.trim($("#phone").val());
        var a = $.trim($("#password").val());
        var b = $.trim($("#projectId").val());
        if (c === "") {
            qpWarn("账号不能为空");
            return false
        }
        if (a === "") {
            qpWarn("密码不能为空");
            return false
        }
        if (b === "") {
            qpWarn("排查项目不能为空");
            return false
        }
        qpLoad("登录中...");
        $.ajax({
            url: "/api/login/",
            type: "post",
            data: {phone: c, password: a, projectId: b},
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            success: function (d) {
                if (d.status === 200) {
                    qpOk("登录成功");
                    // 设置名为 "auth_token" 的 Cookie，值为 your_generated_token，有效期为一天
                    // $.cookie('auth_token', d.token, { expires: 1, path: '/' });
                    setCookie("auth_token", d.token, 7);
                    window.location.href = '/web/index'; // 登录成功后跳转
                } else {
                    qpWarn(d.msg)
                }
            },
            error: function (d, e) {
                qpError("网络错误，请稍候重试")
            }
        })
    })
});





