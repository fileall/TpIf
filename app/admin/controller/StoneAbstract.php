<?php

namespace app\admin\controller;

/**
 * 后台基类必须实现的方法
 * Class StoneAbstract
 * @package app\admin\controller
 */
abstract class StoneAbstract
{

    /**
     * 空方法的定义
     * @return mixed
     */
    abstract protected function _empty();


    /**
     * 调用实际类的方法
     * @param $method
     * @param $params
     * @return mixed
     */
    abstract public function __call($method, $params);

    /**
     * 仅支持通过function __call(),调用indexAddEdit方法。
     * @param $method
     * @return mixed
     */
    abstract protected function _indexAddEdit($method);

    /**
     * 调用执行具体方法。
     * @param $action
     * @return mixed
     */
    abstract protected function _actionBeforeAfter($action);

    /**
     * index & add & edit统一抛出
     * @param $data
     * @return mixed
     */
    abstract protected function _throwMixed($data);
}
