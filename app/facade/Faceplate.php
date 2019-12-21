<?php
/**
 * +
 * / 控制面板类（门面托管类)
 */

namespace app\facade;

use app\model\Data;
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
     * 标识控制面板类中的门面
     * @var array
     */
    protected static $bindFacade = [];
    /**
     * 控制面板当前的类名
     * @var $facade
     */
    protected static $facade;

    /**
     * 注入控制面板类（初始化门面）
     * @param $bind
     */
    public static function init(array $bind)
    {
        static::$bindFacade = $bind;
    }

    /**
     * 检查面板中是否存在定义的门面
     * @param string $facade
     * @return mixed
     */
    public static function hasFacade(string $facade)
    {
        if (empty($facade)) return false;
        if (isset(static::$bindFacade[$facade])) { //精准调用业务模型
            static::$facade = static::$bindFacade[$facade];
            return static::class;
        } elseif (static::$bindFacade['Data']) {  //调用通过数据模型
            static::$facade = static::$bindFacade['Data'];
            return static::class;
        } else {                                  //抛出错误
            throw new ClassNotFoundException('class not exists: ' . $facade, $facade);
        }

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


}