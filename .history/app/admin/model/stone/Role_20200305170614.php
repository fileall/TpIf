<?php
namespace app\admin\model\stone;

class Role extends Lichen
{
    protected $name = 'admin_auth';

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
        
        $original = $this->where(['role_id'=>$role_id])->field('id')->select()->toArray();
        $original = array_mix($original, 'id'); //原数据

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


        if ($original_del) {
            $where['id'] = ['in', $original_del];
            $result = $this->where($where)->delete();
            if ($result === false) {
                return false;
            }
        }

        if ($data_add) {
            $result2 =  $this->addAll($data_add);
            if ($result === false) {
                return false;
            }
        }

        return true;
    }
}
