<?php
namespace app\admin\model\stone;

use think\facade\Db;

class Auth extends Lichen
{
    protected $name = 'admin_auth';

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    public function accessEdit(int $role_id = null, $data =[])
    {
        if ($role_id == null || empty($data)) {
            return true;
        }
        
        $original = $this->where(['role_id'=>$role_id])->field('id,menu_id')->select();
        // dump($this->getLastSql());
        dump($original);
        die;
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
         
        //记录下需要删除的数据
        $data_new = array_mix($data, 'id');
        $original_del = [];
        foreach ($original as $value) {
            if (!isset($data_new[$value['menu_id']])) {
                $original_del[] = $value['id'];
            }
        }
        
        if ($original_del) {
            $result =$this->delete($original_del);
            if ($result === false) {
                return false;
            }
        }

        if ($data_add) {
            $result2 =  $this->insertAll($data_add);//dump($model->getLastSql());die;
            if ($result2 === false) {
                return false;
            }
        }

        return true;
    }
}
