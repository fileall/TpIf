<?php
// 应用公共文件
declare (strict_types=1);


//------------------------
//  公共定义通用函数
//-------------------------

use app\facade\Faceplate;

if (!function_exists('face')) {
    /**
     * 通过控制面板调制门面
     * @param $class
     * @return Faceplate
     */
    function face($class)
    {
        return Faceplate::hasFacade($class);
    }

}