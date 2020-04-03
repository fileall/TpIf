<?php
namespace app\admin\controller;

use think\facade\Config;
use think\facade\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Auth extends Loam
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }



  
    /**
     * 返回角色组权限列表
     */
    public function access()
    {
        $role_id = $this->request::get('id');
        // 所有显示的菜单
        $menu_list = face('menu')::menuGet($role_id, null, true);
        $id_list = array_column($menu_list, 'id');
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

    


    /*-----------------------管理员管理----------------------*/
    // 管理员列表
    public function adminList()
    {
        if (Request::isPost()) {
            $where=Request::post();
            $map=[];
            $map1=[];
            $map2=[];
            if (isset($where['keys'])) {
                $map = [
                    ['a.username', 'like', "%" . $where['keys'] . "%"],

                ];
                $map1 = [
                    ['a.email', 'like', "%" . $where['keys'] . "%"],

                ];
                $map2= [
                    ['a.mobile', 'like', "%" . $where['keys'] . "%"],
                ];
            }
            $list=Db::name('admin')->alias('a')
                ->join('auth_group ag', 'a.group_id = ag.id', 'left')
                ->field('a.*,ag.title')
                ->whereOr($map, $map1, $map2)
                ->select();

            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list];
        }

        return View::fetch();
    }

    // 管理员添加
    public function adminAdd()
    {
        if (Request::isPost()) {
            $data = Request::post();
            try {
                $this->validate($data, 'Login');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            $data['password'] = md5(trim($data['password']));
            //添加
            $result = Admin::create($data);
            if ($result) {
                $this->success('管理员添加成功', url('adminList'));
            } else {
                $this->error('管理员添加失败');
            }
        } else {
            $info = '';
            $auth_group = AuthGroup::where('status', 1)
                ->select();
            $view = [
                'info'  =>$info,
                'authGroup' => $auth_group,
                'title' => '添加管理员',
            ];
            View::assign($view);
            return View::fetch();
        }
    }

    // 管理员删除
    public function adminDel()
    {
        $id = Request::post('id');
        if ($id > 1) {
            Admin::destroy($id);
            $this->success('删除成功!');
        } else {
            $this->error('超级管理员不可删除');
        }
    }



    // 管理员状态修改
    public function adminState()
    {
        if (Request::isPost()) {
            $id = Request::post('id');
            if (empty($id)) {
                $this->error('用户ID不存在!');
            }
            if ($id == 1) {
                $this->error('超级管理员不可修改状态!');
            }

            $admin = Admin::find($id);
            $status = $admin['status'] == 1 ? 0 : 1;
            $admin->status = $status;
            $admin->save();
            $this->success('修改成功!');
        }
    }

    /**
     * 管理员修改
     */
    public function adminEdit()
    {
        if (Request::isPost()) {
            $data = Request::post();
            if (!$data['username']) {
                $this->error('用户名不能为空');
            }
            if (!$data['password']) {
                $this->error('密码不能为空');
            }
            if (!$data['group_id']) {
                $this->error('用户组不能为空');
            }
            $admin = Admin::find($data['id']);
            if ($admin['password']==$data['password']) {
                unset($data['password']);
            } else {
                $data['password'] = Request::post('password', '123456', 'md5');
            }
            Admin::update($data);
            if (Session::get('admin.id')==$data['id']) {
                Session::set('admin', null);
            }
            $this->success('管理员修改成功!', url('Auth/adminList'));
        } else {
            $id = Request::param('id')?Request::param('id'):Session::get('admin.id');
            if ($id) {
                $auth_group = AuthGroup::select();
                $admin = Admin::find($id);
                $view = [
                    'info' => $admin,
                    'authGroup' => $auth_group,
                    'title' => '编辑用户',
                ];
                View::assign($view);
                return View::fetch('admin_add');
            }
        }
    }

    /*-----------------------用户组管理----------------------*/

    // 用户组管理
    public function group()
    {
        if (Request::isPost()) {
            //条件筛选
            $title = Request::param('title');
            //全局查询条件
            $where = [];
            if ($title) {
                $where[] = ['title', 'like', '%' . $title . '%'];
            }
            //显示数量
            $pageSize = Request::param('page_size', Config::get('app.page_size'));

            //查出所有数据
            $list =  Db::table('lm_auth_group')->where($where)
                ->paginate(
                    $this->pageSize,
                    false,
                    ['query' => Request::param()]
                )->toArray();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data']];
        }
        config::set(['layout_on'=>true], 'template');
        // dump(config::get());die;
        return View::fetch();
    }

    // 用户组删除
    public function groupDel()
    {
        $id = Request::post('id');
        if ($id > 1) {
            AuthGroup::destroy($id);
            $this->success('删除成功!');
        } else {
            $this->error('超级管理员组不可删除!');
        }
    }

    // 用户组添加
    public function groupAdd()
    {
        if (Request::isPost()) {
            $data = Request::post();
            try {
                $this->validate($data, 'AuthGroup');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            $result = AuthGroup::create($data);
            if ($result) {
                $this->success('用户组添加成功', 'Auth/adminGroup');
            } else {
                $this->error('用户组添加失败');
            }
        } else {
            $view = [
                'info' => null
            ];
            View::assign($view);
            return View::fetch('group_add');
        }
    }

    // 用户组修改
    public function groupEdit()
    {
        if (Request::isPost()) {
            $data = Request::post();
            if ($data['id']==1) {
                $this->error('超级管理员不可以更改');
            }
            try {
                $this->validate($data, 'AuthGroup');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            $where['id'] = $data['id'];
            $res = AuthGroup::update($data, $where);
            if ($res) {
                $this->success('修改成功!', url('group'));
            } else {
                $this->error('修改失败');
            }
        } else {
            $id = Request::param('id');
            $info = AuthGroup::find(['id' => $id]);
            $view = [
                'info' => $info,
                'title' => '权限组编辑'
            ];
            View::assign($view);
            return View::fetch();
        }
    }

    // 用户组状态修改
    public function groupState()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthGroup::find($id);
            $info->status = $info['status'] == 1 ? 0 : 1;
            $info->save();
            $this->success('修改成功!');
        }
    }

    // 用户组批量删除
    public function groupSelectDel()
    {
        $id = Request::post('id');
        if ($id > 1) {
            AuthGroup::destroy($id);
            $this->success('删除成功!');
        } else {
            $this->error('超级管理员组不可删除!');
        }
    }

    // 用户组显示权限
    public function groupAccess()
    {
        $admin_rule = AuthRule::field('id, pid, title')
            ->where('status', 1)
            ->order('sort asc')
            ->select()->toArray();
        $rules = AuthGroup::where('id', Request::param('id'))
            ->where('status', 1)
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
        View::assign($view);
        return View::fetch('group_access');
    }

    // 用户组保存权限
    public function groupSetaccess()
    {
        $rules = Request::post('rules');
        if (empty($rules)) {
            $this->error('请选择权限');
        }
        $data = Request::post();
        $rules = auth_normal($rules);
        $rls = '';
        foreach ($rules as $k=>$v) {
            $rls.=$v['id'].',';
        }
        $where['id'] = $data['group_id'];
        $where['rules'] = $rls;
        if (AuthGroup::update($where)) {
            $this->success('权限配置成功!', url('group'));
        } else {
            $this->error('保存错误!');
        }
    }

    /********************************权限管理*******************************/
    // 权限列表
    public function adminRule()
    {
        if (Request::isPost()) {
            $arr = cache('authRuleList');
            if (!$arr) {
                $arr = Db::name('auth_rule')
                    ->order('pid asc,sort asc')
                    ->select()->toArray();
                foreach ($arr as $k=>$v) {
                    $arr[$k]['lay_is_open']=false;
                }
                cache('authRuleList', $arr, 3600);
            }
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$arr,'is'=>true,'tip'=>'操作成功'];
        }
        return View::fetch('admin_rule');
    }

    // 权限菜单显示或者隐藏
    public function ruleState()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthRule::find($id);
            $info->menu_status = $info['menu_status'] == 1 ? 0 : 1;
            $info->save();
            $this->success('修改成功');
        }
    }

    // 设置权限是否验证
    public function ruleOpen()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            $info = AuthRule::find($id);
            $info->auth_open = $info['auth_open'] == 1 ? 0 : 1;
            $info->save();
            $this->success('修改成功');
        }
    }

    // 设置权限排序
    public function ruleSort()
    {
        if (Request::isPost()) {
            $id = Request::param('id');
            $sort = Request::param('sort');
            $info = AuthRule::find($id);
            $info->sort = $sort;
            $info->save();
            $this->success('修改成功');
        }
    }

    // 权限删除
    public function ruleDel()
    {
        $id = Request::param('id');
        $child = AuthRule::where('pid', $id)->find();
        if ($id && !$child) {
            AuthRule::destroy($id);
            $this->success('删除成功');
        } elseif ($child) {
            $this->error('有下级，先删除下级');
        } else {
            $this->error('id 不存在');
        }
    }

    // 权限批量删除
    public function ruleSelectDel()
    {
        $id = Request::param('id');
        if ($id) {
            AuthRule::destroy($id);
            $this->success('删除成功');
        }
    }

    // 权限增加
    public function ruleAdd()
    {
        if (Request::isPost()) {
            $data = Request::post();
            if (empty($data['title'])) {
                $this->error('权限名称不可为空');
            }
            if (empty($data['sort'])) {
                $this->error('排序不可为空');
            }
            if (AuthRule::create($data)) {
                $this->success('权限添加成功', url('adminRule'));
            } else {
                $this->error('权限添加失败');
            }
        } else {
            $list = Db::name('auth_rule')
                ->order('sort ASC')
                ->select();
            $list = cate_tree($list);
            $pid = Request::param('id') ? Request::param('id') : 0;
            $view = [
                'info' => null,
                'pid' => $pid,
                'ruleList' => $list
            ];
            View::assign($view);
            return View::fetch('rule_add');
        }
    }

    //权限修改
    public function ruleEdit()
    {
        if (request()->isPost()) {
            $data = Request::param();
            $where['id'] = $data['id'];
            AuthRule::update($data);
            $this->success('修改成功!', url('Auth/adminRule'));
        } else {
            $list = Db::name('auth_rule')
                ->order('sort asc')
                ->select();
            $list = cate_tree($list);
            $id = Request::param('id');
            $info = AuthRule::find($id)->toArray();
            $view = [
                'info' => $info,
                'ruleList' => $list,
            ];
            View::assign($view);
            return View::fetch('rule_add');
        }
    }
}