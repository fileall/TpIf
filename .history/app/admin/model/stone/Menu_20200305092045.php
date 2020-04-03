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
     * @param int $type 菜单类型 1.后台 2.前台
     * @param int|null $parenPid 父级ID
     * @param bool $ALL 是否读取全部(包括不展示的菜单)
     * @return array
     */
    public function menuGet(int $role_id = null, int $aid = null, bool $ALL = false, int $paren_pid = null): array
    {
        if ($ALL) {
            $file = "menus_all_{$type}";
        } else {
            $file = "menus_{$type}";
        }

        is_numeric($paren_pid) && $file .= "_{$paren_pid}";

        $data_menu = cache($file);

        if ($paren_pid == null) {
            $menu = isset($datas['all']) ? $data_menu['all'] : [];
        } else {
            $menu = isset($datas[$paren_pid]) ? $data_menu[$paren_pid] : [];
        }

        if (!$menu) {
            $model = $this->where('type', $type);
            if ($ALL == false) {
                $model->where('status', 1);
            }
            if (is_numeric($paren_pid)) {
                $model->where('parent_id', $paren_pid);
            }
            $menu = $model->order(['parent_id', 'list_order'])
                    ->select()
                    ->toArray();
            if ($paren_pid == null) {
                $data_menu['all'] = $menu;
            } else {
                $data_menu[$paren_pid] = $menu;
            }

            debug_get() or cache($file, $data_menu);
        }
        //权限过滤
            if ($role_id !== null) {   //不进行权限的缓存
                $access = self::roleAccess($role_id, $aid);
                if ($access == 'all') {
                    return $menu;
                } elseif ($access) {

//               $t = array_intersect_mix($menu,'access',$access);
                } else {
                    return [];
                }
            }

        return $menu;
    }

    public function roleAccess($role_id = null,$aid = null)
    {
        $access = [];
        if ($role_id == 1) {
            $access = 'all';
        // if ($force) $access = list_to_tree($access, "id", "parent_id");
        } else {
            $file = 'menu_access';
            $datas = cache($file);
            $access = isset($datas[$role_id]) ? $datas[$role_id] : [];

            if (!$access) {
                $where = [
                    ['name','=','thinkphp'],
                    ['status','=',1],];
                $access = Db::name('admin_auth')->where('role_id|id', $_menuId)->where()->value('menu_id,');
                $datas[$role_id] = $access;
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
    public function subMenuGet(int $role_id = null,int $aid = null, int $_menuId = null)
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
            $access = self::roleAccess($role_id,$aid);
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
