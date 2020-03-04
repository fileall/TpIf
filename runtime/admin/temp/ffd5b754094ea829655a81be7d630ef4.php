<?php /*a:2:{s:47:"E:\gitdata\TpIf\app\admin\view\index\index.html";i:1569752330;s:47:"E:\gitdata\TpIf\app\admin\view\layout_left.html";i:1583310752;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/plugins//layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/static/admin//lib/css/admin.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/plugins//font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="/static/plugins//jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/static/plugins//layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/js//common.js"></script>

</head>
<body class="layui-layout-body">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header" style="z-index: 1000">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" id="reload" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:void(0);" lay-href="<?php echo url('System/cache', ['navid'=>23,'menuid'=>23]); ?>"
                       lay-text="更新缓存" title="更新缓存">
                        <i class="fa fa-television iconfont" style="font-size: 14px">&#xe6f3;</i>
                    </a>
                </li>

                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite>
                            管理员
                        </cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="<?php echo url('profile'); ?>">基本资料</a></dd>
                        <dd><a lay-href="<?php echo url('Index/password'); ?>">修改密码</a></dd>
                        <hr>
                        <dd event='del' data-msg="您确定要退出吗?" href="javascript:;" data-uri="<?php echo url('Login/logout'); ?>"
                            style="text-align: center;cursor: pointer"><a>退出</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect="">
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme" title="切换主题">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <!--                <li class="layui-nav-item layui-hide-xs" lay-unselect>-->
                <!--                    <a href="javascript:;" layadmin-event="note" title="便签">-->
                <!--                        <i class="layui-icon layui-icon-note"></i>-->
                <!--                    </a>-->
                <!--                </li>-->

                <!--                <li class="layui-nav-item layui-hide-xs" lay-unselect>-->
                <!--                    <a href="javascript:;" layadmin-event="about"><i-->
                <!--                            class="layui-icon layui-icon-more-vertical"></i></a>-->
                <!--                </li>-->
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo">
                    <span>后台管理系统</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"
                    lay-filter="layadmin-system-side-menu">
                    <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$vo): ?>
                    <li class="layui-nav-item">
                        <a href="javascript:;" style="padding-left: 20px" lay-tips="<?php echo htmlentities($vo['name']); ?>" lay-direction="2">
                            <i class="<?php echo htmlentities((isset($vo['icon']) && ($vo['icon'] !== '')?$vo['icon']:'fa fa-television')); ?> iconfont"><?php echo htmlentities(htmlspecialchars_decode($vo['icontxt'])); ?></i>
                            <cite><?php echo htmlentities($vo['name']); ?></cite>
                        </a>
                        <?php if(!(empty($vo['_child']) || (($vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator ) && $vo['_child']->isEmpty()))): ?>
                        <dl class="layui-nav-child">
                            <?php if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator): if( count($vo['_child'])==0 ) : echo "" ;else: foreach($vo['_child'] as $key=>$vn): ?>
                            <dd data-name="admin">
                                <a lay-href="<?php echo url($vn['controller_name'].'/'.$vn['action_name'],array('menu_id'=>$vn['id'])); ?><?php echo htmlentities($vn['data']); ?>">
                                    <i class="<?php echo htmlentities((isset($vn['icon']) && ($vn['icon'] !== '')?$vn['icon']:'fa fa-television')); ?> iconfont"><?php echo htmlentities(htmlspecialchars_decode($vn['icontxt'])); ?></i>
                                    <?php echo htmlentities($vn['name']); ?>
                                </a>
                            </dd>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dl>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>


                </ul>


            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down" layadmin-event="rightPage">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="<?php echo htmlentities($href); ?>" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>

<script>

    var public = "/static/admin/";
    layui.config({
        base: public
    }).extend({
        index: 'lib/index'
    }).use('index')
</script>
</body>
</html>


