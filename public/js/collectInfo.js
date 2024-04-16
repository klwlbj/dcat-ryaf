var collectInfoJson = getCollectInfoList(checkTypeID);
var imgJson = getCollectImgList(uuid);
$(function () {
    setImgNum();
    $(document).on("click", ".collectInfor-images", function () {
        collectInforID = $(this).attr("collectInforID");
        var a = $(this).attr("data-target");
        a = a.indexOf("#") !== -1 ? a : "#" + a;
        layui.use("layer", function () {
            layer.open({
                title: "上传图片",
                type: 1,
                anim: 2,
                area: ["100%", "70%"],
                offset: "b",
                closeBtn: 1,
                shadeClose: true,
                shade: [0.8, "#000"],
                content: $(a),
                success: function (b, c) {
                    var d = "";
                    $.each(imgJson, function (e, g) {
                        // if (g.collectInforID == parseInt(collectInforID)) {
                            var f = g.imgUrl + "/" + g.imgName;
                            d += '<li class="weui-uploader__file" imgUuid="' + g.uuid + '" style="background-image:url(' + f + ')"></li>'
                        // }
                    });
                    $("#uploaderFiles").html(d);
                    updateImgNum()
                }
            })
        })
    });
    $(document).on("click", ".layui-layer-close1", function () {
        updateImgNum()
    })
});

function updateImgNum() {
    var a = $(".weui-uploader__file").length;
    $(".weui-uploader__info").text(a + "/" + 50);
    $("#imgNum").text(a)
}

function setImgNum() {
    $.each(collectInfoJson, function (b, c) {
        var a = 0;
        $.each(imgJson, function (e, d) {
            // if (c.id === d.collectInforID) {
                a++
            // }
        });
        $
        $("#imgNum").text(a)
    })
};
