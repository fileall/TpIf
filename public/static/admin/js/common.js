
layui.use(['layer'], function () {
    layer = layui.layer;
    layer.config({
        extend: 'skins/style.css', //加载新皮肤
        skin: 'layer-ext-myskin', //一旦设定，所有弹层风格都采用此主题。
    });
});
//$.extend({
//	//  获取对象的长度，需要指定上下文 this
//	Object:     {
//		count: function( p ) {
//			p = p || false;
//			return $.map( this, function(o) {
//				if( !p ) return o;
//				return true;
//			} ).length;
//		}
//	}
//});
//显示成功信息
function _ok(msg) {
    top.layer.open({title: '成功提示', content: msg, icon: 1});
};

//报错信息
function _error(msg) {
    top.layer.open({title: '错误提示', content: msg, icon: 7});
};

//提示框
function _alert(msg, icon, title) {
    var icon = icon || 0, title = title || "系统提示";
    return top.layer.alert(msg, {skin: 'layui-layer-molv', closeBtn: 0, icon: icon, title: title});
};

//弹窗默认的回调整，会执行子窗口的 api_back()
function win_callback(frame, index, that) {
    if (typeof frame.api_back != 'function') return !0;
    return frame.api_back(index, frame);
};

//重新加载子首页主要内容窗口
function reload_main_frame() {
    try {
        top.$("#reload").click();
    } catch (e) {
    }
};

//刷新当前页面
function reload() {
    location.reload();
};

//移除数据行
function remove_data_line(that, index) {
    if ($(that).data('parent')) {
        $(that).parents($(that).data('parent')).remove();
    } else {
        $(that).parent().remove();
    }
}

//省市区联动
$(document).on('change', 'select[event="loadRegion"]', function () {
    var url = $(this).prevAll("input[event='region_id']").attr("uri"),
        hidden_id = $(this).prevAll("input[name='hidden_id']").val(),
        type = 1,
        id = $(this).val();
    $(this).nextAll().children("option[value!=0]").remove();
    if (id == 0) {
        var region_id = $(this).prev("select[event='loadRegion']").val();
        return $(this).prevAll("input[event='region_id']").val(region_id);
    }
    ;
    $(this).prevAll("input[event='region_id']").val(id);
    var _this = $(this);
    $(this).find("option[value='" + id + "']").attr("selected", true);
    $.getJSON(url, {id: id, type: type, hidden_id: hidden_id},
        function (data) {
            if (data) {
                $(_this).next("select[event='loadRegion']").children().remove();
            }
            ;
            $.each(data, function (idx, item) {
                $("<option value=" + item.region_id + ">" + item.region_name + "</option>").appendTo($(_this).next("select[event='loadRegion']"));
            });
        });
});
//城市信息异步加载
$(document).on('mouseover', 'select[event="loadRegion"]', function () {
    if ($(this).find("option").size() > 1) {
        return;
    }
    var url = $(this).prevAll("input[event='region_id']").attr("uri");
    var type = 0;
    var id = $(this).val();
    if ($(this).prev().attr("event") == "loadRegion" && $(this).val() == 0) {
        id = $(this).prev().val();
        if (id == 0) return;
        type = 1;
    }
    var _self = this;
    $.getJSON(url, {id: id, type: type},
        function (data) {
            if (data.num != 0) {
                $(_self).children().remove();
                $.each(data, function (idx, item) {
                    $(_self).append("<option value=" + item.region_id + ">" + item.region_name + "</option>");
                });
                if (id != 0) {
                    $(_self).find("option[value='" + id + "']").attr("selected", true);
                }
            }
        }
    );
});
//查看实体类型信息
$(document).on("click", "*[event='entity']", function () {
    var type = $(this).attr("entity_type");
    var id = $(this).attr("entity_id");
    var title = $(this).attr("title") ? $(this).attr("title") : $(this).text() + '详情';
    if (isNaN(type) || isNaN(id)) {
        _error('参数不正确，查看失败!');
    } else {
        var url = rootpath + 'Login/Entity/info.html';
        url += (url.indexOf("?") > 0 ? "&" : "?") + "type=" + type + "&id=" + id;
        top.layer.open({
            type: 2,
            title: title,
            area: ["600px", "400px"],
            content: url,
        });
    }
});
$(function () {
    $("*[event='preview']").click(function () {
        var url = $(this).data("uri") ? $(this).data("uri") : $(this).attr("src"),
            title = $(this).data('title') ? $(this).data('title') : '图片预览';
        layer.open({
            type: 1,
            title: title,
            closeBtn: 0,
            shadeClose: true,
            content: '<img src="' + url + '">',
        });
    });
    $("*[event='del']").click(function () {  console.log(3424);
        var _this = $(this);
        var data = $(_this).data();
        layer.msg(data.msg ? data.msg : '你确定执行此操作吗？', {
            time: 0
            , shade: [0.4, 'rgb(0, 0, 0)']
            , btn: [data.btn1 ? data.btn1 : '确定', data.btn2 ? data.btn2 : '考虑一下']
            , yes: function (index) {
                layer.close(index);
                layer.load(1);
                $.ajax({
                    type: "POST",
                    data: {ids: data.id},
                    url: data.uri,
                    success: function (e) {
                        layer.closeAll();
                        if (e.status == 1) {
                            layer.alert(e.info, {icon: 6});
                            if(e.url){
                                window.location = e.url;
                            }else{
                                setTimeout(function () {
                                    location.reload();
                                }, 2000)
                            }
                        } else {
                            layer.msg(e.info, {icon: 5});
                        }
                    }
                });
            }
        });
    });
    $("*[event='del_all']").click(function () {
        var _this = $(this);
        var data = $(_this).data();
        var ids = [];
        if ($("input[name='" + data.obj + "']:checked").size() == 0) {
            layer.msg('请选择要操作的数据', {icon: 5});
            return false;
        }
        $("input[name='" + data.obj + "']:checked").each(function () {
            ids.push($(this).val());
        });
        layer.msg(data.msg ? data.msg : '你确定执行此操作吗？', {
            time: 0
            , btn: [data.btn1 ? data.btn1 : '确定', data.btn2 ? data.btn2 : '考虑一下']
            , yes: function (index) {
                layer.close(index);
                layer.load(1);
                $.ajax({
                    type: "POST",
                    data: {ids: ids},
                    url: data.uri,
                    success: function (e) {
                        layer.closeAll();
                        if (e.status == 1) {
                            layer.alert(e.info, {icon: 6});
                            setTimeout(function () {
                                location.reload();
                            }, 2000)
                        } else {
                            layer.msg(e.info, {icon: 5});
                        }
                    }
                });
            }
        });
    });
    //获取地址位置 [百度]
    $("*[event='bdgps']").click(function () {
        var a = $(this).data();
        var address = "";
        $(a.region).find("select").each(function (i, obj) {
            if ($(obj).val() > 0) address += (!address ? "" : " ") + $(obj).find("option:selected").text();
        });
        if (!!$(a.address).val()) {
            address += (!address ? "" : " ") + $(a.address).val();
        }
        if (a.skip != "1" && address == "") {
            top.layer.msg('请先选择地区', {shade: 0.3});
            return;
        }
        var url = "/index.html/admin/map/getgps.html";
        var lng = $(a.lng).val();
        var lat = $(a.lat).val();
        url += (url.indexOf("?") != -1 ? "&" : "?") + "address=" + address + "&lng=" + lng + "&lat=" + lat;
        top.layer.open({
            type: 2, title: a.title || '设置GPS位置(无红点双击)', content: url,
            area: ['615px', '610px'],
            btn: ['确定', '取消'],
            yes: function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                var b = iframeWin.dosubmit();
                if (!b) {
                    top.layer.msg("请点击地图选择您的经纬度");
                } else {
                    $(a.lng).val(b.lng);
                    $(a.lat).val(b.lat);
                    top.layer.close(index);
                }
            }, btn2: function (index, layero) {
                top.layer.close(index);
            }
        });
    });

    //选择字体
    $("*[event='iconfont']").click(function () {
        var a = $(this).data();
        var uri = a.uri || "/index.html/Public/icon.html";
        top.layer.open({
            type: 2, title: a.title || '选择图标', content: uri,
            area: ['730px', '500px'],
            btn: ['确定', '取消'],
            maxmin: 1,
            yes: function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                var icon = iframeWin.dosumit();
                if (icon == "") {
                    top.layer.msg("请先选择图标");
                } else {
                    $(a.input).val(icon);
                    $(a.show).html(icon);
                    top.layer.close(index);
                }
            }, btn2: function (index, layero) {
                top.layer.close(index);
            }
        });

    });

    //弹出窗口
    $("*[event='window']").click(function () {
        var url = $(this).data("uri");
        var title = $(this).data("title") ? $(this).data("title") : $(this).attr("title");
        art_ajax(title ? title : "详情", url, {padding: 0, ok: true, lock: true});
    });

    //弹出窗口2
    $("*[event='window2']").click(function () {
        var o = $(this);
        var a = $(o).data();
        var c = {
            type: 2,
            title: a.title || a.btn || '详情',
            content: a.uri,
            area: [(a.width || 600) + 'px', (a.height || 350) + 'px'],
            maxmin: a.maxmin || false,
            success: function (e, i) {
                if (a.auto) {
                    top.layer.iframeAuto(i)
                }
            }
        };
        if (a.btn) {
            c.btn = [a.btn, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                top.layer.close(index);
            }
        }
        top.layer.open(c);
    });
    //弹出窗口2
    $("*[event='window23']").click(function () {
        var o = $(this);
        var a = $(o).data();
        var c = {
            type: 2,
            title: a.title || a.btn || '详情',
            content: a.uri,
            area: [(a.width || 600) + 'px', (a.height || 350) + 'px'],
            maxmin: a.maxmin || false,
            success: function (e, i) {
                if (a.auto) {
                    top.layer.iframeAuto(i)
                }
            }
        };
        if (a.btn) {
            c.btn = [a.btn, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                top.layer.close(index);
            }
        }
        // top.layer.open(c);
        layer.open(c);
    });
    //弹出窗口2
    $("*[event='window22']").click(function () {
        var o = $(this);
        var a = $(o).data();
        var c = {
            type: 2,
            title: a.title || a.btn || '详情',
            content: a.uri,
            area: [(a.width || 600) + 'px', (a.height || 350) + 'px'],
            maxmin: a.maxmin || false,
            success: function (e, i) {
                if (a.auto) {
                    top.layer.iframeAuto(i)
                }
            }
        };
        if (a.btn && !a.btn2) {
            c.btn = [a.btn, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                top.layer.close(index);
            }
        }
        if (a.btn2) {
            c.btn = [a.btn, a.btn2, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback2) {
                    eval(a.callback2 + "(iframeWin, index)");
                } else {
                    top.layer.close(index);
                }
                return false;
            };
            c.btn3 = function (index, layero) {
                top.layer.close(index);
                return false;
            }
        }
        if (a.end) {
            c.end = function () {
                eval(a.end + "()");
            }
        }
        top.layer.open(c);
    });
    $("*[event='window3']").click(function () {
        var _this = $(this);
        var data = $(_this).data();
        var ids = [];
        if ($("input[name='" + data.obj + "']:checked").size() == 0) {
            layer.msg('请选择要操作的数据', {icon: 5});
            return false;
        }
        var ids = [];
        $("input[name='" + data.obj + "']:checked").each(function () {
            ids.push($(this).val());
        });
        var o = $(this);
        var a = $(o).data();
        var c = {
            type: 2,
            title: a.title || a.btn || '详情',
            content: a.uri + '?ids=' + ids.join(','),
            area: [(a.width || 600) + 'px', (a.height || 350) + 'px'],
            maxmin: a.maxmin || false,
            success: function (e, i) {
                if (a.auto) {
                    top.layer.iframeAuto(i)
                }
            }
        };
        if (a.btn) {
            c.btn = [a.btn, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                top.layer.close(index);
            }
        }
        top.layer.open(c);
    });

    //弹出窗口2
    $("*[event='winfull']").click(function () {
        var o = $(this);
        var a = $(o).data();
        var c = {
            type: 2, title: a.title || a.btn || '详情', content: a.uri,
            area: ['1100px', '600px'], maxmin: true, success: function (e, i) {
                top.layer.full(i);
            }
        };
        if (a.btn && !a.btn2) {
            c.btn = [a.btn, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                top.layer.close(index);
            }
        }
        if (a.btn2) {
            c.btn = [a.btn, a.btn2, '取消'];
            c.yes = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback) {
                    eval(a.callback + "(iframeWin,index)");
                } else {
                    if (win_callback(iframeWin, index, o)) {
                        top.layer.close(index);
                    }
                }
            };
            c.btn2 = function (index, layero) {
                var iframeWin = top.window[layero.find('iframe')[0]['name']];
                if (a.callback2) {
                    eval(a.callback2 + "(iframeWin, index)");
                } else {
                    top.layer.close(index);
                }
                return false;
            };
            c.btn3 = function (index, layero) {
                top.layer.close(index);
                return false;
            }
        }
        if (a.end) {
            c.end = function () {
                eval(a.end + "()");
            }
        }
        top.layer.open(c);
    });

//更新值
    $(document).on("blur", "input[event='update']", function () {
        var that = $(this);
        var data = $(that).data("data");
        var oval = $(that).data("val");
        var val = $(that).val();
        if (val == oval) return;
        if (data) data = eval("(" + data + ")");
        data.val = val;
        $.ajax({
            type: "post",
            url: $(that).data("uri"),
            data: data,
            success: function (res) {
                if (res.status == 1) {
                    $(that).data("val", data.val);
                } else {
                    $(that).val(oval);
                }
            }
        });
    })

    //页面跳转
    $(".jump_url").click(function () {
        var obj = $(this);
        url = obj.attr("url");
        window.location.href = url;
    })

    $(".show_img").click(function () {
        var imgurl = $(this).prev("input").val();
        if (imgurl) {
            top.layer.open({
                type: 1,
                title: "大图显示",
                content: '<img src="' + imgurl + '" style="max-width:480px;">',
                area: [Math.max(Math.min(this.naturalWidth ? this.naturalWidth : 480, 360), 156) + 'px', Math.max(Math.min(this.naturalHeight ? this.naturalHeight : 480, 403), 199) + 'px'],
                maxmin: true,
            });
        }
    })
    //显示大图
    $("*[event='showbimg']").click(function () {
        var imgurl = $(this).attr("src") ? $(this).attr("src") : ($(this).attr("href") ? $(this).attr("href") : "");
        if (imgurl) {
            var img = new Image();
            img.src = imgurl;
            img.onload = function () {
                var title = $(this).attr("alt") ? $(this).attr("alt") : $(this).attr("title") ? $(this).attr("title") : "大图显示";
                var naturalWidth = img.naturalWidth
                var naturalHeight = img.naturalHeight;
                var width = Math.max(Math.min(naturalWidth ? naturalWidth : 480, 360), 156);
                var height = (naturalHeight * width / naturalWidth) + 43
                // 43是layer弹框标题栏的高度
                top.layer.open({
                    type: 1,
                    title: title,
                    content: '<img src="' + imgurl + '" style="width:' + width + 'px;" />',
                    area: [width + 'px', height + 'px'],
                    maxmin: true,
                });
            }
        }
    });
    /*中文转英文*/
    $("*[event='cntoeng']").click(function () {
        var data = $(this).attr("data");
        if (!data) return;
        data = $.parseJSON(data);
        var cnstr = $("#" + data.id).val();
        data.keyword = cnstr;
        if (cnstr == "") {
            alert("请选择输入内容");
            $("#" + data.id).focus();
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: "JSON",
            url: rootpath + 'ajax/cntoeng',
            data: data,
            success: function (res) {
                if (res.result) {
                    $("#" + data.engid).val(res.data);
                }
            },
            error: function () {
                alert("fuck");
            }
        });

    });
    /*提示*/
    $(".tips").click(function () {
        var a = $(this).data();
        if (a.msg) top.layer.msg(a.msg)
    });

    /*重置搜索表单*/
    $("input.reset").click(function () {
        var form = $(this).parents("form");
        if (form) {
            $(form).find("input[type='text']").val('');
            $(form).find("input[type='number']").val('');
            $(form).find(".textbox-value").val("");
            $(form).find("select").find("option:first").prop("selected", true);
        }
    });
    //金额限制
    $(".money_format").keyup(function () {
        var v = $(this).val();
        var v2 = v.replace(/[^0-9.]/g, '');
        var len = v2.length;
        var no1 = v2.substr(0, 1);
        var no2 = v2.substr(1, 1);
        var point = v2.indexOf(".");

        if (no1 == '.') {
            v2 = '';
        }
        if (len >= 2 && v2 * 1 == 0 && no2 != '.') {
            v2 = '';
        }
        if (len >= 2 && no1 == 0 && no2 != '.') {
            v2 = v2.substr(1);
        }
        if (point > 0) {
            v2 = v2.substr(0, point + 3);
        }

        $(this).val(v2);
    });

    //点击提示信息
    $(document).on('click', "*[event='tips']", function () {
        var data = $(this).attr("data");
        if (!data) return;
        art.dialog({
            title: '详情',
            padding: 0,
            lock: true,
            ok: true,
            okVal: '关闭',
            content: "<div style='padding:20px;'>" + data + "</div>",
        });
    });

    /*确认操作*/
    $(document).on("click", "*[event='confirm']", function () {
        var that = $(this);
        var a = $(that).data();
        top.layer.confirm(a.msg || "确定要操作吗？", {icon: a.icon || 7, title: a.title || '系统提示'}, function (index) {
            if (a.uri) {
                if (a.ajax) {
                    $.ajax({
                        type: "get",
                        url: a.uri,
                        async: false,
                        success: function (res) {
                            top.layer.msg(res.info, {time: 1000});
                            if (res.status == 1 && a.callback) eval(a.callback + "(that,index)");
                        },
                        error: function (res) {
                            _error('网络请求失败');
                        }
                    });
                } else {
                    location.href = a.uri
                }
            } else if (a.callback) {
                eval("a.callback(that,index)");
            }
            top.layer.close(index);
        });
    })

    //ajax删除操作
    $(document).on("click", "*[event='remove2']", function () {
        var a = $(this).data(), that = $(this);
        var msg = a.msg || "确定要删除吗?";	//提示内容
        var parent = a.parent || false;	//移动父级
        var callback = a.callback || false;
        top.layer.confirm(a.msg || "确定要操作吗？", {icon: a.icon || 7, title: a.title || '系统提示'}, function (index) {
            top.layer.close(index);
            //无URL则不需要ajax请求
            if (!a.uri) {
                if (parent) $(that).parents(parent).remove();
                if (callback) try {
                    eval(callback)
                } catch (e) {
                }
                return;
            }
            var index = top.layer.load(2, {time: 10 * 1000});
            $.ajax({
                type: a.post ? "post" : "get",
                url: a.uri,
                success: function (res) {
                    top.layer.close(index);
                    if (res.status) {
                        _ok(res.info);
                        if (parent) {
                            $(that).parents(parent).remove();
                            if (callback) try {
                                eval(callback)
                            } catch (e) {
                            }
                        } else {
                            location.reload();
                        }
                    } else {
                        _error(res.info);
                    }
                }
            });
        });
    });
    //ajax删除操作end

    /* 异步移除数据*/
    $("*[event='remove']").click(function () {
        var icon = $(this);
        var uri = ($(this).attr('uri')) ? $(this).attr('uri') : "";
        var data = $(this).attr("data");
        if (data && confirm('你确定要删除吗？\n\n删除后不可恢复！')) {
            data = eval("(" + data + ")");
            if (!data.act) data.act = 'remove_field';
            $.ajax({
                url: uri + "ajax_" + data.act,
                type: "POST",
                //async:false,
                data: data,
                dataType: "json",
                success: function (res) {
                    if (res.message) {
                        alert(res.message);
                        window.location.reload();
                    }
                    if (res.error == 0) {
                        window.location.reload();
                    }
                }
            });
        }
    });
    /* 切换状态*/
    $("*[event='toggle']").click(function () {
        var icon = $(this);
        var src = $(this).attr('src');
        var uri = ($(this).attr('uri')) ? $(this).attr('uri') : "";
        var val = (src.match(/yes.gif/i)) ? 0 : 1;
        var data = $(this).attr("data");
        if (data) {
            data = eval("(" + data + ")");

            if (!data.act) data.act = 'update_field';
            //if(!data.act) data.prototype.act='update_field';

            $.ajax({
                url: uri + "ajax_" + data.act,
                type: "POST",
                //async:false,
                data: "field=" + data.field + "&val=" + val + "&id=" + data.id,
                success: function (msg) {
                    res = $.parseJSON(msg);
                    if (res.error == 0) {
                        var img_url;
                        img_url = (val == 0) ? src.replace('yes.gif', 'no.gif') : src.replace('no.gif', 'yes.gif');
                        //var img_url = (res.content > 0) ? 'images/yes.gif' : 'images/no.gif';
                        icon.attr('src', img_url);
                    } else {
                        alert(res.message);
                    }
                }
            });
        }
    });


    //规格设置
    // if ($("input[event='spec_chk']").size() > 0) {
    //     if ($("input[event='spec_chk']:checked").size() >= 2) {
    //         $("input[event='spec_chk']").not(":checked").attr("disabled", true);
    //     }
    // }
    $("input[event='spec_chk']").click(function () {
        if ($("input[event='spec_chk']:checked").size() >= 2) {
            $("input[event='spec_chk']").not(":checked").attr("disabled", true);
        } else {
            $("input[event='spec_chk']").not(":checked").attr("disabled", false);
        }
    })
    /*弹框加载页面*/
    $('*[event="layer_iframe"]').click(function () {
        var width = $(this).data('width');
        var height = $(this).data('height');
        var url = $(this).data('url');
        var title = $(this).data('title');
        var maxmin = $(this).data('maxmin') ? true : false;
        layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: false,
            maxmin: maxmin,
            area: [width, height],
            content: url
        });
    });
})


/*列表数据鼠标移动变色事件 和点击变色事件*/
function table_select() {
    $("#list-table tr").hover(
        function () {
            $(this).addClass("trover");
        },
        function () {
            $(this).removeClass("trover");
        }
    ).click(function () {
        $("#list-table .trselect").removeClass("trselect");
        $(this).addClass("trselect");
    });
}

/*菜单栏 全部展开和收起*/
function allClicked(obj) {
    if ($(obj).attr('src').indexOf('menu_minus.gif') > 0) {
        $("#list-table tbody tr.2_explode,tr.3_explode").hide();
        var img_url = obj.src.replace('minus.gif', 'plus.gif');
        $(obj).attr('src', img_url);
        $("#list-table tbody tr img.menu_img").attr('src', img_url)
    } else {
        $("#list-table tbody tr.2_explode,tr.3_explode").show();
        var img_url = obj.src.replace('plus.gif', 'minus.gif');
        $(obj).attr('src', img_url);
        $("#list-table tbody tr img.menu_img").attr('src', img_url);
    }
}

/**
 * 折叠分类列表
 */
function rowClicked(obj) {
    var imgPlus = new Image();
    imgPlus.src = __img__ + "/icon/menu_plus.gif";
    // 当前图像
    img = obj;
    // 取得上二级tr>td>img对象
    obj = obj.parentNode.parentNode;
    // 整个分类列表表格
    var tbl = document.getElementById("list-table");
    // 当前分类级别
    var lvl = parseInt(obj.className);
    // 是否找到元素
    var fnd = false;
    var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (Browser.isIE) ? 'block' : 'table-row';
    // 遍历所有的分类
    for (i = 0; i < tbl.rows.length; i++) {
        var row = tbl.rows[i];
        if (row == obj) {
            // 找到当前行
            fnd = true;
            //document.getElementById('result').innerHTML += 'Find row at ' + i +"<br/>";
        } else {
            if (fnd == true) {
                var cur = parseInt(row.className);
                var icon = 'icon_' + row.id;
                if (cur > lvl) {
                    row.style.display = sub_display;
                    if (sub_display != 'none') {
                        var iconimg = document.getElementById(icon);
                        iconimg.src = iconimg.src.replace('plus.gif', 'minus.gif');
                    }
                } else {
                    fnd = false;
                    break;
                }
            }
        }
    }

    for (i = 0; i < obj.cells[1].childNodes.length; i++) {
        var imgObj = obj.cells[1].childNodes[i];
        if (imgObj.tagName == "IMG" && imgObj.src != __img__ + '/icon/menu_arrow.gif') {
            imgObj.src = (imgObj.src == imgPlus.src) ? __img__ + '/icon/menu_minus.gif' : __img__ + '/icon/menu_plus.gif';
        }
    }
}

/*
* ajax加载页
* obj为当前连接对象
* di为加载成功后，数据返回的窗口ID
* 方法<a href='javascript:void(0)' onclick="ajax_load(this, contet)" uri='网址'>
*/

function ajax_load(obj, id) {
    //art.dialog.tips("正在加载中...",0.5);
    $.ajax({
        url: $(obj).attr("uri"),
        async: false,
        success: function (html) {
            $("#" + id).html(html);
        },
        error: function (XMLHttpRequest, textStatus) {
            alert("加载出错了,请稍后重试!");
        }
    });
}

/*
* ajax读取表单数据
* obj为当前连接对象
* di为加载成功后，数据返回的窗口ID
* 方法<form onsubmit=ajax_form_load(this,obj)"">
*/
function ajax_form_load(_this, obj) {
    var url = $(_this).attr("action");
    var method = ($(_this).attr("method") ? $(_this).attr("method") : "get").toUpperCase();
    var _data = $(_this).serialize();
    var obj = obj ? "#" + obj : ".aui_content";
    if (method == "GET") {
        url += ((url.indexOf("?") == -1) ? "?" : "&") + _data;
        _data = "";
    }
    //art.dialog.tips("正在加载中...",0.5);
    $.ajax({
        type: method,
        url: url,
        data: _data,
        success: function (html) {
            $(obj).html(html);
        },
        error: function (XMLHttpRequest, textStatus) {
            alert("加载出错了,请稍后重试!");
        }
    });
    return false;
}

//显示错误信息
function art_show_error(errmsg) {
    var timer;
    art.dialog({
        icon: 'error',
        content: errmsg,
        lock: true,
        ok: true,
        init: function () {
            var that = this, i = 3;
            var fn = function () {
                that.title(i + '秒后关闭');
                !i && that.close();
                i--;
            };
            timer = setInterval(fn, 1000);
            fn();
        },
        close: function () {
            clearInterval(timer);
        }
    }).show();
}

//ajax加载
function art_ajax(title, url, config) {
    art.dialog.load(url, {
        title: title,
        width: (config.width != 'undefined' ? config.width : "auto"),
        height: (config.height != 'undefined' ? config.height : "auto"),
        ok: (config.ok == false ? false : true),
        okVal: (config.okVal != 'undefined' ? config.okVal : "关闭"),
        padding: (config.padding != 'undefined' ? config.padding : 5),
        lock: (config.lock != 'undefined' ? config.lock : false),
    }, false);
}

/*****
 * 审核资料
 * @param sting id 标识打开的框架
 * @param bool is_refresh 关闭窗口后是否刷新页面
 * @param string title 弹出框的名字
 * @param string url 请求的url
 * @author Jeffreyzhu.cn@gmail.com
 *****/
function dialog_open(id, is_refresh, title, url) {
    art.dialog.open(url, {
        id: id,
        title: title,
        lock: 'true',
        window: 'top',
        width: 1200,
        height: 700,
        cancel: function () {
            if (is_refresh) {
                window.location.reload();
            }
        },
        ok: false

    });
}

function upload_ok(data) {
    if (typeof (data) != "object") return;
    var html = "";
    switch (data.filetype) {
        case "image":
            if (data.ext == "jpg" || data.ext == "jpeg" || data.ext == "png" || data.ext == "gif") {
                if (data.did) {
                    $("input[name='" + data.did + "']").val(data.uri);
                } else {
                    $("#" + data.utype).val(data.uri);
                }
            } else {
                alert('无效的图片');
            }
            break;
        default:
            if (data.did) {
                $("input[name='" + data.did + "']").val(data.uri);
            } else {
                $("#" + data.utype).val(data.uri);
            }
            break;
    }
};