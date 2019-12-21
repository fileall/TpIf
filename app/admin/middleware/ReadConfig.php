<?php
/**
 * +
 * | 挂载后台系统配置
 */

namespace app\admin\middleware;

use Closure;
use think\facade\Db;
use think\Request;

class ReadConfig
{

    /**
     * 操作句柄(事件系统默认操作handle)
     * 挂载后台系统配置
     */
    public function handle(Request $request, Closure $next)
    {
        //读取基本参数
        $config_cache_name = config('const.config_cache_name');
        $configs = cache($config_cache_name);

        if (!$configs) {
            $configs = Db::name('admin_config')->field('name,value')->select()->toArray();
            debug_get() or cache($config_cache_name, $configs);
        }

        //加入配置文件中
        foreach ($configs as $config) {
            config([$config['name'] => $config['value']], $config_cache_name);
        }

        //中间件handle方法的返回值必须是一个Response对象。
        return $next($request);


    }
}