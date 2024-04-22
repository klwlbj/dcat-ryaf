function submitLoad(a, b) {
    $(b).attr("disabled", true);
    setTimeout(function () {
        $(b).attr("disabled", false)
    }, 3000);
    qpLoad(a)
}

function qpLoad(a) {
    $.fn.tips({type: "loading", content: a})
}

function qpOk(a) {
    $.fn.tips({type: "ok", content: a})
}

function qpWarn(a) {
    $.fn.tips({content: a})
}

function qpError(a) {
    $.fn.tips({type: "error", content: a})
}

function qpError(b, a) {
    $.fn.tips({type: "error", content: b, time: a})
}

function qpClose() {
    $.fn.tips.close()
}

function laypageUtil(b, e, d, a, c) {
    layui.use(["laypage"], function () {
        var f = layui.laypage;
        f.render({
            elem: b,
            limit: e,
            curr: d,
            limits: [20, 50, 100, 200, 500],
            groups: 10,
            count: a,
            layout: ["prev", "page", "next", "count", "limit", "limits"],
            jump: function (g, h) {
                if (!h) {
                    c += "page=" + g.curr;
                    c += "&pageSize=" + g.limit;
                    window.location.href = c
                }
            }
        })
    })
}

function ajaxPost(a, b, c) {
    $.ajax({
        url: a,
        type: "post",
        data: b,
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        success: function (d) {
            if (d.status == 200) {
                qpOk(d.msg);
                if (c) {
                    setTimeout("location.reload()", 500)
                }
            } else {
                qpError(d.msg)
            }
        },
        error: function (d, e) {
            qpError("操作失败！")
        }
    })
}

function ajaxPostAsync(a, b) {
    var c = {status: 500};
    $.ajax({
        url: a, type: "post", async: false, data: b, dataType: "json", success: function (d) {
            c = d
        }
    });
    return c
}

function ajaxPostBatch(a, b) {
    qpLoad("保存中...");
    $.ajax({
        url: a,
        type: "post",
        async: false,
        data: JSON.stringify(b),
        dataType: "json",
        contentType: "application/json;charset=utf-8",
        success: function (c) {
            if (c.status == 200) {
                qpOk(c.msg)
            } else {
                qpError(c.msg)
            }
        }
    })
}

function ajaxGet(a, d, c, b) {
    var e = "";
    $.ajax({
        url: a,
        async: c,
        type: b,
        data: d,
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        success: function (f) {
            e = f
        },
        error: function (f, g) {
            qpError("获取数据失败！")
        }
    });
    return e
}

function ajaxDel(a, b, c, d) {
    layer.confirm("确认要删除吗？删除后无法恢复！", function (e) {
        layer.close(e);
        $.ajax({
            url: a,
            async: true,
            type: "post",
            data: b,
            dataType: "json",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            success: function (f) {
                if (f.status == 200) {
                    qpOk("删除成功");
                    if (d != null) {
                        $(d).parents("tr").remove()
                    }
                    if (c) {
                        setTimeout("location.reload()", 500)
                    }
                } else {
                    qpWarn(f.msg)
                }
            },
            error: function (f, g) {
                qpError("删除失败！")
            }
        })
    })
}

function ajaxSaveClose(a, c, b) {
    $.ajax({
        url: a,
        type: "post",
        data: c,
        dataType: "json",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        success: function (d) {
            if (d.status == 200) {
                qpOk("保存成功");
                xadmin.close();
                if (b) {
                    xadmin.father_reload()
                }
            } else {
                qpWarn(d.msg)
            }
        },
        error: function (d, e) {
            qpError("保存失败！")
        }
    })
}

function getCommunityList(e, f, d) {
    var a = ADMIN_ROOT + "api/getCommunityList";
    var c = ajaxGet(a, {}, false, "post");
    var b = "";
    if (d != null) {
        b += '<option value="">' + d + "</option>"
    }
    $.each(c, function (g, i) {
        var h = i == f ? "selected" : "";
        b += '<option value="' + i + '" ' + h + ">" + i + "</option>"
    });
    $(e).html(b)
}

function getCheckStatusList(e, f, d) {
    var a = ADMIN_ROOT + "api/getCheckStatusList";
    var c = ajaxGet(a, {}, false, "post");
    var b = "";
    if (d != null) {
        b += '<option value="0">' + d + "</option>"
    }
    $.each(c, function (g, i) {
        var h = i.id == f ? "selected" : "";
        b += '<option value="' + i.id + '" ' + h + ">" + i.name + "</option>"
    });
    $(e).html(b)
}

function getCheckTypeList(e, f, d) {
    var a = ADMIN_ROOT + "api/getCheckTypeList";
    var c = ajaxGet(a, {}, false, "post");
    var b = "";
    if (d != null) {
        b += '<option value="0">' + d + "</option>"
    }
    $.each(c, function (g, i) {
        var h = i.id == f ? "selected" : "";
        b += '<option value="' + i.id + '" ' + h + ">" + i.name + "</option>"
    });
    $(e).html(b)
}

function getProjectList(e, f, d) {
    var a = "/api/getProjectList";
    var c = ajaxGet(a, {}, false, "post");
    var b = "";
    if (d != '') {
        b += '<option value="0">' + d + "</option>"
    }
    $.each(c, function (g, i) {
        var h = i.id == f ? "selected" : "";
        b += '<option value="' + i.id + '" ' + h + ">" + i.name + "</option>"
    });
    $(e).html(b)
}

function getEnterprise(b) {
    var a = ADMIN_ROOT + "api/getEnterprise";
    return ajaxGet(a, {uuid: b}, false, "post")
}

function getNewJson(c, d) {
    if (c.length > 0) {
        var a = [{}];
        var b = 0;
        $.each(c, function (f, e) {
            if (e.type == d) {
                a[b] = e;
                b++
            }
        });
        return a
    }
    return null
}

function getLocalTime(b) {
    var a = new Date(b + 8 * 3600 * 1000);
    return a.toJSON().substr(0, 10).replace("T", " ")
}

function qpTrim(a) {
    var b = $(a).val().replace(/[, ]/g, "");
    b = b.replace(/\s*/g, "");
    b = b.replace(/\t/g, "");
    $(a).val(b)
}

function entAllPhoto(d) {
    var b = {};
    b.title = "企业全部图片";
    b.id = 1;
    b.start = 0;
    b.data = [];
    var a = ADMIN_ROOT + "api/getCollectImgList";
    var c = ajaxGet(a, {uuid: d}, false, "post");
    $.each(c, function (e, g) {
        var f = {};
        f.alt = "企业图片" + (e + 1);
        f.pid = +(e + 1);
        f.src = g.imgUrl + "/" + g.imgName;
        f.thumb = g.imgUrl + "/" + g.imgName;
        f.uuid = g.uuid;
        b.data.push(f)
    });
    console.info(b);
    layer.photos({photos: b})
}

function layuiDelImg(a) {
    layer.confirm("确认要删除吗？删除后无法恢复！", function (c) {
        layer.close(c);
        var b = "../upload/imageDel";
        $.ajax({
            url: b,
            async: true,
            type: "post",
            cache: false,
            data: {imgUuid: a},
            dataType: "json",
            success: function (d) {
                if (d.status == 200) {
                    alert(d.msg)
                } else {
                    alert(d.msg)
                }
            },
            error: function (d, e) {
                alert("删除失败！")
            }
        })
    })
}

function changefontsize() {
    var a = document.getElementsByTagName("html")[0];
    var c = a.offsetWidth >= 750 ? 750 : a.offsetWidth;
    a.style.fontSize = c * 100 / 750 + "px";
    if (typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function") {
        b()
    } else {
        if (document.addEventListener) {
            document.addEventListener("WeixinJSBridgeReady", b, false)
        } else {
            if (document.attachEvent) {
                document.attachEvent("WeixinJSBridgeReady", b);
                document.attachEvent("onWeixinJSBridgeReady", b)
            }
        }
    }

    function b() {
        WeixinJSBridge.invoke("setFontSizeCallback", {fontSize: 0});
        WeixinJSBridge.on("menu:setfont", function () {
            WeixinJSBridge.invoke("setFontSizeCallback", {fontSize: 0})
        })
    }
}

changefontsize();
window.onresize = changefontsize;
