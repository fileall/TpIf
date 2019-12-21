<?php
/**
 * +
 * | 后台中间件验证权限
 */

namespace app\admin\middleware;

use Closure;
use think\Request;


class AccessCheck
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed|\think\response\Redirect
     */
    public function handle(Request $request, Closure $next)
    {
        $controller = $request->controller();
        $action = $request->action();
        $sessionAdmin = session('admin');
//        dump($request);die;
        //session检测
//        dump(url('Login/index'));die;

        if (!$sessionAdmin && ($controller != 'Login')) {
            return redirect_url('Login/index');
        }
//        dump(3333);die;
        //鉴权验证（app\admin\model\AccessCheck）
        if ($sessionAdmin) {
                $flagPrivate = face('AccessCheck')::handle($controller, $action);
                if ($flagPrivate == false) {
                    return redirect_url('Index/index');
                }
        }


        //中间件handle方法的返回值必须是一个Response对象。
        return $next($request);


    }
}