/** 后台table公共操作**/
; layui.define(['table','treeGrid', 'form', 'element'], function (exports) {
    var table = layui.table, form = layui.form, layer = layui.layer, element = layui.element;treeGrid=layui.treeGrid
    var initTable = function () {
        $(document).find('.layui-laypage-btn').click();
    };
    
    //弹窗默认的回调整，会执行子窗口的 api_back()
    var win_callback = function (frame, index, that) {
        if (typeof frame.api_back != 'function') return !0;
        return frame.api_back(index, frame);
    };

   //layui数据表格toolbar绑定事件
    table.on('toolbar(table)', function (obj) {
      
        var checkStatus = table.checkStatus(obj.config.id);
        switch (obj.event) {
            /*通用批量操作*/
            case 'del_all':
                var data = checkStatus.data, ids = [], _this = $(this);
                $.each(data, function (k, v) {
                    ids.push(v[_this.data('key')]);
                });
                if (ids.length == 0) {
                    layer.tips('请选择要操作的数据', $(this));
                    return false;
                }
                var _this = $(this);
                var data = $(_this).data();
                top.layer.msg(data.msg ? data.msg : '你确定执行此操作吗？', {
                    time: 0
                    , btn: [data.btn1 ? data.btn1 : '确定', data.btn2 ? data.btn2 : '考虑一下']
                    , yes: function (index) {
                        top.layer.close(index);
                        top.layer.load(1);
                        $.ajax({
                            type: "POST",
                            data: { ids: ids },
                            url: data.uri,
                            success: function (e) {
                                top.layer.closeAll();
                                if (e.status == 1) {
                                    top.layer.alert(e.info, { icon: 6 });
                                    initTable();
                                } else {
                                    top.layer.msg(e.info, { icon: 5 });
                                }
                            }
                        });
                    }
                });
                break;
        };
    });

     table.on('tool(table)', function(obj){  console.log(obj)
        switch (obj.event){
            case 'del':
                var _this = $(this);
                var data = $(_this).data();
                top.layer.msg(data.msg?data.msg:'你确定执行此操作吗？', {
                    time: 0
                    ,shade:[0.4, 'rgb(0, 0, 0)']
                    ,btn: [data.btn1?data.btn1:'确定', data.btn2?data.btn2:'考虑一下']
                    ,yes: function(index){
                        top.layer.close(index);
                        top.layer.load(1);
                        $.ajax({
                            type:"POST",
                            data:{ids:data.id},
                            url:data.uri,
                            success: function (e) {
                                top.layer.closeAll();
                                if (e.status == 1){
                                    top.layer.alert(e.info, {icon: 6});
                                    obj.del();
                                }else {
                                    top.layer.msg(e.info, {icon: 5});
                                }
                            }
                        });
                    }
                });
                break;
            /*打开窗口*/
            case 'window':
                var flag = true;
                var o = $(this);
                var a = $(o).data();
                var c = {type:2,title:a.title||a.btn||'详情',content:a.uri,
                    area:[(a.width||600)+'px',(a.height||350)+'px'],maxmin:a.maxmin||false,success:function(e,i){
                        if(a.auto){top.layer.iframeAuto(i)}
                    }};
                if(a.btn){
                    c.btn = [a.btn, '取消'];
                    c.yes = function(index, layero){
                        var iframeWin = top.window[layero.find('iframe')[0]['name']];
                        if(a.callback){
                            eval(a.callback+"(iframeWin,index)");
                        }else{
                            var rest = win_callback(iframeWin, index, o);
                            if (rest) {
                                rest.__proto__.constructor = Object;
                                obj.update(rest);
                                setTimeout(function () {
                                    top.layer.close(index);
                                }, 1000);
                            }
                        }
                    };
                    c.btn2 = function(index, layero){
                        flag = false;
                        top.layer.close(index);
                    }
                    c.cancel = function(index, layero){
                        flag = false;
                    }
                    if(a.refresh){
                        c.end = function(){
                            if(flag){
                                window.location.reload();
                            }
                        }
                    }
                }
                /*是否弹出默认全屏*/
                if(a.full){
                    var index = top.layer.open(c);
                    top.layer.full(index);
                }else {
                    top.layer.open(c);
                }
                break;
            /*相册预览*/
            case 'album':
                var id = $(this).data('id'),uri = $(this).data('uri');
                $.ajax({
                    type:'POST',
                    data:{id:id},
                    url:uri,
                    success: function (e) {
                        layer.photos({
                            photos: e.info
                            ,anim: 5
                            ,shade:0.2
                        });
                    }
                });
                break;
            case 'listorder':
                $(this).blur(function () {
                    if($(this).val() != $(this).attr("old")){
                        var uri = $(this).data('uri');
                        $.ajax({
                            type:'POST',
                            url:uri,
                            data:{'id':$(this).attr('data'),'listorder':$(this).val()},
                            dataType:"json",
                            success: function(data){
                                if(data.error == 1){
                                    alert(data.message);
                                }else{
                                    initTable();
                                }
                            }
                        })
                    }
                });
                break;
        }
    });

    //树形表格工具条调用操作
    treeGrid.on('tool(table)', function (obj) {
        console.log(obj)
        switch (obj.event) {
            //工具条删除操作
            case 'del':
                var _this = $(this);
                var data = $(_this).data();
                top.layer.msg(data.msg ? data.msg : '你确定执行此操作吗？', {
                    time: 0
                    , shade: [0.4, 'rgb(0, 0, 0)']
                    , btn: [data.btn1 ? data.btn1 : '确定', data.btn2 ? data.btn2 : '考虑一下']
                    , yes: function (index) {
                        top.layer.close(index);
                        top.layer.load(1);
                        $.ajax({
                            type: "POST",
                            data: { ids: data.id },
                            url: data.uri,
                            success: function (e) {
                                top.layer.closeAll();
                                if (e.status == 1) {
                                    top.layer.alert(e.info, { icon: 6 });
                                    obj.del();
                                } else {
                                    top.layer.msg(e.info, { icon: 5 });
                                }
                            }
                        });
                    }
                });
                break;
            //工具条打开窗口
            case 'window':
                var flag = true;
                var that = $(this);
                var data = $(that).data();
                var open = {
                    type: 2, title: data.title || data.btn || '详情', content: data.uri,
                    area: [(data.width || 600) + 'px', (data.height || 350) + 'px'], maxmin: data.maxmin || false, success: function (e, i) {
                        if (data.auto) { top.layer.iframeAuto(i) }
                    }
                };
                if (data.btn) {  
                    open.btn = [data.btn, '取消'];
                    open.yes = function (index, layero) {
                        var iframeWin = top.window[layero.find('iframe')[0]['name']];//console.log(data.callback);console.log(iframeWin);
                        if (data.callback) { 
                            eval(data.callback + "(iframeWin,index)");
                        } else {
                            var rest = win_callback(iframeWin, index, that);
                            if (rest) {
                                rest.__proto__.constructor = Object;//定义对象
                                obj.update(rest);
                                setTimeout(function () {
                                    top.layer.close(index);
                                }, 1000);
                            }
                        }
                    };
                    open.btn2 = function (index, layero) {
                        flag = false;
                        top.layer.close(index);
                    }
                    open.cancel = function (index, layero) {
                        flag = false;
                    }
                    if (data.refresh) {
                        open.end = function () {
                            if (flag) {
                                window.location.reload();
                            }
                        }
                    }
                }
                /*是否弹出默认全屏*/
                if (data.full) {
                    var index = top.layer.open(open);
                    top.layer.full(index);
                } else {
                    top.layer.open(open);
                }
                break;
            /*相册预览*/
            case 'album':
                var id = $(this).data('id'), uri = $(this).data('uri');
                $.ajax({
                    type: 'POST',
                    data: { id: id },
                    url: uri,
                    success: function (e) {
                        layer.photos({
                            photos: e.info
                            , anim: 5
                            , shade: 0.2
                        });
                    }
                });
                break;
            case 'listorder':
                $(this).blur(function () {
                    if ($(this).val() != $(this).attr("old")) {
                        var uri = $(this).data('uri');
                        $.ajax({
                            type: 'POST',
                            url: uri,
                            data: { 'id': $(this).attr('data'), 'listorder': $(this).val() },
                            dataType: "json",
                            success: function (data) {
                                if (data.error == 1) {
                                    alert(data.message);
                                } else {
                                    initTable();
                                }
                            }
                        })
                    }
                });
                break;
        }
    });

   
    /*状态开关操作*/
    form.on('switch(status)', function (obj) {
        var data = $(obj.elem).data();
        $.ajax({
            type: "post",
            url: data.uri,
            async: true,
            data: { fieldval: obj.elem.checked ? 1 : 0, id: data.id, field: data.field, type: data.type },
            success: function (e) {
                layer.tips(e.msg, obj.othis);
                if (e.res != 1) {
                    initTable();
                }
            }
        });

    });
    /*鼠标滚轮缩放图片*/

    exports("tablecommon", {})
});