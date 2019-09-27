<?php
/**
 * +
 * | 后台中间件验证权限
 */

namespace app\admin\middleware;

use Closure;
use think\Request;
use think\facade\Db;

class AccessCheck
{

    public function handle(Request $request, Closure $next)
    {

        //权限验证（app\admin\model\AccessCheck）
        face('AccessCheck')::handle($request);

        //中间件handle方法的返回值必须是一个Response对象。
        return $next($request);
    }
}