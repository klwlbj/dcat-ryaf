const bsJson = ajaxGet("/api/getCheckBaseInfo", {uuid: uuid}, false, "post");
const csJson = getCsList(bsJson.checkTypeID);
var cdJson = getCdList(uuid, reportCode);
console.info("cdJson", cdJson);
const csJson1 = getNewJson(csJson, 1);
const csJson2 = getNewJson(csJson, 2);
const csJson3 = reOrderBy(getNewJson(csJson, 3));
const csJson4 = getNewJson(csJson, 4);
const checkDetail_edit_DOM = $("#checkDetail-edit");
const collectInfor_images_DOM = $("#collectInfor-images");
const checkBaseInfo_DOM = $("#checkBaseInfo");
const checkDetail_edit_TPL = checkDetail_edit_DOM.html();
const collectInfor_images_TPL = collectInfor_images_DOM.html();
const checkBaseInfo_TPL = checkBaseInfo_DOM.html();
var autoSave = false;
$(function () {
    layui.use(["laytpl"], function () {
        layui.laytpl(checkBaseInfo_TPL).render(bsJson, function (c) {
            checkBaseInfo_DOM.html(c).show();
            $("#totalRes").text(csJson3.length);
            $("#NGCount").text(cdJson.length)
        })
    });
    showTemplae();
    $(document).on("click", ".question input[type=checkbox]", function () {
        var c = $(this).val();
        if ($(this).is(":checked")) {
            $("#ngbtn_" + c).show();
            $("#ngtext_" + c).show()
        } else {
            $("#ngbtn_" + c).hide();
            $("#ngtext_" + c).hide()
        }
    });
    $(document).on("click", ".question-ng input[type=checkbox]", function () {
        var c = $(this).val();
        if ($(this).is(":checked")) {
            $(this).next("div").show();
            cdJsonUpdate(c, 0)
        } else {
            $(this).next("div").hide();
            cdJsonUpdate(c, 1)
        }
    });
    $(document).on("click", ".ngbtn", function () {
        $(this).next(".ngtext").toggle()
    });
    $(document).on("click", ".weui-icon-cancel", function () {
        var d = $(this);
        var c = d.attr("imgUuid");
        $.confirm("确定删除图片？删除后无法恢复!", function () {
            delImg(c, d.parent("li"))
        }, function () {
        })
    });
    $(document).on("click", ".zgsave", function () {
        var d = $("#question").val();
        var f = $("#rectify").val();
        var c = $("#zgnd").val();
        var e = $("#parentIdType4").val();
        $.each(cdJson, function (g, h) {
            if (h.parentIdType4 == e) {
                h.question = d;
                h.rectify = f;
                h.zgnd = c;
                qpOk("保存成功");
                return false
            }
        })
    });
    $(document).on("click", "#saveAll", function () {
        saveFunc()
    });
    var b = true;
    var a = true;
    $(document).on("click", "#createReport", function () {
        if (!b) {
            return
        }
        b = false;
        var c = weui.confirm("确定生成报告吗? ", function () {
            if (!a) {
                return
            }
            a = false;
            qpLoad("生成中...");
            saveFunc();
            var d = getReporBaseInfo();
            d.enterpriseUuid = uuid;
            console.info("报告对象", d);
            var e = ajaxPostAsync("/api/createReport", d);
            if (e.status == 200) {
                qpOk(e.msg);
                setTimeout(function () {
                    window.location.href = "../enterpriseList?typeId=" + bsJson.checkTypeID + "&typeName=" + bsJson.ctName
                }, 500)
            } else {
                qpWarn(e.msg)
            }
        }, function () {
            c.hide();
            b = true;
            return false
        })
    });
    $(document).on("click", ".btn-checkDetail-edit", function () {
        var d = $(this).attr("parentIdType4");
        const c = checkDetail_edit(d);
        layui.use(["layer", "laytpl"], function () {
            layui.laytpl(checkDetail_edit_TPL).render(c, function (e) {
                checkDetail_edit_DOM.html(e)
            });
            layui.laytpl(checkDetail_edit_TPL).render(c, function (e) {
                checkDetail_edit_DOM.html(e)
            });
            layer.open({
                title: "整改措施",
                type: 1,
                anim: 2,
                area: ["100%", "80%"],
                offset: "b",
                closeBtn: 1,
                shadeClose: true,
                shade: [0.8, "#000"],
                content: $("#checkDetail-edit")
            })
        })
    });
    $(document).on("click", ".btn-collectInfor-images", function () {
        var c = $(this).attr("parentIdType4");
        collectInfor_images(c);
        layui.use(["layer"], function () {
            layer.open({
                title: "图片上传(可同时上传多张)",
                type: 1,
                anim: 2,
                area: ["100%", "80%"],
                offset: "b",
                closeBtn: 1,
                shadeClose: true,
                shade: [0.8, "#000"],
                content: $("#collectInfor-images")
            })
        })
    })
});

function showTemplae() {
    var b = "";
    var a = 0;
    $.each(csJson3, function (e, c) {
        a++;
        b += '<div class="weui-panel__bd"><div class="weui-media-box weui-media-box_text fms-border-b"><div class="weui-cell weui-cell_switch pleft0"><div class="weui-cell__bd color-blue"><span class="color-danger">第 ' + a + " 项检测:</span>" + c.content + '</div><div class="weui-cell__ft question"><input class="weui-switch" type="checkbox" value="' + c.id + '"></div></div></div></div>';
        b += '<div class="weui-panel__ft fms-bg-gray ngbtn dis" id="ngbtn_' + c.id + '"><a href="javascript:void(0);" class="weui-cell weui-cell_access weui-cell_link"><div class="weui-cell__bd color-danger font-weight">消防隐患:</div><span>▽</span></a></div>';
        b += '<div class="weui-panel__bd ngtext dis" id="ngtext_' + c.id + '"><div class="weui-media-box weui-media-box_text">';
        var d = 0;
        $.each(csJson4, function (f, g) {
            d++;
            if (g.parentId == c.id) {
                b += '<div class="weui-cell weui-cell_switch pleft0"><div class="weui-cell__bd color-red">◉ ' + g.content + '</div><div class="weui-cell__ft question-ng"><input class="weui-switch" type="checkbox" value="' + g.id + '"><div class="dis"><button class="weui-btn weui-btn_mini weui-btn_primary ng-img btn-checkDetail-edit" parentIdType3="' + c.id + '" parentIdType4="' + g.id + '">措施</button><br><button class="weui-btn weui-btn_mini weui-btn_primary ng-img btn-collectInfor-images" parentIdType3="' + c.id + '" parentIdType4="' + g.id + '">拍照</button></div></div></div>'
            }
        });
        b += "</div></div>"
    });
    $("#checkBaseInfo").after(b);
    openSelect()
}

function openSelect() {
    $.each(cdJson, function (a, d) {
        var c = d.parentIdType3;
        var b = d.parentIdType4;
        $("input[type='checkbox']").each(function () {
            var e = $(this).val();
            if (e == c) {
                $(this).attr("checked", true);
                $("#ngbtn_" + e).show();
                $("#ngtext_" + e).show()
            } else {
                if (e == b) {
                    $(this).attr("checked", true);
                    $(this).next("div").show()
                }
            }
        })
    })
}

function checkDetail_edit(b) {
    var a = {};
    $.each(cdJson, function (c, d) {
        if (d.parentIdType4 == b) {
            a.question = d.question;
            a.rectify = d.rectify;
            a.zgnd = d.zgnd;
            a.parentIdType4 = b;
            return false
        }
    });
    return a
}

function collectInfor_images(b) {
    checkStandardID = b;
    var c = "";
    $.each(imgJson, function (d, e) {
        if (e.checkStandardID == b) {
            c += '<li class="weui-uploader__file" imgUuid="' + e.uuid + '" style="background-image:url(\'' + e.imgUrl + "/" + e.imgName + "')\"></li>"
        }
    });
    $("#uploaderFiles").html(c);
    var a = $(".weui-uploader__file").length;
    $(".weui-uploader__info").text(a + "/" + 50)
}

function cdJsonUpdate(b, c) {
    var d = {};
    d.isPass = c;
    d.enterpriseUuid = uuid;
    $.each(csJson4, function (e, f) {
        if (b == f.id) {
            d.question = f.content;
            d.parentIdType3 = f.parentId;
            d.parentIdType4 = f.id;
            d.rectify = f.rectifyContent;
            d.zgnd = f.zgnd;
            return false
        }
    });
    var a = true;
    $.each(cdJson, function (e, f) {
        if (d.parentIdType4 === f.parentIdType4) {
            f.isPass = d.isPass;
            a = false;
            return false
        }
    });
    if (a) {
        cdJson[cdJson.length] = d
    }
    autoSave = true;
    console.log("autoSave=", autoSave);
    console.log("cdJson:", cdJson)
}

function getReporBaseInfo() {
    var c = 0;
    var b = 0;
    var f = 0;
    var e = 0;
    var d = 0;
    console.info("csJson1: ", csJson1);
    $.each(csJson1, function (i, h) {
        e = h.totalScore;
        var g = 0;
        $.each(csJson2, function (k, j) {
            if (h.id == j.parentId) {
                $.each(csJson3, function (n, m) {
                    if (m.parentId == j.id) {
                        d = m.totalScore;
                        var l = 0;
                        $.each(cdJson, function (p, o) {
                            if (m.id == o.parentIdType3 && o.isPass == 0) {
                                console.info(m.id + "-扣分", d);
                                l += d;
                                f++
                            }
                        });
                        l = l > d ? d : l;
                        g += l
                    }
                })
            }
        });
        if (g > e) {
            console.info("loseScoreType3=" + g + "超过最高值" + e + ",只扣" + e);
            g = e
        }
        c += g
    });
    b = (100 - c) > 0 ? 100 - c : 0;
    const a = {};
    a.loseScore = c;
    a.getScore = b;
    a.rectifyNum = f;
    return a
}

function saveFunc() {
    if (cdJson == null || cdJson.length == 0) {
        return false
    }
    console.info("保存隐患信息", cdJson);
    ajaxPostBatch("/api/saveCheckResult?uuid=" + uuid + "&reportCode=" + reportCode, cdJson);
    autoSave = false
}

var autoTime = 9;
setInterval(function () {
    if (autoSave) {
        if (autoTime >= 0) {
            $("#saveAll p").text("自动保存(" + autoTime + "秒)");
            autoTime--
        } else {
            saveFunc();
            autoSave = false;
            autoTime = 9;
            $("#saveAll p").text("保存记录")
        }
    } else {
        autoTime = 9;
        $("#saveAll p").text("保存记录")
    }
}, 1000);

function reOrderBy(a) {
    var b = [];
    var c = 0;
    $.each(csJson2, function (e, d) {
        $.each(a, function (g, f) {
            if (f.parentId === d.id) {
                b[c] = f;
                c++
            }
        })
    });
    return b
};
