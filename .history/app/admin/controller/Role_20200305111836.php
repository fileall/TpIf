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
         $menus = $this->model()::menuGet(1,1);
         // 菜单格式化
         $menus = list_to_tree($menus, "id", "parent_id");dump($menus);die;
        sort($idList);
        $assign = [
            'list' => $list,
            'idList' => $idList,
            'group_id' => $group_id,
        ];
        $this->assign($assign);
        return view();
    }
}
