const userCheckResult_DOM = $("#checkResult");
const userCheckResult_TPL = userCheckResult_DOM.html();
const dfjson = ajaxGet("/api/findUserCheckEnterprise", data, false, "post");
$(function () {
    weui.searchBar("#searchBar");
    var a = new Date();
    var c = a.getFullYear() - 1;
    var d = a.getMonth() + 1;
    var b = a.getDate();
    new Mdate("searchInput", {beginYear: c, beginMonth: d, beginDay: b, format: "-"});
    showList(dfjson);
    $("#searchCancel").click(function () {
        $("#searchInput").val("");
        showList(dfjson)
    })
});

function showList(a) {
    layui.use(["laytpl"], function () {
        layui.laytpl(userCheckResult_TPL).render(a, function (b) {
            userCheckResult_DOM.html(b).show()
        })
    })
}

function sureBtnBack() {
    qpLoad("查询中...");
    var a = $("#searchInput").val();
    var c = {checkUser: checkUser, reportTime: a};
    var b = ajaxGet("/api/findUserCheckEnterprise", c, false, "post");
    showList(b);
    qpClose()
};
