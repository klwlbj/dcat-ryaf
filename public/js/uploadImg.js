var progressMax = 98;
$(function () {
    var c = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
    var d = 10 * 1024 * 1024;
    var a = 300;
    var b = 50;
    $("#uploadImg").on("change", function (k) {
        var j = k.target.files;
        if (j.length === 0) {
            return
        }
        for (var h = 0, f = j.length; h < f; h++) {
            var g = j[h];
            var e = new FileReader();
            if (c.indexOf(g.type) === -1) {
                qpError("该类型不允许上传");
                continue
            }
            if (g.size > d) {
                qpError("图片太大，不允许上传");
                continue
            }
            if ($(".weui-uploader__file").length >= b) {
                qpError("最多只能上传" + b + "张图片");
                return
            }
            var l = createUuid();
            compressPicUpload(g, 1000, l);
            e.onload = function (m) {
                var i = new Image();
                i.onload = function () {
                    var u = Math.min(a, i.width);
                    var q = i.height * (u / i.width);
                    var o = document.createElement("canvas");
                    var v = o.getContext("2d");
                    o.width = u;
                    o.height = q;
                    v.drawImage(i, 0, 0, u, q);
                    var s = o.toDataURL("image/png", 0.6);
                    var p = $('<li class="weui-uploader__file weui-uploader__file_status" id="' + l + '" style="background-image:url(' + s + ')"><div class="weui-uploader__file-content">0%</div></li>');
                    $(".weui-uploader__files").append(p);
                    var r = $(".weui-uploader__file").length;
                    $(".weui-uploader__info").text(r + "/" + b);
                    var n = 0;

                    function t() {
                        p.find(".weui-uploader__file-content").text(++n + "%");
                        if (n < progressMax) {
                            setTimeout(t, 30)
                        } else {
                        }
                    }

                    setTimeout(t, 30)
                };
                i.src = m.target.result
            };
            e.readAsDataURL(g)
        }
    })
});

function ajaxUplaod(b, d) {
    var a = "/api/uploadImage";
    a += "?uuid=" + uuid;
    a += "&collectInforID=" + collectInforID;
    a += "&checkStandardID=" + checkStandardID;
    a += "&reportCode=" + reportCode;
    if (uuid == "" || (collectInforID == 0 && checkStandardID == 0)) {
        qpError("上传参数丢失，请重新刷新页面");
        return 500
    }
    var c = new FormData();
    c.append("files", b);
    $.ajax({
        url: a,
        async: true,
        type: "post",
        cache: false,
        data: c,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (e) {
            console.log("上传服务器返回：", e);
            if (e.status == 200) {
                progressMax = 100;
                $(".weui-uploader__file-content").text("100%");
                qpOk("上传成功");
                $("#" + d).attr("imguuid", e.imgUuid);
                newImgJson(e)
            } else {
                qpError(e.msg);
                setTimeout(function () {
                    $("#uploaderFiles .weui-uploader__file-content").text("0%")
                }, 2000)
            }
        },
        error: function (e, f) {
            qpError("网络错误，请稍候再重试")
        }
    });
    return 200
}

function delImg(c, b) {
    var a = "/api/deleteImage";
    $.ajax({
        url: a,
        async: true,
        type: "post",
        cache: false,
        data: {imgUuid: c},
        dataType: "json",
        success: function (d) {
            if (d.status == 200) {
                qpOk(d.message);
                b.remove();
                delImgAccess(d.imgName)
            } else {
                qpError(d.message)
            }
        }
    });
    return 200
}

function newImgJson(b) {
    var a = {};
    a.uuid = b.imgUuid;
    a.imgUrl = b.imgUrl;
    a.imgName = b.imgName;
    a.collectInforID = collectInforID;
    a.checkStandardID = checkStandardID;
    a.enterpriseUuid = uuid;
    imgJson[imgJson.length] = a
}

function delImgAccess(a) {
    $.each(imgJson, function (b, c) {
        if (typeof c !== "undefined" && a === c.imgName) {
            imgJson.splice(b, 1)
        }
    })
}

function compressPicUpload(b, c, d) {
    var a = new FileReader();
    a.onload = function (g) {
        var f = new Image();
        f.onload = function () {
            var i = Math.min(c, f.width);
            var k = f.height * (i / f.width);
            var j = document.createElement("canvas");
            var e = j.getContext("2d");
            j.width = i;
            j.height = k;
            e.drawImage(f, 0, 0, i, k);
            var l = j.toDataURL(b.type, 0.9);
            let blob = dataURLtoBlob(l);
            let miniFile = blobToFile(blob, b.name, b.type);
            ajaxUplaod(miniFile, d)
        };
        f.src = g.target.result
    };
    a.readAsDataURL(b)
}

function dataURLtoBlob(c) {
    var a = c.split(","), e = a[0].match(/:(.*?);/)[1], b = atob(a[1]), f = b.length, d = new Uint8Array(f);
    while (f--) {
        d[f] = b.charCodeAt(f)
    }
    return new Blob([d], {type: e})
}

function blobToFile(b, c, a) {
    return new window.File([b], c, {type: a})
}

function createUuid() {
    return (S4() + S4() + S4() + S4() + S4() + S4() + S4() + S4())
}

function S4() {
    return (((1 + Math.random()) * 65536) | 0).toString(16).substring(1)
};
