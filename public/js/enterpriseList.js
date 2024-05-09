const enterpriseListDOM = $("#enterpriseListTpl");
const enterpriseListTpl = enterpriseListDOM.html();
var enterpriseJson = ajaxGet("/api/getEnterpriseList", {typeId: typeId}, false, "post");
$(function () {
    weui.searchBar("#searchBar");
    layui.use("laytpl", function () {
        layui.laytpl(enterpriseListTpl).render(enterpriseJson, function (a) {
            enterpriseListDOM.html(a).show()
        })
    });
    $("#search").submit(function (c) {
        var b = $.trim($("#searchInput").val());
        // if (b === "") {
        //     return false
        // }
        var a = ajaxGet("/api/getEnterpriseList", {typeId: typeId, key: b}, false, "post");
        layui.use("laytpl", function () {
            layui.laytpl(enterpriseListTpl).render(a, function (d) {
                enterpriseListDOM.html(d)
            })
        });
        return false
    });
    $("#searchCancel").click(function () {
        laytpl(enterpriseListTpl).render(enterpriseJson, function (a) {
            enterpriseListDOM.html(a)
        })
    })
});
