<?php
// +----------------------------------------------------------------------
// | 路由设置
// +----------------------------------------------------------------------
use app\admin\middleware\AccessCheck;
return [

    'middleware'    =>    [
        AccessCheck::class   // 入口权限检查
    ],
];
