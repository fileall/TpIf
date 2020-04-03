<?php

namespace app\admin\controller;

class Role extends Loam
{
    //定义模型层表名称
    protected $_modelName = 'role';

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
        $role_id = $this->request::get('id');
        // 所有显示的菜单
        $menus = face('menu')::menuGet($role_id, null, true);
        // 菜单格式化
        $menus = access_to_tree($menus, 0, $role_id);
       
        array_column($menus,'id');
        sort($menus);
        $assign = [
            'list' => $menus,
            'id_list' => $id_list,
            'group_id' => 1,
        ];
        $this->assign($assign);
        return view();
    }

    public function accessAdd()
    {
        $data = $this->request::post('data');
        $role_id = $this->request::post('role_id');
        if (empty($data) || empty($role_id)) {
            $this->error('参数缺失');
        }
        
        $auth = tree_to_array($data);
        $result = $this->model()::accessAdd($role_id, $auth);
        if ($result !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}
