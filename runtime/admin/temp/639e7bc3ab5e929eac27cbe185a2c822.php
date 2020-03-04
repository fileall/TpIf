<?php /*a:2:{s:47:"E:\gitdata\TpIf\app\admin\view\role\access.html";i:1570349093;s:42:"E:\gitdata\TpIf\app\admin\view\layout.html";i:1583300888;}*/ ?>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/plugins//layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/admin//lib/css/admin.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/admin/css//patch.css" media="all">
    <link id="layuicss-layer" rel="stylesheet" href="/static/plugins//layui/css/modules/layer/default/layer.css" media="all">
    <script type="text/javascript" src="/static/plugins//jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/static/plugins//layui/layui.js"></script>
    <!-- <script type="text/javascript" src="/static/admin/js//common.js"></script> -->

    <style>


    </style>

</head>
<body layadmin-themealias="default">
<div>
<?php if(!(empty($_sub_menu) || (($_sub_menu instanceof \think\Collection || $_sub_menu instanceof \think\Paginator ) && $_sub_menu->isEmpty()))): ?>
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" style="margin-left: 10px;">
        <ul class="layui-tab-title" id="menu">
                <?php if(is_array($_sub_menu) || $_sub_menu instanceof \think\Collection || $_sub_menu instanceof \think\Paginator): if( count($_sub_menu)==0 ) : echo "" ;else: foreach($_sub_menu as $key=>$sub): ?>
                <li <?php if($sub['id'] == $menu_id){?> class="layui-this" <?php }?> ><a id="<?php echo htmlentities($sub['id']); ?>" href="<?php echo url($sub['controller_name'].'/'.$sub['action_name'],array('menu_id'=>$sub['id'])); ?><?php echo htmlentities($sub['data']); ?>"><?php echo htmlentities($sub['name']); ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

    </div>
    <?php endif; ?>
<div class="layui-fluid layui-anim layui-anim-right-left" >
    
<div class="LM-container">
    <div class="LM-main">
        <div class="admin-main layui-anim layui-anim-upbit">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>权限分配</legend>
                <blockquote class="layui-elem-quote">
                    <button type="button" class="layui-btn layui-btn-sm" lay-demo="setChecked">全选</button>
                    <button type="button" class="layui-btn layui-btn-sm layui-btn-warm" lay-demo="reload">取消</button>
                </blockquote>

            </fieldset>
            <div class="layui-form-item">
                <div id="tree" class="demo-tree-more"></div>

            </div>

            <form class="layui-form layui-form-pane" lay-filter="form">
                <div class="layui-form-item">
                    <div class="layui-input-inline">
                        <input type="hidden" name="id"  >
                        <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                        <a href="<?php echo url('group'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<script>
    layui.use(['form', 'table','tree','form'], function () {
        var $ = layui.jquery,
            util = layui.util,
            form = layui.form,
            tree = layui.tree;
        var idList = <?php echo json_encode($idList); ?>;
        tree.render({
            elem: '#tree'
            ,data: <?php echo json_encode($list); ?>
            ,showCheckbox: true  //是否显示复选框
            ,id: 'treebox'
            ,showLine:true
            ,accordion:true//是否开启手风琴模式，默认 false
            ,isJump: false //是否允许点击节点时弹出新窗口跳转


        });

        //按钮事件
        util.event('lay-demo', {
            getChecked: function (othis) {
                var checkedData = tree.getChecked('treebox'); //获取选中节点的数据
            }
            , setChecked: function () {
                tree.setChecked('treebox', idList); //勾选指定节点
            }
            , reload: function () {
                //重载实例
                tree.reload('treebox', {});

            }
        })
        form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var data  = tree.getChecked('treebox');
            console.log(data);
            console.log(data);
            $.post("groupSetaccess", {rules:data,group_id:'<?php echo htmlentities($group_id); ?>'}, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });


    });


</script>

</div>
</div>

<script>

    var public = "/static/admin//lib/modules/";
    layui.config({
        base: public
    }).extend({
        index: 'common'
    }).use('common');


</script>


</body>
</html>