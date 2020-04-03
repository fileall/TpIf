<?php
declare (strict_types=1);

namespace app\admin\controller;

use Exception;
use think\facade\Request;
use think\facade\Session;

class Login extends Loam
{
    //定义默认模型层
    protected $_modelName = 'Login';

    public function _initialize()
    {   
        parent::_initialize();
        $this->force();
    }

    public function index()
    {  
        if ($this->request::isPost()) {
            $username = Request::post('username', '');
            $password = Request::post('password', '');
            $captcha = Request::post('captcha', '');
            $rememberMe = Request::post('rememberMe');
            // 用户信息验证
            try {
                if (!captcha_check($captcha)) {
                    throw new Exception('验证码错误');
                }
                $this->model()::adminLogin($username, $password, $rememberMe);
            } catch (Exception $e) {
                $this->error("登陆失败：{$e->getMessage()}");
            }

         $this->success('登录成功！', (string)url('Index/index'));
        }

        $this->assign('token', token());
        return view();

    }


    /**
     * 验证码
     * @return mixed
     */
    public function captcha()
    {
        ob_clean();
        return captcha();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear();
        $this->success('欢迎下次登录！',(string)url('Login/index'));
    }


}