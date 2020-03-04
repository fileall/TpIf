<?php
// +----------------------------------------------------------------------
// | 参数设置
// +----------------------------------------------------------------------
use app\admin\controller\Stone;
use app\admin\model\stone\Menu;
use app\admin\model\stone\AccessCheck;
// use app\admin\model\stone\Role;
use app\admin\model\stone\Login;
use app\admin\model\stone\Lichen;
use app\model\Warmth;
use app\admin\controller\Auth;
use app\admin\controller\Role;

return [

    'root_dir' => app()->getRootPath(),

    'prefix_dirs' => [
        'admin' =>
        array(
            0 =>  'app\admin\model',
            1 =>  'app\admin\model\stone',
        ),
        'app' =>
        array(
            0 =>  'app\model',
        ),
            
    ],
    //配置信息
    'Warmth' => Warmth::class,
    'Stone' => Stone::class,
    'Login' => Login::class,
    'Menu' => Menu::class,
    'AccessCheck' => AccessCheck::class,
    'Auth' => Auth::class,
    'Role' => Role::class,
    'Lichen' => Lichen::class

];
