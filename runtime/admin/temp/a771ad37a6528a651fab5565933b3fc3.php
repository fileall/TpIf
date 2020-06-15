<?php /*a:2:{s:47:"D:\gitdata\TpIf\app\admin\view\index\index.html";i:1591872101;s:47:"D:\gitdata\TpIf\app\admin\view\layout_left.html";i:1591872101;}*/ ?>
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
    <link rel="stylesheet" type="text/css" href="/static/admin/css//admin.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/admin/css//public.css" media="all">
    <link rel="stylesheet" type="text/css" href="/static/plugins//font-awesome-4.7.0/css/font-awesome.min.css">
    
    <style id="admin-bg-color">
    </style>
</head>
<body class="layui-layout-body">
        <div class="layui-layout layui-layout-admin">
          <div class="layui-header">
            <div class="layui-logo">layui 后台布局</div>
            <a>
                <div class="admin-tool"><i title="展开" class="fa fa-outdent" data-side-fold="1"></i></div>
            </a>
            <!-- 头部区域（可配合layui已有的水平导航） -->
            <!-- <ul class="layui-nav layui-layout-left">
              <li class="layui-nav-item"><a href="">控制台</a></li>
              <li class="layui-nav-item"><a href="">商品管理</a></li>
              <li class="layui-nav-item"><a href="">用户</a></li>
              <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                  <dd><a href="">邮件管理</a></dd>
                  <dd><a href="">消息管理</a></dd>
                  <dd><a href="">授权管理</a></dd>
                </dl>
              </li>
            </ul> -->
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;" data-refresh="刷新"><i class="fa fa-refresh"></i></a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" data-clear="清理" data-href="<?php echo url('cleardata'); ?>" class="LM-clear"><i class="fa fa-trash-o"></i></a>
                </li>
              <li class="layui-nav-item">
                <!-- <a href="javascript:;">
                  <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                  贤心
                </a> -->
                
                <dl class="layui-nav-child">
                  <dd><a href="">基本资料</a></dd>
                  <dd><a href="">安全设置</a></dd>
                </dl>
              </li>
              <li class="layui-nav-item"><a href="">退了</a></li>
              <li class="layui-nav-item admin-select-bgcolor mobile layui-hide-xs">
                <a href="javascript:;" data-bgcolor="配色方案"><i class="fa fa-ellipsis-v"></i></a>
            </li>
            </ul>
          </div>
    
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll layui-left-menu">
                  <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                  <ul class="layui-nav layui-nav-tree"  lay-filter="admin">
                    <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$vo): ?>
                    <li class="layui-nav-item">
                        <a href="javascript:;" class="layui-menu-tips" style="padding-left: 20px" admin-tips="<?php echo htmlentities($vo['name']); ?>" admin-direction="2">
                            <i class="<?php echo htmlentities((isset($vo['icon']) && ($vo['icon'] !== '')?$vo['icon']:'fa fa-television')); ?> iconfont"><?php echo htmlentities(htmlspecialchars_decode($vo['icontxt'])); ?></i>
                            <span class="layui-left-nav"> <?php echo htmlentities($vo['name']); ?></span>
                        </a>
                        <?php if(!(empty($vo['_child']) || (($vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator ) && $vo['_child']->isEmpty()))): ?>
                        <dl class="layui-nav-child">
                            <?php if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator): if( count($vo['_child'])==0 ) : echo "" ;else: foreach($vo['_child'] as $key=>$vn): ?>
                            <dd data-name="admin">
                                <a admin-href="<?php echo url($vn['controller_name'].'/'.$vn['action_name']); ?><?php echo htmlentities($vn['data']); ?>" 
                                   admin-type="tabAdd" admin-menu-id="<?php echo htmlentities($vn['id']); ?>" target="<?php echo htmlentities($vn['target']); ?>" class="layui-menu-tips">
                                    <i class="<?php echo htmlentities((isset($vn['icon']) && ($vn['icon'] !== '')?$vn['icon']:'fa fa-television')); ?> iconfont"><?php echo htmlentities(htmlspecialchars_decode($vn['icontxt'])); ?></i>
                                    <span class="layui-left-nav"><?php echo htmlentities($vn['name']); ?></span> 
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

    
             
<!-- <div class="layui-body">
    <div class="layui-tab" lay-filter="adminTab" id="top_tabs_box">
        <ul class="layui-tab-title" id="top_tabs">
            <li class="layui-this" id="adminHomeTabId" lay-id=""></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
                <a href="javascript:;"> <i class="fa fa-dot-circle-o"></i> 页面操作</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" data-page-close="other"><i class="fa fa-window-close"></i> 关闭其他</a></dd>
                    <dd><a href="javascript:;" data-page-close="all"><i class="fa fa-window-close-o"></i> 关闭全部</a></dd>
                </dl>
            </li>
        </ul> -->
      
    <!-- 内容主体区域 -->
    <!-- <div id="adminTabIframe" >
        <iframe src="<?php echo htmlentities($href); ?>" frameborder="0" ></iframe>
    </div>
  </div>
  </div> -->
  <div class="layui-body">
      <div class="layui-tab" lay-filter="adminTab" id="top_tabs_box">
          <ul class="layui-tab-title" id="top_tabs">
              <li class="layui-this" id="adminHomeTabId" lay-id=""></li>
          </ul>
          <ul class="layui-nav closeBox">
              <li class="layui-nav-item">
                  <a href="javascript:;"> <i class="fa fa-dot-circle-o"></i> 页面操作</a>
                  <dl class="layui-nav-child">
                      <dd><a href="javascript:;" data-page-close="other"><i class="fa fa-window-close"></i> 关闭其他</a></dd>
                      <dd><a href="javascript:;" data-page-close="all"><i class="fa fa-window-close-o"></i> 关闭全部</a></dd>
                  </dl>
              </li>
          </ul>
          <div class="layui-tab-content clildFrame">
              <div id="adminHomeTabIframe"  class="layui-tab-item layui-show">
                  <!-- <iframe src="<?php echo htmlentities($href); ?>" class="admin-home-iframe" frameborder="0" ></iframe> -->
              </div>
          </div>
      </div>
  </div>
 
        <!-- <div class="layui-body">
            <div class="layui-tab" lay-filter="layuiminiTab" id="top_tabs_box">
                <ul class="layui-tab-title" id="top_tabs">
                    <li class="layui-this" id="layuiminiHomeTabId" lay-id=""></li>
                </ul>
                <ul class="layui-nav closeBox">
                    <li class="layui-nav-item">
                        <a href="javascript:;"> <i class="fa fa-dot-circle-o"></i> 页面操作</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" data-page-close="other"><i class="fa fa-window-close"></i> 关闭其他</a></dd>
                            <dd><a href="javascript:;" data-page-close="all"><i class="fa fa-window-close-o"></i> 关闭全部</a></dd>
                        </dl>
                    </li>
                </ul>
                <div class="layui-tab-content clildFrame">
                    <div id="layuiminiHomeTabIframe" class="layui-tab-item layui-show">
                    </div>
                </div>
            </div>
        </div>  -->
    
    </div>
    <script type="text/javascript" src="/static/plugins//jquery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/static/plugins//layui/layui.js"></script>
    <!-- <script type="text/javascript" src="/static/admin/js//layuimini.js"></script> -->
    <script type="text/javascript" src="/static/admin/js//common.js"></script>

    <script>
      //JavaScript代码区域
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    // layui.use('element', function () {
    //     var element = layui.element;
    //     element.init();
    //     //…
    // })
    var href = "<?php echo htmlentities($href); ?>";
    layui.config({
        base: "/static/admin/js/",
        version: true
    }).extend({
        admin: "admin"
    }).use(['element', 'layer', 'admin'], function () {
        var $ = layui.jquery,
            element = layui.element,
            layer = layui.layer;

            admin.init(href);
    });
    </script>
    </body>
</html>


