(function () {
    var s = document;
    var c = function (d) {
        var u = s.createElement("link");
        u.rel = "stylesheet";
        u.type = "text/css";
        u.href = d;
        s.getElementsByTagName("head")[0].appendChild(u)
    };
    c("https://cdn.qiping.cn/fcms/lib/Mdate/Mdate.css");
    var i = {
        beginYear: 2000,
        beginMonth: 1,
        beginDay: 1,
        endYear: new Date().getFullYear(),
        endMonth: new Date().getMonth() + 1,
        endDay: new Date().getDate(),
        format: "YMD"
    };
    var e = "";
    var b = "";
    var g = "";
    var r = "";
    var o = "";
    var n = "";
    var j = "";
    var l = 1;
    var q = 1;
    var t = 1;
    var a = null;
    var h = null;
    var p = null;
    var m = null;
    var f = null;
    var k = function (d, u) {
        if (!u) {
            u = {}
        }
        this.id = d;
        this.selectorId = s.getElementById(this.id);
        this.acceptId = s.getElementById(u.acceptId) || s.getElementById(this.id);
        this.beginYear = u.beginYear || i.beginYear;
        this.beginMonth = u.beginMonth || i.beginMonth;
        this.beginDay = u.beginDay || i.beginDay;
        this.endYear = u.endYear || i.endYear;
        this.endMonth = u.endMonth || i.endMonth;
        this.endDay = u.endDay || i.endDay;
        this.format = u.format || i.format;
        this.dateBoxShow()
    };
    k.prototype = {
        constructor: k, dateBoxShow: function () {
            var d = this;
            d.selectorId.onclick = function () {
                document.activeElement.blur();
                d.createDateBox();
                d.dateSure()
            }
        }, createDateBox: function () {
            var u = this;
            MdatePlugin = s.getElementById("MdatePlugin");
            if (!MdatePlugin) {
                g = s.createElement("div");
                g.id = "MdatePlugin";
                s.body.appendChild(g);
                MdatePlugin = s.getElementById("MdatePlugin")
            }
            MdatePlugin.setAttribute("class", "slideIn");
            u.createDateUi();
            var w = s.getElementById("yearUl");
            var d = s.getElementById("monthUl");
            var v = s.getElementById("dayUl");
            w.innerHTML = u.createDateYMD("year");
            u.initScroll();
            u.refreshScroll()
        }, createDateUi: function () {
            var d = '<section class="getDateBg"></section><section class="getDateBox" id="getDateBox"><div class="choiceDateTitle"><button id="dateCancel">取消</button><button id="dateSure" class="fr">确定</button></div><div class="dateContent"><div class="checkeDate"></div><div id="yearwrapper"><ul id="yearUl"></ul></div><div id="monthwrapper"><ul id="monthUl"></ul></div><div id="daywrapper"><ul id="dayUl"></ul></div></div></section>';
            MdatePlugin.innerHTML = d
        }, createDateYMD: function (v) {
            var y = this;
            var A = "<li>&nbsp;</li>";
            var x = null, z = null, d = "年", w = "data-year";
            if (v == "year") {
                x = y.beginYear;
                z = y.endYear
            }
            if (v == "month") {
                d = "月";
                w = "data-month";
                x = y.beginMonth;
                z = 12;
                if (o != y.beginYear) {
                    x = 1
                }
                if (o == i.endYear) {
                    z = y.endMonth
                }
            }
            if (v == "day") {
                d = "日";
                w = "data-day";
                x = 1;
                z = new Date(o, n, 0).getDate();
                if (o == y.beginYear && n == y.beginMonth) {
                    x = y.beginDay
                }
                if (o == y.endYear && n == y.endMonth) {
                    z = y.endDay
                }
            }
            for (var u = x; u <= z; u++) {
                A += "<li " + w + "=" + u + ">" + y.dateForTen(u) + d + "</li>"
            }
            return A + "<li>&nbsp;</li>"
        }, initScroll: function () {
            var d = this;
            p = new iScroll("yearwrapper", {
                snap: "li", vScrollbar: false, onScrollEnd: function () {
                    l = Math.ceil(this.y / 40 * -1 + 1);
                    o = yearUl.getElementsByTagName("li")[l].getAttribute("data-year");
                    monthUl.innerHTML = d.createDateYMD("month");
                    m.refresh();
                    try {
                        n = monthUl.getElementsByTagName("li")[q].getAttribute("data-month")
                    } catch (u) {
                        return true
                    }
                    dayUl.innerHTML = d.createDateYMD("day");
                    f.refresh();
                    try {
                        j = dayUl.getElementsByTagName("li")[t].getAttribute("data-day")
                    } catch (u) {
                        return true
                    }
                }
            });
            m = new iScroll("monthwrapper", {
                snap: "li", vScrollbar: false, onScrollEnd: function () {
                    q = Math.ceil(this.y / 40 * -1 + 1);
                    if (q == 1 && o != d.beginYear) {
                        n = 1
                    } else {
                        n = monthUl.getElementsByTagName("li")[q].getAttribute("data-month")
                    }
                    dayUl.innerHTML = d.createDateYMD("day");
                    f.refresh();
                    try {
                        j = dayUl.getElementsByTagName("li")[t].getAttribute("data-day")
                    } catch (u) {
                        return true
                    }
                }
            });
            f = new iScroll("daywrapper", {
                snap: "li", vScrollbar: false, onScrollEnd: function () {
                    t = Math.ceil(this.y / 40 * -1 + 1);
                    if (t == 1 && n != d.beginMonth) {
                        j = 1
                    } else {
                        j = dayUl.getElementsByTagName("li")[t].getAttribute("data-day")
                    }
                }
            })
        }, refreshScroll: function () {
            var v = this;
            var u = v.acceptId.getAttribute("data-year");
            var d = v.acceptId.getAttribute("data-month");
            var w = v.acceptId.getAttribute("data-day");
            u = u || v.beginYear;
            d = d || v.beginMonth;
            w = w || v.beginDay;
            a = v.beginMonth;
            h = v.beginDay;
            if (u != v.beginYear && a != 1) {
                a = 1
            }
            if (d != v.beginMonth && h != 1) {
                h = 1
            }
            u -= v.beginYear;
            d -= a;
            w -= h;
            p.refresh();
            p.scrollTo(0, u * 40, 300, true);
            m.scrollTo(0, d * 40, 300, true);
            f.scrollTo(0, w * 40, 300, true)
        }, dateSure: function () {
            var d = this;
            var v = s.getElementById("dateSure");
            var u = s.getElementById("dateCancel");
            v.onclick = function () {
                if (d.format == "YMD") {
                    d.acceptId.value = o + "年" + n + "月" + j + "日"
                } else {
                    d.acceptId.value = o + d.format + d.dateForTen(n) + d.format + d.dateForTen(j)
                }
                d.acceptId.setAttribute("data-year", o);
                d.acceptId.setAttribute("data-month", n);
                d.acceptId.setAttribute("data-day", j);
                d.dateCancel();
                sureBtnBack()
            };
            u.onclick = function () {
                d.dateCancel()
            }
        }, dateForTen: function (d) {
            if (d < 10) {
                return "0" + d
            } else {
                return d
            }
        }, dateCancel: function () {
            MdatePlugin.setAttribute("class", "slideOut");
            setTimeout(function () {
                MdatePlugin.innerHTML = ""
            }, 400)
        }
    };
    if (typeof exports !== "undefined") {
        exports.Mdate = k
    } else {
        window.Mdate = k
    }
})();
