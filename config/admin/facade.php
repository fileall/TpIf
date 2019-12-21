<?php
// +----------------------------------------------------------------------
// | 参数设置
// +----------------------------------------------------------------------
use app\admin\controller\Stone;
use app\admin\model\stone\{
    Menu,
    AccessCheck,
    Role,
    Login
};
use app\model\Data;

return [

    //配置信息
    'Data' => Data::class,
    'Stone' => Stone::class,
    'Login' => Login::class,
    'Menu' => Menu::class,
    'AccessCheck' => AccessCheck::class,
    'Role' => Role::class

];
