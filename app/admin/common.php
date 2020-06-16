<?php
// 这是系统自动生成的admin应用公共文件
/**
 * 图形化数据： 将树结构数据处理成 树结构图形
 * @param array $tree
 * @param string $pk
 * @param string $child
 * @param string $_depth
 * @param string $replace_icon
 * @param string $icon
 * @return array
 * @author Jeffreyzhu.cn@gmail.com
 */
function graph_tree_list($tree, $pk, $child = '_child',$_depth=true, $replace_icon = array(), $icon = ' ')
{
    $list = array();

    if (count($replace_icon) < 1) $replace_icon = array('a' => ' ', 'b' => '├', 'c' => '└');
    $replace_icon = $replace_icon + array(' ' => $icon);
    //array('a' => '│', 'b' => '├', 'c' => '└', ' ' => $icon)
    if (is_array($tree)) {
        $next = array();
        $depth = 0;
        $_icon = '';
        $__icon = '                                ';
        // icon  │├└ 对应 abc

        while ($depth > -1) {
            // dump($depth);
            // dump($tree);
            $data = current($tree);
            // dump($data);
            if (!empty($data)) {
                $list[$data[$pk]] = &$data;
                if (false !== next($tree)) {  //dump(222);die;
                    $next[$depth] = &$tree;

                    if ($icon && $depth) {
                        $__icon[$depth - 1] == 'b' && $__icon[$depth - 1] = 'a';
                        $__icon[$depth] = 'b';
                        $_icon = rtrim($__icon, ' ');
                    }
                } else if ($icon && $depth) {
                    $__icon[$depth - 1] == 'b' && $__icon[$depth - 1] = 'a';
                    $__icon[$depth] = 'c';
                    $_icon = rtrim($__icon, ' ');
                    $__icon[$depth] = ' ';
                }

                $data['_depth'] = $depth;
                // $icon && $data['_icon'] = strtr($_icon, $replace_icon);
                if ($icon) {
                   
                    if ($depth >= 1) {
                        for ($i = 1; $i <= $depth; $i++) {
                            $_icon = '%%' . $_icon;
                        }
                    }
                    $data['_icon'] = strtr($_icon, $replace_icon);
                } 
                if (isset($data[$child]) && ($_depth === true || $depth < $_depth)) {
                    $depth++;
                    unset($tree);
                    $tree = &$data[$child];
                    unset($data[$child]);
                    $data['_has_child'] = true;
                } else {
                    $data['_has_child'] = false;
                }
            } else {
                $icon && ($__icon[$depth] = ' ') && ($_icon = '');
                $depth--;
                unset($tree);
                $tree = &$next[$depth];
                unset($next[$depth]);
            }

            unset($data);
        }
    }

    return $list;
}
/**
 * 进行数组的id & pid分级组合
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param int $root
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0): array
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }
    return $tree;
}

function access_to_tree($data, $parent_id = 0, $role_id = null)
{
    $list = [];

    foreach ($data as $v) {
        if ($v['parent_id'] == $parent_id) {

            $v['spread'] = true;
            if (access_to_tree($data, $v['id'], $role_id)) {
                $v['children'] = access_to_tree($data, $v['id'], $role_id);
            } else {
                if (isset($v['merge']) || $role_id == 1) {
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
function tree_to_array($data)
{
    $list = [];
    foreach ($data as $v) {
        $list[]['id'] = $v['id'];
        //        $list[]['title'] = $v['title'];
        //        $list[]['pid'] = $v['pid'];
        if (!empty($v['children'])) {
            $listChild =  tree_to_array($v['children']);
            $list = array_merge($list, $listChild);
        }
    }
    return $list;
}
