<?php
/**
 * +
 * | 挂载面板控制配置
 */

namespace app\event;

use app\facade\Faceplate;

class FacadeConfig
{

    /**
     * 操作句柄(事件系统默认操作handle)
     * 挂载面板控制类操作门面
     */
    public function handle()
    {
        Faceplate::init((array)config('facade'));
    }
}