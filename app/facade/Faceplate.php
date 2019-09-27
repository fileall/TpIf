<?php
/**
 * +
 * / 控制面板类加载可控门面
 */
namespace app\facade;

use think\exception\ClassNotFoundException;
use think\facade;

/**
 * 私自定义控制面板类，可控门面（处理业务控制类）
 * Class Faceplate
 * @method menu get_menu() static
 * @package app\admin\facade
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
        if (static::$bindFacade[$facade]) {
            static::$facade = static::$bindFacade[$facade];
            return static::class;
        }
        throw new ClassNotFoundException('class not exists: ' . $facade, $facade);
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