/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : tpif

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 18/10/2019 16:45:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '帐户ID',
  `uname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员用户名',
  `roles` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户角色,一些特定权限的用户;',
  `gid` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '管理员组ID',
  `status` smallint(2) NULL DEFAULT 0 COMMENT '管理员状态 1:正常 0:锁定',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登陆密码',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱地址',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机号码',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `sex` tinyint(4) NULL DEFAULT 1 COMMENT '1男2女',
  `real_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `add_time` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册时间',
  `last_time` int(11) NULL DEFAULT 0 COMMENT '上次登陆时间',
  `last_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '上次登陆IP',
  `last_online` int(11) NULL DEFAULT NULL COMMENT '最后在线时间,记录用户的最后访问时间',
  `login_time` int(10) NULL DEFAULT 0 COMMENT '用户登陆次数',
  `is_sys` tinyint(1) NULL DEFAULT 1 COMMENT '是否为系统人员，系统人员不可删除（1不是2是）',
  `muid` int(10) NULL DEFAULT 0 COMMENT '前台的会员编号',
  `region_id` int(10) NULL DEFAULT 0 COMMENT '管理城市',
  `shop_id` int(10) NULL DEFAULT 0 COMMENT '项目ID',
  `skin` tinyint(1) NULL DEFAULT 0 COMMENT '皮肤设置',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uname`(`uname`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES (1, 'admin', '', 1, 1, '7b73bb7b8e1112107467980a182f33cc', '787177568@qq.com', '15825563258', '0791-8621118633', 3, '系统管理员', '1404957464', 1568789707, '127.0.0.1', 1568966191, 2860, 1, 0, 0, 0, 0);
INSERT INTO `tp_admin` VALUES (29, 'zoe', '', 1, 1, 'ef3c3d72ce0719895d448b3ee714c75c', '1750855459@qq.com', '', '', 3, '', '1536140696', 0, '', NULL, 0, NULL, 0, 0, 0, 0);
INSERT INTO `tp_admin` VALUES (31, 'liaojinhui', '', 12, 1, '7b73bb7b8e1112107467980a182f33cc', '2637162918@qq.com', '13576856761', '', 3, '廖金辉', '1544785128', 1545792527, '183.216.199.237', 1545886453, 19, NULL, 0, 0, 0, 0);
INSERT INTO `tp_admin` VALUES (32, 'jianglonglong', '', 13, 1, '8f9cc813478c18a225e821dbdea3cb58', '1123757724@qq.com', '13479694883', '', 3, '江隆龙', '1544834848', 1545525248, '59.53.246.192', 1545525930, 16, NULL, 0, 0, 0, 0);
INSERT INTO `tp_admin` VALUES (33, 'zhangmenglan', '', 12, 1, '7b73bb7b8e1112107467980a182f33cc', '2286214322@qq.com', '15779621752', '', 3, '张梦蓝', '1544856513', 1545881525, '59.53.207.203', 1545884670, 69, NULL, 0, 0, 0, 0);
INSERT INTO `tp_admin` VALUES (34, 'root', NULL, 1, 1, '9c452a30c499813566a578b8a0f3b51d', NULL, NULL, NULL, NULL, NULL, NULL, 1558404233, '127.0.0.1', 1558684031, 26, 1, 0, 0, 0, 0);

-- ----------------------------
-- Table structure for tp_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_auth`;
CREATE TABLE `tp_admin_auth`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色ID',
  `menu_id` int(11) NOT NULL COMMENT '菜单ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for tp_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_config`;
CREATE TABLE `tp_admin_config`  (
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参数名',
  `value` blob NULL COMMENT '参数值,序列化数据',
  `groupid` int(4) NULL DEFAULT NULL COMMENT '分组ID',
  `label` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '参数说明',
  `uridata` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `data` blob NULL COMMENT '数据源',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'text' COMMENT '设置类型 ',
  `about` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `listorder` smallint(2) NULL DEFAULT 0 COMMENT '排序',
  UNIQUE INDEX `shopid`(`name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tp_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_menu`;
CREATE TABLE `tp_admin_menu`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `subname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '在子菜单显示名称',
  `parent_id` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级ID',
  `controller_name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '方法',
  `data` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '参数',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单类型 0:后台 1:前台',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态:1启用 1,禁用',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注信息',
  `list_order` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '显示排序',
  `icon` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `icontxt` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `attval` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '自定义值',
  `dialog` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '弹框设置',
  `menu_or_method` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1菜单2是方法（区分左上方，与每一行列表）',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `parentid`(`parent_id`) USING BTREE,
  INDEX `model`(`controller_name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 611 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_menu
-- ----------------------------
INSERT INTO `tp_admin_menu` VALUES (1, '后台首页', '后台首页', 0, 'Index', 'main', '', 1, 1, '', 10, 'fa fa-home', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (2, '系统设置', '系统设置', 0, 'Config', '', '', 1, 1, '', 12, 'fa fa-cog', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (21, '修改密码', '修改密码', 1, 'Index', 'password', '', 1, 1, '', 2, 'fa fa-pencil', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (23, '更新缓存', '更新缓存', 1, 'System', 'cache', '', 1, 1, '', 4, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (24, '系统日志', '系统日志', 1, 'Index', 'log', '', 1, 1, '', 5, 'fa fa-file-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (26, '网站参数', '网站参数', 2, 'Config', 'index', 'groupid=1', 1, 1, '', 10, 'fa fa-cog', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (27, '系统配置', '系统配置', 26, 'Config', 'index', 'groupid=2', 1, 1, '', 11, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (29, '短信设置', '短信设置', 26, 'Config', 'index', 'groupid=8', 1, 1, '', 13, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (32, '会员设置', '会员设置', 26, 'Config', 'index', 'groupid=3', 1, 0, '', 12, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (37, '个人资料', '个人资料', 1, 'Index', 'profile', '', 1, 1, '', 3, 'fa fa-user-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (38, '管理员组', '管理员组', 2, 'Role', 'index', '', 1, 1, '', 40, 'fa fa-group', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (110, '添加管理组', '添加管理组', 38, 'Role', 'admin_add', '', 1, 1, '', 41, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (111, '管理员列表', '管理员列表', 2, 'Admins', 'index', '', 1, 1, '', 20, 'fa fa-group', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (112, '用户管理', '用户管理', 0, 'Member', 'index', '', 1, 1, '会员管理', 30, 'fa fa-group', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (119, '财务管理', '财务管理', 0, 'Finance', 'index', '', 1, 0, '公司财务管理', 80, 'fa fa-money', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (159, '上传附件设置', '上传附件设置', 26, 'Config', 'index', 'groupid=5', 1, 1, '', 15, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (160, '其它设置', '其它设置', 26, 'Config', 'index', 'groupid=6', 1, 1, '交易设置', 18, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (163, '营销资讯', '资讯管理', 0, 'News', 'index', '', 1, 1, '', 14, 'fa fa-newspaper-o ', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (174, '地区管理', '地区管理', 555, 'region', 'index', '', 1, 1, '地区管理', 50, 'fa fa-send', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (176, '添加', '添加', 111, 'Admins', 'add', '', 1, 1, '', 21, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (204, '支付配置', '支付方式设置', 401, 'Payment', 'index', '', 1, 0, '', 60, 'fa fa-credit-card', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (219, '微信菜单', '微信菜单', 401, 'Category', 'index', 'type=menu', 1, 0, '', 12, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (220, '添加菜单', '添加菜单', 219, 'Category', 'add', 'type=menu', 1, 1, '', 13, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (296, '单页管理', '单页管理', 296, 'Category', 'index', 'type=pages', 1, 1, '', 51, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (297, '单页管理', '单页管理', 163, 'Category', 'index', 'type=pages', 1, 1, '', 60, 'fa fa-file-powerpoint-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (298, '添加单页', '添加单页', 297, 'Category', 'add', 'type=pages', 1, 1, '', 61, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (314, '帐户管理', '帐户管理', 0, 'Account', 'profile', '', 1, 1, '', 10, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (321, '我的资料', '&amp;#xe6e5;', 314, 'Account', 'profile', '', 1, 1, '', 3, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (326, '我的排队', '&amp;#xf00ce;', 0, 'Queue', 'index', '', 1, 1, '', 4, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (327, '我的资料', '&amp;#xf00d6;', 0, 'Member', 'person', '', 1, 1, '', 5, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (337, '修改密码', '&amp;#xe6d8;', 314, 'Account', 'password', '', 1, 1, '', 4, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (341, '会员记录', '会员记录', 157, 'Finance', 'cash', 'utype=MEMBER', 1, 1, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (343, '会员记录', '会员记录', 243, 'Paylog', 'index', 'utype=MEMBER', 1, 1, '', 61, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (344, '供货商记录', '供货商记录', 243, 'Paylog', 'index', 'utype=SHOP', 1, 1, '', 63, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (352, '已中奖', '已中奖', 334, 'Queue', 'index', 'status=1', 1, 1, '', 2, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (353, '已兑现金', '已兑现金', 334, 'Queue', 'index', 'status=2', 1, 1, '', 3, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (354, '已兑积分', '已兑积分', 334, 'Queue', 'index', 'status=3', 1, 1, '', 4, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (355, '已失效', '已失效', 334, 'Queue', 'index', 'status=4', 1, 1, '', 5, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (363, '店铺管理', '店铺管理', 0, 'Shop', 'index', '', 1, 1, '', 1, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (364, '店铺设置', '&amp;#xe627;', 363, 'Shop', 'index', '', 1, 1, '', 2, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (365, '添加分类', '添加分类', 361, 'Category', 'add', 'type=goods&amp;shop_id=0', 1, 1, '', 36, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (366, '商品管理', '&amp;#xe657;', 363, 'Goods', 'index', '', 1, 1, '', 3, '', '', 'SHOP', '', 1);
INSERT INTO `tp_admin_menu` VALUES (367, '订单管理', '&amp;#xe635;', 0, 'Orders', 'index', '', 1, 1, '', 4, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (376, '销售统计', '&amp;#xe6a1;', 367, 'Sales', 'index', '', 1, 1, '', 6, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (378, '财务管理', '财务管理', 0, 'Finance', 'index', '', 1, 1, '', 5, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (379, '我的财务', '&amp;#xe670;', 378, 'Finance', 'balance', '', 1, 1, '', 1, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (380, '资金明细', '&amp;#xe66f;', 378, 'Finance', 'balance', '', 1, 0, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (381, '积分明细', '&amp;#xe624;', 378, 'Finance', 'Integral', '', 1, 0, '', 5, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (382, '资金提现', '&amp;#xe6e1;', 378, 'Withdraw', 'index', '', 1, 1, '', 4, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (383, '供货商记录', '供货商记录', 169, 'Balance', 'index', 'utype=SHOP', 1, 1, '', 83, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (384, '会员记录', '会员记录', 169, 'Balance', 'index', 'utype=MEMBER', 1, 1, '', 81, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (386, '供货商记录', '供货商记录', 157, 'Finance', 'cash', 'utype=SHOP', 1, 1, '', 4, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (387, '会员记录', '会员记录', 350, 'Integral', 'index', 'utype=MEMBER', 1, 1, '', 53, NULL, NULL, NULL, '', 1);
INSERT INTO `tp_admin_menu` VALUES (388, '社团记录', '社团记录', 350, 'Integral', 'index', 'utype=TEAM', 1, 1, '', 54, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (390, '应用配置', '应用配置', 2, 'Configs', 'index', 'type=shop', 1, 0, '', 60, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (401, '微信管理', '微信管理', 0, 'Weixn', 'index', '', 1, 1, '', 13, 'fa fa-wechat', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (402, '文本自动回复', '文本自动回复', 401, 'Message', 'index', 'type=2', 1, 0, '', 14, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (403, '图文自动回复', '图文自动回复', 401, 'Message', 'index', 'type=3', 1, 0, '', 15, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (404, '微信模版消息', '微信模版消息', 401, 'Message', 'index', 'type=4', 1, 0, '', 16, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (405, '系统自动回复', '系统自动回复', 401, 'Message', 'index', 'type=1', 1, 0, '', 13, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (406, '图片自动回复', '图片自动回复', 401, 'Message', 'index', 'type=5', 1, 0, '', 18, 'fa fa-desktop', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (408, '附件管理', '附件管理', 2, 'File', 'index', '', 1, 0, '', 65, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (415, '员工管理', '&amp;#xe656;', 314, 'Staff', 'index', '', 1, 1, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (416, '团购订单', '&amp;#xe635;', 367, 'Orders', 'index', 'type=1', 1, 1, '', 1, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (420, '我的商品', '&amp;#xe657;', 363, 'Mygoods', 'index', '', 1, 1, '', 4, NULL, NULL, 'MAKER', '', 1);
INSERT INTO `tp_admin_menu` VALUES (429, '红包管理', '&amp;#xe666;', 363, 'Coupon', 'index', '', 1, 0, '', 11, '', '', 'SHOP', '', 1);
INSERT INTO `tp_admin_menu` VALUES (431, '社团记录', '社团记录', 243, 'Paylog', 'index', 'utype=TEAM', 1, 1, '', 62, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (434, '待付款', '待付款', 419, 'Offorders', 'index', 'status=0', 1, 1, '', 61, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (435, '已付款', '已付款', 419, 'Offorders', 'index', 'status=1', 1, 1, '', 62, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (436, '已完成', '已完成', 419, 'Offorders', 'index', 'status=4', 1, 1, '', 63, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (437, '已取消', '已取消', 419, 'Offorders', 'index', 'status=10', 1, 1, '', 64, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (440, '线下订单统计', '线下订单统计', 120, 'Finance', 'offorder', '', 1, 1, '', 1, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (441, '提现统计', '提现统计', 120, 'Finance', 'tixian', '', 1, 1, '', 2, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (445, '数据库管理', '数据库管理', 2, 'database', 'index', '', 1, 0, '', 66, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (446, '数据还原', '数据还原', 445, 'database', 'import', '', 1, 1, '', 1, NULL, NULL, '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (449, '库存详情记录', '库存详情记录', 448, 'Stocks', 'index', '', 1, 1, '', 33, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (456, '库存调拨记录', '库存调拨记录', 448, 'Stocks', 'allot_list', '', 1, 1, '', 34, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (465, '社团记录', '社团记录', 157, 'Finance', 'cash', 'utype=TEAM', 1, 1, '', 3, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (466, '社团记录', '记录', 169, 'Balance', 'index', 'utype=TEAM', 1, 1, '', 82, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (468, '会员明细', '会员明细', 467, 'Finance', 'details', 'utype=MEMBER', 1, 1, '', 1, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (469, '社团明细', '社团明细', 467, 'Finance', 'details', 'utype=TEAM', 1, 1, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (470, '供货商明细', '供货商明细', 467, 'Finance', 'details', 'utype=SHOP', 1, 1, '', 3, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (471, '供货商记录', '供货商记录', 350, 'Integral', 'index', 'utype=SHOP', 1, 1, '', 55, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (472, '供应地区模版', '&amp;#xe781;', 363, 'Pickup', 'index', '', 1, 1, '', 12, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (473, '社团管理', '社团管理', 0, 'Team', 'index', '', 1, 1, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (474, '直属社团', '&amp;#xe6f1;', 473, 'Team', 'index', 'type=1', 1, 1, '', 1, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (475, '供应社团', '&amp;#xe62f;', 473, 'Team', 'index', 'type=2', 1, 1, '', 2, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (479, '采购订单', '&amp;#xe635;', 367, 'Orders', 'index', 'type=3', 1, 1, '', 0, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (485, '添加商品', '添加商品', 360, 'Goods', 'add', '', 1, 1, '', 21, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (487, '添加规格', '添加规格', 486, 'Category', 'add', 'type=spec', 1, 1, '', 38, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (495, '广告管理', '广告管理', 163, 'Slide', 'index', '', 1, 1, '', 61, 'fa fa-image', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (498, '资金明细', '资金明细', 119, 'Finance', 'cash', '', 1, 1, '', 61, 'fa fa-line-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (499, '财务概况', '财务概况', 119, 'Finance', 'index', '', 1, 1, '', 62, 'fa fa-line-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (500, '小程序设置', '小程序设置', 401, 'Config', 'index', 'groupid=9', 1, 1, '', 19, 'fa fa-cog', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (508, '用户余额记录', '用户余额记录', 119, 'Balance', 'index', '', 1, 0, '', 63, 'fa fa-newspaper-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (515, '收益记录', '收益记录', 119, 'Profit', 'index', '', 1, 0, '', 64, 'fa fa-newspaper-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (516, '推广码设置', '推广码设置', 26, 'Config', 'index', 'groupid=7', 1, 0, '', 17, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (518, '添加', '添加', 517, 'Category', 'add', 'type=bus', 1, 1, '', 9, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (523, '添加', '添加', 522, 'Category', 'add', 'type=house', 1, 1, '', 13, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (526, '支付记录管理', '支付记录管理', 119, 'Paylog', 'index', '', 1, 1, '', 65, 'fa fa-newspaper-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (528, '添加', '添加', 527, 'Category', 'add', 'type=repair', 1, 1, '', 13, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (530, '添加', '添加', 529, 'Category', 'add', 'type=complain', 1, 1, '', 14, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (531, '数据统计', '数据统计', 0, 'statistics', 'index', '', 1, 0, '', 81, 'fa fa-bar-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (533, '添加', '添加', 502, 'shop', 'add', '', 1, 1, '', 13, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (535, '缴费汇总', '缴费汇总', 531, 'Finance', 'summary', 'type=1', 1, 1, '', 1, 'fa fa-line-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (536, '投诉汇总', '投诉汇总', 531, 'Finance', 'summary', 'type=2', 1, 1, '', 2, 'fa fa-line-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (537, '报修汇总', '报修汇总', 531, 'Finance', 'summary', 'type=3', 1, 1, '', 3, 'fa fa-line-chart', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (542, '工匠说', '工匠说', 163, 'News', 'index', '', 1, 0, '', 63, 'fa fa-newspaper-o ', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (543, '添加', '添加', 542, 'News', 'add', 'type=news', 1, 1, '', 64, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (544, '资讯分类', '资讯分类', 163, 'Category', 'index', 'type=news', 1, 1, '', 64, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (545, '添加', '添加', 544, 'Category', 'add', 'type=news', 1, 1, '', 65, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (546, '用户列表', '用户列表', 112, 'Member', 'index', 'is_rec=1', 1, 1, '', 7, 'fa fa-group', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (547, '服务管理', '服务管理', 0, 'Category', 'index', '', 1, 1, '', 82, 'fa fa-server', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (552, '订单列表', '订单列表', 589, 'Orders', 'index', 'type=1', 1, 1, '', 3, 'fa fa-list', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (555, '商品管理', '商品管理', 0, 'Goods', 'index', '', 1, 1, '', 83, 'fa fa-cab', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (556, '商品列表', '商品列表', 555, 'Goods', 'index', '', 1, 1, '', 1, 'fa fa-cab', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (557, '添加', '添加', 556, 'Goods', 'add', '', 1, 1, '', 1, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (559, '会员积分记录', '会员积分记录', 555, 'Integral', 'index', '', 1, 0, '', 4, 'fa fa-money', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (560, '品牌列表', '品牌列表', 555, 'Category', 'index', 'type=goods', 1, 1, '', 5, 'fa fa-sitemap', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (561, '添加', '添加', 560, 'Category', 'add', 'type=goods', 1, 1, '', 6, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (562, '商品方案', '商品方案', 555, 'Category', 'index', 'type=spec', 1, 1, '', 7, 'fa fa-braille', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (563, '添加规格', '添加规格', 562, 'Category', 'add', 'type=spec', 1, 0, '', 8, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (566, '交易设置', '交易设置', 26, 'Config', 'index', 'groupid=4', 1, 0, '', 17, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (569, '物流管理', '物流管理', 589, 'Express', 'index', '', 1, 1, '', 7, 'fa fa-truck', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (570, '添加', '添加', 569, 'Express', 'add', '', 1, 1, '', 8, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (571, '已付款', '已付款', 552, 'Orders', 'index', 'order_status=1', 1, 1, '', 4, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (572, '已发货', '已发货', 552, 'Orders', 'index', 'order_status=2', 1, 1, '', 5, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (573, '已收货', '已收货', 552, 'Orders', 'index', 'order_status=3', 1, 1, '', 6, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (574, '已完成', '已完成', 552, 'Orders', 'index', 'order_status=4', 1, 1, '', 7, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (589, '订单管理', '订单管理', 0, 'Orders', 'index', '', 1, 0, '', 84, 'fa fa-list', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (590, '常见问题', '常见问题', 547, 'Category', 'index', 'type=prob', 1, 1, '', 12, 'fa fa-question', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (591, '添加', '添加', 590, 'Category', 'add', 'type=prob', 1, 1, '', 13, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (592, '展示模块', '模块列表', 547, 'Plate', 'index', '', 1, 1, '', 13, 'fa fa-bars', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (593, '添加', '添加', 592, 'Plate', 'add', '', 1, 1, '', 14, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (595, '门店管理', '门店列表', 555, 'shop', 'index', '', 1, 1, '', 8, 'fa fa-university', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (596, '门店分类', '门店分类', 555, 'Category', 'index', 'type=shop', 1, 0, '', 9, 'fa fa-sitemap', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (597, '添加', '添加', 596, 'Category', 'add', 'type=shop', 1, 1, '', 10, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (598, '添加', '添加', 595, 'shop', 'add', '', 1, 1, '', 9, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (600, '黑名单', '黑名单', 546, 'Member', 'index', 'is_rec=2', 1, 1, '', 8, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (604, '商品属性', '商品属性', 555, 'Category', 'index', 'type=attr', 1, 1, '', 8, 'fa fa-gavel', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (605, '添加', '添加', 604, 'Category', 'add', 'type=attr', 1, 1, '', 11, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (606, '面包屑管理', '面包屑列表', 163, 'Block', 'index', '', 1, 1, '', 65, 'fa fa-newspaper-o ', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (607, '添加', '添加', 606, 'Block', 'add', '', 1, 1, '', 66, '', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (608, '投诉建议', '投诉建议', 547, 'Suggest', 'index', '', 1, 1, '', 14, 'fa fa-pencil-square-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (609, '咨询管理', '咨询列表', 547, 'Cons', 'index', '', 1, 1, '', 15, 'fa fa-commenting-o', '', '', '', 1);
INSERT INTO `tp_admin_menu` VALUES (610, '赚钱申请', '申请列表', 547, 'Apply', 'index', '', 1, 1, '', 16, '', '', '', '', 1);

-- ----------------------------
-- Table structure for tp_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin_role`;
CREATE TABLE `tp_admin_role`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户组名称',
  `is_lock` smallint(1) NOT NULL DEFAULT 1 COMMENT '是否锁定 1:正常 2:锁定 ',
  `access` blob NOT NULL COMMENT '拥有的权限',
  `enable` smallint(1) NOT NULL DEFAULT 1 COMMENT '是否显示 1:是 2:否',
  `is_sys` smallint(1) UNSIGNED NOT NULL DEFAULT 2 COMMENT '是否为系统组,系统组不能删除（1是2否）',
  `listorder` smallint(4) NOT NULL DEFAULT 100 COMMENT '显示排序',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '最近一次修改时间',
  `remark` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '管理员组' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tp_admin_role
-- ----------------------------
INSERT INTO `tp_admin_role` VALUES (1, '超级管理员', 0, 0x736C6964655F6164642C736C6964655F656469742C736C6964655F64656C2C70726F705F696E6465782C70726F705F6164642C70726F705F656469742C70726F705F64656C2C706C61745F696E6465782C706C6174655F6164642C706C6174655F656469742C706C6174655F64656C2C7375675F6C6973742C7375675F64656C2C636F6E735F6C6973742C636F6E735F6368616E67652C636F6E735F64656C2C6170706C795F6C6973742C6170706C795F6368616E67652C6170706C795F64656C2C6D656E755F6164642C6D656E755F656469742C6D656E755F64656C2C6361745F70616765735F6164642C6361745F70616765735F656469742C6361745F70616765735F64656C2C6163636573735F6164642C6163636573735F656469742C6163636573735F64656C2C6163636573735F67726F75705F6164642C6D656D6265725F64656C2C6D656D6265725F6C6F636B2C6D656D6265725F6C6973742C6E6577735F64656C2C6E6577735F656469742C6E6577735F7374617475732C6E6577735F6164642C61646D696E697374725F6164642C61646D696E697374725F656469742C61646D696E697374725F64656C6574652C61646D696E697374725F7374617475732C61646D696E697374725F62617463682C61646D696E5F67726F75705F6164642C61646D696E5F67726F75705F656964742C61646D696E5F67726F75705F64656C6574652C61646D696E5F67726F75705F6163636573732C61646D696E5F67726F75705F7374617475732C61646D696E5F6C6973742C626C6F636B5F6C6973742C626C6F636B5F6164642C626C6F636B5F656469742C626C6F636B5F64656C6574652C6361745F6D656E755F6164642C6361745F6D656E755F656469742C6361745F6D656E755F64656C2C6D6573736167655F6164642C6D6573736167655F656469742C6D6573736167655F73656E642C66696C655F766965772C66696C655F64656C2C66696C655F636C6561722C726567696F6E5F6164642C726567696F6E5F656469742C726567696F6E5F64656C2C73797374656D5F6C6F675F766965772C73797374656D5F6C6F675F636C6561722C73797374656D5F63616368655F7570646174652C6164645F736974655F636F6E6669672C7365745F736974655F636F6E6669672C676F6F64735F6164642C676F6F64735F656469742C676F6F64735F64656C2C6361745F676F6F64735F6164642C6361745F676F6F64735F656469742C6361745F676F6F64735F64656C2C6361745F737065635F6164642C6361745F737065635F656469742C6361745F737065635F64656C2C6361745F617474725F696E6465782C6361745F617474725F6164642C6361745F617474725F64656C2C73686F705F696E6465782C73686F705F6164642C73686F705F656469742C73686F705F64656C, 1, 1, 1, 0, 0, '总部管理');
INSERT INTO `tp_admin_role` VALUES (10, '员工', 0, '', 1, 0, 0, 1541129493, 0, '');
INSERT INTO `tp_admin_role` VALUES (12, '商品、工人', 0, 0x676F6F64735F6164642C676F6F64735F656469742C676F6F64735F64656C2C6361745F676F6F64735F6164642C6361745F676F6F64735F656469742C6361745F676F6F64735F64656C2C6361745F737065635F6164642C6361745F737065635F656469742C6361745F737065635F64656C2C6361745F617474725F696E6465782C6361745F617474725F6164642C6361745F617474725F64656C2C73686F705F696E6465782C73686F705F6164642C73686F705F656469742C73686F705F64656C, 1, 0, 11, 1544785173, 0, '上传商品');
INSERT INTO `tp_admin_role` VALUES (13, '工匠信息', 0, 0x626C6F636B5F6C6973742C626C6F636B5F6164642C626C6F636B5F656469742C626C6F636B5F64656C6574652C6361745F6D656E755F6164642C6361745F6D656E755F656469742C6361745F6D656E755F64656C2C6D6573736167655F6164642C6D6573736167655F656469742C6D6573736167655F73656E642C66696C655F766965772C66696C655F64656C2C66696C655F636C6561722C726567696F6E5F6164642C726567696F6E5F656469742C726567696F6E5F64656C, 1, 0, 0, 1544834759, 0, '上传工匠信息');

SET FOREIGN_KEY_CHECKS = 1;
