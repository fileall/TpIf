<?php
/**
 * +
 * | 挂载后台系统配置
 */

namespace app\admin\event;

use think\facade\Db;

class ReadConfig
{

    /**
     * 操作句柄(事件系统默认操作handle)
     * 挂载后台系统配置
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function handle()
    {   
        //读取基本参数
        $config_cache_name = config('const.config_cache_name');
        $configs = cache($config_cache_name);

        if (!$configs) {
            $configs = Db::name('config')->field('code,value')->select()->toArray();
            env('app_debug') or cache($config_cache_name, $configs);
        }

        //加入配置文件中
        foreach ($configs as $config) {
            config([$config['code'] => $config['value']], $config_cache_name);
        }

    }
}