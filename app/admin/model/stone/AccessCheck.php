<?php

namespace app\admin\model\stone;

use think\Model;
use think\facade\Db;
use think\facade\Request;


class AccessCheck extends Model
{
    protected $name = 'admin_menu';

    public function handle($controller = null, $action = null,$roleId= null)
    {

        if($roleId == null) $roleId = session('admin');
        if(!$roleId) return false;

        $flag = true;        //操作进行鉴权验证（true 为要验证。false不进行拦截）
        $flagPrivate = true; //默认鉴权通过；

        if ($controller === null) $controller = Request::controller();
        if ($action === null) $action = Request::action();

        //获取过滤不需要鉴权的参数（array)
        $check_no = (array)config('const.check_controller_action_not');

        if ($check_no) {
            if (!isset($check_no[$controller])) {
                $flag = true;
            } elseif ($check_no[$controller] == true) {
                $flag = false;
            } elseif (in_array($action, $check_no[$controller])) {
                $flag = false;
            }

        }

        //进行鉴权
        if ($flag) {
            $rules = Db::name('admin_menu');

        }
        return $flagPrivate;
        
    }
}