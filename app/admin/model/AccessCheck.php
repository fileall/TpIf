<?php
namespace app\admin\model;

use think\facade\Db;
use think\Model;
use think\Request;
use think\facade\Session;

class AccessCheck extends Model
{
    protected $name = 'menu';

    public function handle(Request $request){
//        Session::set('name', 'thinkphp');
//        dump(session('admin','wqerqw'));
        dump(session());die;
        $flag = true;
        $controller = $request->controller();
        $action = $request->action();
        $check_no = config('const.check_no_controller_action');
        if ($check_no) {
            if ($check_no[$controller] == true) {
                $flag = false;
            } elseif ($check_no[$controller][$action]) {
                $flag = false;
            }

        }
        if ($flag) {
            $rules = Db::name('menu')->alias('a')
                ->join('auth_group ag', 'a.group_id = ag.id', 'left')
                ->where($map)
                ->value('ag.rules');
        }
    }

}