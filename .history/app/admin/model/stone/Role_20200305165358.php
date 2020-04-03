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
        $original = array_mix($original,'id');
        
        //使用匿名函数
        $result2 = function ($_del, $where) use ($model) {
            //删除不需要的图片
            if ($_del) {
                $where['fid'] = ['in', $_del];
                $result2 = $model->where($where)->delete();
                if ($result2 !== false) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        };

    }
}
