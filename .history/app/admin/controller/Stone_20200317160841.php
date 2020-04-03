<?php
declare(strict_types=1);

namespace app\admin\controller;

use think\App;
use think\facade\Request;

/**
 * 基石类（坚硬的石头类，为搭建提供基础）
 * Class Stone
 * @package app\admin\controller
 */
class Stone extends StoneAbstract
{

//    /**
//     * 采集模板变量
//     * @var array
//     */
//    protected $_assignData = [];

//    protected $_actionArray = [];
    /**
     * 开启自动模式
     * 自动模式执行子类继承的index,add,edit方法(前置后置操作均在display&success等操作之前）
     * @var bool
     */
    protected $force = true;

    /**
     * 子类所调用的默认模型层名称（与自动模式协同作用或者单独门面操作）
     * 如果子类未定义，则默认与控制器层名称一致
     * 支持一子类申明定义模型层名称
     * 支持二同样适合门面操作定义face($_modelName)定义
     * @var string
     */
    protected $_modelName;

    /**
     * 定制如果是异步返回的信息
     *
     * @var [mixed] $_msg
     */
    protected $_msg = '';

    /**
     * 定制如果是异步返回的跳转url
     *
     * @var [null] $_url
     */
    protected $_url = null;

    /**
     * 定制如果是异步返回的数据
     *
     * @var [mixed] $_data
     */
    protected $_data = '';

    /**
     * 跳转等待时间
     *
     * @var integer $_wait
     */
    protected $_wait = 3;

    /**
     * 自动模式支持方法
     * @var array
     */
    protected $_bindAction = [
        'index',
        'add',
        'edit'
    ];

   
    public function __construct()
    {  
        if (empty($this->_modelName)) {
            // 当前模型名
            $modelName = str_replace('\\', '/', static::class);
            $this->_modelName = basename($modelName);
        }
//        bind('Stone', $this);
        // 控制器初始化
        $this->_initialize();
    }

    // 初始化
    protected function _initialize()
    {
    }


    /**
     * 安全模式（关闭自动模式）
     * @access public
     * @param bool $force
     * @return $this
     */
    public function force(bool $force = false)
    {
        $this->force = $force;
        return $this;
    }

    /**
     * 判断force
     * @access public
     * @return bool
     */
    public function isForce(): bool
    {
        return $this->force;
    }


    
    /**
     * 获取当前模型名称并返回模型反射类静态调用
     *
     * @param string $name 模型层名称或者表名称
     * @param array $args  给构造方法传递参数
     * @param boolean $Lichen  是否启用后台继承模型
     * @return \app\facade\Faceplate
     */
    protected function model($name = '', $args= [], $Lichen = false)
    {
        if ($name) {
            return face($name, $args, $Lichen);
        }
       
        return face($this->_modelName, $args, $Lichen);
    }

    /**
     * 返回404
     * @return mixed|\think\response\View
     */
    protected function _empty()
    {
        return view(config('app.dispatch_error_html') . '404.html');
    }

    /*************************************自动模式开始********************************/
    /**
     * 调用实际类的方法
     * @param $method
     * @param $params
     * @return bool|mixed|\think\response\View
     */
    public function __call($method, $params)
    {
        if ($this->force && in_array($method, $this->_bindAction)) {
            $data = self::_indexAddEdit($method);
        } else {
            $data = $this->_empty();
        }
        //返回数据
        return $data;
    }


    /**
     * 仅支持通过function __call(),调用indexAddEdit方法。
     * @param $method
     * @return mixed|\think\response\View
     */
    protected function _indexAddEdit($method)
    {
        $data = [];
        if ($this->force) {
            $data = self::_actionBeforeAfter($method);
            $data = self::_throwMixed($data);
        }
        return $data;
    }

    /**
     * index & add & edit统一抛出
     * @param $data
     * @return mixed|\think\response\View
     */
    protected function _throwMixed($data)
    {
        if (false !== $data) {                  //执行成功
            if (!Request::isAjax()) {           //不是ajax
                $this->assign($data['assign']);
                return  view();                //执行到此，不会继续执行
            } else {                            //ajax
                $this->success($this->$_msg,self::$_url,self::$_data,self::$_wait); //执行到此，不会继续执行
            }
        } else {                                //执行失败
            $this->error(self::$_msg,self::$_url,self::$_data,self::$_wait);   //执行到此，不会继续执行
        }
        return $data;
    }


    /**
     * 调用执行具体方法。
     * @param string $action
     * @return mixed
     */
    protected function _actionBeforeAfter($action = 'index')
    {
        //获取输入数据
        $data = input();
        //转大驼峰
        $action = parse_name($action, 1);
        //定义前置方法名
        $_beforeAction = '_before' . $action;
        //定义后置方法名
        $_afterAction = '_after' . $action;
        //定义执行模型方法名
        $_linkActionAttr = '_link' . $action . 'Attr';


        //执行子类中的前置方法级操作(注：需要返回数据)
        if (method_exists($this, $_beforeAction)) {
            $data = $this->$_beforeAction($data);
        }

        //执行从模型中获取数据(注：需要返回数据）
        $data = self::model('', [], true)::$_linkActionAttr($data);

        //执行子类的中后置方法级操作(注：需要返回数据）
        if (method_exists($this, $_afterAction)) {
            $data = $this->$_afterAction($data);
        }

        //返回数据
        return $data;
    }



    /***************************************自动模式完成*****************************/
//    /**
//     * 模板变量赋值
//     * @access public
//     * @param string|array $name 模板变量
//     * @param mixed $value 变量值
//     * @return Stone
//     */
//    public function _assign($name, $value = null)
//    {
//        if (is_array($name)) {
//            $this->_assignData = array_merge($this->_assignData, $name);
//        } else {
//            $this->_assignData[$name] = $value;
//        }
//
//        return $this;
//    }
//
//
//    /**
//     * 渲染页面
//     * @param string $tpl
//     * @return \think\response\View
//     */
//    protected function view($tpl = '')
//    {
//        View::assign($this->_assignData);//dump($this->_assignData);die;
//        return view($tpl);
//    }
}
