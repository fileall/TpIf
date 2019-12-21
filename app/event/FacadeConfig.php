<?php
/**
 * +
 * | 挂载面板控制配置
 */

namespace app\event;

use app\facade\Faceplate;
use Closure;
use think\Request;

class FacadeConfig
{

    /**
     * 操作句柄(事件系统默认操作handle)
     * 挂载面板控制类操作门面
     */
    public function handle(Request $request, Closure $next)
    {
        Faceplate::init((array)config('facade'));

        //中间件handle方法的返回值必须是一个Response对象。
        return $next($request);

    }
}