<?php /*a:2:{s:46:"D:\gitdata\TpIf\app\admin\view\role\index.html";i:1592274601;s:42:"D:\gitdata\TpIf\app\admin\view\layout.html";i:1592274657;}*/ ?>
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
    
<form class="layui-form" id="search">

    <div class="demoTable">

        &nbsp;&nbsp;开始时间：
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" class="layui-input" READONLY style="cursor:pointer" size='10' name="sdate" id="sdate" placeholder="开始时间">
            </div>
        </div>
        &nbsp;&nbsp;结束时间：
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" class="layui-input" READONLY style="cursor:pointer" size='10' name="edate" id="edate" placeholder="结束时间">
            </div>
        </div>

        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formSub" id="sub"><i class="layui-icon layui-icon-search"></i></button>
        <button type="reset" class="layui-btn layui-btn-warm" id='reset'>重置</button>
    </div>
</form>

<table class="layui-hide" id="table" lay-filter="table"></table>

<!--图片-->
<script type="text/html" id="shezss">
    <img style="border-radius: 2px;width: 50px;height: 50px !important;"  lay-event="showbimg" src="{{d.headimg}}" />
</script>

<script type="text/html" id="toolbarTable">
    <div class="layui-btn-container">
        <a class="layui-btn layui-btn-danger layui-btn-sm" data-key="uid" lay-event="del_all" data-obj="ids[]" data-uri="<?php echo url('delete'); ?>"><i class="layui-icon">&#xe640;</i>批量删除</a>
    </div>
</script>

<script type="text/html" id="barDemo">
    <a href="<?php echo url('Auth/access',['menu_id'=>$menu_id]); ?>&id={{d.id}}" class="layui-btn layui-btn-xs layui-btn-normal">配置规则</a>
    <a href="javascript:;" lay-event="window" class="layui-btn layui-btn-normal layui-btn-xs" data-maxmin="1" data-title="用户详情"  data-width="700" data-height="500"  data-uri="<?php echo url('select'); ?>?uid={{d.uid}}"><i class="layui-icon">&#xe705;</i>详情</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" data-uri="<?php echo url('delete'); ?>" data-id="{{d.uid}}" ><i class="layui-icon">&#xe640;</i>删除</a>

</script>
<script type="text/html" id="is_lock">
    {{# if(d.id==1){ }}
    <input type="checkbox" disabled name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="status" checked>
    {{# }else{  }}
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}>
    {{# } }}
</script>
<script type="text/html" id="enable">
    {{# if(d.id==1){ }}
    <input type="checkbox" disabled name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="status" checked>
    {{# }else{  }}
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}>
    {{# } }}
</script>

<script type="text/javascript">
console.log(232322);
    var page_1 = <?php echo json_encode($page_1); ?>; console.log(page_1);
    $(function(){
        layui.use(['table','form','laydate'], function(){
            var table = layui.table,form = layui.form,laydate = layui.laydate;
            //自定义颜色
            laydate.render({
                elem: '#sdate'
                ,theme: '#2F4056'
            });
            laydate.render({
                elem: '#edate'
                ,theme: '#2F4056'
            });
            tableOptions = {
                elem: '#table'
                ,url: '<?php echo url("dataIndexGet"); ?>'
                ,tablePage_1:page_1
                ,toolbar: '#toolbarTable'
                // ,cellMinWidth:120
                ,cols: [[
                    {checkbox: true, fixed: true}
                   ,{field: 'id', title: 'ID',align: 'center', fixed: true, sort: true}
                   ,{field: 'name', title: '角色组', fixed: true}
                   ,{field: 'is_lock', title: '锁定状态', sort: true}
                   ,{field: 'enable', title: '启用状态', sort: true}
                   ,{field: 'create_time', title: '添加时间', sort: true}
                   ,{field: 'update_time', title: '修改时间', sort: true} 
                   ,{field: 'status', title: '说明', sort: true}
                   ,{title:'操作', align:'center', toolbar: '#barDemo',fixed: 'right', sort: true}

                ]]
                ,done: function (res, curr, count) {

                }
                ,page: true
                ,height: 680
                ,limits:[10,20,40,80,100,200,400,600,800]
                ,text: {
                    none: '暂无数据!'
                }

            };
            /*方法级渲染*/
            table.render(tableOptions);
            form.on('select(changeStatus)', function (e) {
                $('#sub').click();
            });
            /*表格重载*/
            form.on('submit(formSub)', function(data){
                var field = data.field;
                table.reload('table', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        searchtype: field.searchtype,
                        keyword: field.keyword,
                        searchtype3: field.searchtype3,
                        searchtype4: field.searchtype4,
                        sdate: field.sdate,
                        edate: field.edate
                    }
                });
                return false;
            });
        });
    })
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
    console.log(111111);
    console.log($('#barDemo'));
</script>


</body>
</html>