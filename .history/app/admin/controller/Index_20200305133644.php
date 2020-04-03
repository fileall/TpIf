<?php
/*
 * @Author: your name
 * @Date: 2019-10-12 11:18:23
 * @LastEditTime: 2020-03-05 13:36:44
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \TpIf\app\admin\controller\Index.php
 */
declare(strict_types=1);

namespace app\admin\controller;

use think\facade\Cache;
use think\facade\View;

class Index extends Loam
{
    //定义模型层表名称
    protected $_modelName = 'menu';

    public function _initialize()
    {
        parent::__construct();
        //安全模式(关闭自动模式)
        $this->force();
    }


    public function index()
    {  
        // 所有显示的菜单
        $menus = $this->model()::menuGet(,1);
        // 菜单格式化
        $menus = list_to_tree($menus, "id", "parent_id");
        // 设置模板布局
        config(['layout_name' => 'layout_left'], 'view');
        // 定义返回第一个iframe
        $href = (string)url('main');
        // 模板分配的变量数组化
        $assign = [
            'menus' => $menus,
            'href' => $href
        ];
        
        $this->assign($assign);
        return  View::fetch();
    }

    /**
     * @return string
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\PDOException
     * 主页面
     */
    public function main()
    {
        $version = $this->db::query('SELECT VERSION() AS ver');
        $config = Cache::get('main_config');
        if (!$config) {
            $config = [
                'url' => $_SERVER['HTTP_HOST'],
                'document_root' => $_SERVER['DOCUMENT_ROOT'],
                'document_protocol' => $_SERVER['SERVER_PROTOCOL'],
                'server_os' => PHP_OS,
                'server_port' => $_SERVER['SERVER_PORT'],
                'server_ip' => $_SERVER['REMOTE_ADDR'],
                'server_soft' => $_SERVER['SERVER_SOFTWARE'],
                'server_file' => $_SERVER['SCRIPT_FILENAME'],
                'php_version' => PHP_VERSION,
                'mysql_version' => $version[0]['ver'],
                'max_upload_size' => ini_get('upload_max_filesize'),
            ];
            Cache::set('main_config', $config, 3600);
        }
        //
        $this->assign('config', $config);
        return view();
    }
}
