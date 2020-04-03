<?php
declare(strict_types=1);

namespace app\admin\controller;

use think\exception\ClassNotFoundException;
use think\exception\HttpResponseException;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

/**
 * 土壤类（土壤依赖于基石，为搭建提供基础）
 * Class Loam
 * @property-read string $view
 * @property-read string $db
 * @property-read string $request
 * @package app\admin\controller
 */

class Loam extends Stone
{
    protected $_menuId;
    /**
     * 私自引用类名,对IDE不友好,尽量少操作。
     * @var array
     */
    private $_bindConst = [
        'db' => Db::class,   //Db操作类
        'view' => View::class, //视图类
        'request' => Request::class, //请求类
    ];

    public function __construct()
    {  
        parent::__construct();
        $this->init();
    }

    /**
     * 初始化子菜单
     */
    
    protected function init()
    {
        $this->_menuId = Request::get('menu_id', '0');
        //同级菜单
        if ($this->_menuId) {
            $_sub_menu = face('menu')::subMenuGet(1,1, $this->_menuId);//dump($sub_menu);die;
            $assign = [
                '_sub_menu' => $_sub_menu ?? [],
                'menu_id' => $this->_menuId
            ];

            $this->assign($assign);
        }
    }

    protected function assign($name, $value = null)
    {
        view::assign($name, $value);
    }

    /**
     * 统一返回JSON格式(用于前端的页面列表数据返回)
     * @param array $list
     * @param string $msg
     * @param int $code
     * @param int $count
     * @return array
     */
    protected function _dataJson(array $list = [], $count = 0, $msg = '执行成功！', $code = 0, $f)
    {
        $data['data'] = $list;
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['count'] = $count;
        return $data;
    }



    /**
     * 操作成功跳转的快捷方法
     * @param string $msg  提示信息
     * @param string|null $url 跳转的URL地址
     * @param string $data 返回的数据
     * @param int $wait 跳转等待时间
     * @param array $header 发送的Header信息
     */
    protected function success($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }
        $result = [
            'status' => 1,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html') {
            $response = view(config('app.dispatch_success_tmpl'), $result);
        } elseif ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed $msg 提示信息
     * @param string $url 跳转的URL地址
     * @param mixed $data 返回的数据
     * @param integer $wait 跳转等待时间
     * @param array $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = $this->request::isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }
        $result = [
            'stats' => 0,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];
        $type = $this->getResponseType();
        if ($type == 'html') {
            $response = view(config('app.dispatch_error_tmpl'), $result);
        } elseif ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
        return $this->request::isJson() || $this->request::isAjax() ? 'json' : 'html';
    }

    /**
     * 获取私有属性（返回反射类路径）
     * @param $bindConst
     * @return mixed
     */
    protected function get($bindConst)
    {
        if (isset($this->_bindConst[$bindConst])) {
            return $this->_bindConst[$bindConst];
        }
        throw new ClassNotFoundException('var not exists: ' . $bindConst, $bindConst);
    }


    /**
     * 实现变量获取魔术方法
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        return $this->get($name);
    }
}
