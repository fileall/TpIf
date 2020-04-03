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

function access_to_tree($data,$parent_id = 0,$role_id=null){
    $data = [];
   
    foreach ($data as $v){
        if ($v['parent_id'] == $parent_id) {

            $v['spread'] = true;
            if(access_to_tree($data,$v['id'],$role_id)){
                $v['children'] = access_to_tree($data,$v['id'],$role_id);
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
 * 权限多维转化为二维
 * @param $cate  栏目
 * @param int $pid 父ID
 * @param $rules 规则
 * @return array
 */
function tree_to_array($data){
    $list = [];
    foreach ($data as $v){
        $list[]['id'] = $v['id'];
//        $list[]['title'] = $v['title'];
//        $list[]['pid'] = $v['pid'];
        if (!empty($v['children'])) {
            $listChild =  tree_to_array($v['children']);
            $list = array_merge($list,$listChild);
        }
    }
    return $list;
}
