<?php /*a:2:{s:36:"E:\gitdata\TpIf\/view/error/404.html";i:1499131106;s:42:"E:\gitdata\TpIf\app\admin\view\layout.html";i:1583300888;}*/ ?>
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
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>404 Not Found - 404.html - AMH [LNMP]</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
body {
	font-size: 12px;
	font-family:Arial,宋体;
	margin:0px;
	padding:0px;
	-webkit-text-size-adjust:none;
	padding:70px 0px;
	color:#4F6F7D;
	background:#F6F6F6;
}
h1 {
	font-size:25px;
	color: #87A0A7;
	margin:20px 0px;
	padding:0px;
}
a {
	cursor: pointer;
	outline:none; 
	color:#7698A7;
	blr:expression(this.onFocus=this.blur());
	text-decoration: none;
}
pre {
	background:#fff;
	padding:20px;
	margin:20px 5%;
	width:82%;
	line-height:22px;
	font-family:Arial,宋体;
	border-bottom:9px solid #E7EFF1;
	box-shadow: 1px 0px 5px rgba(100, 100, 100, 0.3);
}
p {
	font-size:10px;
	_font-size:9px;
	margin:20px 5%;
	width:82%;
	color:#919191;
}
</style>
</head>

<BODY>

<pre>
<h1>404 Not Found - 404.html</h1>
您所访问的资源已不存在。
查看更多请返回网站主页。
» <a href="http://amc.0791jr.com">amc.0791jr.com</a>

</pre>
<p>基于<a href="http://amysql.com/AMH.htm">AMH</a> [<a href="http://amysql.com/AMH.htm">lnmp</a>] 架构为您提供快速安全高效的用户体验。
<br />Powered by <a href="http://amysql.com/">Amysql.com</a> </p>
</BODY>
</HTML>


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