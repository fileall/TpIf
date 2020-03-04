<?php
namespace app\admin\model\stone;

use app\model\Warmth;
use think\facade\View;
use think\Model;

/**
 * 苔藓类（苔藓依赖于温室&&土壤&基石，提供便利合适的环境）
 * Class Lichen
 * @package app\admin\model\stone
 */

class Lichen extends Warmth
{
    protected $name;
    public function __construct($tb_name = '')
    {
        //由face门面操作进行数据模型操作定义数据库表名
        if ($tb_name && empty($this->name)) {
            // 当前模型名
            $this->name = $tb_name;
        }

        parent::__construct();
    }
    /**
     * @param $data
     * @return mixed
     */
    public function _linkIndexAttr($data)
    {
        $data['assign']['page_1'] = $this->listGet($data); //dump(json_encode($data['tablePage_1'],JSON_UNESCAPED_UNICODE));die;
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
}
