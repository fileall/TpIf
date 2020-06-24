<?php /*a:2:{s:46:"D:\gitdata\TpIf\app\admin\view\auth\index.html";i:1592989942;s:42:"D:\gitdata\TpIf\app\admin\view\layout.html";i:1592991979;}*/ ?>
<html>

<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/plugins/layui/css/layui.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/admin/lib/css/admin.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/admin/css/patch.css" media="all">
    <link id="layuicss-layer" rel="stylesheet" href="/static/plugins/layui/css/modules/layer/default/layer.css" media="all">
    <script type="text/javascript" src="/static/plugins/jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/static/plugins/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/js/admin.js"></script>
    <script type="text/javascript" src="/static/admin/js/common.js"></script>
    <script type="text/javascript" src="/static/admin/js/tablecommon.js"></script>

    <style>


    </style>



</head>

<body layadmin-themealias="default">
    <div>
        <?php if(!(empty($_sub_menu) || (($_sub_menu instanceof \think\Collection || $_sub_menu instanceof \think\Paginator ) && $_sub_menu->isEmpty()))): ?>
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief" style="margin-left: 10px;">
            <ul class="layui-tab-title" id="menu">
                <?php if(is_array($_sub_menu) || $_sub_menu instanceof \think\Collection || $_sub_menu instanceof \think\Paginator): if( count($_sub_menu)==0 ) : echo "" ;else: foreach($_sub_menu as $key=>$sub): ?>
                <li <?php if($sub['id'] == $menu_id){?> class="layui-this" <?php }?>>
                    <a data-iframe-tab="<?php echo url($sub['controller_name'].'/'.$sub['action_name']); ?>" admin-type="tabAdd"
                        admin-data="<?php echo htmlentities($sub['data']); ?>" admin-menu-id="<?php echo htmlentities($sub['id']); ?>" target="<?php echo htmlentities($sub['target']); ?>"
                        data-title="<?php echo htmlentities($sub['name']); ?>" class="layui-menu-tips">
                        <span class="layui-left-nav"><?php echo htmlentities($sub['name']); ?></span>
                    </a>
                    <!-- <a id="<?php echo htmlentities($sub['id']); ?>"
                    data-iframe-tab="<?php echo url($sub['controller_name'].'/'.$sub['action_name'],array('menu_id'=>$sub['id'])); ?><?php echo htmlentities($sub['data']); ?>"><?php echo htmlentities($sub['name']); ?></a> -->
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

        </div>
        <?php endif; ?>
        <div class="layui-fluid layui-anim layui-anim-right-left">
            
<div class="LM-container">
    <div class="LM-main">
        <div class="admin-main layui-anim layui-anim-upbit">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>权限<?php echo lang('list'); ?></legend>
            </fieldset>
            <blockquote class="layui-elem-quote">
                <a href="<?php echo url('ruleAdd'); ?>" class="layui-btn layui-btn-sm LM-add"><?php echo lang('add'); ?>路由</a>
                <a class="layui-btn layui-btn-normal layui-btn-sm" onclick="openAll();">展开或折叠全部</a>
            </blockquote>
            <table class="layui-table" id="table" lay-filter="table"></table>
        </div>
    </div>
</div>

<script type="text/html" id="auth">
    <input type="checkbox" name="auth_open" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="auth_open" {{ d.auth_open == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="status">
    <input type="checkbox" name="menu_status" value="{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="menu_status" {{ d.menu_status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="order">
    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/>
</script>
<script type="text/html" id="icon">
    <span class="icon {{d.icon}}"></span>
</script>
<script type="text/html" id="action">
    <!-- <a href="javascript:;" lay-event="window" data-btn="确定" class="layui-btn layui-btn-normal layui-btn-xs"  data-title="查看详情"  data-width="700" data-height="600"  data-uri="<?php echo url('member_log'); ?>"><i class="layui-icon">&#xe705;</i>会员记录</a> -->
    <a  lay-event="window" data-btn="确定" data-uri="<?php echo url('edit'); ?>?id={{d.id}}" data-width="700" data-height="600" data-title="查看详情" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="topBtn">
    <a href="<?php echo url('ruleAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?>权限</a>
</script>

<script>
    var editObj=null,ptable=null,treeGrid=null,tableId='table',layer=null;
    layui.config({
        base: '/static/plugins/layui/extend/'
    }).extend({
        treeGrid: 'treeGrid/treeGrid'
    }).use(['jquery','treeGrid','layer','form'], function(){
        var $=layui.jquery ,form = layui.form;
        table = layui.treeGrid;
        layer=layui.layer;

        ptable=table.render({
            id:tableId
            ,elem: '#'+tableId
            ,idField:'id'
            ,url:'<?php echo url("index"); ?>'
            ,cellMinWidth: 100
            ,treeId:'id'//树形id字段名称
            ,treeUpId:'parent_id'//树形父id字段名称
            ,treeShowName:'title'//以树形式显示的字段
            ,height:'full-140'
            ,isFilter:false
            ,iconOpen:true//是否显示图标【默认显示】
            ,isOpenDefault:true//节点默认是展开还是折叠【默认展开】
            ,cols: [[
                {field: 'id', title: '<?php echo lang("id"); ?>', width: 70, fixed: true},
                {field: 'icon', align: 'center',title: '<?php echo lang("icon"); ?>', width: 60,templet: '#icon'},
                {field: 'title', title: '权限名称', width: 200},
                {field: 'href', title: '控制器/方法', width: 200},
                {field: 'auth_open',align: 'center', title: '是否验证权限', width: 150,toolbar: '#auth'},
                {field: 'menu_status',align: 'center',title: '菜单<?php echo lang("status"); ?>', width: 150,toolbar: '#status'},
                {field: 'sort',align: 'center', title: '<?php echo lang("order"); ?>', width: 80, templet: '#order'},
                {width: 160,align: 'center', toolbar: '#action'}
            ]]
            ,page:false
        });
      
        // table.on('tool('+tableId+')',function (obj) {  
        //     var data = obj.data;
        //     if(obj.event === 'del'){
        //         layer.confirm('您确定要删除吗？', function(index){
        //             var loading = layer.load(1, {shade: [0.1, '#fff']});
        //             $.post("<?php echo url('ruleDel'); ?>",{id:data.id},function(res){
        //                 layer.close(loading);
        //                 if(res.code==1){
        //                     layer.msg(res.msg,{time:1000,icon:1});
        //                     obj.del();
        //                 }else{
        //                     layer.msg(res.msg,{time:1000,icon:2});
        //                 }
        //             });
        //             layer.close(index);
        //         });
        //     }
        // });
        table.on('toolbar('+tableId+')',function (obj) { consol.log(2334);
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('ruleDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            obj.del();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
        form.on('switch(auth_open)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var auth_open = obj.elem.checked===true?0:1;
            $.post('<?php echo url("ruleOpen"); ?>',{'id':id,'auth_open':auth_open},function (res) {
                layer.close(loading);
                if (res.code==1) {
                    treeGrid.render;
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                    return false;
                }
            })
        });
        form.on('switch(menu_status)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var menu_status = obj.elem.checked===true?1:0;
            $.post('<?php echo url("ruleState"); ?>',{'id':id,'menu_status':menu_status},function (res) {
                layer.close(loading);
                if (res.code==1) {
                    treeGrid.render;
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                    return false;
                }
            })
        });
        $('body').on('blur','.sort',function() {
            var id = $(this).attr('data-id');
            var sort = $(this).val();
            $.post('<?php echo url("ruleOrder"); ?>',{id:id,sort:sort},function(res){
                if(res.code==1){
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        location.href = res.url;
                    });
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                }
            })
        })



    });

    function openAll() {
        var treedata=treeGrid.getDataTreeList(tableId);
        treeGrid.treeOpenAll(tableId,!treedata[0][treeGrid.config.cols.isOpen]);
    }

</script>

        </div>
    </div>

    <script>

        // var public = "/static/admin/js/";
        // console.log(public);
        // layui.config({
        //     base: public
        // }).extend({
        //     admin: 'admin',
        // }).use(['admin']);
        
    </script>


</body>

</html>