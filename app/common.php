<?php
// 应用公共文件
declare (strict_types=1);

//------------------------
//  公共定义通用函数
//-------------------------

/**
 * 请遵循以下规范命名
 *
 * 函数和类、属性命名
 * 类的命名采用驼峰法（首字母大写），例如 User、UserType；
 * 函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 get_client_ip；
 * 方法的命名使用驼峰法（首字母小写），例如 getUserName；
 * 属性的命名使用驼峰法（首字母小写），例如 tableName、instance；
 * 特例：以双下划线__打头的函数或方法作为魔术方法，例如 __call 和 __autoload；
 *
 * 常量和配置
 * 常量以大写字母和下划线命名，例如 APP_PATH；
 * 配置参数以小写字母和下划线命名，例如 url_route_on 和url_convert；
 * 环境变量定义使用大写字母和下划线命名，例如APP_DEBUG；
 */

use app\facade\Faceplate;
use think\facade\Route;
use think\response\Redirect;
use app\model\Data;
use think\route\Url as UrlBuild;

if (!function_exists('face')) {
    /**
     * 通过控制面板调制门面
     * @param $class
     * @return Faceplate
     */
    function face($class)
    {
        $class = parse_name($class, 1);
//
//        if (empty($class)) return new Data;
//        static $_model = array();
//        $layer = $layer ?: C('DEFAULT_M_LAYER');
//        if (isset($_model[$name . $layer]))
//            return $_model[$name . $layer];
//        $class = parse_res_name($name, $layer);
//        if (class_exists($class)) {
//            $model = new $class(basename($name));
//        } elseif (false === strpos($name, '/')) {
//            // 自动加载公共模块下面的模型
//            if (!C('APP_USE_NAMESPACE')) {
//                import('Common/' . $layer . '/' . $class);
//            } else {
//                $class = '\\Common\\' . $layer . '\\' . $name . $layer;
//            }
//            $model = class_exists($class) ? new $class($name) : new Think\Model($name);
//        } else {
//            Think\Log::record('D方法实例化没找到模型类' . $class, Think\Log::NOTICE);
//            $model = new Think\Model(basename($name));
//        }
//        $_model[$name . $layer] = $model;

        return Faceplate::hasFacade($class);
    }
}

if (!function_exists('array_intersect_mixed')) {
    /**
     * 运算二维数组（PHP底层函数array_intersect仅支持简单数组的组合，为方便功能需求进行下列组合）
     * 支持模式一，传数组$master,$key,即为指定一个下标键值作为键名，并返回新数组
     * 支持模式二，传数组$master,$key,$branch,$force 在$master中比较有无存在$branch标识,二者以$key键名关联
     * $force 默认为false 仅取主数组$master中的数据，并以此返回新数组。
     * $force 主动设置为true 取数组$master & $branch 组合数据，并以此返回新数组。
     * 注意传入的主从数组 $master & $branch ,在此函数释放。
     * @param array $master 主数组
     * @param string $key 关联键名
     * @param array $branch 从数组
     * @param bool $force false 返回交集，true返回并集
     * @return array
     */
    function array_intersect_mix(array $master, string $key, array $branch, bool $force = false): array
    {
        $branch_arr = $master_arr = [];
        $branch_multi = true;                                          //$branch默认是多维数组
        if ($branch) {
            if (count($branch) == count($branch, 1)) {
                $branch_multi = false;                                 //设置是一维数组
            }
            foreach ($branch as &$item) {
                if ($branch_multi == false) {                          //一维数组
                    $branch_arr[$item] = $item;
                } else {
                    $branch_arr[$item[$key]] = $item;
                }
            }
        }
        unset($branch);
        foreach ($master as $k => $v) {
            if ($branch_arr) {
                if ($branch_arr[$v[$key]]) {                           //返回交集
                    if ($force == false || $branch_multi == false) {   //不合并数组
                        $master_arr[$k] = $v;
                    } else {                                           //合并数组
                        $master_arr[$k] = array_merge($v, $branch_arr[$v[$key]]);
                    }
                }
            } else {
                $master_arr[$v[$key]][] = $v;
            }
        }
        unset($master);
        return $master_arr;
    }
}


if (!function_exists('anonymity')) {
    /**
     * 匿名处理
     * @param $name
     * @return string
     */
    function anonymity($name)
    {
        $strLen = mb_strlen($name, 'UTF-8');
        $min = 3;
        if ($strLen <= 1)
            return '*';
        if ($strLen <= $min)
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $min - 1);
        else
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $strLen - 1) . mb_substr($name, -1, 1, 'UTF-8');
    }
}


if (!function_exists('time_tran')) {
    /**
     * 时间的运算
     * @param $time
     * @return bool|string
     */
    function time_tran($time)
    {
        $t = time() - $time;
        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
        return false;
    }
}


if (!function_exists('debug_get')) {
    /**
     * 统一获取app_debug配置方式方式（便于移殖）
     * @return mixed
     */
    function debug_get()
    {
        return env('app_debug');
    }
}


if (!function_exists('redirect_url')) {
    /**
     * 重定向自动获取应用名（框架redirect方法 不支持自动获取应用名）
     * @param string $url 路由地址
     * @param array $vars 变量
     * @param bool $suffix 生成的URL后缀
     * @param bool $domain 域名
     * @return Redirect
     */
    function redirect_url(string $url = '', array $vars = [], $suffix = true, $domain = false): Redirect
    {
        $url_domain = Route::buildUrl($url, $vars)->suffix($suffix)->domain($domain);
        return redirect((string)$url_domain);
    }
}

if (!function_exists('format_where')) {
    /**
     * tp官方数组查询方法废弃，数组转化为现有支持的查询方法
     * @param array $data 原始查询条件
     * @return array
     */
    function format_where($data)
    {
        $where = [];
        foreach ($data as $k => $v) {
            if ($v || $v == '0') {
                if (is_array($v)) {
                    if ($v[0] == 'like') {
                        $v[1] = '%' . $v[1] . '%';
                    }
                    if ($v[1] && $v[1] <> '%%') {
                        $where[] = [$k, $v[0], $v[1]];
                    }
                } else {
                    $where[] = [$k, '=', $v];
                }
            }
        }
        return $where;
    }

}

function stripslashes_deep($value)
{
    if (is_array($value)) {
        $value = array_map('stripslashes_deep', $value);
    } elseif (is_object($value)) {
        $vars = get_object_vars($value);
        foreach ($vars as $key => $data) {
            $value->{$key} = stripslashes_deep($data);
        }
    } elseif (is_string($value)) {
        $value = stripslashes($value);
    }
    return $value;
}




