<?php
declare(strict_types = 1);
namespace app\admin\model\stone;

use Exception;
use think\Model;
use think\facade\Db;

class Menu extends Model
{
    protected $name = 'admin_menu';
    protected static $model;

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }

    /**
     * 读取数据库设置的菜单
     * @param int|null $role_id
     * @param int|null $aid 父级ID
     * @param bool $ALL 是否读取全部(包括不展示的菜单)
     * @param bool $force 是否返回所有(包括不在此权限菜单)
     * @return array
     */
    public function menuGet(int $role_id = null, int $aid = null, bool $ALL = false, bool $force = false): array
    {
        $menu = [];
        if ($role_id == null || $aid == null) {
            return $menu;
        }
        if ($ALL) {
            $file = "menus_all";
        } else {
            $file = "menus";
        }

        $data_menu = cache($file);

        $menu = isset($data_menu) ? $data_menu : [];
        

        if (!$menu) {
            $model = self::class;
            if ($ALL == false) $where['status'] = 1;
               
            $menu = $model::where($where)
                    ->order(['parent_id', 'list_order'])
                    ->select()
                    ->toArray();
            debug_get() or cache($file, $menu);
        }
        //权限过滤(如是是超级管理员返回所有权限)
        if($role_id != 1){
            $access = self::roleAccess($role_id, $aid,$force);
            if ($access) {
                $menu = array_intersect_mix($menu, 'id', $access,'menu_id',$force);
            } else {
                $menu = [];
            }
        }
            
        return $menu;
    }

    /**
     *返回此管理员下的权限
     * @param [type] $role_id
     * @param [type] $aid
     * @return void
     */
    public function roleAccess($role_id = null, $aid = null,$force = false)
    {
        $access = [];
        if ($role_id == 1) {
            $access = 'all';
        } else {
            $file = 'menu_access';
            $datas = cache($file);
            $label = $role_id.'_'.$aid;
            $access = isset($datas[$label]) ? $datas[$label] : [];

            if (!$access) {
                $where =  ['role_id','=',$role_id];
                $where2 = ['aid','=',$aid];
                $access = Db::name('admin_auth')->whereOr([$where,$where2])->select()->toArray();
                Db:
                $datas[$label] = $access;
                debug_get() or cache($file, $datas);
            }
        }

        return $access;
    }


    /**
     * 读取同级菜单
     * @param int|null $role_id
     * @param int|null $_menuId
     * @return array|bool
     */
    public function subMenuGet(int $role_id = null, int $aid = null, int $_menuId = null)
    {
        $sub_menu = [];
        if ($_menuId == null || $role_id == null) {
            return $sub_menu;
        }

        $file = "menu_sub";
        $data_sub_menu = cache($file);

        $sub_menu = isset($datas[$_menuId]) ? $data_sub_menu[$_menuId] : [];

        if (!$sub_menu) {
            $sub_menu = $this->where('status', 1)
                ->where('parent_id|id', $_menuId)
                ->order(['parent_id', 'list_order'])
                ->select()
                ->toArray();
            $access = self::roleAccess($role_id, $aid);
            foreach ($sub_menu as $value) {
            }
        }

        //dump($sub_menu);die;
        return $sub_menu;
    }

    /**
     * 读取指定ID的菜单信息
     * @param int $menuid :菜单ID
     * @return array
     */
    public function get_menu_info($menuid)
    {
        if (!is_numeric($menuid) || $menuid == 0) {
            return false;
        }
        $file = "menus_info_data";
        $datas = F($file);
        $menu = isset($datas[$menuid]) ? $datas[$menuid] : false;
        if (!$menu) {
            $model = M("checkprv");
            $menu = $model->where("id = %d", $menuid)->find();
            $datas[$menuid] = $menu;
            APP_DEBUG or F($file, $datas);
        }
        return $menu;
    }
}
