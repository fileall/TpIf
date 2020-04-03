<?php

namespace app\admin\controller;


class Menu extends stone
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }


    if(Request::isPost()){
        $arr = cache('authRuleList');
        if(!$arr){
            $arr = Db::name('auth_rule')
                ->order('pid asc,sort asc')
                ->select()->toArray();
            foreach($arr as $k=>$v){
                $arr[$k]['lay_is_open']=false;
            }
            cache('authRuleList', $arr, 3600);
        }
        return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$arr,'is'=>true,'tip'=>'操作成功'];
    }
    return View::fetch('admin_rule');

    //获取左侧主菜单
    public  function authMenu($arr,$pid=0,$rules=[]){
        $authrules = explode(',',session('admin.rules'));
        $list =array();
        foreach ($arr as $k=>$v){
            $v['href'] = strtolower(url($v['href']));
            if (session('admin.id') != 1) {
                if ($v['pid'] == $pid){
//                    if(in_array($v['id'],$authrules)){
                        $v['child'] = self::authMenu($arr,$v['id']);
                        $list[] = $v;
//                    }
                }
            }else{
                if ($v['pid'] == $pid) {
                    $v['child'] = self::authMenu($arr, $v['id']);
                    $list[] = $v;
                }
            }

        }

        return $list;

    }



    /*
    * 自定义菜单排列
    */
    static public function menu($cate, $lefthtml = '|— ', $pid = 0, $lvl = 0, $leftpin = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['lvl'] = $lvl + 1;
                $v['leftpin'] = $leftpin + 0;
                $v['lefthtml'] = str_repeat($lefthtml, $lvl);
                $v['ltitle'] = $v['lefthtml'] . $v['title'];
                $arr[] = $v;
                $arr = array_merge($arr, self::menu($cate, $lefthtml, $v['id'], $lvl + 1, $leftpin + 20));
            }
        }

        return $arr;
    }

    static public function cate($cate, $lefthtml = '|— ', $pid = 0, $lvl = 0, $leftpin = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['lvl'] = $lvl + 1;
                $v['leftpin'] = $leftpin + 0;
                $v['lefthtml'] = str_repeat($lefthtml, $lvl);
                $arr[] = $v;
                $arr = array_merge($arr, self::menu($cate, $lefthtml, $v['id'], $lvl + 1, $leftpin + 20));
            }
        }

        return $arr;
    }

    static public function auth($cate, $rules, $pid = 0)
    {
        $arr = array();
        $rulesArr = explode(',', $rules);
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                if (in_array($v['id'], $rulesArr)) {
                    $v['checked'] = true;
                }
                $v['open'] = true;
                $arr[] = $v;
                $arr = array_merge($arr, self::auth($cate, $v['id'], $rules));
            }
        }
        return $arr;
    }


    /*
     * $column_one 顶级栏目
     * $column_two 所有栏目
     * 用法匹配column_leftid 进行数组组合
     */
    static public function index_top($column_one, $column_two)
    {
        $arr = array();
        foreach ($column_one as $v) {
            $v['sub'] = self::index_toptwo($column_two, $v['id']);
            $v['url'] = url('home/' . $v['catdir'] . '/index', ['catId' => $v['id']]);
            $arr[] = $v;
        }
        return $arr;
    }

    static public function index_toptwo($column_two, $c_id)
    {
        $arry = array();
        foreach ($column_two as $v) {
            if ($v['pid'] == $c_id) {
                $v['url'] = url('home/' . $v['catdir'] . '/index', ['catId' => $v['id']]);
                $arry[] = $v;
            }
        }
        return $arry;
    }


}
