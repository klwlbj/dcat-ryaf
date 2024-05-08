const userCheckResult_DOM = $("#checkResult");
const userCheckResult_TPL = userCheckResult_DOM.html();
const checkResultJson = ajaxGet("/api/findUserCheckResult", {}, false, "post");
var laytpl;
$(function () {
    weui.searchBar("#searchBar");
    showList(checkResultJson);
    var a = new Date();
    var c = a.getFullYear() - 1;
    var d = a.getMonth() + 1;
    var b = a.getDate();
    new Mdate("searchInput", {beginYear: c, beginMonth: d, beginDay: b, format: "-"});
    $("#searchCancel").click(function () {
        $("#searchInput").val("");
        showList(checkResultJson)
    });
    $(document).on("click", ".open-popup-checkResult", function () {
        var e = $("#searchInput").val();
        var g = $(this).attr("checkUser");
        var h = $(this).attr("fullName") + " 排查数据";
        var f = "userCheckResult?checkUser=" + g + "&reportTime=" + e;
        layer.open({
            title: h,
            type: 2,
            anim: 2,
            area: ["99%", "100%"],
            offset: "b",
            closeBtn: 1,
            shadeClose: true,
            shade: [0.8, "#000"],
            content: f
        })
    })
});

function showList(a) {
    layui.use("laytpl", function () {
        layui.laytpl(userCheckResult_TPL).render(a, function (b) {
            userCheckResult_DOM.html(b).show()
        })
    })
}

function sureBtnBack() {
    qpLoad("查询中...");
    var a = $("#searchInput").val();
    var c = {reportTime: a};
    var b = ajaxGet("/api/findUserCheckResult", c, false, "post");
    showList(b);
    qpClose()
};
