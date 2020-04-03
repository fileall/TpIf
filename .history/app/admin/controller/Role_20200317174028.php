<?php

namespace app\admin\controller;

class Role extends Loam
{
    //定义模型层表名称
    protected $_modelName = 'role';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function _beforeIndex($data)
    {
        if ($this->request::isAjax()) {           //不是ajax
            dump(22121);die;
            return  view();                //执行到此，不会继续执行
        }
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

  
    /**
     * 返回角色组权限列表
     */
    public function access()
    {
        $role_id = $this->request::get('id');
        // 所有显示的菜单
        $menu_list = face('menu')::menuGet($role_id, null, true);
        $id_list = array_column($menu_list,'id');
        // sort($id_list);
        // 菜单格式化
        $menus = access_to_tree($menu_list, 0, $role_id);
       
        $assign = [
            'list' => $menus,
            'id_list' => $id_list,
            'role_id' => $role_id,
        ];
        $this->assign($assign);
        return view();
    }
    /**
     * 角色权限提交编辑
     */
    public function accessEdit()
    {
        $data = $this->request::post('data');
        $role_id = $this->request::post('role_id');
        if (empty($data) || empty($role_id)) {
            $this->error('参数缺失');
        }
        
        $auth = tree_to_array($data);
        $result = $this->model()::accessEdit($role_id, $auth);
        if ($result !== false) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
}
