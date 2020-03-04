<?php
/**
 * +
 * / 控制面板类（门面托管类)
 */

namespace app\facade;

use think\exception\ClassNotFoundException;
use think\facade;

/**
 * 私自定义控制面板类（实现应用业务逻辑类的调用）
 * Class Faceplate
 * TODO::AccessCheck 类
 * @see \app\admin\model\stone\AccessCheck
 * @mixin \app\admin\model\stone\AccessCheck
 * TODO::Menu 类
 * @see \app\admin\model\stone\Menu
 * @mixin \app\admin\model\stone\Menu
 * TODO::Login 类
 * @see \app\admin\model\stone\Login
 * @mixin \app\admin\model\stone\Login
 * TODO::Role 类
 * @see \app\admin\model\stone\Role
 * @mixin \app\admin\model\stone\Role
 */
final class Faceplate extends facade
{
    /**
     * 控制面板当前的类名
     * @var string $facade
     */
    protected static $facade = '';
    /**
     * 控制面板当前的类名传递构造函数参数
     * @var array $args
     */
    protected static $args = [];



    /**
     * 返回门面
     * @param string $facade
     * @param array $args
     * @param bool $Lichen
     * @return mixed
     */
    public static function hasFacade(string $facade, array $args = [])
    {

        static::$facade = $facade;
        $args ? static::$args = $args : [];
        
        return  static::class;
    }
   
         
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return static::$facade;
    }


    // 调用实际类的方法()
    public static function __callStatic($method, $params)
    {
        return call_user_func_array([static::createFacade(self::$facade, self::$args), $method], $params);
    }
}
