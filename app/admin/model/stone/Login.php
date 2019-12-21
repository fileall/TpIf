<?php
declare (strict_types = 1);
namespace app\admin\model\stone;

use Exception;
use think\facade\Session;
use think\Model;

class Login extends Model
{
    protected $name = 'admin';
    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
//        static::$model = new self();
    }

    /**
     * 根据用户名密码，验证用户是否能成功登陆
     * @param $userName
     * @param $password
     * @param $rememberMe
     * @return bool
     */
    public function adminLogin($userName, $password, $rememberMe)
    {
        try {
            $where['uname'] = strip_tags(trim($userName));
            $password = strip_tags(trim($password));
            $where['password'] = md5(config('const.admin_login_key') . $password);
            $info = $this->where($where)->find();

            if (!$info) {
                throw new Exception("请检查用户名或者密码");
            }
            if ($info['status'] == 0) {
                throw new Exception("账号已经被禁用");
            }

            if ($rememberMe) {
                Session::set('admin', $info);
            } else {
                Session::set('admin', $info);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

}