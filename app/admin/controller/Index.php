<?php
declare (strict_types=1);

namespace app\admin\controller;


use think\facade\Cache;

class Index extends Stone
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {


        // 所有显示的菜单；
        $menus = cache('adminMenus');
        if (!$menus) {
//            face('checkprv')::get_menu();
            $cate = $this->Db::name('auth_rule')->where('menu_status', 1)->order('sort asc')->select()->toArray();
            $menus = Menu::authMenu($cate);
            cache('adminMenus', $menus);

        }
        //dump($menus);die;
//        dump(config());die;
        config(['layout_name' => 'layout_menu'], 'view');
        $href = (string)url('main');
        $home = ["href" => $href, "icon" => "fa fa-home", "title" => "首页"];
        $menusInit = ['menus' => $menus, 'home' => $home];
//        $this->View::assign('menus', json_encode($menusInit));
        $this->View::assign('menus', $menus);
        return $this->View::fetch();
    }

    /**
     * @return string
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\PDOException
     * 主页面
     */
    public function main()
    {

        $version = $this->Db::query('SELECT VERSION() AS ver');
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

        $this->View::assign('config', $config);
        return $this->View::fetch();
    }

}
