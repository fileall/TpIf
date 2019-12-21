<?php

namespace app\model;

use think\Model;

class Data extends Model
{

    function __construct(string $tb_name = '')
    {       dump(32);dump($tb_name);die;
        //由face门面操作进行数据模型操作定义数据库表名
        if ($tb_name && empty($this->name)) {
            // 当前模型名
            $this->name = $tb_name;
        }

        parent::__construct();
    }

    /**
     * @param array $filter
     * @return array
     */
    public function listGet(array $filter = []): array
    {

        $where = $filter['where'] ?? [];
        $field = $filter['field'] ?? '*';
        $order = $filter['order'] ?? 'id asc';

        $list = $this->where(format_where($where))->field($field)->order($order)->select()->toArray();
        $count = count($list);
        $data = []; //dump($list);die;
        if ($list !== false) {
            $data = $this->_dataJson((array)$list, $count);
        }
        return $data;
    }


}
