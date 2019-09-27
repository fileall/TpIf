<?php
// +----------------------------------------------------------------------
// | 参数设置
// +----------------------------------------------------------------------

return [
    //后台系统配置缓存文件名
    'config_cache_name' => 'site_config',            //系统设置绑定文件名
    //模板配置信息
    'html_parse_string' => [
        'public' => '/static/admin',        // 更改默认的__PUBLIC__ 替换规则
        'img' => '/static/admin/images',
        'css' => '/static/admin/css',
        'js' => '/static/admin/js',        // 增加新的JS类库路径替换规则
        'upload' => '/Uploads',                // 增加新的上传路径替换规则
        'plugins' => '/static/admin',         // 第三方组件引入路径
    ],
    //后台权限检查过滤（要检查的控制器，方法。如果该控制器下，所有方法都要进行检查，则给控制器名赋值true）
    'check_no_controller_action'  => [
         'Login' => [             //控制器名
            'login',              //方法名
            'index'
        ],

    ]

];
