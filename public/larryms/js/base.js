layui.extend({larryms: "lib/larryms"}).define(["jquery", "configure", "layer", "larryms"], function (e) {
    "use strict";
    var s = layui.$,
        o = layui.configure,
        c = layui.layer,
        d = layui.device(),
        r = s(window),
        u = layui.larryms;
    var a = new Function;
    var i = {
        forms: "larry/modules/forms",
        larryms: "lib/larryms",
        larryTab: "lib/larryTab",
        larryElem: "lib/larryElem",
        larryMenu: "lib/larryMenu",
        larryajax: "lib/larryajax",
        larryEditor: "lib/larryEditor",
        larryApi: "lib/larryApi",
        larryTree: "lib/larryTree",
        larrySecret: "lib/larrySecret",
        face: "lib/face",
        xss: "lib/xss",
        wangEditor: "lib/extend/we/wangEditor",
        echarts: "lib/extend/echarts",
        echartStyle: "lib/extend/echartStyle",
        md5: "lib/extend/md5",
        base64: "lib/extend/base64",
        fullPage: "lib/extend/fullPage", 
        geetest: "lib/extend/geetest",
        classie: "lib/extend/classie",
        snapsvg: "lib/extend/svg/snapsvg",
        svgLoader: "lib/extend/svg/svgLoader",
        clipboard: "lib/extend/clipboard",
        swiper: "lib/extend/swiper/swiper",
        ckplayer: "lib/extend/ckplayer/ckplayer",
        countup: "lib/extend/countup",
        qrcode: "lib/extend/qrcode",
        jqui: "lib/extend/jqueryui/jqui", 
        ueconfig: "lib/extend/ueditor/ueconfig",
        neconfig: "lib/extend/neditor/neconfig",
        nebase: "lib/extend/neditor/nebase",
        ueditor: "lib/extend/ueditor/ueditor",
        neditor: "lib/extend/neditor/neditor",
        fullpages: "lib/extend/fullpage/fullpages", 
        tinymce: "lib/extend/tinymce/tinymce",
        ckeditor: "lib/extend/ckeditor/ckeditor",
        modernizr: "lib/modernizr",
    };
    a.prototype.modules = function () {
        for (var e in i) {
            layui.modules[e] = i[e];
        }
    }();
    if (o.thirdExtend == true) {
        var l = o.basePath + o.thirdDir + "conf.json";
        s.ajaxSettings.async = false;
        s.getJSON(l, function (e) {
            for (var r in e) {
                layui.modules[r] = o.thirdDir + e[r];
            }
        });
        s.ajaxSettings.async = true;
    }
    window.larrymsExtend = true;
    layui.cache.extendStyle = o.basePath + "lib/extendStyle/";
    var y = o.modules + o.modsname;
    if (o.uploadUrl) {
        layui.cache.neUploadUrl = o.uploadUrl;
    } else {
        layui.cache.neUploadUrl = "";
    }
    if (o.upvideoUrl) {
        layui.cache.neVideoUrl = o.upvideoUrl;
    } else {
        layui.cache.neVideoUrl = "";
    }
    
    function f() {
        var e = r.width();
        if (e >= 1200) {
            return 3;
        } else if (e >= 992) {
            return 2;
        } else if (e >= 768) {
            return 1;
        } else {
            return 0;
        }
    }
    
    a.prototype.init = function () {
        var e = this;
        u.debug = o.debug;
        if (o.browserCheck) {
            if (d.ie && d.ie < 8) {
                c.alert("本系统最低支持ie8，您当前使用的是古老的 IE" + d.ie + "  建议使用IE9及以上版本的现代浏览器", {title: u.tit[0], skin: "larry-debug", icon: 2, resize: false, zIndex: c.zIndex, anim: Math.ceil(Math.random() * 6)});
            }
            if (d.ie) {
                s("body").addClass("larryms-ie-hack");
            }
        }
        u.screen = f();
        if (o.fontSet) {
            if (o.font !== "larry-icon") {
                layui.link(layui.cache.base + "css/fonts/larry-icon.css");
            }
            u.fontset({font: o.font, url: o.fontUrl, online: o.fontSet});
        } else {
            layui.link(layui.cache.base + "css/fonts/larry-icon.css");
        }
        if (window.top === window.self) {
            layui.use(["larrySecret", "md5"], function () {
                var e = layui.larrySecret, r = layui.md5;
                var a = e.userKey;
                if (o.grantUser && o.grantKey) {
                    var i = u.grantCheck(o.grantUser, o.grantKey, a);
                    if (!i) {
                        console.log("您需要检查授权参数是否正确配置");
                        return false;
                    }
                } else {
                    console.log("请检查配置文件必填参数");
                    return false;
                }
            });
        }
        if (layui.cache.page) {
            layui.cache.page = layui.cache.page.split(",");
            if (s.inArray("larry", layui.cache.page) === -1) {
                var r = {};
                for (var a = 0; a < layui.cache.page.length; a++) {
                    r[layui.cache.page[a]] = y + layui.cache.page[a];
                }
                layui.extend(r);
                layui.use(layui.cache.page);
            }
        }
        if (o.basecore !== "undefined") {
            var i = o.basecore.split(",");
            var l = {};
            for (var a = 0; a < i.length; a++) {
                l[i[a]] = o.modules + i[a];
            }
            layui.extend(l);
            layui.use(o.basecore);
        }
        if (o.modscore) {
            if (layui.cache.modscore == false) {
                return false;
            }
            var n = o.corename.split(",");
            var t = {};
            for (var a = 0; a < n.length; a++) {
                t[n[a]] = y + n[a];
            }
            layui.extend(t);
            layui.use(o.corename);
        }
    }();
    window.onresize = function () {
        u.screen = f();
    };
    e("larry", {});
});