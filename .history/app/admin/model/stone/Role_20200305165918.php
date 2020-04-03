<?php
namespace app\admin\model\stone;

class Role extends Lichen
{
    protected $name = 'admin_role';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    public function accessAdd(int $role_id = null,$data =[])
    {
        if($role_id == null || empty($data)) return true;
        $model = self::class;
        $original = $model->where(['role_id'=>$role_id])->field('id')->select()->toArray();
        $original = array_mix($original,'id'); //原数据

        //记录下需要新增的数据
        $data_add = [];
        foreach ($data as $value) {    
            if (!$original[$value['id']]) {
                $_add = [
                    'role_id' => $role_id,
                    'menu_id' => $value['id'],
                ];
                //入栈
                array_push($data_add, $_add);
            }
        }

        //记录下需要删除的数据
        $data_new = array_mix($data, 'id');
        $original_del = [];
        foreach ($original as $value) {
            if (!$data_new[$value['id']]) {
                $original_del[] = $value['id'];
            }
        }

        //使用匿名函数
        $result2 = function ($_del, $where) use ($model) {
            //删除不需要的图片
            if ($_del) {
                $where['id'] = ['in', $_del];
                $result2 = $model->where($where)->delete();
                if ($result2 !== false) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        };

        if($original_del){
            $where['id'] = ['in', $original_del];
            $result2 = $model->where($where)->delete();
        }



    }
}
