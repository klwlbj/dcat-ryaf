if (typeof (typeId) != "undefined") {
    var url = "/api/getCheckStandard", jsonData = {typeId: typeId};
    showCsInfo(getCheckStandard(url, "info", jsonData))
} else {
    layui.use("laytpl", function () {
        var b = getCheckStandard("/api/getCheckStandard", "list", {});
        var a = $("#checkStandardTpl");
        var c = a.html();
        layui.laytpl(c).render(b, function (d) {
            a.html(d).show()
        })
    })
}

function showCsInfo(b) {
    var a = "";
    var c = 0;
    $.each(b.list, function (f, e) {
        if (e.type == 1) {
            c++;
            a += '<tr class="fms-bg-gray-t">';
            a += '<th colspan="2"><p>' + c + "、" + e.title + "(" + e.totalScore + "分)</p></th>";
            a += "</tr>";
            a += '<tr class="fms-bg-gray">';
            a += "<th>检查内容</th>";
            a += "<th>检查标准</th>";
            a += "</tr>";
            var d = 0;
            $.each(b.list, function (i, h) {
                if (h.type == 2 && h.parentId == e.id) {
                    d++;
                    a += "<tr>";
                    a += "<td>" + d + "、" + h.content + "</td>";
                    a += "<td>";
                    var g = 0;
                    $.each(b.list, function (k, j) {
                        if (j.type == 3 && j.parentId == h.id && h.parentId == e.id) {
                            g++;
                            a += "<p>" + g + "、" + j.content + "</p>"
                        }
                    });
                    a += "</td>";
                    a += "</tr>"
                }
            })
        }
    });
    $(".fms-table").html(a)
};
