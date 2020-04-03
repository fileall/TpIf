<?php

namespace app\admin\controller;

class Role extends Loam
{
    //定义模型层表名称
    protected $_modelName = 'admin_role';

    public function initialize()
    {
        // parent::__construct();
    }

    public function _beforeIndex($data)
    {
        // $temp = $this->model()::listGet();die;
        // $this->model('admin')::listGet();die;
        // dump($temp);die;
        // xdebug_debug_zval('data','copy');
        return $data;
    }

    public function dataIndexGet()
    {
        $data = $this->model()::listGet();
       
        return json($data);
    }

    public function _afterIndex($data)
    {
        return $data;
    }

  

    public function access()
    {
        // 所有显示的菜单
        $menus = face('menu')::menuGet(1, null, true);
        // 菜单格式化
        $menus = access_to_tree($menus, 0, 1);
        dump($menus);die;
        db
        $assign = [
            'list' => $menus,
            'idList' => 1,
            'group_id' => 1,
        ];
        $this->assign($assign);
        return view();
    }
}
