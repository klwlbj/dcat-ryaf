$(function () {
    $(".header").on("click", ".back-page", function (a) {
        window.history.back()
    });
    $(document).on("click", ".loginOut", function () {
        window.location.href = "/web/logout"
    });
    $(document).on("click", "#savepw", function () {
        var b = $.trim($("#oldPassword").val());
        var d = $.trim($("#newPassword").val());
        if (b == "") {
            $(".weui-form__tips").text("原密码不能为空");
            return false
        }
        if (!/^[\S]{6,16}$/.test(d)) {
            $(".weui-form__tips").text("新密码必须6到12位，且不能出现空格");
            return false
        }
        var a = {oldPassword: b, newPassword: d, act: "userupdate"};
        var c = ajaxPostAsync("../../admin/save", a);
        if (c.status == 200) {
            layer.close(layer.index);
            $("#oldPassword,#newPassword").val("");
            qpOk("密码修改成功")
        } else {
            $(".weui-form__tips").text("密码修改失败:" + c.msg)
        }
    });
    $(document).on("click", ".weui-icon_gallery-delete", function () {
        var a = $(this).attr("imgUuid");
        weui.confirm("确认删除图片？删除后无法恢复!", function () {
            delImg(a, $("li[imgUuid=" + a + "]"));
            $(".weui-gallery").hide()
        })
    });
    $(document).on("click", ".weui-uploader__file", function () {
        $(".weui-gallery").show();
        $(".weui-gallery .weui-gallery__img").css("background-image", $(this).css("background-image"));
        var a = $(this).attr("imgUuid");
        if (typeof a === "undefined") {
            $(".weui-icon_gallery-delete").hide()
        } else {
            $(".weui-icon_gallery-delete").attr("imgUuid", a);
            $(".weui-icon_gallery-delete").show()
        }
    });
    $(document).on("click", ".weui-gallery__img", function () {
        $(".weui-gallery").hide()
    });
    $(document).on("click", ".weui_dialog_wrap_close", function () {
        closeWeuiDialog($(this))
    })
});
layui.use(["layer"], function () {
    $(document).on("click", ".open-popup", function () {
        var a = $(this).attr("data-target");
        a = a.indexOf("#") !== -1 ? a : "#" + a;
        const b = $(this).attr("title");
        layer.open({
            title: b,
            type: 1,
            anim: 2,
            area: ["100%", "80%"],
            offset: "b",
            closeBtn: 1,
            shadeClose: true,
            shade: [0.8, "#000"],
            content: $(a)
        })
    });
    $(document).on("click", ".open-popup-full", function () {
        var a = $(this).attr("data-target");
        var b = $(this).attr("title");
        a = a.indexOf("#") !== -1 ? a : "#" + a;
        layer.open({
            title: b,
            type: 1,
            anim: 2,
            area: ["99%", "100%"],
            offset: "b",
            closeBtn: 1,
            shadeClose: true,
            shade: [0.8, "#000"],
            content: $(a)
        })
    });
    $(document).on("click", ".open-popup-iframe", function () {
        var a = $(this).attr("data-target");
        var b = $(this).attr("title");
        layer.open({
            title: b,
            type: 2,
            anim: 2,
            area: ["99%", "100%"],
            offset: "b",
            closeBtn: 1,
            shadeClose: true,
            shade: [0.8, "#000"],
            content: a
        })
    });
    $(document).on("click", ".close-popup,.layui-layer-setwin,.layui-layer-title", function () {
        layer.close(layer.index)
    })
});

function closeDialog(a) {
    const b = a.parents(".weui_dialog_wrap");
    b.attr("aria-hidden", "true").attr("aria-modal", "false").removeAttr("tabindex");
    b.fadeOut(300);
    b.find(".weui_dialog").removeClass("weui-half-screen-dialog_show");
    setTimeout(function () {
        $("#" + b.attr("ref")).trigger("focus")
    }, 300)
}

function changeProjectId(c) {
    var a = {projectId: c};
    var b = ajaxPostAsync("/api/changeSystemItemId", a);
    if (b.status === 200) {
        qpOk("切换项目成功")
    } else {
        qpError("切换失败!")
    }
}

function getCheckStandard(b, a, c) {
    b += "?act=" + a;
    return ajaxGet(b, c, false, "post")
}

function getCollectInfoList(a) {
    return ajaxGet("/api/getCollectInfoList", {checkTypeID: a}, false, "post")
}

function getCollectImgList(b, a) {
    var c = {uuid: b, reportCode: a};
    return ajaxGet("/api/getCollectImgList", c, false, "post")
}

function getCsList(a) {
    b = ajaxGet("/api/getCheckStandard?act=info", {typeId: a}, false, "post")
    return b.list
}

function getCdList(b, a) {
    var c = {uuid: b, reportCode: a};
    return ajaxGet("/api/getCheckDetailList", c, false, "post")
};
