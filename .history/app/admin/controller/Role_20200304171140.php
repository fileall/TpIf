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
        $admin_rule = AuthRule::field('id, pid, title')
            ->where('status',1)
            ->order('sort asc')
            ->select()->toArray();
        $rules = AuthGroup::where('id', Request::param('id'))
            ->where('status',1)
            ->value('rules');

        $group_id = Request::param('id');
        $idList = AuthRule::column('id');
        $list = auth_checked($admin_rule, $pid = 0, $rules);
        sort($idList);
        $view = [
            'list' => $list,
            'idList' => $idList,
            'group_id' => $group_id,
        ];
        $this->assign($assign);
        return view();
    }
}
