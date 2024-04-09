var checkTypeID = 0;
var laytpl;
const enterpriseJson = ajaxGet("/api/getEnterprise", {number: number}, false, "post");
$(function () {
    $(document).on("click", "#newCheckBtn", function () {
        window.location.href = "../checkDetail/check?number=" + number
    });
    $(document).on("click", "#reCheckBtn", function () {
        window.location.href = "../checkDetail/reCheck?number=" + number + "&reportCode=" + reportCode
    });
    if (enterpriseJson.enterprise.stopCheck === 1) {
        stopCheck(1)
    } else {
        stopCheck(0)
    }
    $(document).on("click", ".edit", function (a) {
        fms_border(1);
        $(this).text("保存").addClass("save").removeClass("edit");
        $(".back-icon").text("取消").removeClass("back-page").addClass("cancel")
    });
    $(document).on("click", ".cancel", function (a) {
        cancelEdit()
    });
    $(document).on("click", ".save", function (a) {
        submitLoad("保存中...", ".edit-icon");
        weui.form.validate("#form", function (c) {
            if (!c) {
                var b = "../../enterprise/save?isCheck=" + isCheck;
                var d = decodeURIComponent($("#form").serialize(), true);
                var e = ajaxPostAsync(b, d);
                if (e.stauts === 200) {
                    qpOk("保存成功");
                    cancelEdit()
                } else {
                    qpError("保存失败，请稍候再试")
                }
            } else {
                if (c.msg === "empty") {
                    qpError(c.ele.placeholder)
                }
            }
        })
    });
    $(document).on("click", "#stopCheck .stopCheckSave", function () {
        $(".weui-cells_radio").each(function () {
            $(this).find("input[type='radio']").each(function () {
                if ($(this).is(":checked")) {
                    var d = $(this).val();
                    var a = $(this).attr("refName");
                    var c = $(this).attr("orderBy");
                    var b = c == 0 ? 0 : 1;
                    ajaxPost("stopCheck", {number: number, id: d, stop: b}, false);
                    $("#checkStatusID").val(d);
                    if (b == 1) {
                        stopCheck(1)
                    } else {
                        stopCheck(0)
                    }
                    return false
                }
            })
        });
        setTimeout("layer.close(layer.index)", 1000)
    });
    $(document).on("click", ".open-popup-camera", function () {
        var a = $(this).attr("data-target");
        var b = $(this).attr("title");
        layui.use("layer", function () {
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
        })
    })
});
layui.use("laytpl", function () {
    laytpl = layui.laytpl;
    var a = $("#enterprise-edit");
    laytpl(a.html()).render(enterpriseJson, function (b) {
        $("#enterprise-edit").html(b).show()
    });
    checkTypeID = enterpriseJson.enterprise.checkTypeID;
    getCheckStatusList();
    checkStatus()
});

function getCheckStatusList() {
    var a = $(".weui-cells_radio").html();
    laytpl(a).render(enterpriseJson.csList, function (b) {
        $(".weui-cells_radio").html(b)
    })
}

function fms_border(a) {
    if (a == 1) {
        $("form input").attr("disabled", false).addClass("fms-border");
        $("form select").attr("disabled", false).addClass("fms-border");
        $("form textarea").attr("disabled", false).addClass("fms-border");
        if (isCheck == "true") {
            $("#checkTypeID").attr("disabled", true).removeClass("fms-border")
        }
    } else {
        $("form input").attr("disabled", true).removeClass("fms-border");
        $("form select").attr("disabled", true).removeClass("fms-border");
        $("form textarea").attr("disabled", true).removeClass("fms-border")
    }
}

function cancelEdit() {
    fms_border(0);
    $(".edit-icon").text("编辑").addClass("edit").removeClass("save");
    $(".back-icon").addClass("back-page").removeClass("cancel");
    $(".back-icon").html('<i class="weui-icon-back weui-icon_msg color-white"></i>')
}

function stopCheck(a) {
    if (a == 1) {
        $("#newCheckBtn").addClass("weui-btn_disabled").attr("disabled", true);
        $("#reCheckBtn").addClass("weui-btn_disabled").attr("disabled", true)
    } else {
        $("#newCheckBtn").removeClass("weui-btn_disabled").attr("disabled", false);
        if (isCheck == "true") {
            $("#reCheckBtn").removeClass("weui-btn_disabled").attr("disabled", false)
        }
    }
}

function checkStatus() {
    var a = $("#checkStatusID").val();
    if (a != 3 && a != 4 && a != 5) {
        stopCheck(1)
    } else {
        stopCheck(0)
    }
};
