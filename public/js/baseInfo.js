var navTag = "enterprise";
const enterpriseListDOM = $("#enterpriseListTpl");
const userListDOM = $("#userListTpl");
const enterpriseInfoDOM = $("#enterpriseInfo");
const userInfoDOM = $("#userInfo");
const enterpriseListTpl = enterpriseListDOM.html();
const userListTpl = userListDOM.html();
const enterpriseInfoTpl = enterpriseInfoDOM.html();
const userInfoTpl = userInfoDOM.html();
var enterpriseJson = getBaseInfo("/api/getBaseInfo", "enterprise", {});
var adminJson = getBaseInfo("/api/getBaseInfo", "admin", {});
layui.use("laytpl", function () {
    const a = layui.laytpl;
    a(enterpriseListTpl).render(enterpriseJson, function (b) {
        enterpriseListDOM.html(b).show()
    });
    a(userListTpl).render(adminJson, function (b) {
        userListDOM.html(b).show()
    });
    $(document).on("click", ".open-popup,.open-popup-full", function (f) {
        var c = $(this).attr("data-target");
        var d = $(this).attr("uuid");
        if (c === "enterprise-show") {
            var g = getObj(enterpriseJson.list, d);
            a(enterpriseInfoTpl).render(g, function (e) {
                enterpriseInfoDOM.html(e)
            })
        } else {
            if (c === "user-show") {
                var b = getObj(adminJson.list, d);
                a(userInfoTpl).render(b, function (e) {
                    userInfoDOM.html(e)
                })
            }
        }
    });
    $("#searchCancel").click(function () {
        if (navTag === "enterprise") {
            a(enterpriseListTpl).render(enterpriseJson, function (b) {
                enterpriseListDOM.html(b)
            })
        } else {
            if (navTag === "user") {
                a(userListTpl).render(adminJson, function (b) {
                    userListDOM.html(b)
                })
            }
        }
    });
    $("#search").submit(function (g) {
        var c = null;
        var f = null;
        var b = {};
        var d = $.trim($("#searchInput").val());
        // if (d === "") {
        //     return false
        // }
        if (navTag === "enterprise") {
            c = enterpriseListTpl;
            f = enterpriseListDOM;
            qpLoad("搜索中...");
            b = getBaseInfo("/api/getBaseInfo", "enterprise", {key: d});
            qpClose()
        } else {
            if (navTag === "user") {
                c = userListTpl;
                f = userListDOM;
                b.list = [];
                $.each(adminJson.list, function (e, h) {
                    if (h.fullName.indexOf(d) !== -1 || h.phone.indexOf(d) !== -1) {
                        b.list.push(h)
                    }
                })
            }
        }
        a(c).render(b, function (e) {
            f.html(e)
        });
        return false
    })
});
weui.searchBar("#searchBar");

function getBaseInfo(b, a, c) {
    b += "?act=" + a;
    return ajaxGet(b, c, false, "post")
}

function getObj(b, c) {
    var a = {};
    $.each(b, function (d, e) {
        if (e.uuid == c) {
            a = e;
            return false
        }
    });
    return a
}

weui.tab("#tab", {
    defaultIndex: 0, onChange: function (a) {
        if (a === 0) {
            navTag = "enterprise"
        } else {
            if (a === 1) {
                navTag = "user"
            }
        }
        console.log(navTag)
    }
});
