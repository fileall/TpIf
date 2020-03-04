<?php

namespace app\model;

use think\Model;
use think\facade\Db;

/**
 * 温室类（温室为苔藓提供环境，提供便利合适的环境）
 * Class Warmth
 * @package app\model
 */
class Warmth extends Model
{
    public function __construct($tb_name = '')
    {   
        
        //由face门面操作进行数据模型操作定义数据库表名
        if ($tb_name && empty($this->name)) {
         
            $this->name = $tb_name;
        }
       
        parent::__construct();
    }

    // 模型初始化
    // protected function initialize($tb_name = '')
    // {
    //     //初始化内容
    //       //由face门面操作进行数据模型操作定义数据库表名
    //       if ($tb_name && empty($this->name)) {
    //         // 当前模型名
    //         $this->name = $tb_name;
    //     }

    //     parent::__construct();
    // }


    /**
     * @param array $filter
     * @return array
     */
    public function listGet(array $filter = []): array
    {
        $where = $filter['where'] ?? [];
        $field = $filter['field'] ?? '*';
        $order = $filter['order'] ?? 'id asc';
        $list = [];
        $list = Db::name($this->name)->where(format_where($where))->field($field)->order($order)->select()->toArray();
      
        $count = count($list);
        $data = []; //dump($list);die;
        if ($list) {
            $data = $this->_dataJson((array)$list, $count);
        }
        return $data;
    }

    /**
     * 统一返回JSON格式(用于前端的页面列表数据返回)
     * @param array $list
     * @param string $msg
     * @param int $code
     * @param int $count
     * @return array
     */
    protected function _dataJson(array $list = [], $count = 0, $msg = '执行成功！', $code = 0)
    {
        $data['data'] = $list;
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['count'] = $count;
        return $data;
    }
}
