<?php /*a:2:{s:46:"D:\gitdata\TpIf\app\admin\view\index\main.html";i:1586942709;s:42:"D:\gitdata\TpIf\app\admin\view\layout.html";i:1593231796;}*/ ?>
<!DOCTYPE html>
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
                    <a  lay-event="window" data-btn="确定" data-uri="<?php echo url($sub['controller_name'].'/'.$sub['action_name']); ?>" class="layui-menu-tips" target="<?php echo htmlentities($sub['target']); ?>" admin-menu-id="<?php echo htmlentities($sub['id']); ?>" admin-data="<?php echo htmlentities($sub['data']); ?>" data-width="700" data-height="600" data-title="查看详情" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
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
            <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">快捷方式</div>
                    <div class="layui-card-body">

                        <div class="layui-carousel layadmin-carousel layadmin-shortcut"
                             style="width: 100%; height: 280px;" lay-anim="" lay-indicator="inside"
                             lay-arrow="none">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs3">
                                        <a lay-href="home/homepage1.html">
                                            <i class="layui-icon layui-icon-console"></i>
                                            <cite>主页一</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="home/homepage2.html">
                                            <i class="layui-icon layui-icon-chart"></i>
                                            <cite>主页二</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="component/layer/list.html">
                                            <i class="layui-icon layui-icon-template-1"></i>
                                            <cite>弹层</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a layadmin-event="im">
                                            <i class="layui-icon layui-icon-chat"></i>
                                            <cite>聊天</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="component/progress/index.html">
                                            <i class="layui-icon layui-icon-find-fill"></i>
                                            <cite>进度条</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="app/workorder/list.html">
                                            <i class="layui-icon layui-icon-survey"></i>
                                            <cite>工单</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="user/user/list.html">
                                            <i class="layui-icon layui-icon-user"></i>
                                            <cite>用户</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/system/website.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>设置</cite>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="layui-row layui-col-space10">
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs3">
                                        <a lay-href="set/user/info.html">
                                            <i class="layui-icon layui-icon-set"></i>
                                            <cite>我的资料</cite>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                            <div class="layui-carousel-ind">
                                <ul>
                                    <li class="layui-this"></li>
                                    <li class></li>
                                </ul>
                            </div>
                            <button class="layui-icon layui-carousel-arrow" lay-type="sub"></button>
                            <button class="layui-icon layui-carousel-arrow" lay-type="add"></button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">待办事项</div>
                    <div class="layui-card-body">

                        <div class="layui-carousel layadmin-carousel layadmin-backlog"
                             style="width: 100%; height: 280px;" lay-anim="" lay-indicator="inside"
                             lay-arrow="none">
                            <div carousel-item="">
                                <ul class="layui-row layui-col-space10 layui-this">
                                    <li class="layui-col-xs6">
                                        <a lay-href="app/content/comment.html" class="layadmin-backlog-body">
                                            <h3>待审评论</h3>
                                            <p><cite>66</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs6">
                                        <a lay-href="app/forum/list.html" class="layadmin-backlog-body">
                                            <h3>待审帖子</h3>
                                            <p><cite>12</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs6">
                                        <a lay-href="template/goodslist.html" class="layadmin-backlog-body">
                                            <h3>待审商品</h3>
                                            <p><cite>99</cite></p>
                                        </a>
                                    </li>
                                    <li class="layui-col-xs6">
                                        <a href="javascript:;" onclick="layer.tips('不跳转', this, {tips: 3});"
                                           class="layadmin-backlog-body">
                                            <h3>待发货</h3>
                                            <p><cite>20</cite></p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="layui-row layui-col-space10">
                                    <li class="layui-col-xs6">
                                        <a href="javascript:;" class="layadmin-backlog-body">
                                            <h3>待审友情链接</h3>
                                            <p><cite style="color: #FF5722;">5</cite></p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="layui-carousel-ind">
                                <ul>
                                    <li class="layui-this"></li>
                                    <li></li>
                                </ul>
                            </div>
                            <button class="layui-icon layui-carousel-arrow" lay-type="sub"></button>
                            <button class="layui-icon layui-carousel-arrow" lay-type="add"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">数据概览</div>
                    <div class="layui-card-body">

                        <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade"
                             lay-filter="LAY-index-dataview" style="width: 100%; height: 280px;" lay-anim="fade"
                             lay-indicator="inside" lay-arrow="none">
                            <div carousel-item="" id="LAY-index-dataview">
                                <div class="layui-this" _echarts_instance_="1569803434935"
                                     style="-webkit-tap-highlight-color: transparent; user-select: none; cursor: default; background-color: rgba(0, 0, 0, 0);">
                                    <div style="position: relative; overflow: hidden; width: 660px; height: 332px;">
                                        <div data-zr-dom-id="bg" class="zr-element"
                                             style="position: absolute; left: 0px; top: 0px; width: 660px; height: 332px; user-select: none;"></div>
                                        <canvas width="660" height="332" data-zr-dom-id="0" class="zr-element"
                                                style="position: absolute; left: 0px; top: 0px; width: 660px; height: 332px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas>
                                        <canvas width="660" height="332" data-zr-dom-id="1" class="zr-element"
                                                style="position: absolute; left: 0px; top: 0px; width: 660px; height: 332px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas>
                                        <canvas width="660" height="332" data-zr-dom-id="_zrender_hover_"
                                                class="zr-element"
                                                style="position: absolute; left: 0px; top: 0px; width: 660px; height: 332px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas>
                                    </div>
                                </div>
                                <div></div>
                                <div></div>
                            </div>
                            <div class="layui-carousel-ind">
                                <ul>
                                    <li class="layui-this"></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                            <button class="layui-icon layui-carousel-arrow" lay-type="sub"></button>
                            <button class="layui-icon layui-carousel-arrow" lay-type="add"></button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>



        </div>
    </div>

    <script>

        
    </script>


</body>

</html>