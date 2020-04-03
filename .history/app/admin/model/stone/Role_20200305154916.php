<?php
namespace app\admin\model\stone;

class Role extends Lichen
{
    protected $name = 'admin_role';
    protected static $model;

    // 模型初始化
    protected static function init()
    {
        //TODO:初始化内容
    }
    public function accessAdd($role_id, $data)
    {
        $model = self::class;
        $original = $model->where()
    }
}
