<?php

namespace app\admin\model\stone;

use app\model\Data;
use think\facade\View;
use think\Model;

/**
 * 苔藓类（苔藓依赖于基石，提供便利合适的环境）
 * Class Lichen
 * @package app\admin\model\stone
 */

class Lichen extends Data
{


    /**
     * @param $data
     * @return mixed
     */
    public function _linkIndexAttr($data)
    {
        $data['tablePage_1'] = $this->listGet($data); //dump(json_encode($data['tablePage_1'],JSON_UNESCAPED_UNICODE));die;
        View::assign('tablePage_1',$data['tablePage_1']);
        return $data;
    }

    public function _linkAddAttr($data)
    {
           $this->create($data);
      return $data;
    }

    public function _linkEditAttr($data)
    {

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

    /**
     * @param array $filter
     * @return array
     */
    public function listGet(array $filter = []):array
    {

        $where = $filter['where'] ?? [];
        $field = $filter['field'] ?? 'id,name,is_lock,enable';
        $order = $filter['order'] ?? 'id asc';

        $list = $this->where(format_where($where))->field($field)->order($order)->select()->toArray();
        $count = count($list);
        $data = []; //dump($list);die;
        if($list !== false){
            $data = $this->_dataJson((array)$list,$count);
        }
        return $data;
    }



}