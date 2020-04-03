<?php
// 这是系统自动生成的admin应用公共文件

/**
 * 进行数组的id & pid分级组合
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param int $root
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0):array
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

function access_to_tree($list,$parent_id = 0,$role_id=null){
    $data = [];
   
    foreach ($list as $v){
        if ($v['parent_id'] == $parent_id) {

            $v['spread'] = true;
            if(access_to_tree($list,$v['id'],$role_id)){
                $v['children'] = access_to_tree($list,$v['id'],$role_id);
            }else{
                if (isset($v['merge']) || $role_id == 1) {
                    $v['checked'] = true;
                }
            }
            $data[] = $v;
        }
    }
    return $data;

}
/**
 * 权限设置选中状态
 * @param $cate  栏目
 * @param int $pid 父ID
 * @param $rules 规则
 * @return array
 */
function auth_checked($cate , $pid = 0,$rules){
    $list = [];
    $rulesArr = explode(',',$rules);
    foreach ($cate as $v){
        if ($v['pid'] == $pid) {

            $v['spread'] = true;
            if(auth_checked($cate,$v['id'],$rules)){
                $v['children'] =auth_checked($cate,$v['id'],$rules);
            }else{
                if (in_array($v['id'], $rulesArr)) {
                    $v['checked'] = true;
                }
            }
            $list[] = $v;
        }
    }
    return $list;
}

/**
 * 权限多维转化为二维
 * @param $cate  栏目
 * @param int $pid 父ID
 * @param $rules 规则
 * @return array
 */
function auth_normal($cate){
    $list = [];
    foreach ($cate as $v){
        $list[]['id'] = $v['id'];
//        $list[]['title'] = $v['title'];
//        $list[]['pid'] = $v['pid'];
        if (!empty($v['children'])) {
            $listChild =  auth_normal($v['children']);
            $list = array_merge($list,$listChild);
        }
    }
    return $list;
}