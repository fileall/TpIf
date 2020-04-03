<?php
namespace app\admin\model\stone;
use think\facade\Db;
class Role extends Lichen
{
    protected $name = 'admin_role';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    public function accessAdd(int $role_id = null, $data =[])
    {
        if ($role_id == null || empty($data)) {
            return true;
        }
        $model = Db::name('admin_auth');
        $original = $model->where(['role_id'=>$role_id])->field('id,menu_id')->select()->toArray();
        $original = array_mix($original, 'menu_id'); //原数据
        
        //记录下需要新增的数据
        $data_add = [];
        foreach ($data as $value) {
            if (!isset($original[$value['id']])) {
                $_add = [
                    'role_id' => $role_id,
                    'menu_id' => $value['id'],
                ];
                //入栈
                array_push($data_add, $_add);
            }
        }
         dump()
        //记录下需要删除的数据
        $data_new = array_mix($data, 'id');
        $original_del = [];
        foreach ($original as $value) {
            if (!isset($data_new[$value['menu_id']])) {
                $original_del[] = $value['id'];
            }
        }
       
        if ($original_del) {
            $result = $model->delete($original_del);
            if ($result === false) {
                return false;
            }
        }

        if ($data_add) {
            $result2 =  $model->insertAll($data_add);
            if ($result2 === false) {
                return false;
            }
        }

        return true;
    }
}