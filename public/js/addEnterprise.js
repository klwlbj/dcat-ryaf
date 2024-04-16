layui.use("laytpl", function () {
    const a = ajaxGet("/api/getCheckStatusList", {}, false, "post");
    layui.laytpl($("#checkStatusID").html()).render(a, function (d) {
        $("#checkStatusID").html(d)
    });
    const b = ajaxGet("/api/getCheckStandard?act=list", {}, false, "post").list;
    layui.laytpl($("#checkTypeID").html()).render(b, function (d) {
        $("#checkTypeID").html(d)
    });
    if (typeof typeId != "undefined") {
        $("#checkTypeID").val(typeId)
    }
    const c = ajaxGet("../../api/getCommunityList", {}, false, "post");
    layui.laytpl($("#communityList").html()).render(c, function (d) {
        $("#communityList").html(d)
    });
    $("#communityList").change(function () {
        $("input[name=community]").val($(this).val())
    })
});
$(function () {
    $(document).on("click", "#save", function (a) {
        if (typeof typeId != "undefined") {
            $("#checkTypeID").val(typeId)
        }
        weui.form.validate("#form", function (d) {
            if (!d) {
                if ($("#checkTypeID").val() == "") {
                    $(".weui-form__tips").text($("#checkTypeID").attr("placeholder"));
                    return false
                }
                var c = "/api/saveEnterprise";
                var b = decodeURIComponent($("#form").serialize(), true);
                submitLoad("提交中...", "#save");
                var e = ajaxPostAsync(c, b);
                if (e.status === 200) {
                    qpOk("新增成功");
                    layer.close(layer.index);
                    if (typeof typeId == "undefined") {
                        enterpriseJson = getBaseInfo("getBaseInfo", "enterprise", {})
                    } else {
                        enterpriseJson = ajaxGet("/api/getEnterpriseList", {typeId: typeId}, false, "post");
                        console.info(enterpriseJson)
                    }
                    layui.use("laytpl", function () {
                        layui.laytpl(enterpriseListTpl).render(enterpriseJson, function (f) {
                            enterpriseListDOM.html(f)
                        })
                    });
                    $(".weui-form__tips").text("");
                    $("input[name=enterpriseName]").val("");
                    $("input[name=floorNum]").val("");
                    $("input[name=businessArea]").val("")
                } else {
                    $(".weui-form__tips").text(e.msg)
                }
            } else {
                if (d.msg === "empty") {
                    $(".weui-form__tips").text(d.ele.placeholder)
                }
            }
        })
    })
});
