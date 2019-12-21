<?php
// +----------------------------------------------------------------------
// | 参数设置
// +----------------------------------------------------------------------

return [
    //后台系统配置缓存文件名
    'config_cache_name' => 'site_config',            //系统设置绑定文件名
    'admin_login_key' => 'DadiNdDP23sgdkdd',            //系统设置绑定文件名

    //后台权限白名单过滤（白名单的控制器仅支持二维数组，方法。如果该控制器下，所有方法都过滤，则给控制器键值赋值true）
    'check_controller_action_not' => [
        'Login' => true,
        'Index' => true,

    ]

];
