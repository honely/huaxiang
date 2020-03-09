/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : xcx

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2020-03-09 09:22:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `super_admin`
-- ----------------------------
DROP TABLE IF EXISTS `super_admin`;
CREATE TABLE `super_admin` (
  `ad_id` int(11) NOT NULL COMMENT '管理员id',
  `ad_bid` varchar(50) NOT NULL COMMENT '员工编号',
  `ad_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `ad_realname` varchar(255) DEFAULT NULL COMMENT '员工真实姓名',
  `ad_email` varchar(255) DEFAULT NULL COMMENT '管理员邮箱，用于登录',
  `ad_branch` int(10) DEFAULT NULL COMMENT '归属站点，对应站点id',
  `ad_p_id` int(11) DEFAULT NULL COMMENT '管理员省份id',
  `ad_c_id` int(11) DEFAULT NULL COMMENT '管理员城市id',
  `ad_phone` varchar(255) NOT NULL COMMENT '管理员手机号，用于登录',
  `ad_qq` varchar(20) DEFAULT NULL COMMENT '管理员QQ号码',
  `ad_birth` varchar(20) DEFAULT NULL COMMENT '出生年月日',
  `ad_sex` tinyint(2) DEFAULT '3' COMMENT '性别；1 男；2 女； 3 未知',
  `ad_img` varchar(255) DEFAULT NULL COMMENT '管理员图像',
  `ad_createtime` int(11) DEFAULT NULL COMMENT '开通时间',
  `ad_isable` tinyint(2) DEFAULT NULL COMMENT '是否在职 1 在职；2 离职',
  `ad_role` int(11) DEFAULT NULL COMMENT '权限，对应权限的id',
  `ad_admin` int(255) DEFAULT NULL COMMENT '操作人，对应管理员id',
  `ad_wechat` varchar(255) DEFAULT NULL COMMENT '微信号'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of super_admin
-- ----------------------------
INSERT INTO `super_admin` VALUES ('1', 'D00024', 'e10adc3949ba59abbe56e057f20f883e', '萌萌', '1549089944@qq.com', '22', '1', '3', '17691074991', '31123123', '2010-05-18', '2', '/uploads/20180519/9c478cec4a8460e814d8b2a20bb94ae5.jpg', '1525592904', '1', '1', '1', null);

-- ----------------------------
-- Table structure for `super_menu`
-- ----------------------------
DROP TABLE IF EXISTS `super_menu`;
CREATE TABLE `super_menu` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `m_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '菜单名称',
  `m_fid` int(11) DEFAULT NULL COMMENT '菜单父级id',
  `m_control` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '控制器名称，小写',
  `m_action` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '方法名，小写',
  `m_sort` int(10) DEFAULT NULL COMMENT '排序',
  `m_type` int(10) DEFAULT NULL COMMENT '菜单类型1.菜单；2.操作',
  `m_icon` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '菜单图标',
  `m_opeatime` int(11) DEFAULT NULL COMMENT '操作时间',
  `m_admin` int(10) DEFAULT NULL COMMENT '操作人，对应管理员id',
  PRIMARY KEY (`m_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='菜单表';

-- ----------------------------
-- Records of super_menu
-- ----------------------------
INSERT INTO `super_menu` VALUES ('1', '平台员工', '0', 'admin', 'admin', '1', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('2', '员工列表', '1', 'admin', 'admin', '1', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('4', '角色列表', '1', 'admin', 'role', '1', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('10', '系统配置', '0', 'setinfo', 'setlist', '2', '1', '123', null, null);
INSERT INTO `super_menu` VALUES ('11', '基础配置', '10', 'setinfo', 'setlist', '0', '1', '123', null, null);
INSERT INTO `super_menu` VALUES ('210', '客户列表', '201', 'user', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('87', '模块配置', '10', 'admin', 'menu', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('212', '搜索历史', '203', 'mate', 'search', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('211', '房源搜索', '202', 'house', 'search', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('209', '房源列表', '202', 'house', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('201', '客户管理', '0', 'user', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('202', '房源管理', '0', 'house', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('203', '找室友管理', '0', 'mate', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('204', '广告轮播', '0', 'banner', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('205', '帮我找房', '0', 'help', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('206', '找房列表', '205', 'help', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('207', '广告列表', '204', 'banner', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('208', '找室友列表', '203', 'mate', 'index', '0', '1', '1', null, null);
INSERT INTO `super_menu` VALUES ('213', 'banner', '204', 'banner', 'loop', '0', '1', '1', null, null);

-- ----------------------------
-- Table structure for `super_role`
-- ----------------------------
DROP TABLE IF EXISTS `super_role`;
CREATE TABLE `super_role` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `r_bid` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '权限编号',
  `r_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '权限名称',
  `r_power` text CHARACTER SET utf8 COMMENT '权限设置，对应菜单的id',
  `r_opeatime` int(11) DEFAULT NULL COMMENT '操作时间',
  `r_admin` int(10) DEFAULT NULL COMMENT '操作人，对应管理员id',
  PRIMARY KEY (`r_id`,`r_bid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC COMMENT='管理员权限表';

-- ----------------------------
-- Records of super_role
-- ----------------------------
INSERT INTO `super_role` VALUES ('1', '201806010001', '超级管理员', '10,11,87,1,2,4,201,210,202,209,203,212,208,204,207,213,205,206', null, null);

-- ----------------------------
-- Table structure for `super_setinfo`
-- ----------------------------
DROP TABLE IF EXISTS `super_setinfo`;
CREATE TABLE `super_setinfo` (
  `s_id` int(100) NOT NULL AUTO_INCREMENT COMMENT '基本配置自增键',
  `s_key` varchar(255) DEFAULT NULL COMMENT '系统配置key',
  `s_desc` varchar(255) DEFAULT NULL COMMENT '解释说明',
  `s_value` varchar(255) DEFAULT NULL COMMENT '配置值',
  `s_is_able` tinyint(2) DEFAULT '1' COMMENT '是否可用',
  `s_opeatime` int(11) DEFAULT NULL COMMENT '操作时间',
  `s_admin` int(10) DEFAULT NULL COMMENT '操作人，对应管理员id',
  `s_type` tinyint(2) DEFAULT NULL COMMENT '设置的类型；1 短信配置',
  PRIMARY KEY (`s_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统配置表';

-- ----------------------------
-- Records of super_setinfo
-- ----------------------------
INSERT INTO `super_setinfo` VALUES ('8', 'webname', '网站名称', '小宝小程序', '1', '1579082211', '1', '0');
INSERT INTO `super_setinfo` VALUES ('13', 'helpemail', '帮我找房邮件接受者', '1149054548@qq.com', '1', '1579084182', '1', '0');

-- ----------------------------
-- Table structure for `tk_apartment`
-- ----------------------------
DROP TABLE IF EXISTS `tk_apartment`;
CREATE TABLE `tk_apartment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cid` int(10) unsigned NOT NULL COMMENT '分类',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `thumbnail` varchar(256) NOT NULL DEFAULT '' COMMENT '缩略图',
  `summary` varchar(1024) NOT NULL DEFAULT '' COMMENT '摘要',
  `content` text NOT NULL COMMENT '内容',
  `admin_id` int(10) unsigned NOT NULL COMMENT '上传者id',
  `show_time` datetime NOT NULL,
  `dots` int(11) NOT NULL DEFAULT '0',
  `savepathfilename` text NOT NULL,
  `editor` varchar(32) NOT NULL DEFAULT '',
  `view` int(11) NOT NULL,
  `collection` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `cdate` datetime NOT NULL COMMENT '上传时间',
  `mdate` datetime NOT NULL COMMENT '修改时间',
  `oseq` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of tk_apartment
-- ----------------------------
INSERT INTO `tk_apartment` VALUES ('1', '0', 'iglu', '/uploads/thumbnail/2019070714222715624805474222.png', '', '<p>AA</p>', '12', '2019-07-03 10:37:13', '0', '', '', '0', '0', '1', '2019-07-07 14:22:35', '2019-07-07 14:22:35', '0');
INSERT INTO `tk_apartment` VALUES ('2', '0', 'SHA', '/uploads/thumbnail/2019070714203715624804373861.jpg', '', '', '12', '2019-07-03 10:42:47', '0', '', '', '0', '0', '1', '2019-07-07 14:20:47', '2019-07-07 14:20:47', '0');
INSERT INTO `tk_apartment` VALUES ('3', '0', 'Unilodge', '/uploads/thumbnail/2019070714185615624803369939.jpg', '', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0026.gif\"/>&nbsp;Test by Charlie</p>', '12', '2019-07-03 10:48:29', '0', '', '', '0', '0', '1', '2019-07-07 14:19:29', '2019-07-07 14:19:29', '1');

-- ----------------------------
-- Table structure for `tk_cate`
-- ----------------------------
DROP TABLE IF EXISTS `tk_cate`;
CREATE TABLE `tk_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pid` int(11) NOT NULL,
  `hot` varchar(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0' COMMENT 'leixing',
  `dsn` varchar(256) NOT NULL,
  `oseq` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=765 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tk_cate
-- ----------------------------
INSERT INTO `tk_cate` VALUES ('257', 'La Trobe University (Bundoora)', '27', '', '2019-03-01 05:46:29', '2019-05-23 19:13:06', '2', '', '18');
INSERT INTO `tk_cate` VALUES ('4', '清华大学', '1', '', '2018-12-29 14:31:09', '2018-12-29 14:31:09', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('15', '塔斯马尼亚大学', '8', '', '2019-01-03 16:04:08', '2019-01-03 16:04:08', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('28', '悉尼', '0', '', '2019-01-04 22:11:38', '2019-03-01 08:38:33', '0', '002', '100');
INSERT INTO `tk_cate` VALUES ('711', ' Winston Hills', '28', '', '2019-03-11 14:26:21', '2019-03-11 14:26:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('10', '墨尔本大学', '5', '', '2019-01-03 16:00:58', '2019-01-03 16:00:58', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('710', ' Willoughby East', '28', '', '2019-03-11 14:26:08', '2019-03-11 14:26:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('709', 'Willoughby', '28', '', '2019-03-11 14:25:51', '2019-03-11 14:25:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('708', ' Wiley Park ', '28', '', '2019-03-11 14:25:38', '2019-03-11 14:25:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('14', '悉尼大学', '6', '', '2019-01-03 16:02:38', '2019-01-03 16:02:38', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('707', 'Westmead', '28', '', '2019-03-11 14:25:22', '2019-03-11 14:25:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('706', ' Westleigh ', '28', '', '2019-03-11 14:25:08', '2019-03-11 14:25:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('27', '墨尔本', '0', '否', '2019-01-04 22:11:26', '2019-01-04 22:11:26', '0', '001', '100');
INSERT INTO `tk_cate` VALUES ('705', ' West Ryde', '28', '', '2019-03-11 14:24:51', '2019-03-11 14:24:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('704', ' West Pymble ', '28', '', '2019-03-11 14:24:39', '2019-03-11 14:24:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('23', '悉尼大学', '18', '', '2019-01-04 14:46:51', '2019-01-04 14:46:51', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('26', '墨尔本大学', '19', '', '2019-01-04 14:47:18', '2019-01-04 14:47:18', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('702', ' Wentworthville ', '28', '', '2019-03-11 14:24:07', '2019-03-11 14:24:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('301', '塔大Sandy Bay', '274', '', '2019-03-01 15:50:14', '2019-03-01 15:50:57', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('692', 'Wahroonga', '28', '', '2019-03-11 14:18:42', '2019-03-11 14:18:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('686', ' Turramurra ', '28', '', '2019-03-11 14:17:18', '2019-03-11 14:17:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('685', ' Thornleigh', '28', '', '2019-03-11 14:16:54', '2019-03-11 14:16:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('684', ' The Rocks', '28', '', '2019-03-11 14:16:27', '2019-03-11 14:16:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('673', 'Surry Hills', '28', '', '2019-03-11 14:11:52', '2019-03-11 14:11:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('72', 'Box Hill', '27', '是', '2019-02-28 05:41:51', '2019-05-17 12:48:18', '1', '', '2');
INSERT INTO `tk_cate` VALUES ('672', ' Summer Hill ', '28', '', '2019-03-11 14:11:37', '2019-03-11 14:11:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('664', ' South Wentworthville', '28', '', '2019-03-11 14:09:11', '2019-03-11 14:09:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('84', 'Burwood', '27', '是', '2019-02-28 05:45:32', '2019-05-17 12:48:04', '1', '', '1');
INSERT INTO `tk_cate` VALUES ('662', ' South Hurstville', '28', '', '2019-03-11 14:08:37', '2019-03-11 14:08:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('88', 'Carlton', '27', '是', '2019-02-28 05:47:26', '2019-05-19 14:06:18', '1', '', '3');
INSERT INTO `tk_cate` VALUES ('90', 'Caulfield', '27', '是', '2019-02-28 05:48:30', '2019-02-28 05:48:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('91', 'Caulfield East', '27', '否', '2019-02-28 05:48:45', '2019-02-28 05:48:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('652', ' Ryde', '28', '', '2019-03-11 14:05:31', '2019-03-11 14:05:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('100', 'Carnegie', '27', '是', '2019-02-28 05:51:43', '2019-02-28 05:51:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('651', ' Rydalmere', '28', '', '2019-03-11 14:05:12', '2019-03-11 14:05:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('650', 'Russell Lea', '28', '', '2019-03-11 14:04:59', '2019-03-11 14:04:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('104', 'Clayton', '27', '是', '2019-02-28 05:52:40', '2019-02-28 05:52:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('647', ' Roseville Chase', '28', '', '2019-03-11 14:02:23', '2019-03-11 14:02:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('646', 'Roseville', '28', '', '2019-03-11 14:02:10', '2019-03-11 14:02:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('109', 'Docklands', '27', '是', '2019-02-28 17:58:31', '2019-02-28 17:58:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('635', 'Revesby Heights', '28', '', '2019-03-11 13:59:05', '2019-03-11 13:59:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('634', ' Revesby ', '28', '', '2019-03-11 13:58:47', '2019-03-11 13:58:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('632', ' Redfern ', '28', '', '2019-03-11 13:58:16', '2019-03-11 13:58:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('631', ' Randwick', '28', '', '2019-03-11 13:58:00', '2019-03-11 13:58:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('614', ' Pennant Hills', '28', '', '2019-03-11 12:22:39', '2019-03-11 12:22:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('613', ' Pendle Hill', '28', '', '2019-03-11 12:22:25', '2019-03-11 12:22:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('609', ' Panania', '28', '', '2019-03-11 12:21:11', '2019-03-11 12:21:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('608', ' Pagewood', '28', '', '2019-03-11 12:20:56', '2019-03-11 12:20:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('603', ' Oxford Falls ', '28', '', '2019-03-11 12:18:28', '2019-03-11 12:18:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('598', 'Northwood ', '28', '', '2019-03-11 12:16:55', '2019-03-11 12:16:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('597', ' Northmead ', '28', '', '2019-03-11 12:16:42', '2019-03-11 12:16:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('596', ' Northbridge ', '28', '', '2019-03-11 11:52:45', '2019-03-11 11:52:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('595', 'North Willoughby', '28', '', '2019-03-11 11:52:33', '2019-03-11 11:52:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('594', 'North Wahroonga ', '28', '', '2019-03-11 11:52:19', '2019-03-11 11:52:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('592', ' North Sydney ', '28', '', '2019-03-11 11:51:42', '2019-03-11 11:51:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('588', ' North Parramatta', '28', '', '2019-03-11 11:43:14', '2019-03-11 11:43:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('587', ' North Narrabeen', '28', '', '2019-03-11 11:42:56', '2019-03-11 11:42:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('586', ' North Manly ', '28', '', '2019-03-11 11:42:42', '2019-03-11 11:42:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('176', 'Melbourne CBD', '27', '是', '2019-02-28 19:48:16', '2019-06-15 14:33:48', '1', '', '4');
INSERT INTO `tk_cate` VALUES ('585', 'North Epping', '28', '', '2019-03-11 11:42:26', '2019-03-11 11:42:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('584', 'North Curl Curl', '28', '', '2019-03-11 10:56:48', '2019-03-11 10:56:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('583', ' North Bondi ', '28', '', '2019-03-11 10:56:14', '2019-03-11 10:56:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('565', 'Monterey', '28', '', '2019-03-11 10:03:07', '2019-03-11 10:03:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('564', 'Mona Vale', '28', '', '2019-03-11 10:02:50', '2019-03-11 10:02:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('563', 'Miranda', '28', '', '2019-03-11 10:02:33', '2019-03-11 10:02:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('561', ' Milperra', '28', '', '2019-03-11 10:01:52', '2019-03-11 10:01:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('560', ' Middle Cove', '28', '', '2019-03-11 09:46:44', '2019-03-11 09:46:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('204', 'Parkville', '27', '是', '2019-03-01 05:02:20', '2019-06-15 14:34:24', '1', '', '6');
INSERT INTO `tk_cate` VALUES ('557', 'Menai', '28', '', '2019-03-11 09:45:54', '2019-03-11 09:45:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('556', 'Melrose Park', '28', '', '2019-03-11 09:45:13', '2019-03-11 09:45:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('555', ' Meadowbank', '28', '', '2019-03-11 09:44:57', '2019-03-11 10:17:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('544', 'Maianbar', '28', '', '2019-03-11 09:36:23', '2019-03-11 10:16:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('220', 'Southbank', '27', '是', '2019-03-01 05:08:23', '2019-06-15 14:34:58', '1', '', '7');
INSERT INTO `tk_cate` VALUES ('525', ' Lane Cove West', '28', '', '2019-03-03 06:42:58', '2019-03-03 06:42:58', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('514', ' Kirrawee', '28', '', '2019-03-03 06:37:27', '2019-03-03 06:37:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('513', ' Kingsgrove', '28', '', '2019-03-03 06:37:14', '2019-03-03 06:37:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('512', 'Kingsford', '28', '', '2019-03-03 06:34:42', '2019-03-03 06:34:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('510', ' Killara', '28', '', '2019-03-03 06:34:00', '2019-03-03 06:34:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('509', ' Kensington', '28', '', '2019-03-03 06:33:44', '2019-03-03 06:33:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('508', ' Kareela', '28', '', '2019-03-03 06:33:26', '2019-03-03 06:33:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('258', 'LaTrobe University(市中心)', '27', '', '2019-03-01 05:47:39', '2019-05-23 19:12:33', '2', '', '17');
INSERT INTO `tk_cate` VALUES ('259', '莫纳什大学 (Clayton）', '27', '', '2019-03-01 05:48:57', '2019-05-23 18:19:32', '2', '', '5');
INSERT INTO `tk_cate` VALUES ('260', '莫纳什大学 (Caulfield)', '27', '', '2019-03-01 05:54:00', '2019-05-23 18:18:38', '2', '', '4');
INSERT INTO `tk_cate` VALUES ('261', '莫纳什大学 (Peninsula)', '27', '', '2019-03-01 05:54:50', '2019-05-23 18:20:59', '2', '', '7');
INSERT INTO `tk_cate` VALUES ('262', '莫纳什大学 (Parkville)', '27', '', '2019-03-01 05:56:11', '2019-05-23 18:20:39', '2', '', '6');
INSERT INTO `tk_cate` VALUES ('263', 'RMIT University (市中心)	', '27', '', '2019-03-01 05:56:51', '2019-05-23 18:21:31', '2', '', '8');
INSERT INTO `tk_cate` VALUES ('264', 'RMIT University (Brunswick)', '27', '', '2019-03-01 05:57:19', '2019-05-23 19:07:12', '2', '', '9');
INSERT INTO `tk_cate` VALUES ('265', 'RMIT University (Bundoora)', '27', '', '2019-03-01 05:57:46', '2019-05-23 19:07:38', '2', '', '10');
INSERT INTO `tk_cate` VALUES ('266', 'Swinburne University (Hawthorn)', '27', '', '2019-03-01 05:58:34', '2019-05-23 19:11:58', '2', '', '16');
INSERT INTO `tk_cate` VALUES ('267', '墨尔本大学 (Parkville)', '27', '', '2019-03-01 05:59:44', '2019-05-26 07:31:15', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('268', '墨尔本大学语言学校 (Hawthorn)', '27', '', '2019-03-01 06:00:40', '2019-05-23 18:17:40', '2', '', '3');
INSERT INTO `tk_cate` VALUES ('269', '墨尔本大学 (Southbank)', '27', '', '2019-03-01 06:01:44', '2019-05-23 18:16:52', '2', '', '2');
INSERT INTO `tk_cate` VALUES ('270', 'Victoria University (Footscray)', '27', '', '2019-03-01 06:02:17', '2019-05-23 19:08:39', '2', '', '12');
INSERT INTO `tk_cate` VALUES ('271', 'Victoria University (市中心)', '27', '', '2019-03-01 06:03:30', '2019-05-23 19:08:15', '2', '', '11');
INSERT INTO `tk_cate` VALUES ('272', 'Victoria University (Sunshine)', '27', '', '2019-03-01 06:04:42', '2019-05-23 19:09:59', '2', '', '13');
INSERT INTO `tk_cate` VALUES ('273', 'Deakin University (Burwood)', '27', '', '2019-03-01 06:05:09', '2019-05-23 19:11:25', '2', '', '15');
INSERT INTO `tk_cate` VALUES ('274', '霍巴特', '0', '', '2019-03-01 08:39:21', '2019-03-01 08:39:21', '0', '003', '100');
INSERT INTO `tk_cate` VALUES ('504', ' Illawong', '28', '', '2019-03-03 06:32:19', '2019-03-03 06:32:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('501', 'Hurlstone Park', '28', '', '2019-03-03 06:30:11', '2019-03-03 06:30:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('497', 'Hornsby Heights', '28', '', '2019-03-03 06:15:50', '2019-03-03 06:15:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('287', '朗塞斯顿', '0', '', '2019-03-01 11:14:56', '2019-09-18 12:16:12', '0', '005', '100');
INSERT INTO `tk_cate` VALUES ('496', 'Hornsby', '28', '', '2019-03-03 06:15:34', '2019-03-03 06:15:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('293', '塔大Newnham校区', '287', '', '2019-03-01 11:32:34', '2019-03-01 11:32:34', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('294', '塔大Inveresk校区', '287', '', '2019-03-01 11:34:01', '2019-03-01 11:34:01', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('488', ' Hmas Kuttabul', '28', '', '2019-03-03 06:13:16', '2019-03-03 06:13:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('487', 'Hillsdale', '28', '', '2019-03-03 06:12:56', '2019-03-03 06:12:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('486', ' Henley', '28', '', '2019-03-03 06:12:41', '2019-03-03 06:12:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('303', 'Auburn', '28', '否', '2019-03-02 06:10:23', '2019-03-02 12:39:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('485', ' Haymarket', '28', '', '2019-03-03 06:12:23', '2019-03-03 06:12:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('484', 'Harris Park', '28', '', '2019-03-03 06:12:01', '2019-03-03 06:12:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('483', ' Harbord ', '28', '', '2019-03-03 06:11:44', '2019-03-03 06:11:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('482', 'Haberfield', '28', '', '2019-03-03 06:11:25', '2019-03-03 06:11:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('480', 'Gymea', '28', '', '2019-03-03 05:55:21', '2019-03-03 05:55:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('476', ' Greenwich', '28', '', '2019-03-03 05:54:16', '2019-03-03 05:54:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('471', 'Glebe', '28', '', '2019-03-03 05:52:47', '2019-03-03 05:52:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('470', 'Gladesville', '28', '', '2019-03-03 05:52:32', '2019-03-03 05:52:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('321', '其他', '27', '', '2019-03-02 12:44:57', '2019-03-27 18:32:26', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('469', ' Georges Hall', '28', '', '2019-03-03 05:52:12', '2019-03-03 05:52:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('462', ' Fairfield Heights', '28', '', '2019-03-03 05:48:21', '2019-03-03 05:48:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('454', 'Enmore', '28', '', '2019-03-02 17:38:33', '2019-03-02 17:38:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('453', ' Enfield', '28', '', '2019-03-02 17:38:17', '2019-03-02 17:38:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('452', ' Elizabeth Bay', '28', '', '2019-03-02 17:38:00', '2019-03-02 17:38:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('446', ' East Ryde', '28', '', '2019-03-02 17:36:04', '2019-03-02 17:36:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('440', ' Dulwich Hill ', '28', '', '2019-03-02 15:55:28', '2019-03-02 15:55:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('424', 'Curl Curl', '28', '', '2019-03-02 15:34:29', '2019-03-02 15:34:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('418', ' Cremorne', '28', '', '2019-03-02 15:32:30', '2019-03-02 15:32:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('417', ' Coogee ', '28', '', '2019-03-02 15:31:06', '2019-03-02 15:31:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('386', 'Caravan Head', '28', '', '2019-03-02 14:51:32', '2019-03-02 14:51:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('385', ' Canterbury', '28', '', '2019-03-02 14:51:17', '2019-03-02 14:51:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('380', ' Cammeray', '28', '', '2019-03-02 14:49:34', '2019-03-02 14:49:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('379', ' Camellia', '28', '', '2019-03-02 14:49:16', '2019-03-02 14:49:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('378', 'Cabarita', '28', '', '2019-03-02 14:48:48', '2019-03-02 14:48:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('372', 'Bronte', '28', '', '2019-03-02 13:43:16', '2019-03-02 13:43:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('369', ' Botany', '28', '', '2019-03-02 13:35:54', '2019-03-02 13:35:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('364', 'Bondi', '28', '', '2019-03-02 13:31:21', '2019-03-02 13:31:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('346', 'Baulkham Hills', '28', '', '2019-03-02 12:57:33', '2019-03-02 12:57:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('345', 'Bass Hill', '28', '', '2019-03-02 12:57:16', '2019-03-02 12:57:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('344', 'Bardwell Valley', '28', '', '2019-03-02 12:56:55', '2019-03-02 12:56:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('343', ' Bardwell Park', '28', '', '2019-03-02 12:56:41', '2019-03-02 12:56:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('338', ' Bangor', '28', '', '2019-03-02 12:52:39', '2019-03-02 12:52:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('337', ' Balmain East', '28', '', '2019-03-02 12:52:20', '2019-03-02 12:52:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('336', ' Balmain', '28', '', '2019-03-02 12:52:05', '2019-03-02 12:52:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('326', 'Allawah', '28', '', '2019-03-02 12:48:59', '2019-03-02 12:48:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('325', 'Allambie Heights', '28', '', '2019-03-02 12:48:36', '2019-03-02 12:48:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('299', '其他', '287', '', '2019-03-01 11:38:12', '2019-03-01 11:38:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('298', 'Kings Meadows', '287', '', '2019-03-01 11:37:52', '2019-03-01 11:37:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('297', 'South Launceston', '287', '', '2019-03-01 11:36:59', '2019-03-01 11:36:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('256', 'Yallambie', '27', '', '2019-03-01 05:36:54', '2019-03-01 05:36:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('255', 'Yarraville', '27', '', '2019-03-01 05:36:39', '2019-03-01 05:36:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('254', 'Westmeadows', '27', '', '2019-03-01 05:36:20', '2019-03-01 05:36:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('250', 'West Melbourne', '27', '', '2019-03-01 05:35:16', '2019-03-01 05:35:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('726', '悉尼音乐学院', '28', '', '2019-03-11 14:32:35', '2019-03-11 14:32:35', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('217', 'South Melbourne', '27', '', '2019-03-01 05:07:48', '2019-03-01 05:07:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('725', '悉尼大学(主校区）', '28', '', '2019-03-11 14:31:51', '2019-03-11 14:31:51', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('208', 'Prahran', '27', '', '2019-03-01 05:03:43', '2019-03-01 05:03:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('207', 'Port Melbourne', '27', '', '2019-03-01 05:03:29', '2019-03-01 05:03:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('203', 'Ormond', '27', '', '2019-03-01 05:02:04', '2019-03-01 05:02:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('202', 'Oakleigh South', '27', '', '2019-03-01 05:01:48', '2019-03-01 05:01:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('201', 'Oakleigh East', '27', '', '2019-03-01 04:59:51', '2019-03-01 04:59:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('200', 'Oakleigh', '27', '', '2019-03-01 04:59:39', '2019-03-01 04:59:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('199', 'Oak Park', '27', '', '2019-03-01 04:59:28', '2019-03-01 04:59:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('198', 'Nunawading', '27', '', '2019-03-01 04:56:26', '2019-03-01 04:56:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('196', 'Niddrie', '27', '', '2019-03-01 04:55:58', '2019-03-01 04:55:58', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('195', 'Northcote', '27', '', '2019-03-01 04:55:28', '2019-03-01 04:55:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('148', 'Heidelberg West', '27', '', '2019-02-28 19:13:43', '2019-02-28 19:13:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('138', 'Gowanbrae', '27', '', '2019-02-28 19:10:21', '2019-02-28 19:10:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('137', 'Glenroy', '27', '', '2019-02-28 19:10:09', '2019-02-28 19:10:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('136', 'Glen Waverley', '27', '', '2019-02-28 19:09:55', '2019-02-28 19:09:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('135', 'Glen Huntly', '27', '', '2019-02-28 19:08:14', '2019-02-28 19:09:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('118', 'Elwood', '27', '', '2019-02-28 18:01:20', '2019-02-28 18:01:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('117', 'Elsternwick', '27', '', '2019-02-28 18:01:03', '2019-02-28 18:01:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('115', 'Donvale', '27', '', '2019-02-28 18:00:10', '2019-02-28 18:00:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('93', 'Caulfield South', '27', '', '2019-02-28 05:49:15', '2019-02-28 05:49:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('92', 'Caulfield North', '27', '', '2019-02-28 05:48:59', '2019-02-28 05:48:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('89', 'Carlton North', '27', '', '2019-02-28 05:48:14', '2019-02-28 05:48:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('74', 'Box Hill South', '27', '', '2019-02-28 05:42:21', '2019-02-28 05:42:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('71', 'Blackburn South', '27', '', '2019-02-28 05:41:34', '2019-02-28 05:41:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('69', 'Blackburn', '27', '', '2019-02-28 05:41:03', '2019-02-28 05:41:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('68', 'Black Rock', '27', '', '2019-02-28 05:38:53', '2019-02-28 05:38:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('64', 'Burnley', '27', '', '2019-02-28 05:37:28', '2019-02-28 05:37:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('52', 'Ardeer', '27', '', '2019-02-28 05:26:11', '2019-02-28 05:26:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('51', 'Altona North', '27', '', '2019-02-28 05:25:52', '2019-02-28 05:25:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('727', '悉尼大学(Cumberland)', '28', '', '2019-03-11 14:34:16', '2019-03-11 14:34:16', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('728', '悉尼大学(Rozelle)', '28', '', '2019-03-11 14:35:35', '2019-03-11 14:35:35', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('729', '悉尼大学(Westmead)', '28', '', '2019-03-11 14:36:53', '2019-03-11 14:36:53', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('730', '新南威尔士大学(Kensington)', '28', '', '2019-03-11 14:39:03', '2019-03-11 14:39:03', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('731', '新南威尔士大学(Paddington)', '28', '', '2019-03-11 14:39:36', '2019-03-11 14:39:36', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('732', '麦觉理大学', '28', '', '2019-03-11 14:42:37', '2019-03-11 14:42:37', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('733', '悉尼科技大学(City)', '28', '', '2019-03-11 14:44:57', '2019-03-11 14:44:57', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('734', '西悉尼大学(Bankstown)', '28', '', '2019-03-11 14:47:04', '2019-03-11 14:47:04', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('735', '西悉尼大学(Campbelltown)', '28', '', '2019-03-11 14:48:35', '2019-03-11 14:48:35', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('736', '西悉尼大学(Hawkesbury)', '28', '', '2019-03-11 14:49:40', '2019-03-11 14:49:40', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('737', '西悉尼大学(Nirimba)', '28', '', '2019-03-11 14:51:05', '2019-03-11 14:51:05', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('738', '西悉尼大学(Parramatta)', '28', '', '2019-03-11 14:52:49', '2019-03-11 14:52:49', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('739', '西悉尼大学(Kingswood)', '28', '', '2019-03-11 14:54:34', '2019-03-11 14:54:34', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('740', '西悉尼大学(City)', '28', '', '2019-03-11 14:55:06', '2019-03-11 14:55:06', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('741', '澳洲天主教大学(North Sydney)', '28', '', '2019-03-11 14:56:42', '2019-03-11 14:56:42', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('743', '其他', '28', '', '2019-03-11 14:58:26', '2019-03-11 14:58:26', '2', '', '100');
INSERT INTO `tk_cate` VALUES ('749', 'Victoria University (Werribee)', '27', '', '2019-04-19 09:30:37', '2019-05-23 19:10:57', '2', '', '14');
INSERT INTO `tk_cate` VALUES ('9', '北墨尔本', '5', '', '2019-01-03 16:00:48', '2019-01-03 16:00:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('757', '新南威尔士大学（Randwick）', '28', '', '2019-07-15 10:27:10', '2019-07-15 10:27:10', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('703', ' West Pennant Hills', '28', '', '2019-03-11 14:24:25', '2019-03-11 14:24:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('701', ' Waverton ', '28', '', '2019-03-11 14:23:55', '2019-03-11 14:23:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('700', ' Waverley', '28', '', '2019-03-11 14:23:40', '2019-03-11 14:23:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('699', ' Watsons Bay ', '28', '', '2019-03-11 14:23:24', '2019-03-11 14:23:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('698', ' Waterloo', '28', '', '2019-03-11 14:23:09', '2019-03-11 14:23:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('697', ' Warumbul', '28', '', '2019-03-11 14:20:14', '2019-03-11 14:20:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('696', ' Warriewood ', '28', '', '2019-03-11 14:19:50', '2019-03-11 14:19:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('695', 'Warrawee ', '28', '', '2019-03-11 14:19:34', '2019-03-11 14:19:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('694', ' Wareemba', '28', '', '2019-03-11 14:19:17', '2019-03-11 14:19:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('693', ' Waitara', '28', '', '2019-03-11 14:18:56', '2019-03-11 14:18:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('691', ' Voyager Point', '28', '', '2019-03-11 14:18:29', '2019-03-11 14:18:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('690', ' Villawood ', '28', '', '2019-03-11 14:18:15', '2019-03-11 14:18:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('689', ' Vaucluse', '28', '', '2019-03-11 14:18:03', '2019-03-11 14:18:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('688', ' Ultimo ', '28', '', '2019-03-11 14:17:49', '2019-03-11 14:17:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('687', ' Turrella', '28', '', '2019-03-11 14:17:29', '2019-03-11 14:17:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('683', ' Terrey Hills ', '28', '', '2019-03-11 14:15:47', '2019-03-11 14:15:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('682', 'Tennyson Point', '28', '', '2019-03-11 14:15:32', '2019-03-11 14:15:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('681', 'Tempe ', '28', '', '2019-03-11 14:15:16', '2019-03-11 14:15:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('680', 'Telopea', '28', '', '2019-03-11 14:15:02', '2019-03-11 14:15:02', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('679', ' Taren Point', '28', '', '2019-03-11 14:14:42', '2019-03-11 14:14:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('678', 'Tamarama', '28', '', '2019-03-11 14:14:24', '2019-03-11 14:14:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('677', ' Sylvania Waters', '28', '', '2019-03-11 14:14:06', '2019-03-11 14:14:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('676', 'Sylvania', '28', '', '2019-03-11 14:13:23', '2019-03-11 14:13:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('675', 'Sydenham', '28', '', '2019-03-11 14:12:22', '2019-03-11 14:12:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('674', ' Sutherland ', '28', '', '2019-03-11 14:12:07', '2019-03-11 14:12:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('671', 'Strathfield South ', '28', '', '2019-03-11 14:11:21', '2019-03-11 14:11:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('670', ' Strathfield ', '28', '', '2019-03-11 14:11:04', '2019-03-11 14:11:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('669', 'Stanmore ', '28', '', '2019-03-11 14:10:39', '2019-03-11 14:10:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('668', ' St Peters', '28', '', '2019-03-11 14:10:23', '2019-03-11 14:10:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('667', ' St Leonards', '28', '', '2019-03-11 14:10:03', '2019-03-11 14:10:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('666', 'St Ives Chase', '28', '', '2019-03-11 14:09:50', '2019-03-11 14:09:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('665', ' St Ives', '28', '', '2019-03-11 14:09:24', '2019-03-11 14:09:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('663', ' South Turramurra ', '28', '', '2019-03-11 14:08:57', '2019-03-11 14:08:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('661', ' South Granville', '28', '', '2019-03-11 14:08:22', '2019-03-11 14:08:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('660', ' South Coogee', '28', '', '2019-03-11 14:08:06', '2019-03-11 14:08:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('659', 'Smithfield', '28', '', '2019-03-11 14:07:49', '2019-03-11 14:07:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('658', 'Silverwater', '28', '', '2019-03-11 14:07:22', '2019-03-11 14:07:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('657', ' Sefton', '28', '', '2019-03-11 14:07:06', '2019-03-11 14:07:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('656', ' Seaforth', '28', '', '2019-03-11 14:06:44', '2019-03-11 14:06:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('655', 'Sans Souci', '28', '', '2019-03-11 14:06:13', '2019-03-11 14:06:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('654', ' Sandy Point', '28', '', '2019-03-11 14:05:59', '2019-03-11 14:05:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('653', ' Sandringham ', '28', '', '2019-03-11 14:05:46', '2019-03-11 14:05:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('649', ' Rushcutters Bay', '28', '', '2019-03-11 14:04:46', '2019-03-11 14:04:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('648', 'Rozelle', '28', '', '2019-03-11 14:02:42', '2019-03-11 14:04:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('645', ' Roselands', '28', '', '2019-03-11 14:01:57', '2019-03-11 14:01:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('644', ' Rosehill ', '28', '', '2019-03-11 14:01:31', '2019-03-11 14:01:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('643', 'Rosebery ', '28', '', '2019-03-11 14:01:13', '2019-03-11 14:01:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('642', ' Rose Bay', '28', '', '2019-03-11 14:00:55', '2019-03-11 14:00:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('641', 'Rookwood', '28', '', '2019-03-11 14:00:34', '2019-03-11 14:00:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('640', 'Rodd Point', '28', '', '2019-03-11 14:00:19', '2019-03-11 14:00:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('639', ' Rockdale', '28', '', '2019-03-11 14:00:02', '2019-03-11 14:00:02', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('638', 'Riverwood', '28', '', '2019-03-11 13:59:50', '2019-03-11 13:59:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('637', 'Riverview', '28', '', '2019-03-11 13:59:37', '2019-03-11 13:59:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('636', 'Rhodes', '28', '', '2019-03-11 13:59:23', '2019-03-11 13:59:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('633', ' Regents Park', '28', '', '2019-03-11 13:58:33', '2019-03-11 13:58:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('630', ' Ramsgate Beach', '28', '', '2019-03-11 13:57:42', '2019-03-11 13:57:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('629', ' Ramsgate', '28', '', '2019-03-11 13:57:23', '2019-03-11 13:57:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('628', ' Queenscliff ', '28', '', '2019-03-11 13:56:56', '2019-03-11 13:56:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('627', ' Queens Park ', '28', '', '2019-03-11 13:56:40', '2019-03-11 13:56:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('626', ' Pyrmont', '28', '', '2019-03-11 13:56:27', '2019-03-11 13:56:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('625', ' Pymble', '28', '', '2019-03-11 13:56:14', '2019-03-11 13:56:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('624', ' Putney', '28', '', '2019-03-11 13:56:00', '2019-03-11 13:56:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('623', ' Punchbowl', '28', '', '2019-03-11 13:55:47', '2019-03-11 13:55:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('622', ' Potts Point', '28', '', '2019-03-11 13:55:31', '2019-03-11 13:55:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('621', ' Potts Hill', '28', '', '2019-03-11 13:55:15', '2019-03-11 13:55:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('620', ' Port Hacking', '28', '', '2019-03-11 12:24:47', '2019-03-11 12:24:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('619', ' Port Botany ', '28', '', '2019-03-11 12:24:22', '2019-03-11 12:24:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('618', ' Picnic Point', '28', '', '2019-03-11 12:23:47', '2019-03-11 12:23:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('617', 'Phillip Bay', '28', '', '2019-03-11 12:23:34', '2019-03-11 12:23:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('616', 'Petersham', '28', '', '2019-03-11 12:23:15', '2019-03-11 12:23:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('615', 'Penshurst', '28', '', '2019-03-11 12:23:00', '2019-03-11 12:23:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('612', 'Peakhurst Heights ', '28', '', '2019-03-11 12:22:04', '2019-03-11 12:22:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('611', ' Peakhurst ', '28', '', '2019-03-11 12:21:45', '2019-03-11 12:21:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('610', ' Parramatta', '28', '', '2019-03-11 12:21:26', '2019-03-11 12:21:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('607', 'Padstow Heights', '28', '', '2019-03-11 12:20:38', '2019-03-11 12:20:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('606', 'Padstow', '28', '', '2019-03-11 12:19:27', '2019-03-11 12:19:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('605', ' Paddington ', '28', '', '2019-03-11 12:19:02', '2019-03-11 12:19:02', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('604', 'Oyster Bay', '28', '', '2019-03-11 12:18:41', '2019-03-11 12:18:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('602', ' Old Toongabbie', '28', '', '2019-03-11 12:18:11', '2019-03-11 12:18:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('601', 'Old Guildford', '28', '', '2019-03-11 12:17:54', '2019-03-11 12:17:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('600', 'Oatley', '28', '', '2019-03-11 12:17:32', '2019-03-11 12:17:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('599', ' Oatlands', '28', '', '2019-03-11 12:17:11', '2019-03-11 12:17:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('593', ' North Turramurra', '28', '', '2019-03-11 11:52:05', '2019-03-11 11:52:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('591', 'North Strathfield ', '28', '', '2019-03-11 11:44:05', '2019-03-11 11:44:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('590', ' North Ryde', '28', '', '2019-03-11 11:43:47', '2019-03-11 11:43:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('589', 'North Rocks', '28', '', '2019-03-11 11:43:28', '2019-03-11 11:43:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('582', ' North Balgowlah', '28', '', '2019-03-11 10:55:57', '2019-03-11 10:55:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('581', 'Normanhurst', '28', '', '2019-03-11 10:55:36', '2019-03-11 10:55:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('580', ' Newtown ', '28', '', '2019-03-11 10:55:16', '2019-03-11 10:55:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('579', 'Newport ', '28', '', '2019-03-11 10:55:01', '2019-03-11 10:55:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('578', ' Newington', '28', '', '2019-03-11 10:31:10', '2019-03-11 10:31:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('577', ' Neutral Bay', '28', '', '2019-03-11 10:30:54', '2019-03-11 10:30:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('576', 'Narwee', '28', '', '2019-03-11 10:30:36', '2019-03-11 10:30:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('575', 'Narraweena', '28', '', '2019-03-11 10:30:16', '2019-03-11 10:30:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('574', 'Narrabeen', '28', '', '2019-03-11 10:29:57', '2019-03-11 10:29:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('573', ' Naremburn', '28', '', '2019-03-11 10:29:35', '2019-03-11 10:29:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('572', ' Mount Lewis', '28', '', '2019-03-11 10:24:32', '2019-03-11 10:24:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('571', 'Mount Colah', '28', '', '2019-03-11 10:24:17', '2019-03-11 10:24:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('570', ' Mosman', '28', '', '2019-03-11 10:24:01', '2019-03-11 10:24:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('569', ' Mortlake', '28', '', '2019-03-11 10:23:41', '2019-03-11 10:23:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('568', ' Mortdale', '28', '', '2019-03-11 10:23:23', '2019-03-11 10:23:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('567', ' Moorebank ', '28', '', '2019-03-11 10:18:27', '2019-03-11 10:18:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('566', ' Moore Park', '28', '', '2019-03-11 10:18:09', '2019-03-11 10:18:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('562', ' Milsons Point', '28', '', '2019-03-11 10:02:14', '2019-03-11 10:02:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('559', ' Merrylands West ', '28', '', '2019-03-11 09:46:26', '2019-03-11 09:46:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('558', 'Merrylands', '28', '', '2019-03-11 09:46:10', '2019-03-11 09:46:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('554', ' Mcmahons Point', '28', '', '2019-03-11 09:44:41', '2019-03-11 09:44:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('553', 'Mays Hill', '28', '', '2019-03-11 09:40:05', '2019-03-11 09:40:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('552', 'Matraville ', '28', '', '2019-03-11 09:39:45', '2019-03-11 09:39:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('551', ' Mascot ', '28', '', '2019-03-11 09:39:13', '2019-03-11 09:39:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('550', 'Marsfield', '28', '', '2019-03-11 09:38:57', '2019-03-11 09:38:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('549', ' Marrickville', '28', '', '2019-03-11 09:38:35', '2019-03-11 09:38:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('548', ' Maroubra', '28', '', '2019-03-11 09:38:19', '2019-03-11 09:38:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('547', ' Manly Vale', '28', '', '2019-03-11 09:37:56', '2019-03-11 09:37:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('546', ' Manly', '28', '', '2019-03-11 09:37:31', '2019-03-11 09:37:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('545', 'Malabar', '28', '', '2019-03-11 09:36:51', '2019-03-11 09:37:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('543', ' Macquarie Park', '28', '', '2019-03-11 09:35:55', '2019-03-11 09:35:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('540', 'Lugarno', '28', '', '2019-03-03 06:56:33', '2019-03-03 06:56:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('539', 'Longueville ', '28', '', '2019-03-03 06:56:20', '2019-03-03 06:56:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('538', ' Loftus', '28', '', '2019-03-03 06:56:06', '2019-03-03 06:56:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('537', ' Little Bay', '28', '', '2019-03-03 06:55:53', '2019-03-03 06:55:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('536', 'Linley Point ', '28', '', '2019-03-03 06:55:36', '2019-03-03 06:55:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('535', 'Lindfield', '28', '', '2019-03-03 06:46:39', '2019-03-03 06:46:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('534', ' Lilyfield', '28', '', '2019-03-03 06:46:19', '2019-03-03 06:46:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('533', ' Lilli Pilli', '28', '', '2019-03-03 06:46:06', '2019-03-03 06:46:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('532', ' Lidcombe', '28', '', '2019-03-03 06:45:51', '2019-03-03 06:45:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('531', ' Liberty Grove', '28', '', '2019-03-03 06:45:23', '2019-03-03 06:45:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('530', ' Lewisham', '28', '', '2019-03-03 06:44:56', '2019-03-03 06:44:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('529', ' Leichhardt', '28', '', '2019-03-03 06:44:41', '2019-03-03 06:44:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('528', 'Lavender Bay', '28', '', '2019-03-03 06:44:07', '2019-03-03 06:44:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('527', ' Lansvale', '28', '', '2019-03-03 06:43:51', '2019-03-03 06:43:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('526', 'Lansdowne ', '28', '', '2019-03-03 06:43:33', '2019-03-03 06:43:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('524', 'Lane Cove North', '28', '', '2019-03-03 06:42:24', '2019-03-03 06:42:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('523', 'Lane Cove', '28', '', '2019-03-03 06:41:12', '2019-03-03 06:41:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('522', 'Lakemba', '28', '', '2019-03-03 06:40:51', '2019-03-03 06:40:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('521', ' La Perouse', '28', '', '2019-03-03 06:40:33', '2019-03-03 06:40:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('520', ' Kyle Bay', '28', '', '2019-03-03 06:39:37', '2019-03-03 06:39:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('519', ' Kyeemagh', '28', '', '2019-03-03 06:39:25', '2019-03-03 06:39:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('518', 'Kurnell', '28', '', '2019-03-03 06:39:11', '2019-03-03 06:39:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('517', ' Kogarah Bay', '28', '', '2019-03-03 06:38:55', '2019-03-03 06:38:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('516', ' Kogarah', '28', '', '2019-03-03 06:38:35', '2019-03-03 06:38:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('515', ' Kirribilli ', '28', '', '2019-03-03 06:37:48', '2019-03-03 06:37:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('511', 'Killarney Heights', '28', '', '2019-03-03 06:34:22', '2019-03-03 06:34:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('507', ' Kangaroo Point', '28', '', '2019-03-03 06:33:09', '2019-03-03 06:33:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('506', 'Jannali', '28', '', '2019-03-03 06:32:55', '2019-03-03 06:32:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('505', 'Ingleside', '28', '', '2019-03-03 06:32:39', '2019-03-03 06:32:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('503', 'Hurstville Grove', '28', '', '2019-03-03 06:30:51', '2019-03-03 06:30:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('502', 'Hurstville', '28', '', '2019-03-03 06:30:27', '2019-03-03 06:30:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('500', ' Huntleys Point', '28', '', '2019-03-03 06:29:55', '2019-03-03 06:29:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('499', ' Huntleys Cove', '28', '', '2019-03-03 06:16:28', '2019-03-03 06:16:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('498', 'Hunters Hill', '28', '', '2019-03-03 06:16:11', '2019-03-03 06:16:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('495', ' Homebush West', '28', '', '2019-03-03 06:15:15', '2019-03-03 06:15:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('494', 'Homebush Bay', '28', '', '2019-03-03 06:14:52', '2019-03-03 06:14:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('493', ' Homebush', '28', '', '2019-03-03 06:14:36', '2019-03-03 06:14:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('492', 'Holroyd', '28', '', '2019-03-03 06:14:20', '2019-03-03 06:14:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('491', 'Hmas Watson', '28', '', '2019-03-03 06:14:07', '2019-03-03 06:14:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('490', 'Hmas Waterhen', '28', '', '2019-03-03 06:13:50', '2019-03-03 06:13:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('489', ' Hmas Rushcutters', '28', '', '2019-03-03 06:13:34', '2019-03-03 06:13:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('481', ' Gymea Bay', '28', '', '2019-03-03 05:55:40', '2019-03-03 05:55:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('479', ' Guildford West', '28', '', '2019-03-03 05:55:05', '2019-03-03 05:55:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('478', 'Guildford', '28', '', '2019-03-03 05:54:49', '2019-03-03 05:54:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('477', ' Greystanes', '28', '', '2019-03-03 05:54:33', '2019-03-03 05:54:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('475', ' Greenacre', '28', '', '2019-03-03 05:53:49', '2019-03-03 05:53:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('474', 'Grays Point', '28', '', '2019-03-03 05:53:32', '2019-03-03 05:53:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('473', ' Granville', '28', '', '2019-03-03 05:53:17', '2019-03-03 05:53:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('472', ' Gordon', '28', '', '2019-03-03 05:53:01', '2019-03-03 05:53:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('468', 'Frenchs Forest East', '28', '', '2019-03-03 05:51:50', '2019-03-03 05:51:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('467', 'Frenchs Forest', '28', '', '2019-03-03 05:49:50', '2019-03-03 05:49:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('466', 'Forestville', '28', '', '2019-03-03 05:49:28', '2019-03-03 05:49:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('465', 'Forest Lodge', '28', '', '2019-03-03 05:49:12', '2019-03-03 05:49:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('464', 'Five Dock', '28', '', '2019-03-03 05:48:56', '2019-03-03 05:48:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('463', ' Fairlight', '28', '', '2019-03-03 05:48:40', '2019-03-03 05:48:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('461', ' Fairfield East', '28', '', '2019-03-03 05:47:52', '2019-03-03 05:47:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('460', ' Fairfield', '28', '', '2019-03-03 05:47:22', '2019-03-03 05:47:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('459', ' Eveleigh', '28', '', '2019-03-02 19:03:21', '2019-03-02 19:03:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('458', 'Eurimbla', '28', '', '2019-03-02 19:03:01', '2019-03-02 19:03:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('457', 'Erskineville', '28', '', '2019-03-02 17:39:38', '2019-03-02 17:39:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('456', ' Ermington', '28', '', '2019-03-02 17:39:23', '2019-03-02 17:39:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('455', ' Epping ', '28', '', '2019-03-02 17:39:04', '2019-03-02 17:39:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('451', 'Elanora Heights', '28', '', '2019-03-02 17:37:42', '2019-03-02 17:37:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('450', 'Edgecliff', '28', '', '2019-03-02 17:37:20', '2019-03-02 17:37:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('449', 'Eastwood', '28', '', '2019-03-02 17:37:03', '2019-03-02 17:37:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('448', ' Eastlakes', '28', '', '2019-03-02 17:36:35', '2019-03-02 17:36:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('447', ' Eastgardens', '28', '', '2019-03-02 17:36:20', '2019-03-02 17:36:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('445', ' East Lindfield ', '28', '', '2019-03-02 17:35:46', '2019-03-02 17:35:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('444', ' East Killara', '28', '', '2019-03-02 17:35:30', '2019-03-02 17:35:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('443', ' East Hills', '28', '', '2019-03-02 17:35:17', '2019-03-02 17:35:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('442', ' Earlwood ', '28', '', '2019-03-02 15:56:53', '2019-03-02 15:56:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('441', ' Dundas ', '28', '', '2019-03-02 15:56:28', '2019-03-02 15:56:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('439', ' Duffys Forest', '28', '', '2019-03-02 15:55:12', '2019-03-02 15:55:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('438', 'Drummoyne', '28', '', '2019-03-02 15:54:53', '2019-03-02 15:54:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('437', ' Dover Heights', '28', '', '2019-03-02 15:54:35', '2019-03-02 15:54:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('436', 'Double Bay', '28', '', '2019-03-02 15:54:15', '2019-03-02 15:54:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('435', 'Dolls Point', '28', '', '2019-03-02 15:53:59', '2019-03-02 15:53:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('434', 'Dolans Bay', '28', '', '2019-03-02 15:42:19', '2019-03-02 15:42:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('433', ' Denistone East', '28', '', '2019-03-02 15:41:50', '2019-03-02 15:41:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('432', 'Denistone', '28', '', '2019-03-02 15:41:28', '2019-03-02 15:41:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('431', ' Dee Why', '28', '', '2019-03-02 15:41:06', '2019-03-02 15:41:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('430', 'Dawes Point', '28', '', '2019-03-02 15:40:07', '2019-03-02 15:40:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('429', ' Davidson', '28', '', '2019-03-02 15:39:47', '2019-03-02 15:39:47', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('428', 'Darlington', '28', '', '2019-03-02 15:39:30', '2019-03-02 15:39:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('427', ' Darlinghurst', '28', '', '2019-03-02 15:39:09', '2019-03-02 15:39:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('426', 'Darling Point', '28', '', '2019-03-02 15:38:53', '2019-03-02 15:38:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('425', ' Daceyville', '28', '', '2019-03-02 15:38:26', '2019-03-02 15:38:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('423', 'Croydon Park', '28', '', '2019-03-02 15:34:12', '2019-03-02 15:34:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('422', ' Croydon', '28', '', '2019-03-02 15:33:49', '2019-03-02 15:33:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('421', ' Crows Nest', '28', '', '2019-03-02 15:33:33', '2019-03-02 15:33:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('420', ' Cronulla', '28', '', '2019-03-02 15:33:13', '2019-03-02 15:33:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('419', 'Cromer', '28', '', '2019-03-02 15:32:53', '2019-03-02 15:32:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('416', ' Connells Point', '28', '', '2019-03-02 15:30:46', '2019-03-02 15:30:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('415', 'Condell Park', '28', '', '2019-03-02 15:30:16', '2019-03-02 15:30:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('414', 'Concord West', '28', '', '2019-03-02 15:29:59', '2019-03-02 15:29:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('413', ' Concord', '28', '', '2019-03-02 15:29:39', '2019-03-02 15:29:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('412', ' Como ', '28', '', '2019-03-02 15:28:31', '2019-03-02 15:28:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('411', 'Collaroy', '28', '', '2019-03-02 15:25:06', '2019-03-02 15:25:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('410', ' Clyde', '28', '', '2019-03-02 15:24:51', '2019-03-02 15:24:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('409', ' Clovelly', '28', '', '2019-03-02 15:24:34', '2019-03-02 15:24:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('408', 'Clontarf', '28', '', '2019-03-02 15:24:19', '2019-03-02 15:24:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('407', 'Clemton Park', '28', '', '2019-03-02 15:23:55', '2019-03-02 15:23:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('406', ' Chullora', '28', '', '2019-03-02 15:23:39', '2019-03-02 15:23:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('405', 'Chiswick', '28', '', '2019-03-02 15:23:24', '2019-03-02 15:23:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('404', ' Chisholm', '28', '', '2019-03-02 15:23:04', '2019-03-02 15:23:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('403', 'Chipping Norton', '28', '', '2019-03-02 15:22:46', '2019-03-02 15:22:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('402', 'Chippendale', '28', '', '2019-03-02 15:22:26', '2019-03-02 15:22:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('401', 'Chifley', '28', '', '2019-03-02 15:22:07', '2019-03-02 15:22:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('400', 'Chester Hill', '28', '', '2019-03-02 15:21:50', '2019-03-02 15:21:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('399', ' Cherrybrook', '28', '', '2019-03-02 15:21:32', '2019-03-02 15:21:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('398', ' Cheltenham', '28', '', '2019-03-02 15:21:06', '2019-03-02 15:21:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('397', ' Chatswood West', '28', '', '2019-03-02 15:20:45', '2019-03-02 15:20:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('396', ' Chatswood', '28', '', '2019-03-02 15:20:17', '2019-03-02 15:20:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('395', 'Centennial Park', '28', '', '2019-03-02 15:19:59', '2019-03-02 15:19:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('394', ' Castlecrag', '28', '', '2019-03-02 15:08:50', '2019-03-02 15:08:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('393', 'Castle Hill ', '28', '', '2019-03-02 15:08:33', '2019-03-02 15:08:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('392', ' Castle Cove', '28', '', '2019-03-02 15:08:02', '2019-03-02 15:08:02', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('391', 'Carss Park', '28', '', '2019-03-02 15:07:44', '2019-03-02 15:07:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('390', ' Carramar', '28', '', '2019-03-02 15:07:24', '2019-03-02 15:07:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('389', 'Carlton', '28', '', '2019-03-02 15:07:01', '2019-03-02 15:07:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('388', 'Carlingford', '28', '', '2019-03-02 15:06:34', '2019-03-02 15:06:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('387', ' Caringbah', '28', '', '2019-03-02 14:51:49', '2019-03-02 14:51:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('384', ' Canley Vale', '28', '', '2019-03-02 14:50:53', '2019-03-02 14:50:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('383', 'Canada Bay', '28', '', '2019-03-02 14:50:35', '2019-03-02 14:50:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('382', ' Campsie', '28', '', '2019-03-02 14:50:17', '2019-03-02 14:50:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('381', 'Camperdown', '28', '', '2019-03-02 14:49:50', '2019-03-02 14:49:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('377', ' Burwood Heights', '28', '', '2019-03-02 14:48:30', '2019-03-02 14:48:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('376', ' Burwood', '28', '', '2019-03-02 14:48:12', '2019-03-02 14:48:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('375', 'Burraneer', '28', '', '2019-03-02 14:47:52', '2019-03-02 14:47:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('374', 'Bundeena', '28', '', '2019-03-02 13:43:52', '2019-03-02 13:43:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('373', 'Brookvale', '28', '', '2019-03-02 13:43:33', '2019-03-02 13:43:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('371', ' Brighton-le-sands', '28', '', '2019-03-02 13:42:18', '2019-03-02 13:42:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('370', 'Breakfast Point', '28', '', '2019-03-02 13:36:13', '2019-03-02 13:36:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('366', ' Bondi Junction', '28', '', '2019-03-02 13:32:06', '2019-03-02 13:32:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('368', ' Bonnet Bay', '28', '', '2019-03-02 13:35:35', '2019-03-02 13:35:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('363', ' Blenheim Road', '28', '', '2019-03-02 13:31:06', '2019-03-02 13:31:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('362', ' Blakehurst', '28', '', '2019-03-02 13:30:26', '2019-03-02 13:30:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('361', ' Birrong', '28', '', '2019-03-02 13:30:06', '2019-03-02 13:30:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('360', ' Birchgrove', '28', '', '2019-03-02 13:29:49', '2019-03-02 13:29:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('359', 'Bexley North', '28', '', '2019-03-02 13:29:25', '2019-03-02 13:29:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('358', ' Bexley', '28', '', '2019-03-02 13:28:24', '2019-03-02 13:28:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('357', 'Beverly Hills', '28', '', '2019-03-02 13:28:07', '2019-03-02 13:28:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('356', 'Beverley Park', '28', '', '2019-03-02 13:27:41', '2019-03-02 13:27:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('355', 'Berala', '28', '', '2019-03-02 13:00:33', '2019-03-02 13:00:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('354', 'Belrose', '28', '', '2019-03-02 13:00:16', '2019-03-02 13:00:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('353', 'Belmore', '28', '', '2019-03-02 12:59:53', '2019-03-02 12:59:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('352', 'Bellevue Hill', '28', '', '2019-03-02 12:59:36', '2019-03-02 12:59:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('351', 'Belfield', '28', '', '2019-03-02 12:59:07', '2019-03-02 12:59:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('350', ' Beecroft', '28', '', '2019-03-02 12:58:52', '2019-03-02 12:58:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('349', ' Beaconsfield', '28', '', '2019-03-02 12:58:36', '2019-03-02 12:58:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('348', ' Beacon Hill', '28', '', '2019-03-02 12:58:18', '2019-03-02 12:58:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('347', 'Bayview', '28', '', '2019-03-02 12:58:01', '2019-03-02 12:58:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('342', ' Bankstown Aerodrome', '28', '', '2019-03-02 12:54:25', '2019-03-02 12:54:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('341', 'Bankstown', '28', '', '2019-03-02 12:53:31', '2019-03-02 12:53:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('340', ' Banksmeadow', '28', '', '2019-03-02 12:53:12', '2019-03-02 12:53:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('339', 'Banksia', '28', '', '2019-03-02 12:52:56', '2019-03-02 12:52:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('335', ' Balgowlah Heights', '28', '', '2019-03-02 12:51:46', '2019-03-02 12:51:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('334', 'Balgowlah', '28', '', '2019-03-02 12:51:30', '2019-03-02 12:51:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('333', 'Auburn', '28', '', '2019-03-02 12:51:09', '2019-03-02 12:51:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('332', 'Asquith', '28', '', '2019-03-02 12:50:52', '2019-03-02 12:50:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('331', 'Ashfield', '28', '', '2019-03-02 12:50:33', '2019-03-02 12:50:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('330', 'Ashbury', '28', '', '2019-03-02 12:50:17', '2019-03-02 12:50:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('329', ' Artarmon', '28', '', '2019-03-02 12:50:01', '2019-03-02 12:50:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('328', ' Arncliffe', '28', '', '2019-03-02 12:49:37', '2019-03-02 12:49:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('327', 'Annandale', '28', '', '2019-03-02 12:49:21', '2019-03-02 12:49:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('324', 'Alfords Point', '28', '', '2019-03-02 12:48:20', '2019-03-02 12:48:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('323', 'Alexandria', '28', '', '2019-03-02 12:48:01', '2019-03-02 12:48:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('322', 'Abbotsford', '28', '', '2019-03-02 12:47:39', '2019-03-02 12:47:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('320', 'Zetland', '28', '', '2019-03-02 12:44:13', '2019-03-02 12:44:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('319', 'Waterloo', '28', '', '2019-03-02 12:43:58', '2019-03-02 12:43:58', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('318', 'Ultimo', '28', '', '2019-03-02 12:43:45', '2019-03-02 12:43:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('317', 'Sydney City', '28', '', '2019-03-02 12:43:31', '2019-03-02 12:43:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('316', 'Strathfield', '28', '', '2019-03-02 12:43:16', '2019-03-02 12:43:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('315', 'Ryde', '28', '', '2019-03-02 12:42:53', '2019-03-02 12:42:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('314', 'Rhodes', '28', '', '2019-03-02 12:42:41', '2019-03-02 12:42:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('313', 'Parramatta', '28', '', '2019-03-02 12:42:29', '2019-03-02 12:42:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('312', 'Marsfield', '28', '', '2019-03-02 12:42:09', '2019-03-02 12:42:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('311', 'Kingsford', '28', '', '2019-03-02 12:41:55', '2019-03-02 12:41:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('310', 'Hurstville', '28', '', '2019-03-02 12:41:38', '2019-03-02 12:41:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('309', 'Haymarket', '28', '', '2019-03-02 12:41:18', '2019-03-02 12:41:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('308', 'Epping', '28', '', '2019-03-02 12:41:03', '2019-03-02 12:41:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('307', 'Eastwood', '28', '', '2019-03-02 12:40:50', '2019-03-02 12:40:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('306', 'Chatswood', '28', '', '2019-03-02 12:40:29', '2019-03-02 12:40:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('305', ' Campsie', '28', '', '2019-03-02 09:00:38', '2019-03-02 12:40:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('304', ' Burwood', '28', '', '2019-03-02 06:11:23', '2019-03-02 12:39:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('302', ' Ashfield', '28', '', '2019-03-02 06:09:50', '2019-03-02 12:39:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('300', '其他', '27', '', '2019-03-01 11:38:31', '2019-03-01 11:38:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('296', 'East Launceston', '287', '', '2019-03-01 11:36:36', '2019-03-01 11:36:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('295', 'Newstead', '287', '', '2019-03-01 11:36:23', '2019-03-01 11:36:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('292', 'CITY', '287', '', '2019-03-01 11:31:59', '2019-03-01 11:31:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('291', 'West Launceston', '287', '', '2019-03-01 11:31:21', '2019-03-01 11:31:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('290', 'Trevallyn', '287', '', '2019-03-01 11:31:03', '2019-03-01 11:31:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('289', 'Invermay', '287', '', '2019-03-01 11:28:54', '2019-03-01 11:28:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('288', 'Newnham', '287', '', '2019-03-01 11:15:08', '2019-03-01 11:15:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('286', '其他', '274', '', '2019-03-01 11:07:42', '2019-03-01 11:07:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('285', 'Glebe', '274', '', '2019-03-01 11:06:25', '2019-03-01 11:06:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('284', 'Bellerive', '274', '', '2019-03-01 11:04:41', '2019-03-01 11:04:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('283', 'Lenah Valley', '274', '', '2019-03-01 11:04:19', '2019-03-01 11:04:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('282', 'Moonah', '274', '', '2019-03-01 11:03:42', '2019-03-01 11:03:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('281', 'New Town', '274', '', '2019-03-01 11:03:28', '2019-03-01 11:03:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('280', 'Glenorchy', '274', '', '2019-03-01 11:03:06', '2019-03-01 11:03:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('279', 'Blackmans Bay', '274', '', '2019-03-01 10:54:01', '2019-03-01 10:54:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('278', 'Kingston', '274', '', '2019-03-01 10:53:49', '2019-03-01 10:53:49', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('277', 'Battery Point', '274', '', '2019-03-01 10:53:25', '2019-03-01 10:53:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('276', 'City', '274', '', '2019-03-01 10:52:59', '2019-03-01 10:52:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('275', 'SandyBay', '274', '', '2019-03-01 08:39:34', '2019-03-01 15:50:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('253', 'Watsonia North', '27', '', '2019-03-01 05:36:08', '2019-03-01 05:36:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('252', 'Watsonia', '27', '', '2019-03-01 05:35:57', '2019-03-01 05:35:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('251', 'Windsor', '27', '', '2019-03-01 05:35:35', '2019-03-01 05:35:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('249', 'West Footscray', '27', '', '2019-03-01 05:35:01', '2019-03-01 05:35:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('248', 'Williamstown North', '27', '', '2019-03-01 05:31:33', '2019-03-01 05:34:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('247', 'Williamstown ', '27', '', '2019-03-01 05:31:23', '2019-03-01 05:34:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('246', 'Viewbank', '27', '', '2019-03-01 05:31:08', '2019-03-01 05:33:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('245', 'Vermont South', '27', '', '2019-03-01 05:30:52', '2019-03-01 05:32:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('244', 'Vermont', '27', '', '2019-03-01 05:30:41', '2019-03-01 05:32:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('243', 'Tullamarine', '27', '', '2019-03-01 05:30:16', '2019-03-01 05:30:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('242', 'Thomastown', '27', '', '2019-03-01 05:30:06', '2019-03-01 05:30:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('241', 'Templestowe Lower', '27', '', '2019-03-01 05:29:55', '2019-03-01 05:29:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('240', 'Templestowe', '27', '', '2019-03-01 05:29:38', '2019-03-01 05:29:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('239', 'Travancore', '27', '', '2019-03-01 05:12:52', '2019-03-01 05:12:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('238', 'Tottenham', '27', '', '2019-03-01 05:12:41', '2019-03-01 05:12:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('237', 'Toorak', '27', '', '2019-03-01 05:12:28', '2019-03-01 05:12:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('236', 'Thornbury', '27', '', '2019-03-01 05:12:14', '2019-03-01 05:12:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('235', 'Surrey Hills', '27', '', '2019-03-01 05:11:46', '2019-03-01 05:11:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('234', 'Sunshine West', '27', '', '2019-03-01 05:11:36', '2019-03-01 05:11:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('233', 'Sunshine North', '27', '', '2019-03-01 05:11:24', '2019-03-01 05:11:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('232', 'Sunshine', '27', '', '2019-03-01 05:11:10', '2019-03-01 05:11:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('231', 'Strathmore Heights', '27', '', '2019-03-01 05:10:56', '2019-03-01 05:10:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('230', 'Strathmore', '27', '', '2019-03-01 05:10:14', '2019-03-01 05:10:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('229', 'St Albans', '27', '', '2019-03-01 05:10:14', '2019-03-01 05:10:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('228', 'Somerton', '27', '', '2019-03-01 05:10:02', '2019-03-01 05:10:02', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('227', 'Seaholme', '27', '', '2019-03-01 05:09:51', '2019-03-01 05:09:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('226', 'Seabrook', '27', '', '2019-03-01 05:09:39', '2019-03-01 05:09:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('225', 'Sandringham', '27', '', '2019-03-01 05:09:29', '2019-03-01 05:09:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('224', 'St Kilda West', '27', '', '2019-03-01 05:09:06', '2019-03-01 05:09:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('223', 'St Kilda East', '27', '', '2019-03-01 05:08:54', '2019-03-01 05:08:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('222', 'St Kilda', '27', '', '2019-03-01 05:08:42', '2019-03-01 05:08:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('221', 'Spotswood', '27', '', '2019-03-01 05:08:33', '2019-03-01 05:08:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('219', 'South Yarra', '27', '是', '2019-03-01 05:08:12', '2019-06-15 14:39:02', '1', '', '5');
INSERT INTO `tk_cate` VALUES ('218', 'South Wharf', '27', '', '2019-03-01 05:08:01', '2019-03-01 05:08:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('216', 'South Kingsville', '27', '', '2019-03-01 05:07:34', '2019-03-01 05:07:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('215', 'Seddon', '27', '', '2019-03-01 05:06:45', '2019-03-01 05:06:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('214', 'Rosanna', '27', '', '2019-03-01 05:06:29', '2019-03-01 05:06:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('213', 'Reservoir', '27', '', '2019-03-01 05:05:13', '2019-03-01 05:05:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('212', 'Ripponlea', '27', '', '2019-03-01 05:04:57', '2019-03-01 05:04:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('211', 'Richmond', '27', '', '2019-03-01 05:04:44', '2019-03-01 05:04:44', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('210', 'Princes Hill', '27', '', '2019-03-01 05:04:05', '2019-03-01 05:04:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('209', 'Preston', '27', '', '2019-03-01 05:03:55', '2019-03-01 05:03:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('206', 'Pascoe Vale South', '27', '', '2019-03-01 05:02:56', '2019-03-01 05:02:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('205', 'Pascoe Vale ', '27', '', '2019-03-01 05:02:48', '2019-03-01 05:02:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('197', 'Notting Hill', '27', '', '2019-03-01 04:56:11', '2019-03-01 04:56:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('194', 'North Melbourne', '27', '', '2019-03-01 04:55:15', '2019-03-01 04:55:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('193', 'Newport', '27', '', '2019-03-01 04:54:53', '2019-03-01 04:54:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('192', 'Murrumbeena', '27', '', '2019-02-28 20:01:34', '2019-02-28 20:01:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('191', 'Mount Waverley', '27', '', '2019-02-28 20:01:20', '2019-02-28 20:01:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('190', 'Moorabbin', '27', '', '2019-02-28 19:55:09', '2019-02-28 19:55:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('189', 'Montmorency', '27', '', '2019-02-28 19:54:48', '2019-02-28 19:54:48', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('188', 'Mont Albert North', '27', '', '2019-02-28 19:54:35', '2019-02-28 19:54:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('187', 'Mont Albert', '27', '', '2019-02-28 19:54:23', '2019-02-28 19:54:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('186', 'Mitcham', '27', '', '2019-02-28 19:54:07', '2019-02-28 19:54:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('185', 'Mill Park', '27', '', '2019-02-28 19:53:54', '2019-02-28 19:53:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('184', 'Mentone', '27', '', '2019-02-28 19:53:41', '2019-02-28 19:53:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('183', 'Moorabbin Airport', '27', '', '2019-02-28 19:51:18', '2019-02-28 19:51:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('182', 'Melbourne Airport', '27', '', '2019-02-28 19:50:35', '2019-02-28 19:50:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('181', 'Meadow Heights', '27', '', '2019-02-28 19:49:26', '2019-02-28 19:49:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('180', 'Mckinnon', '27', '', '2019-02-28 19:49:13', '2019-02-28 19:49:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('179', 'Macleod', '27', '', '2019-02-28 19:49:00', '2019-02-28 19:49:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('178', 'Moonee Ponds', '27', '', '2019-02-28 19:48:41', '2019-02-28 19:48:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('177', 'Middle Park', '27', '', '2019-02-28 19:48:28', '2019-02-28 19:48:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('175', 'Maribyrnong', '27', '', '2019-02-28 19:48:04', '2019-02-28 19:48:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('174', 'Malvern East', '27', '', '2019-02-28 19:47:52', '2019-02-28 19:47:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('173', 'Malvern', '27', '', '2019-02-28 19:47:40', '2019-02-28 19:47:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('172', 'Maidstone', '27', '', '2019-02-28 19:47:11', '2019-02-28 19:47:11', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('171', 'Lower Plenty', '27', '', '2019-02-28 19:46:52', '2019-02-28 19:46:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('170', 'Laverton North', '27', '', '2019-02-28 19:46:37', '2019-02-28 19:46:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('169', 'Laverton', '27', '', '2019-02-28 19:46:22', '2019-02-28 19:46:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('168', 'Lalor', '27', '', '2019-02-28 19:46:08', '2019-02-28 19:46:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('167', 'Kingsbury', '27', '', '2019-02-28 19:45:25', '2019-02-28 19:45:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('166', 'Kings Park', '27', '', '2019-02-28 19:45:14', '2019-02-28 19:45:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('165', 'Keilor Park', '27', '', '2019-02-28 19:45:01', '2019-02-28 19:45:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('164', 'Keilor Lodge', '27', '', '2019-02-28 19:44:50', '2019-02-28 19:44:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('163', 'Keilor East', '27', '', '2019-02-28 19:44:38', '2019-02-28 19:44:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('162', 'Keilor Downs', '27', '', '2019-02-28 19:44:24', '2019-02-28 19:44:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('161', 'Keilor', '27', '', '2019-02-28 19:44:13', '2019-02-28 19:44:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('160', 'Kealba', '27', '', '2019-02-28 19:43:51', '2019-02-28 19:43:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('159', 'Kooyong', '27', '', '2019-02-28 19:43:35', '2019-02-28 19:43:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('158', 'Kingsville', '27', '', '2019-02-28 19:43:09', '2019-02-28 19:43:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('157', 'Kensington', '27', '', '2019-02-28 19:33:51', '2019-02-28 19:40:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('156', 'Kew East', '27', '', '2019-02-28 19:33:29', '2019-02-28 19:42:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('155', 'Kew', '27', '', '2019-02-28 19:33:16', '2019-02-28 19:42:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('154', 'Jacana', '27', '', '2019-02-28 19:33:06', '2019-02-28 19:41:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('153', 'Ivanhoe East', '27', '', '2019-02-28 19:32:52', '2019-02-28 19:38:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('152', 'Ivanhoe', '27', '', '2019-02-28 19:32:38', '2019-02-28 19:38:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('151', 'Huntingdale', '27', '', '2019-02-28 19:32:05', '2019-02-28 19:37:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('150', 'Hughesdale', '27', '', '2019-02-28 19:31:51', '2019-02-28 19:36:39', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('149', 'Highett', '27', '', '2019-02-28 19:13:58', '2019-02-28 19:13:58', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('147', 'Heidelberg Heights', '27', '', '2019-02-28 19:13:30', '2019-02-28 19:13:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('146', 'Heidelberg', '27', '', '2019-02-28 19:13:06', '2019-02-28 19:13:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('145', 'Heatherton', '27', '', '2019-02-28 19:12:53', '2019-02-28 19:12:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('144', 'Hampton East', '27', '', '2019-02-28 19:12:31', '2019-02-28 19:12:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('143', 'Hampton', '27', '', '2019-02-28 19:12:16', '2019-02-28 19:12:16', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('142', 'Hadfield', '27', '', '2019-02-28 19:12:00', '2019-02-28 19:12:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('141', 'Hawthorn East', '27', '', '2019-02-28 19:11:21', '2019-02-28 19:11:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('140', 'Hawthorn(霍桑)', '27', '', '2019-02-28 19:11:06', '2019-03-03 08:00:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('139', 'Greensborough', '27', '', '2019-02-28 19:10:34', '2019-02-28 19:10:34', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('134', 'Gladstone Park', '27', '', '2019-02-28 19:08:02', '2019-02-28 19:09:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('133', 'Glen Iris', '27', '', '2019-02-28 18:19:29', '2019-02-28 18:19:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('132', 'Gardenvale', '27', '', '2019-02-28 18:16:56', '2019-02-28 18:16:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('131', 'Forest Hill', '27', '', '2019-02-28 18:16:32', '2019-02-28 18:16:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('130', 'Fawkner', '27', '', '2019-02-28 18:16:20', '2019-02-28 18:16:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('129', 'Footscray', '27', '', '2019-02-28 18:15:55', '2019-02-28 18:15:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('128', 'Flemington', '27', '', '2019-02-28 18:15:43', '2019-02-28 18:15:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('127', 'Fitzroy North', '27', '', '2019-02-28 18:15:29', '2019-02-28 18:15:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('126', 'Fitzroy', '27', '', '2019-02-28 18:15:17', '2019-02-28 18:15:17', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('125', 'Fairfield', '27', '', '2019-02-28 18:15:03', '2019-02-28 18:15:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('124', 'Essendon North', '27', '', '2019-02-28 18:13:55', '2019-02-28 18:13:55', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('123', 'Epping', '27', '', '2019-02-28 18:13:38', '2019-02-28 18:13:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('122', 'Eltham', '27', '', '2019-02-28 18:13:26', '2019-02-28 18:13:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('121', 'Eaglemont', '27', '', '2019-02-28 18:12:16', '2019-02-28 18:12:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('120', 'Essendon West', '27', '', '2019-02-28 18:11:57', '2019-02-28 18:11:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('119', 'Essendon', '27', '', '2019-02-28 18:11:29', '2019-02-28 18:11:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('116', 'East Melbourne', '27', '', '2019-02-28 18:00:50', '2019-02-28 18:00:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('114', 'Doncaster East', '27', '', '2019-02-28 17:59:57', '2019-02-28 17:59:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('113', 'Doncaster', '27', '', '2019-02-28 17:59:42', '2019-02-28 17:59:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('112', 'Derrimut', '27', '', '2019-02-28 17:59:28', '2019-02-28 17:59:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('111', 'Deer Park', '27', '', '2019-02-28 17:59:10', '2019-02-28 17:59:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('110', 'Dallas', '27', '', '2019-02-28 17:58:52', '2019-02-28 17:58:52', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('108', 'Deepdene', '27', '', '2019-02-28 17:58:12', '2019-02-28 17:58:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('107', 'Coolaroo', '27', '', '2019-02-28 05:53:29', '2019-02-28 05:53:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('106', 'Coburg North', '27', '', '2019-02-28 05:53:18', '2019-02-28 05:53:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('105', 'Clayton South', '27', '', '2019-02-28 05:53:04', '2019-02-28 05:53:04', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('103', 'Clarinda', '27', '', '2019-02-28 05:52:28', '2019-02-28 05:52:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('102', 'Cheltenham', '27', '', '2019-02-28 05:52:14', '2019-02-28 05:52:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('101', 'Chadstone', '27', '', '2019-02-28 05:51:56', '2019-02-28 05:51:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('99', 'Campbellfield', '27', '', '2019-02-28 05:51:31', '2019-02-28 05:51:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('98', 'Cairnlea', '27', '', '2019-02-28 05:51:22', '2019-02-28 05:51:22', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('97', 'Cremorne', '27', '', '2019-02-28 05:51:01', '2019-02-28 05:51:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('96', 'Collingwood', '27', '', '2019-02-28 05:50:46', '2019-02-28 05:50:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('95', 'Coburg', '27', '', '2019-02-28 05:50:30', '2019-02-28 05:50:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('94', 'Clifton Hill', '27', '', '2019-02-28 05:49:43', '2019-02-28 05:49:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('87', 'Canterbury', '27', '', '2019-02-28 05:47:06', '2019-02-28 05:47:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('86', 'Camberwell', '27', '', '2019-02-28 05:46:50', '2019-02-28 05:46:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('85', 'Burwood East', '27', '', '2019-02-28 05:45:33', '2019-02-28 05:46:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('83', 'Burnside', '27', '', '2019-02-28 05:45:19', '2019-02-28 05:45:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('82', 'Bundoora', '27', '', '2019-02-28 05:45:03', '2019-02-28 05:45:03', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('81', 'Bulleen', '27', '', '2019-02-28 05:44:50', '2019-02-28 05:44:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('80', 'Brooklyn', '27', '', '2019-02-28 05:44:27', '2019-02-28 05:44:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('79', 'Broadmeadows', '27', '', '2019-02-28 05:43:36', '2019-02-28 05:43:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('78', 'Brighton East', '27', '', '2019-02-28 05:43:23', '2019-02-28 05:43:23', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('77', 'Brighton', '27', '', '2019-02-28 05:43:06', '2019-02-28 05:43:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('76', 'Briar Hill', '27', '', '2019-02-28 05:42:51', '2019-02-28 05:42:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('75', 'Braybrook', '27', '', '2019-02-28 05:42:35', '2019-02-28 05:42:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('73', 'Box Hill North', '27', '', '2019-02-28 05:42:07', '2019-02-28 05:42:07', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('70', 'Blackburn North', '27', '', '2019-02-28 05:41:21', '2019-02-28 05:41:21', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('67', 'Bentleigh East', '27', '', '2019-02-28 05:38:31', '2019-02-28 05:38:31', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('66', 'Bentleigh', '27', '', '2019-02-28 05:38:14', '2019-02-28 05:38:14', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('65', 'Beaumaris', '27', '', '2019-02-28 05:37:57', '2019-02-28 05:37:57', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('63', 'Brunswick West', '27', '', '2019-02-28 05:36:50', '2019-02-28 05:36:50', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('62', 'Brunswick East', '27', '', '2019-02-28 05:36:30', '2019-02-28 05:36:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('61', 'Brunswick', '27', '', '2019-02-28 05:34:10', '2019-02-28 05:34:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('60', 'Bellfield', '27', '', '2019-02-28 05:33:51', '2019-02-28 05:33:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('59', 'Balwyn North', '27', '', '2019-02-28 05:31:37', '2019-02-28 05:31:37', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('58', 'Balwyn', '27', '', '2019-02-28 05:31:19', '2019-02-28 05:31:19', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('57', 'Balaclava', '27', '', '2019-02-28 05:28:00', '2019-02-28 05:28:00', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('56', 'Avondale Heights', '27', '', '2019-02-28 05:27:09', '2019-02-28 05:27:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('55', 'Attwood', '27', '', '2019-02-28 05:26:56', '2019-02-28 05:26:56', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('54', 'Ashwood', '27', '', '2019-02-28 05:26:41', '2019-02-28 05:26:41', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('53', 'Ashburton', '27', '', '2019-02-28 05:26:27', '2019-02-28 05:26:27', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('50', 'Altona Meadows', '27', '', '2019-02-28 05:25:33', '2019-02-28 05:25:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('49', 'Altona', '27', '', '2019-02-28 05:25:12', '2019-02-28 05:25:12', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('48', 'Albion', '27', '', '2019-02-28 05:24:51', '2019-02-28 05:24:51', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('47', 'Albanvale', '27', '', '2019-02-28 05:24:28', '2019-02-28 05:24:28', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('46', 'Airport West', '27', '', '2019-02-28 05:24:06', '2019-02-28 05:24:06', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('43', 'Alphington', '27', '', '2019-02-28 05:20:33', '2019-02-28 05:20:33', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('42', 'Albert Park', '27', '', '2019-02-28 05:20:05', '2019-02-28 05:20:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('44', 'Armadale', '27', '', '2019-02-28 05:22:54', '2019-02-28 05:22:54', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('45', 'Ascot Vale', '27', '', '2019-02-28 05:23:43', '2019-02-28 05:23:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('41', 'Aberfeldie', '27', '', '2019-02-28 05:12:25', '2019-05-17 13:56:02', '1', '', '0');
INSERT INTO `tk_cate` VALUES ('25', '南墨尔本', '19', '', '2019-01-04 14:47:10', '2019-01-04 14:47:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('24', '北墨尔本', '19', '', '2019-01-04 14:47:01', '2019-01-04 14:47:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('22', '南悉尼', '18', '', '2019-01-04 14:46:42', '2019-01-04 14:46:42', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('21', '北悉尼', '18', '', '2019-01-04 14:46:29', '2019-01-04 14:46:29', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('17', '朗萨斯顿', '8', '', '2019-01-03 16:04:32', '2019-01-03 16:04:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('16', '荷巴特', '8', '', '2019-01-03 16:04:18', '2019-01-03 16:04:18', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('13', '欧缇莫', '6', '', '2019-01-03 16:02:30', '2019-01-03 16:02:30', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('12', '北悉尼', '6', '', '2019-01-03 16:02:05', '2019-01-03 16:02:05', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('11', '南墨尔本', '5', '', '2019-01-03 16:01:10', '2019-01-03 16:01:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('712', ' Wolli Creek ', '28', '', '2019-03-11 14:26:35', '2019-03-11 14:26:35', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('713', ' Wollstonecraft ', '28', '', '2019-03-11 14:27:01', '2019-03-11 14:27:01', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('714', ' Woodpark', '28', '', '2019-03-11 14:27:38', '2019-03-11 14:27:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('715', 'Woollahra', '28', '', '2019-03-11 14:27:53', '2019-03-11 14:27:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('716', ' Woolloomooloo ', '28', '', '2019-03-11 14:28:32', '2019-03-11 14:28:32', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('717', 'Woolooware ', '28', '', '2019-03-11 14:28:43', '2019-03-11 14:28:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('718', ' Woolwich', '28', '', '2019-03-11 14:28:59', '2019-03-11 14:28:59', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('719', 'Woronora', '28', '', '2019-03-11 14:29:13', '2019-03-11 14:29:13', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('720', ' Woronora Heights', '28', '', '2019-03-11 14:29:25', '2019-03-11 14:29:25', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('721', ' Yagoona', '28', '', '2019-03-11 14:29:38', '2019-03-11 14:29:38', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('722', 'Yennora', '28', '', '2019-03-11 14:29:53', '2019-03-11 14:29:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('723', ' Yowie Bay', '28', '', '2019-03-11 14:30:08', '2019-03-11 14:30:08', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('724', ' Zetland', '28', '', '2019-03-11 14:30:26', '2019-03-11 14:30:26', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('742', '其他', '28', '', '2019-03-11 14:57:46', '2019-03-11 14:57:46', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('744', 'Point Cook', '27', '', '2019-04-07 21:41:20', '2019-04-07 21:41:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('745', 'Ringwood East', '27', '', '2019-04-19 09:23:36', '2019-04-19 09:23:36', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('746', 'Keysborough', '27', '', '2019-04-19 09:24:09', '2019-04-19 09:24:09', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('747', 'Point Cook', '27', '', '2019-04-19 09:24:45', '2019-04-19 09:24:45', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('748', 'Werribee', '27', '', '2019-04-19 09:26:15', '2019-04-19 09:26:15', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('750', 'Noble Park', '27', '', '2019-04-19 09:32:10', '2019-04-19 09:32:10', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('751', 'Coburg North', '27', '', '2019-04-20 21:12:40', '2019-04-20 21:12:40', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('752', 'Wyndham Vale', '27', '', '2019-04-20 21:15:20', '2019-04-20 21:15:20', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('753', 'Mordialloc', '27', '', '2019-04-20 21:15:43', '2019-04-20 21:15:43', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('754', 'Armadale', '27', '', '2019-04-20 21:18:24', '2019-04-20 21:18:24', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('755', 'Bayswater', '27', '', '2019-04-20 21:23:53', '2019-04-20 21:23:53', '1', '', '100');
INSERT INTO `tk_cate` VALUES ('759', 'St. Lucia', '287', '', '2019-09-18 12:14:52', '2019-09-18 12:14:52', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('760', '布里斯班', '0', '', '2019-09-18 12:16:24', '2019-09-18 12:16:24', '0', '007', null);
INSERT INTO `tk_cate` VALUES ('761', '昆士兰大学St. Lucia', '760', '', '2019-09-18 12:16:36', '2019-09-18 12:18:34', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('762', '昆士兰大学Herson', '760', '', '2019-09-18 12:20:12', '2019-09-18 12:20:12', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('763', '昆士兰科技大学Gardens Point ', '760', '', '2019-09-18 12:28:03', '2019-09-18 12:28:18', '2', '', '0');
INSERT INTO `tk_cate` VALUES ('764', '昆士兰科技大学Kelvin Grove', '760', '', '2019-09-18 12:29:26', '2019-09-18 12:29:26', '2', '', '0');

-- ----------------------------
-- Table structure for `tk_houses`
-- ----------------------------
DROP TABLE IF EXISTS `tk_houses`;
CREATE TABLE `tk_houses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `dsn` varchar(256) NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '房源标题',
  `address` varchar(255) DEFAULT NULL COMMENT '房源详细地址',
  `price` int(10) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL COMMENT '来源',
  `type` varchar(20) DEFAULT NULL COMMENT '出租方式',
  `sex` varchar(20) DEFAULT NULL,
  `pet` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '宠物',
  `smoke` varchar(255) DEFAULT NULL,
  `bill` varchar(255) DEFAULT NULL COMMENT '包含bill, 不包含Bill',
  `deposit` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '押金',
  `live_date` date DEFAULT NULL COMMENT '可入住时间',
  `lease_term` varchar(20) DEFAULT NULL COMMENT '租期：少于3个月，3-6个月，6-12个月 租期可议',
  `house_type` varchar(20) DEFAULT NULL COMMENT '房屋类型：公寓、别墅、不限',
  `furniture` varchar(20) DEFAULT NULL COMMENT '家具',
  `house_room` varchar(20) DEFAULT NULL COMMENT '户型：一室，两室，三室，三室以上',
  `car` varchar(25) DEFAULT NULL COMMENT '车位：1个；2个；3个；3个以上',
  `toilet` varchar(20) DEFAULT NULL COMMENT '卫生间：1个；2个；3个；3个以上；',
  `home` varchar(255) DEFAULT NULL COMMENT '设施：游泳池、健身房；车位',
  `sation` varchar(255) DEFAULT NULL COMMENT '交通：火车站；电车站；免费电车',
  `province` varchar(100) DEFAULT NULL COMMENT '省',
  `city` varchar(100) DEFAULT NULL COMMENT '市',
  `area` varchar(100) DEFAULT NULL COMMENT '区',
  `street` varchar(255) DEFAULT NULL COMMENT '街道',
  `school` varchar(255) DEFAULT NULL COMMENT '校区',
  `real_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `wchat` varchar(255) DEFAULT NULL COMMENT '微信号',
  `tel` varchar(11) DEFAULT NULL,
  `thumnail` varchar(255) DEFAULT NULL COMMENT '封面图',
  `images` text COMMENT '详情图',
  `content` text COMMENT '描述房源',
  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '0：未发布，1：已发布；2：下线',
  `view` int(11) DEFAULT '0' COMMENT '查看次数',
  `publish_date` datetime DEFAULT NULL COMMENT '发布时间',
  `collection` int(11) NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `free_in` varchar(30) NOT NULL DEFAULT '否',
  `free_view` varchar(30) NOT NULL DEFAULT '否',
  `check` varchar(30) NOT NULL DEFAULT '否',
  `tj` varchar(30) NOT NULL DEFAULT '否',
  `x` varchar(255) NOT NULL,
  `y` varchar(255) NOT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `area_img` varchar(255) NOT NULL COMMENT '静态地图',
  `top` varchar(30) NOT NULL COMMENT '置顶',
  `top_datetime` datetime NOT NULL COMMENT '置顶设置时间',
  `usertop` varchar(30) NOT NULL,
  `usertop_datetime` datetime NOT NULL,
  `http` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `validity` int(11) NOT NULL DEFAULT '0',
  `studentapartment` varchar(255) NOT NULL,
  `publishtype` varchar(45) NOT NULL,
  `video` text COMMENT '房源视频',
  `tags` text COMMENT '房源标签',
  `uemail` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `checks` tinyint(1) DEFAULT '2' COMMENT '是否为验证房源：是1；否2',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tk_houses
-- ----------------------------
INSERT INTO `tk_houses` VALUES ('230', '0', 'A000000001', '1分钟到墨大10分钟到city单间出租', '11, Acacia Ridge, QLD,Australia', '563', '个人', '单间', '限男性', '不接受', null, '包水,包电,包煤气,包网', '0', '2020-01-31', '3-6个月', '别墅', '不包家具', '两室', '1个', '2个', '游泳池,健身房,车位', '巴士站,火车站,电车站,免费电车', null, '墨尔本', 'Melbourne CBD', null, '莫纳什大学 (Parkville)', '夜微凉', 'mengm', '17691074991', null, 'uploads/text/20200122/f533be775815f8635088434d2ca25973.jpg,uploads/text/20200122/bbec081f59c2ea63166568ae21a9a69b.jpg,uploads/text/20200122/c3de6b0a944b5ab4b5677044435a7bb3.jpg', '墨大对面、（彩云南边上）跟墨大一条马路之隔，上学可以8点的课7点55分起床，便捷享用墨尔本大学一切资源。\r\n\r\n出租两室一厅一厨一卫中的侧卧。室友是对墨大学生。房子客厅面积很大，为保证生活质量，客厅不另外出租，可以随意在客厅置放家具和行李。房子厨房也很大，做菜很方便。房子带大阳台，方便晒衣服。家里有冰箱、洗衣机、微波炉、烤箱、打印机、衣柜、床、书桌、电扇、台灯等常用家具电器。激光打印机随便用，不用再去打印店浪费钱。房子应有尽有，欢迎随时联系看房。房间位于公寓楼4楼，公寓配有门禁安全系统，非常安全。公寓配有电梯，不用爬楼梯。房间内无窗但离阳台门很近，采光透气不成问题。\r\n\r\n谷歌地图668 Swanston Street，楼底就有电车站2站直达墨尔本centre。楼下方圆100米内有不同口味中餐厅至少10家和KFC、subway、domino等快餐，紧邻意大利lygon street有各种西餐美食，楼底还有711超市和亚超，woolworth大型超市步行8分钟可达，生活非常方便。300刀/周 share bill 包煤气。租期至少半年，2020年1月即刻拎包入住。\r\n\r\n联系人：Crystal\r\n电话：0422712614\r\n微信：chenruiyi843650', '0', '0', '2020-01-22 14:19:38', '0', '否', '否', '否', '否', '', '', '2020-01-22 14:19:38', '2020-01-22 14:19:38', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 'https://www.realestate.com.au/property-unit-vic-bentleigh-426660646', '1549089944@qq.com', '0', 'SHA', '', 'uploads/text/20200122/255897487cf643d2165889509597d275.mp4', null, null, '2');
INSERT INTO `tk_houses` VALUES ('231', '0', 'A000000231', '墨尔本ct Vicone 近rmit 墨大', '462 Elizabeth St, Melbourne, VIC,Australia', '650', '个人', '单间', '限男性', '不接受', null, '包电,包煤气,包网', '0', '2020-01-31', '3-6个月', '别墅', '不包家具', '两室', '1个', '2个', '游泳池,健身房,车位', '巴士站,火车站,电车站,免费电车', null, '墨尔本', 'Melbourne CBD', null, '莫纳什大学 (Caulfield)', '轻烟微雨', 'qweqw', '17691074991', null, 'uploads/text/20200122/3b2d63ff23fe8777309c946cb84b1367.jpg,uploads/text/20200122/dc84a3383df193e6d3ffb6fdc22ff1d7.jpg,uploads/text/20200122/8f778290d14cc453ceb5f1160558e02a.jpg', '墨尔本ct  \r\nVictoria One  整租 2月14可入住（也', '0', '0', '2020-01-22 14:24:07', '0', '否', '否', '否', '否', '', '', '2020-01-22 14:24:07', '2020-01-22 14:24:07', '', '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 'https://wx.xiaobaozufang.com/', '11@qq.com', '0', 'iglu', '', 'uploads/text/20200122/cdc416a8b02b95db5c8c7a0afbce8b8d.mp4', null, null, '2');

-- ----------------------------
-- Table structure for `tk_roommates`
-- ----------------------------
DROP TABLE IF EXISTS `tk_roommates`;
CREATE TABLE `tk_roommates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `dsn` varchar(256) NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '房源标题',
  `price` int(10) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `pet` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '宠物',
  `smoke` varchar(255) DEFAULT NULL,
  `live_date` date DEFAULT NULL COMMENT '可入住时间',
  `lease_term` varchar(20) DEFAULT NULL COMMENT '租期：少于3个月，3-6个月，6-12个月 租期可议',
  `habit` varchar(255) DEFAULT NULL COMMENT '生活习惯：夜猫子，安静，会做饭，爱运动，不开派对',
  `city` varchar(100) DEFAULT NULL COMMENT '市',
  `area` varchar(100) DEFAULT NULL COMMENT '区',
  `school` varchar(255) DEFAULT NULL COMMENT '校区',
  `real_name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `wchat` varchar(255) DEFAULT NULL COMMENT '微信号',
  `tel` varchar(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `thumnail` varchar(255) DEFAULT NULL COMMENT '封面图',
  `images` text COMMENT '详情图',
  `content` text COMMENT '描述房源',
  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '0：未发布，1：已发布；2：下线',
  `view` int(11) DEFAULT '0' COMMENT '查看次数',
  `publish_date` datetime DEFAULT NULL COMMENT '发布时间',
  `collection` int(11) NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `collection_status` int(11) DEFAULT '1',
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `area_img` varchar(255) NOT NULL COMMENT '静态地图',
  `top` varchar(30) NOT NULL COMMENT '置顶',
  `summary` text,
  `age` varchar(45) DEFAULT NULL,
  `sexr` varchar(20) DEFAULT NULL,
  `collectedhouses` varchar(45) DEFAULT NULL,
  `if_house` varchar(45) DEFAULT NULL,
  `usertop` varchar(30) NOT NULL COMMENT '自己的年龄',
  `usertop_datetime` datetime NOT NULL,
  `ager` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tk_roommates
-- ----------------------------
INSERT INTO `tk_roommates` VALUES ('103', '241', 'B000000001', '小宝租房找室友功能上线啦', '666', '男性', '接受', '接受', '2019-07-03', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', '小宝租房', 'HXXBService1', '', '', '', null, '小宝租房为你提供一系列的租房服务，不但能帮你闪电拿下中介房源、学生公寓，还有开通水电气网、配置家具、房屋清洁等服务等你来用。', '1', '45', null, '2', '1', '2019-07-03 15:34:44', '2019-07-03 15:34:44', '', '', '小宝租房找室友功能上线啦，来这里找志同道合的小伙伴一起租房吧！', '18-24岁', null, '2562,1532,2340', '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('104', '3127', 'B000000002', '找舍友', '340', '女性', '不接受', '不接受', '2019-08-01', '少于3个月', '安静,会做饭', '墨尔本', null, 'RMIT University (市中心)	', 'iii', '15852399024', '15852399024', '', '', null, 'rmit学生，好相处，房子尽量靠近rmit语言班，可短租更好', '2', '93', null, '0', '1', '2019-07-03 15:55:46', '2019-07-03 15:55:46', '', '', '不要带人回家，可以一起做饭', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('105', '2517', 'B000000003', '莫那什找女生室友', '550', '女性', '接受', '不接受', '2019-07-17', '6-12个月', '安静,会做饭,吃货一枚,逗比,爱美剧,爱运动', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Nicole', 'njz1231', '', '', '', null, '佛系中年少女，不轰趴，爱吃爱运动。有炒鸡可以猫咪一只，不介意来一起take房子哦！', '1', '46', '2019-07-03 16:17:40', '0', '1', '2019-07-03 16:11:43', '2019-07-03 16:11:43', '', '', '安静，不带外人来家里，喜欢小动物，生活习惯健康', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('106', '26', 'B000000004', 'Caulfield找室友', '300', '男性', '接受', '不接受', '2019-07-10', '少于3个月', '安静,会做饭,不开派对,爱运动,钢铁直男', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Snow', 'Snowaria', '184', '', '/uploads/houses/2019070316134615621416267009.jpg', null, '莫纳什国际金融，找室友，一起take两居室整租', '1', '36', null, '0', '1', '2019-07-03 16:13:48', '2019-07-03 16:13:48', '', '', '爱干净，会做饭，平时作息正常的男生', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('107', '21', 'B000000005', 'Albert park公园附近找室友', '280', '男性', '不接受', '不接受', '2019-08-03', '租期可议', '爱运动,安静,会做饭,不开派对', '墨尔本', null, '其他', 'ruixuan', 'hdjd', '0452255366', '', '', null, '刚从墨大毕业的学生，正在办理移民', '0', '14', null, '0', '1', '2019-07-03 16:42:40', '2019-07-03 16:42:40', '', '', '安静讲卫生', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('108', '21', 'B000000006', '发广告', '555', '男性', '接受', '接受', '2019-08-03', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', 'ruixuan', 'hdjd', '', '', '', null, '吃吃吃', '0', '2', null, '0', '1', '2019-07-03 16:46:50', '2019-07-03 16:46:50', '', '', '对对对', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('109', '4660', 'B000000007', '西悉尼大学', '200', '女性', '接受', '不接受', '2019-09-10', '租期可议', '吃货一枚,逗比', '悉尼', null, '西悉尼大学(Bankstown)', '鲁凤英', '18811301755', '18811301755', '191728064@qq.com', '/uploads/houses/2019070317115615621451169347.jpg', null, '求合适的房子和小伙伴！\n\n入住时间：2019.9.10\n租期：最短三个月，合适可以一直续租三年\n地点：西悉尼大学Bankstown 校区附近\n价格：越便宜越好\n', '1', '25', null, '0', '1', '2019-07-03 17:11:57', '2019-07-03 17:11:57', '', '', '只要不是奇葩难搞的我都接受', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('110', '4651', 'B000000008', '找室友', '350', '女性', '接受', '不接受', '2019-07-23', '3-6个月', '', '悉尼', null, '悉尼大学(主校区）', 'Katniss', 'yuetming1108', null, '', '', null, '女生 ', '1', '42', null, '0', '1', '2019-07-03 19:22:27', '2019-07-03 19:22:27', '', '', '女生 愛清潔 ', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('111', '3859', 'B000000009', 'Carnegie主卧带独立卫浴/衣帽间/车位', '380', '女性', '不接受', '接受', '2019-07-13', '租期可议', '会做饭,吃货一枚', '墨尔本', null, '莫纳什大学 (Caulfield)', 'ma', 'happemr', null, '', '', null, 'monash Clayton校区 找女生室友 爱干净 不带人过夜回家', '1', '45', null, '0', '1', '2019-07-03 22:48:39', '2019-07-03 22:48:39', '', '', '爱干净 吃货 可以一起做饭或吃饭', '18-24岁', null, '2633', '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('112', '4684', 'B000000010', 'Clayton 六分五十秒站上bus loop超近', '190', '女性', '不接受', '不接受', '2019-07-10', '6-12个月', '', '墨尔本', null, '莫纳什大学 (Clayton）', '圈儿/Tanya', 'tyy_1101', '0452146307', '3243879385@qq.com', '/uploads/houses/2019070408170115621994211235.jpg', null, '四到七分钟进学校&站上bus loop（无水分，可提供视频），近monash Clayton校区好房招租\n\n家在黄金五条街第二条街，学校security bus巡逻范围内，因为租客全是妹子，房东阿姨十分良心地给所有临街窗户加了一层安全网，安全有保障！！\n门口就是各种bus station方便去港超、Clayton station和chadston。有中央暖气和中央冷气\n\n每月有人来打扫公共区域卫生（厨房、院子、客厅、厕所），有洗衣机和烘干机，锅碗瓢盆齐全，随时看房，支持各种照片、视频、亲自看&小伙伴代看，拎包入住，7.23正式起租，如果提前到也完全ok，有两间房已空可以随时入住\n直接和房东签合同，没有二房东那堆乱七八糟的破事！！\n有意的妹子可以随时戳我呀，v//x：tyy_1101', '1', '71', null, '1', '1', '2019-07-04 08:17:02', '2019-07-04 08:17:02', '', '', '求三个妹子室友，希望能注意公共区域卫生，不抽烟，不酗酒，不养宠物（宠物搞坏家具要赔偿，怕引起纠纷等等），因为租客都是妹子，所以希望带异性来家里玩能和其他小伙伴说一声（特别是夏天）', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('113', '2399', 'B000000011', '近墨大', '350', '女性', '接受', '不接受', '2019-07-15', '租期可议', '安静', '墨尔本', null, '墨尔本大学 (Parkville)', 'Edith', '18859277919', null, '', '', null, '安静，好相处', '2', '27', null, '0', '1', '2019-07-04 09:42:28', '2019-07-04 09:42:28', '', '', '安静，好相处', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('114', '2214', 'B000000012', 'docklands 找室友', '350', '中性', '不接受', '接受', '2019-07-29', '3-6个月', '会做饭,学渣', '墨尔本', null, 'RMIT University (市中心)	', 'Hugh', 'zxf941223038', '0475468753', '', '/uploads/houses/2019070511422615622981467199.jpg', null, '本人RMIT在读研究生，在Docklands  take了整套房子，两室一厅，带全部家具。由于本人现在假期回国，在墨尔本的小伙伴可以联系我的微信。', '1', '42', null, '1', '1', '2019-07-05 11:42:26', '2019-07-05 11:42:26', '', '', '因为本人为学生党，所以希望室友也是学生，爱干净，不养宠物。注：couple勿扰（本人容易酸）谢谢', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('115', '1953', 'B000000013', '招室友', '340', '女性', '不接受', '接受', '2019-07-20', '6-12个月', '会做饭,吃货一枚,小可爱', '墨尔本', null, 'RMIT University (市中心)	', '1淩', '13584809233', '', '', '', null, '本人rmit学生 艺管专业\n不吵闹，会做饭～\n已有看中的房源，近rmit 2室2卫or1卫\n等你一起take', '1', '51', null, '0', '1', '2019-07-05 14:12:44', '2019-07-05 14:12:44', '', '', '女生  一定要爱干净！ 不随便带人回家！\n可以长租更好！\nrmit学生更好～\n\n', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('116', '190', 'B000000014', 'test3', '111', '男性', '接受', '接受', '2019-07-05', '少于3个月', '摇滚', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '/uploads/houses/2019070514572915623098490587.png', null, '123', '2', '4', '2019-07-05 14:59:34', '0', '1', '2019-07-05 14:57:29', '2019-07-05 14:57:29', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('118', '3121', 'B000000016', '12', '22', '男性', '接受', '接受', '2019-07-06', '少于3个月', '小可爱', '墨尔本', null, 'Victoria University (市中心),Victoria University (Footscray),Victoria University (Sunshine),Deakin University (Burwood),LaTrobe University(市中心)', '2', '2', '2', '2@q.com', '/uploads/houses/2019070613105215623898524754.jpg', null, '1', '0', '17', null, '0', '1', '2019-07-06 13:05:20', '2019-07-06 13:10:52', '', '', '1', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('119', '21', 'B000000017', '哈哈哈', '555', '男性', '接受', '接受', '2019-07-06', '少于3个月', '学霸', '墨尔本', null, '墨尔本大学 (Parkville)', 'ruixuan', 'hdjd', '', '', '', null, '哈哈哈', '0', '4', null, '0', '1', '2019-07-06 18:23:17', '2019-07-06 18:23:17', '', '', '哈哈哈', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('120', '4184', 'B000000018', '莫纳什旁边两室一卫招租', '280', '女性', '接受', '不接受', '2019-07-07', '6-12个月', '会做饭,夜猫子,安静,爱运动,不开派对,吃货一枚,IT民工', '墨尔本', null, '莫纳什大学 (Caulfield)', 'dorcas', '442981857', '0420749544', '442981857@qq.com', '/uploads/houses/2019070621005115624180515264.jpg', null, '【招租】走路到Monash caufield校区8分钟的15 bond st两室一卫apartment次卧（无窗但是有自然光）招租啦 半年起租 只招女生，接受couple 280pw 室友是一对友善couple 家具全包拎包入住\n\ncaulfield地区环境最好，健身房游泳馆桑拿房电影院酒柜自备的apartment，匀速步行到火车站实测6分钟。乘公交车到chadstone 15分钟，乘火车到melbourne central 25分钟。生活体验极佳，性价比高。', '1', '59', '2019-07-07 18:35:26', '1', '1', '2019-07-06 21:00:51', '2019-07-06 21:00:51', '', '', '互相尊重，爱干净，平易近人好相处。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('121', '190', 'B000000019', '123', '123', '男性', '接受', '接受', '2019-07-07', '少于3个月', '吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '', null, '123', '0', '4', null, '0', '1', '2019-07-07 13:00:53', '2019-07-07 13:00:53', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('122', '190', 'B000000020', '123', '123', '男性', '接受', '接受', '2019-07-07', '少于3个月', '不开派对', '墨尔本', null, '墨尔本大学 (Southbank)', '123', '123', '123', '', '', null, '123', '0', '4', null, '0', '1', '2019-07-07 13:02:14', '2019-07-07 13:02:14', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('123', '190', 'B000000021', '12344', '12344', '男性', '接受', '接受', '2019-07-07', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '', null, '123', '0', '4', null, '0', '1', '2019-07-07 13:04:53', '2019-07-07 13:04:53', '', '', '1444', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('124', '190', 'B000000022', '12344', '12344', '男性', '接受', '接受', '2019-07-07', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville),墨尔本大学 (Southbank)', '123123', '1234555', '111', '', '', null, '123', '0', '3', null, '0', '1', '2019-07-07 13:06:48', '2019-07-07 13:06:48', '', '', '1444', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('125', '190', 'B000000023', '12344', '12344', '男性', '接受', '接受', '2019-07-07', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '', null, '123', '0', '3', null, '0', '1', '2019-07-07 13:07:47', '2019-07-07 13:07:47', '', '', '1444', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('126', '190', 'B000000024', '123123', '1231', '男性', '接受', '接受', '2019-07-07', '少于3个月', '懒癌患者,长腿欧巴', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '/uploads/houses/2019070713235615624770364997.png', null, '123', '2', '6', null, '0', '1', '2019-07-07 13:08:56', '2019-07-07 13:23:56', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('127', '190', 'B000000025', 'test1', '111', '男性', '接受', '接受', '2019-07-07', '少于3个月', '吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', '123123', '1234555', '111', '', '', null, '123', '0', '3', null, '0', '1', '2019-07-07 13:24:21', '2019-07-07 13:24:21', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('128', '190', 'B000000026', '123', '123', '男性', '接受', '接受', '2019-07-07', '少于3个月', '不开派对', '墨尔本', null, '墨尔本大学 (Southbank)', '123123', '1234555', '111', '', '', null, '123', '2', '5', '2019-07-07 13:27:42', '0', '1', '2019-07-07 13:26:47', '2019-07-07 13:27:48', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('129', '190', 'B000000027', '123', '123', '男性', '接受', '接受', '2019-07-07', '少于3个月', '中二', '墨尔本', null, '墨尔本大学 (Parkville),墨尔本大学 (Southbank)', '123123', '1234555', '111', '', '', null, '123', '2', '3', '2019-07-07 13:41:20', '0', '1', '2019-07-07 13:41:04', '2019-07-07 13:41:04', '', '', '123', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('130', '4823', 'B000000028', 'RMIT/墨大/找室友', '300', '女性', '不接受', '不接受', '2020-02-23', '租期可议', '中二,文艺范,不开派对', '墨尔本', null, 'RMIT University (市中心)	', '砒霜', '705048301', '', '', '/uploads/houses/2019111515170215738022228112.jpg', null, '1.\n是明年RMIT本科学生\n爱干净+好相处，爱好很广泛。可活跃可安静。\n\n\n2.\n位置要在CBD附近，租金接受每人300以内的，有长租打算最好。\n\n起租期最好和我相差半个月内，偏好有独卫，相对不在意公寓的新旧程度，安全第一。有看上的房子，细节可以一起商量。可以一起take房子买家具or直接找全家具，都不介意。\n\n', '2', '64', null, '2', '1', '2019-07-07 21:30:42', '2019-11-15 15:17:03', '', '', '最好是女性。要求性格不坏，讲卫生，无不良生活作息(如随意带人回家/夜间party)。抽烟和养宠物如果几乎完全(重点）可以不影响他人也可接受。\n\n是RMIT的学生就更好啦!\n\n如果想一起去看展一起分享有趣的日常就更好了(做梦ing)', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('131', '190', 'B000000029', '123', '123', '男性', '接受', '接受', '2019-07-08', '少于3个月', '', '墨尔本', null, '墨尔本大学 (Parkville),墨尔本大学 (Southbank),墨尔本大学语言学校 (Hawthorn)', '123123', '1234555', '111', '', '', null, '123', '2', '7', '2019-07-08 14:03:47', '0', '1', '2019-07-08 09:19:30', '2019-07-08 09:19:30', '', '', '123', '18岁以下', null, null, '有房', '是', '2019-07-08 14:03:50', null);
INSERT INTO `tk_roommates` VALUES ('132', '2790', 'B000000030', 'docklands 889两室两卫找室友', '360', '中性', '不接受', '接受', '2019-07-20', '6-12个月', '吃货一枚,懒癌患者', '墨尔本', null, '其他', '11', 'MYMH431', null, '', '/uploads/houses/2019070903251415626139148959.jpg', null, '希望找一个随性一点 好相处的室友 ', '1', '27', null, '2', '1', '2019-07-09 03:25:15', '2019-07-09 03:25:15', '', '', '889全海景房 房间空间足够大 整面落地窗海景 绝无其他楼遮挡 楼下免费电车 感兴趣的朋友可以一起take ', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('133', '4955', 'B000000031', '极近悉尼大学 uts', '295', '女性', '不接受', '不接受', '2019-07-20', '6-12个月', '安静', '悉尼', null, '悉尼科技大学(City)', 'Vivian', '13715695541', '0452149495', '', '', null, '极近悉尼大学 UTS 走路7分钟  两房两卫 broadway购物中心对面 超大主卧配独立宽敞浴室有阳台 女生双人合租295 一周 已有一女生舍友 次卧也是女生 整个屋子都有防蚊网 ！ 有空调 !  楼下就有超市 餐厅 ！包家具 !合租会换成两张床 包水Wi-Fi不包电 欢迎添加微信 13715695541 细聊 房子就在市区 很方便 小区治安也好 特别有安全感 房东会帮忙办电话卡 银行卡 熟悉周边 很贴心', '1', '37', null, '1', '1', '2019-07-09 09:50:46', '2019-07-09 09:50:46', '', '', '极近悉尼大学 UTS 走路7分钟  两房两卫 broadway购物中心对面 超大主卧配独立宽敞浴室有阳台 女生双人合租295 一周 已有一女生舍友 次卧也是女生 整个屋子都有防蚊网 ！ 有空调 !  楼下就有超市 餐厅 ！包家具 !合租会换成两张床 包水Wi-Fi不包电 欢迎添加微信 13715695541 细聊 房子就在市区 很方便 小区治安也好 特别有安全感 房东会帮忙办电话卡 银行卡 熟悉周边 很贴心', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('134', '4973', 'B000000031', '421 docklands drive', '350', '男性', '接受', '接受', '2019-07-09', '少于3个月', '', '墨尔本', null, 'RMIT University (市中心)	', '陈思源', 'seyonchy', '0426760508', '416127979@qq.com', '', null, '421 docklands drive 次卧招短租\n\n楼下就有电车站 亚超 对面还有个小购物广场 生活挺便利的\n随时入住 时间到8月21日之前都可以\n房子家具都是今年刚买的 两个卫生间 生活上没有影响 \n本人抽烟 如果你不抽烟我可以不在公共区域抽 \n租金 350一周\n', '1', '22', null, '1', '1', '2019-07-09 14:31:54', '2019-07-09 14:31:54', '', '', '无\n', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('135', '4991', 'B000000032', 'Rockdale主卧厅卧招人', '300', '女性', '不接受', '不接受', '2019-07-11', '租期可议', '不开派对', '悉尼', null, '其他', 'Chloe', 'kaqiyu13', null, '', '/uploads/houses/2019070917513215626658922671.jpg', null, '无', '1', '16', null, '1', '1', '2019-07-09 17:51:32', '2019-07-09 17:51:32', '', '', '学生党工作党皆可 女生优先 whver优先 ', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('136', '4728', 'B000000033', '近墨大parkville校区两室两卫', '310', '女性', '不接受', '不接受', '2019-07-23', '租期可议', '安静,不开派对', '墨尔本', null, '墨尔本大学 (Parkville)', 'yuhan', 'zyh617261552', '13021925255', 'yoohann1205@163.com', '', null, '墨大研究生&nbsp;女&nbsp;无不良嗜好&nbsp;爱干净&nbsp;作息基本健康&nbsp;可以很安静&nbsp;玩得来也能说\n\n房子在495 Rathdowne St Carlton 周边基本住宅区 公车站就在门口 每人有自己的独立卫浴 房间宽敞', '2', '24', null, '0', '1', '2019-07-10 01:16:52', '2019-07-10 01:19:40', '', '', '女 学生 爱干净 重视安全性 倾向于生活环境较为安静', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('137', '5122', 'B000000034', '一起合租啊', '210', '女性', '接受', '不接受', '2019-07-31', '租期可议', '', '墨尔本', null, 'RMIT University (市中心)	', '李欣然', 'LXR530642539', '', '', '', null, '8.5RMIT读语言班的贫民窟少女', '1', '48', null, '0', '1', '2019-07-12 08:45:04', '2019-07-12 08:45:04', '', '', '随便啦，你有房源就更好了', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('138', '5140', 'B000000035', 'RMIT9月语言班+研究生，一起来合租吧', '350', '女性', '接受', '不接受', '2019-09-02', '租期可议', '中二,吃货一枚,逗比,学渣,天然呆,单身狗,会做饭,安静,不开派对,小可爱', '墨尔本', null, 'RMIT University (市中心)	', 'Zizi', 'Zhibao0510', null, '', '', null, '刚过25岁的学渣，无不良嗜好，可静可动，无不良嗜好，不抽烟不喝酒，可接受宠物。爱好探索美食，旅行，看展。', '1', '43', null, '0', '1', '2019-07-12 15:36:20', '2019-07-17 13:36:11', '', '', '有共同爱好的的女生，爱干净。如果我们合的来，可以考虑长租', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('139', '2504', 'B000000036', 'rmit商学院City市中心', '300', '女性', '接受', '不接受', '2019-07-13', '6-12个月', '安静,会做饭,爱运动,不开派对,单身狗,懒癌患者', '墨尔本', null, 'RMIT University (市中心)	', 'ZYi', 'gogogofus', '0426922088', '', '', null, '好人一枚，不搞乱七八糟的事，生活习惯特别健康，爱干净，明白事理，好相处。', '1', '50', null, '0', '1', '2019-07-13 16:53:49', '2019-07-15 07:59:44', '', '', '爱干净，不带男生回家，没有男朋友，习惯良好，不爱喝酒不抽烟，好相处靠谱点的，其他的绕道。可以一起take一个新的两室两卫 已看好房源。', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('140', '5423', 'B000000037', '找室友Caulfield', '260', '女性', '不接受', '不接受', '2019-09-01', '6-12个月', '会做饭,安静,吃货一枚', '墨尔本', null, '莫纳什大学 (Caulfield)', '谈谈', 'a18622370015a', '0452106897', 'tanhanhong2@gmail.com', '', null, '喜欢做饭的95后', '1', '50', null, '2', '1', '2019-07-13 18:05:07', '2019-07-13 18:05:07', '', '', '不要太吵闹，没有宠物', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('141', '5451', 'B000000038', 'southyarra 两室两卫 副卧招租', '320', '男性', '不接受', '接受', '2019-07-15', '6-12个月', '会做饭,逗比,安静', '墨尔本', null, '莫纳什大学 (Caulfield)', 'leo', null, '0424521216', '', '/uploads/houses/2019071410274015630712609191.jpg', null, '男生 安静 会做饭 ', '1', '13', null, '0', '1', '2019-07-14 10:27:41', '2019-07-14 10:27:41', '', '', '安静 不带人回家 不开party', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('142', '5451', 'B000000039', 'south yarra两室两卫', '320', '男性', '不接受', '接受', '2019-07-15', '租期可议', '安静,会做饭,不开派对', '墨尔本', null, '莫纳什大学 (Caulfield)', 'leo', 'V5_possess', '0424521216', '', '/uploads/houses/2019071418344115631004811013.jpg', null, '安静 宅男 不开party', '1', '33', null, '0', '1', '2019-07-14 18:34:41', '2019-07-14 18:34:41', '', '', '安静 不开party ', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('143', '5556', 'B000000040', 'unilodge 800 swanston找室友', '180', '男性', '接受', '不接受', '2019-07-17', '3-6个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', '曹', 'caojinghao0208', '0422617887', '', '', null, '墨大大三civil在读生，作息规律，无不良嗜好，经常去图书馆。', '1', '31', '2019-07-17 12:07:49', '0', '1', '2019-07-17 12:03:44', '2019-07-17 12:03:44', '', '', '希望室友爱干净，无不良嗜好。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('144', '5590', 'B000000041', '莫纳什city语言班，找附近室友', '300', '男性', '接受', '接受', '2019-11-01', '3-6个月', '会做饭,爱运动,逗比', '墨尔本', null, 'RMIT University (市中心)	', 'chris', 'ah970204', null, '', '', null, '性格外向爱运动偶尔可小聚开黑', '1', '57', null, '1', '1', '2019-07-17 22:44:18', '2019-08-06 11:37:49', '', '', '随和玩儿得来的就ok，没有什么朋友是一顿烧烤处不来的，如果有就两顿～当然你有房源最好啦', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('145', '5640', 'B000000042', 'Springvale单间招租近clayton', '220', '女性', '接受', '接受', '2019-07-21', '租期可议', '安静,会做饭,吃货一枚', '墨尔本', null, '莫纳什大学 (Clayton）', 'gracia', 'wangruilinlinda', '0406152986', '', '', null, '房租：\n单人 220/week\ncouple 260/week\n\n交通：\n小区门口就是811公交站\n步行10分钟有两个火车站springvale station和sandown park station，直达caulfield、clayton和city\n开车10分钟到monash clayton校区\n\n房子：\n单间招租，男女不限，单人和情侣都可以，有完整的床、桌子\n有独立的卫生间\n家里有一个停车位，小区里也有visitor车位\n已有网、水、电、煤，share bill\n房子可以和中介签合同\n家具家电齐全（洗衣机、冰箱、电视、微波炉、沙发、餐桌）', '1', '64', null, '3', '1', '2019-07-18 23:37:30', '2019-07-18 23:37:30', '', '', '室友是一对couple，目前都是monash本科在读，人很好相处，希望找性格好、爱干净的室友一起住，最好也是上学的年纪 大家平时可以一起玩一起看电视打游戏。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('146', '5662', 'B000000043', '墨尔本市中心及周边', '350', '女性', '不接受', '不接受', '2019-07-28', '3-6个月', '爱运动,安静', '墨尔本', null, '莫纳什大学 (Caulfield)', '小耳朵', null, '0424811819', '', '', null, '本人比较安静，爱干净，生活作息正常', '1', '31', null, '0', '1', '2019-07-19 16:54:50', '2019-07-19 16:54:50', '', '', '不抽烟不喝酒，作息正常，爱干净的学生', '18岁以下', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('147', '3286', 'B000000044', '主卧室友', '340', '女性', '不接受', '不接受', '2019-07-20', '租期可议', '会做饭', '墨尔本', null, 'RMIT University (市中心)	', 'sysy', 'sysy_au', '0452168941', '', '', null, '女生 rmit研究生 开朗 好相处', '1', '53', null, '1', '1', '2019-07-19 22:30:25', '2019-07-19 22:30:25', '', '', '爱干净 ', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('148', '5450', 'B000000045', 'Docklands 883', '350', '女性', '不接受', '接受', '2019-08-01', '3-6个月', '吃货一枚', '墨尔本', null, '莫纳什大学 (Caulfield)', 'FIONA', '870383631', '', '', '', null, '活泼开朗 人很nice', '1', '50', null, '1', '1', '2019-07-21 15:23:47', '2019-07-21 15:23:47', '', '', '干净 性格好 ', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('149', '5750', 'B000000046', '需clayton校区短租房源', '300', '男性', '接受', '不接受', '2019-09-21', '3-6个月', '不开派对,爱美剧', '墨尔本', null, '莫纳什大学 (Clayton）', 'Bruce Yuan', '1252149790', null, '', '', null, '上大悉商毕业&nbsp;准备读10月开始的15周语言课&nbsp;然后去caulfield读硕士&nbsp;上海人&nbsp;不会抽烟不会喝酒&nbsp;无不良嗜好&nbsp;普普通通', '1', '89', null, '3', '1', '2019-07-22 19:34:24', '2019-07-24 22:45:33', '', '', '不抽烟 无不良嗜好 不经常带人回来或者特爱闹腾 别太不爱干净 好说话', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('150', '5799', 'B000000047', '墨爾本市中心3房2廁 單間', '319', '女性', '不接受', '不接受', '2019-07-23', '6-12个月', 'IT民工,天然呆,安静,不开派对', '墨尔本', null, '墨尔本大学 (Parkville)', 'Alison', 'alison_wong720', null, '', '/uploads/houses/2019072413322015639463402404.jpg', null, '不煮飯', '1', '45', null, '0', '1', '2019-07-24 13:32:21', '2019-07-24 13:32:21', '', '', '安靜，好相處，不開趴，乾淨，不帶男朋友回家', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('151', '1740', 'B000000048', '求组boxhill火车站附近房子', '200', '女性', '不接受', '接受', '2019-08-31', '3-6个月', '安静,会做饭,不开派对,吃货一枚,懒癌患者', '墨尔本', null, '其他', 'Ada', 'z5858x9898', '0426574792', '', '', null, '我们是一对留学生夫妻，安静不吵闹！', '1', '24', null, '0', '1', '2019-07-25 16:33:56', '2019-07-25 16:33:56', '', '', '夫妻，情侣都可以！', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('152', '2667', 'B000000049', 'CBD豪华厅卧降价出租即刻入住', '198', '女性', '不接受', '不接受', '2019-07-28', '租期可议', '安静,会做饭', '墨尔本', null, '其他', 'Cassie', 'yaoxintong64', null, '', '', null, '墨大本科生 安静 爱干净 爱学习 和另外一个墨大研究生小姐姐 已经找到房源啦 需要一个也同样热爱生活的你 快来联系我吧～', '1', '28', null, '1', '1', '2019-07-28 19:41:45', '2019-07-28 19:41:45', '', '', '安静 爱干净', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('153', '5918', 'B000000050', 'BrunswickEast两房两卫复式公寓', '530', '男性', '不接受', '不接受', '2019-08-15', '6-12个月', '安静,不开派对,懒癌患者,IT民工', '墨尔本', null, 'RMIT University (Brunswick)', 'Bo', 'xiaoboMr_wang', '0426540319', '', '', null, 'brunswick east两房两卫复式公寓，家具家电全包，想找个室友一起。', '2', '9', null, '0', '1', '2019-07-29 11:49:35', '2019-07-29 11:49:35', '', '', '男女不限，事儿少就行，', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('154', '5948', 'B000000051', 'Clayton附近二居室', '250', '女性', '接受', '接受', '2019-09-20', '6-12个月', '小可爱,夜猫子,安静,爱运动,吃货一枚', '墨尔本', null, '莫纳什大学 (Clayton）', '刘亚慧', '15618733659', '15618733659', '1293647452@qq.com', '/uploads/houses/2019072916235315643886332151.jpg', null, '嗨，我是个性格外向，活泼开朗的射手女，爱运动爱摄影爱吃爱看电影爱哈哈哈哈哈，很乖不混，希望找个小姐姐一起住', '0', '3', null, '0', '1', '2019-07-29 16:23:53', '2019-07-29 16:23:53', '', '', '乖乖的不混的，热爱生活的小姐姐', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('155', '2953', 'B000000052', '两室一卫一厅卧，一卧室招室友', '285', '中性', '接受', '接受', '2019-08-01', '3-6个月', '', '墨尔本', null, 'RMIT University (市中心)	', 'Sophie', 'chuzihang61yongli', null, '', '', null, '现在其中一间卧室已住了一个男生', '2', '21', null, '0', '1', '2019-08-01 16:23:20', '2019-08-01 16:23:20', '', '', '男生女生都可', '18-24岁', null, '3617', '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('156', '5579', 'B000000053', '还在找合适房源，摊下来一人350/w上限', '350', '男性', '接受', '接受', '2019-10-07', '租期可议', '爱运动,夜猫子,戏精本精,篮球', '墨尔本', null, 'RMIT University (市中心)	', '朱宇龙', '17612034514', '17612034514', '365400593@qq.com', '', null, '十月十四的语言班，就想找个室友一起，过去互相有个照应这种……就只要不是那种脏脏的性格就都OK，认识了我你就知道我多好讲话了嘿嘿', '1', '53', null, '0', '1', '2019-08-02 14:20:30', '2019-08-02 14:20:30', '', '', '最好是能接受抽烟能接受宠物的，周末如果有需要可以带你去找我的小伙伴们，就都已经在那边了，租期没到都，没人能合租，朋友还是有滴，如果有什么不能接受的也可以讲，主要和睦嘛嘻嘻', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('157', '6074', 'B000000054', '近city 墨大 墨尔本大学 主卧我独立卫浴 长租', '280', '女性', '不接受', '不接受', '2019-08-03', '3-6个月', '安静,会做饭,爱运动,不开派对,学霸,逗比', '墨尔本', null, '墨尔本大学 (Parkville)', 'Olivia', 'wudanyun202450', null, '', '', null, '墨大在读研究生&nbsp;已在墨尔本二年', '1', '71', null, '0', '1', '2019-08-03 15:38:32', '2019-08-27 09:35:32', '', '', '不抽烟，不养宠物，爱学习，热爱生活，健康作息习惯', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('158', '812', 'B000000158', '找可爱的室友', '340', '女性', '不接受', '不接受', '2019-09-06', '3-6个月', '不开派对,会做饭,爱运动,安静', '墨尔本', null, 'RMIT University (市中心)	', '杨霖坤', '15624979499', '', '', '', null, '安静 会做饭', '1', '32', null, '0', '1', '2019-08-08 08:47:31', '2019-08-08 08:47:31', '', '', '女生\n\n性格开朗\n\n安静', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('159', '812', 'B000000159', '找室友', '340350', '女性', '不接受', '不接受', '2019-09-06', '6-12个月', '安静,会做饭,不开派对,爱美剧', '墨尔本', null, 'RMIT University (市中心)	', '杨霖坤', '15624979499', null, '', '', null, '安静 会做饭', '1', '38', null, '0', '1', '2019-08-08 08:49:55', '2019-08-08 08:49:55', '', '', '安静\n\n性格开朗\n\n', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('160', '6173', 'B000000160', '悉大附近寻找舍友', '500', '男性', '不接受', '接受', '2019-09-24', '6-12个月', '', '悉尼', null, '悉尼大学(主校区）', '刘子鑫', '18852724911', '18852724911', '632926599@qq.com', '', null, '耐心，易于交流。', '1', '36', null, '1', '1', '2019-08-08 16:38:59', '2019-08-08 16:38:59', '', '', '容易沟通，乐观开朗', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('161', '6185', 'B000000161', 'city脸楼主卧招租 采光好 近墨大 rmit', '370', '男性', '接受', '接受', '2019-08-08', '租期可议', '学霸,单身狗,安静', '墨尔本', null, '墨尔本大学 (Parkville)', 'Daniel', 'angus-dong11', null, '', '', null, '墨大finance学生，在家不抽烟，基本不做饭 厨房干净，不带人回家，想要实地看房或照片的话加我微信就好', '1', '45', null, '0', '1', '2019-08-08 16:44:05', '2019-08-08 16:44:05', '', '', '爱卫生最重要！', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('162', '1397', 'B000000162', 'City 主卧招长租 男生佳 CP可', '380', '男性', '接受', '不接受', '2019-08-10', '3-6个月', '安静,会做饭,不开派对,天然呆,吃货一枚', '墨尔本', null, 'RMIT University (市中心)	', 'cc', 'tc86543', null, '', '/uploads/houses/2019080906574415653050640683.jpg', null, 'City 主卧、车位招长租 CP可\n\n房型：两室两卫一厅卧 带全套家具 \n\n主卧:  单人-380pw/周，\n         好朋友、CP-400/周，\n超大主卧，带阳台、带卫浴，带衣帽间，东西在多都能装得下\n租1年，可小刀，share bills \n有健身房、泳池\n\n入住时间：\n主卧8.10-8.18起租，租期最短到2020年二月\n车位8.20起，55/周\n\n微信: tc86543（备注主卧、车位）\n\nbuilding不临主街超安静，\n近Monash 语言班，走路10-15分钟\n\n\n男女不限、不吵无不良嗜好。\n厨房很大可煮饭，', '1', '41', null, '0', '1', '2019-08-09 06:57:44', '2019-08-09 06:57:44', '', '', '男女不限、不吵无不良嗜好。\n厨房很大可煮饭，', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('163', '4564', 'B000000163', '莫那什city语言10周~找室友', '300', '女性', '接受', '接受', '2019-10-25', '租期可议', '小可爱,爱美剧,会做饭,铲屎官', '墨尔本', null, '莫纳什大学 (Caulfield)', '雅婷', '15117977466', '15117977466', '1522002675@qq.com', '/uploads/houses/2019080916031015653377904724.jpg', null, '想找莫那什的室友一起租房', '1', '63', null, '1', '1', '2019-08-09 16:03:11', '2019-08-09 16:03:11', '', '', '开朗的nice室友，能聊得来，互相照应的美女和帅哥', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('164', '6307', 'B000000164', '墨尔本大学对面卧室出租', '255', '男性', '不接受', '接受', '2019-08-15', '租期可议', '安静', '墨尔本', null, '墨尔本大学 (Parkville)', 'vicky', 'wxhbn111', '0450110315', '', '/uploads/houses/2019081316302015656850207337.png', null, '无', '1', '51', null, '0', '1', '2019-08-13 16:30:22', '2019-08-13 16:30:22', '', '', '安静就好', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('165', '6107', 'B000000165', 'mq附近找女生舍友', '250', '女性', '接受', '不接受', '2019-09-25', '3-6个月', '不开派对,会做饭,吃货一枚', '悉尼', null, '麦觉理大学', '胖虎', null, '15230614774', '646883854@qq.com', '', null, '可以接受宠物，抽烟最好不要在室内或者少烟', '1', '19', null, '0', '1', '2019-08-13 20:43:57', '2019-08-13 20:43:57', '', '', '事情少，可以一起做饭', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('166', '639', 'B000000166', 'vanguard 803 Dandenong', '330', '女性', '接受', '接受', '2019-08-22', '租期可议', '会做饭,夜猫子,安静,吃货一枚,逗比', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Luting Wang', '15900732764', '0452095868', '954769477@qq.com', '/uploads/houses/2019081809443215660926725441.jpg', null, 'Monash business information system在读第二学期，直女一枚hhh\n刚take的两室两卫一车位，出租次卧，家里有一只英短已绝育，非常聪明爱干净。', '0', '4', null, '0', '1', '2019-08-18 09:44:34', '2019-08-18 09:44:34', '', '', '爱干净讲卫生，好相处，男女不限\n更偏向找个外向直话直说的，爽快的 ', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('167', '5142', 'B000000167', '找室友呗', '350', '女性', '接受', '不接受', '2020-02-01', '租期可议', '安静,不开派对', '墨尔本', null, '莫纳什大学 (Caulfield)', '刘京婷', 'wu0ting', '13520552327', '2756824167@qq.com', '', null, '二月入学&nbsp;莫纳什传媒专业&nbsp;', '1', '44', null, '3', '1', '2019-08-18 18:57:56', '2019-08-20 13:10:23', '', '', '没不良嗜好', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('168', '1175', 'B000000168', '65 Dudley street', '380', '女性', '接受', '不接受', '2019-09-08', '租期可议', '安静,会做饭,不开派对', '墨尔本', null, 'RMIT University (市中心)	', 'Grace', '18101947212', '0402164282', '1937896433@qq.com', '', null, '比较宅，但是会做饭。比较开朗活泼，找小姐姐进来一起住。', '1', '24', null, '0', '1', '2019-08-22 09:56:00', '2019-08-22 09:56:00', '', '', '安静活泼的小姐姐就好。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('169', '21', 'B000000169', '求租cbd两房', '255', '男性', '接受', '接受', '2019-08-22', '少于3个月', '钢铁直男,吃货一枚,爱运动', '墨尔本', null, 'RMIT University (市中心)	,Victoria University (Footscray)', 'ruixuan', 'hdjd', '', '', '', null, '哈哈哈', '2', '4', null, '0', '1', '2019-08-22 10:39:13', '2019-08-22 10:39:13', '', '', '你好好', '18岁以下', null, '653', '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('170', '5769', 'B000000170', 'rmit10月入学找舍友', '350', '男性', '接受', '接受', '2019-10-10', '租期可议', '会做饭,爱运动,不开派对,篮球', '墨尔本', null, 'RMIT University (市中心)	', 'Argentina', 'z853027828', '13011619279', '', '', null, '10月rmit入学 找个男生舍友 预算350左右 有意加微信 房源还在找 希望在city附近 ', '1', '21', null, '0', '1', '2019-08-23 16:34:34', '2019-08-23 16:34:34', '', '', '爱干净爱运动的最好 可以一起健身打游戏', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('171', '6591', 'B000000171', 'city区域找室友一起take房子', '380', '女性', '接受', '不接受', '2019-09-08', '6-12个月', '会做饭,小可爱', '墨尔本', null, 'RMIT University (市中心)	', 'vera', 'VERA_yangyc', null, '', '', null, 'rmit本科学生\n想找人一起take City区域内的apartment\n有猫 偶尔带人回家玩\n意向为租两室两卫的studio\n有想一起take房子的小伙伴来找我吧', '1', '43', null, '0', '1', '2019-08-24 02:23:20', '2019-08-24 02:23:20', '', '', '爱干净\n不生事\n不每天带人回家玩到半夜\n', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('172', '4876', 'B000000172', 'Victoria one', '480', '男性', '接受', '接受', '2019-09-21', '3-6个月', '夜猫子,铲屎官,学霸,赌神', '墨尔本', null, 'RMIT University (市中心)	', 'Yuan', '17620518346', '0477598006', '2573584619@qq.com', '', null, '详情私聊', '1', '35', null, '0', '1', '2019-08-26 09:25:13', '2019-08-26 09:25:13', '', '', '男 接受吸烟和宠物', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('173', '4255', 'B000000173', 'Victoria one', '360', '男性', '不接受', '不接受', '2019-08-26', '6-12个月', '钢铁直男,会做饭,不开派对,爱运动', '墨尔本', null, '墨尔本大学 (Parkville)', '小白', 'Bzhwhoiswho', '0466666059', '', '', null, '墨尔本大学硕士学生', '1', '38', null, '0', '1', '2019-08-26 20:52:34', '2019-08-26 20:52:34', '', '', 'Rmit或者墨大学生', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('174', '6587', 'B000000174', '近墨大 维码 新公寓', '300', '女性', '不接受', '不接受', '2019-08-28', '3-6个月', '不开派对,吃货一枚,逗比', '墨尔本', null, '墨尔本大学 (Parkville)', '雨', 'caoxiaoyu-xiaopang', '0412188191', '', '/uploads/houses/2019092421215615693313161590.jpg', null, '【全新公寓City】顶楼有公共区域可以BBQ，家里就是窗户多&nbsp;全明房&nbsp;朝北/西&nbsp;无遮挡，在阳台使劲垫脚可以看到dockland&nbsp;海边！\n价格：320/周\n1.地理位置：&nbsp;121&nbsp;Rosslyn&nbsp;street&nbsp;步行维妈7分钟.&nbsp;墨大&nbsp;15分钟&nbsp;.flagstaff&nbsp;station&nbsp;/garden&nbsp;3分钟.&nbsp;去哪都方便\n2.内部配置：洗衣机、冰箱、洗碗机、空调、沙发…家具家电全齐！\n3.&nbsp;房主是个墨大在读ｍａｓｔｅｒ小姐姐：&nbsp;人美，心善&nbsp;主要还有个有趣的灵魂（哈哈哈哈），事不多，虽然不咋会做饭，但是爱吃！\n4.要求：希望你是个爱干净的小朋友（保证公共区域+自己领地的清洁），不吵不闹，不随便带人回家.\n5.水、电、煤、网&nbsp;：share&nbsp;bill\n此区域没有那么吵闹&nbsp;很安静，吃多了下楼直奔flagstaff&nbsp;garden&nbsp;消消食，顺便看看负鼠！&nbsp;也不会有什么路噪，交通便利58、35&nbsp;、30电车、220公交，火车，样样齐全！\ncp&nbsp;❌：单身', '1', '49', null, '0', '1', '2019-08-28 11:05:11', '2019-09-24 21:21:57', '', '', '是个爱干净的小朋友', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('175', '608', 'B000000175', 'Carnegie两室一厅找室友', '200', '女性', '接受', '不接受', '2019-08-28', '3-6个月', '学霸,安静,小可爱', '墨尔本', null, '莫纳什大学 (Caulfield)', '刘', '342690850', '0433770510', '', '', null, 'monash master of accounting在读', '1', '23', null, '1', '1', '2019-08-28 17:15:47', '2019-08-28 17:15:47', '', '', '爱护房子～', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('176', '4588', 'B000000176', 'city两室两卫已经take的的房子 找男室友', '330', '男性', '不接受', '不接受', '2019-08-30', '租期可议', '安静,爱运动,不开派对', '墨尔本', null, 'RMIT University (市中心)	', 'da', null, '0450156883', '', '', null, '房子在维多利亚一号 近一切', '1', '58', null, '0', '1', '2019-08-29 23:04:00', '2019-08-29 23:04:00', '', '', '爱干净 不抽烟喝酒 好说话好相处', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('177', '6545', 'B000000177', '月租925 主卧招租', '210', '女性', '不接受', '不接受', '2019-09-02', '租期可议', '会做饭,爱运动,小可爱,中华小当家,爱美剧', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Zoey', 'hypatiaaa', null, '', '', null, '会计本科大二学生，会做饭，好相处。晚上回家以后会收拾收拾房子，喜欢交新朋友。', '1', '64', null, '3', '1', '2019-08-30 15:08:14', '2019-08-30 15:08:14', '', '', '女室友，最好也是monash学生。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('178', '6835', 'B000000178', '找室友take Ct附近（docklands最好）', '350', '女性', '接受', '接受', '2019-09-15', '3-6个月', '小可爱,会做饭,安静,中华小当家', '墨尔本', null, 'RMIT University (市中心)	', '糖小畅', 'tanchangwin', '0405581020', '719050312@qq.com', '', null, '天秤座女生，莫那什研究生刚毕业\n本人有轻微洁癖，但能接受宠物，抽烟请在阳台\n爱整理，会做饭，好相处\n想take一个两室两卫的公寓\n地点：ct附近，docklands最佳\n一般整套take租金在680-700之间\n', '1', '37', null, '0', '1', '2019-09-04 09:59:19', '2019-09-04 09:59:19', '', '', '事少，互不干扰\n合得来可以一起喝酒玩游戏', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('179', '6358', 'B000000179', 'Richmond 找室友', '220', '女性', '接受', '接受', '2019-09-25', '租期可议', '安静,铲屎官', '墨尔本', null, '墨尔本大学 (Southbank)', '叶大葵', 'lynnkuikui', null, '', '/uploads/houses/2019090706375915678094791990.jpg', null, '爱看电影 准备买个投影仪去新家\ntake了一年 \n现在是社工 一周四天工作 两天志愿者\n比较随意 万事好商量\n有一只橘猫', '1', '37', null, '0', '1', '2019-09-07 06:37:59', '2019-09-07 06:37:59', '', '', '爱看电影\n尊重个人空间\n可以一起Netflix 也可以各干各的\n基本整洁 及时付房租', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('180', '4632', 'B000000180', 'Southbank（全包)找室友', '310', '男性', '不接受', '不接受', '2019-09-24', '少于3个月', '安静,会做饭,吃货一枚', '墨尔本', null, '墨尔本大学 (Southbank)', '小白', '305844456', '0423162813', 'yijing951@hotmail.com', '/uploads/houses/2019091105200015681504008435.jpg', null, 'Monash在读男生，安静好相处。', '1', '31', null, '0', '1', '2019-09-11 05:20:01', '2019-09-11 05:20:01', '', '', 'southbank公寓走路一分钟Metro，8分钟到南墨尔本市场，WWS，10分钟到coles。楼下十米12路电车站，5分钟达southern cross station和Collins st。现master房间招租。房间内带窗，queen size的床+床垫，床头柜，写字台，嵌入式大衣柜。转合同到明年2月1可续租。公寓内有洗衣机，烘干机，电视。现另一间房住的是monash在读男生，好相处随和不计较。每周$310，月付。押金一个月租金。包水电煤气和wifi，包家具。', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('181', '6663', 'B000000181', '一起take Caulfield房租', '300', '女性', '接受', '不接受', '2019-09-30', '租期可议', '安静,夜猫子,会做饭,文艺范', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Maria', '657847759', '0424486211', '', '', null, 'Caulfield的房子！离学校近，去哪里都方便～本人好相处 爱做饭 找个室友一起住～对于住上理想中的公寓势在必得！', '1', '34', null, '0', '1', '2019-09-13 20:54:49', '2019-09-13 20:54:49', '', '', '可以接受你夜猫子 但请保持安静～希望你能保持公共区域干净整洁～一切可以详谈～', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('182', '398', 'B000000182', 'vision 两室一厅 次卧', '300', '女性', '不接受', '不接受', '2019-12-24', '租期可议', '夜猫子,会做饭,中二,戏精本精,逗比', '墨尔本', null, 'RMIT University (市中心)	', 'KIKI', 'LiJuly2', '0410926619', '', '', null, '会做饭 现在rmit 上预科 爱玩 不抽烟喝酒', '1', '38', null, '0', '1', '2019-09-17 09:16:54', '2019-09-17 09:16:54', '', '', '睡觉晚一点无所谓 深夜声音尽量能小一些 性格好一些 爱干净', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('183', '7126', 'B000000183', 'Hobart Sandy Bay 近塔大 海景房出', '210', '女性', '不接受', '不接受', '2019-09-18', '3-6个月', '安静,会做饭,学霸,天然呆', '霍巴特', null, '塔大Sandy Bay', 'Cindy ', null, '0452168113', '', '', null, '来澳5年 曾在悉尼UTS读本科 现在在霍巴特呆着拿PR', '1', '6', null, '0', '1', '2019-09-17 19:49:09', '2019-09-17 19:49:09', '', '', '爱干净 尊重彼此隐私 开朗好相处  三观正', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('184', '25', 'B000000184', 'Clayton学生公寓求小姐姐一起take', '210', '女性', '不接受', '不接受', '2020-02-18', '6-12个月', '安静,会做饭', '墨尔本', null, '莫纳什大学 (Clayton）', 'Coral', 'MCY-1209', '', '', '/uploads/houses/2019091909152115688557218739.jpg', null, 'monash本科在读，education专业的妹子。特别好相处，会做饭！之后可以一起做饭一起逛街～目前我看上了SHA学生公寓，因为以前在这里住了一年了，交通什么的感觉都比较方便，如果想来了解一下的，可以随时加我微信～', '2', '15', null, '0', '1', '2019-09-18 21:09:52', '2019-09-19 09:15:22', '', '', '希望未来的室友，好相处聊得来就好，毕竟我们是要一起生活的人。', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('185', '218', 'B000000185', 'glen找室友', '150', '中性', '接受', '接受', '2019-09-19', '租期可议', '不开派对,高富帅,文艺范,懒癌患者', '墨尔本', null, '其他', 'lin', null, '0452285208', '', '/uploads/houses/2019091901504015688290407332.jpg', null, 'rmit大二学生，欢迎电话咨询', '1', '17', null, '1', '1', '2019-09-19 01:50:41', '2019-09-19 01:50:41', '', '', '没有不良习惯，其他都行', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('186', '7192', 'B000000186', 'Dockland毕业工作找室友', '350', '女性', '接受', '接受', '2020-01-01', '6-12个月', '单身狗,IT民工', '墨尔本', null, '其他', 'Ellie', 'Wby0322', '0413322000', '', '', null, '墨大11月master毕业 1月开始工作，找一个妹子室友一起找Dockland两室一厅的房子啦！希望室友也是即将开始工作或者已经在工作的人，这样话题会更多schedule也对得上', '1', '25', null, '1', '1', '2019-09-20 02:04:58', '2019-09-20 02:04:58', '', '', '讲卫生好相处就行 可能我有计划养猫 对毛绒绒不过敏以及不讨厌小动物就好', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('187', '7115', 'B000000187', '莫纳什Clayton附近房子，希望和女生合租', '300', '女性', '接受', '不接受', '2019-11-06', '少于3个月', '安静,会做饭,不开派对,单身狗,吃货一枚,夜猫子', '墨尔本', null, '莫纳什大学 (Clayton）', 'Miranda', '1340500378', '15063082371', 'Miranda_WZ@163.com', '', null, '无不良嗜好，不自来熟，比较安静，喜欢吃各种美食', '1', '27', null, '0', '1', '2019-09-20 20:52:12', '2019-09-20 20:52:12', '', '', '女生，比较热情，比较自律能带动我学习，可爱', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('188', '7413', 'B000000188', 'skyone新房两室两卫找室友', '300', '女性', '不接受', '接受', '2019-10-14', '6-12个月', '夜猫子,爱运动,安静,学渣,懒癌患者,会做饭', '墨尔本', null, 'Deakin University (Burwood)', '小佳', 'zjj080911', null, '1048879858@qq.com', '', null, '热情大方性格开朗善良 河南郑州人 希望有自己独处的空间', '1', '28', null, '1', '1', '2019-09-26 11:53:18', '2019-09-26 11:53:18', '', '', '安静 爱学习 性格开朗 ', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('189', '6746', 'B000000189', '找室友一起租房', '300', '女性', '不接受', '不接受', '2019-10-28', '6-12个月', '会做饭,安静,不开派对,逗比,吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', '叶', 'ppsai_66', null, '', '', null, '人美心善会做饭的小姐姐', '1', '52', '2019-10-07 20:58:21', '1', '1', '2019-10-07 20:52:12', '2019-10-08 17:52:23', '', '', '性格好，安静，不带人回家', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('190', '6083', 'B000000190', 'clayton单间11月底找女生室友', '198', '女性', '不接受', '不接受', '2019-11-26', '租期可议', '', '墨尔本', null, '莫纳什大学 (Clayton）', 'heather', 'lhj000315', '0433970315', '', '', null, '室友a 安静的女学生会做饭讲卫生\n室友b 安静的女学生diploma 会做饭讲卫生\n房东小姐姐 安静的女学生研究生在读会做饭讲卫生\n\n\n', '1', '30', null, '0', '1', '2019-10-07 21:34:21', '2019-10-07 21:34:21', '', '', '安静 讲卫生 女生only\n租期可议 价格可议', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('191', '7787', 'B000000191', '副卧招租！', '300', '女性', '接受', '接受', '2020-02-26', '租期可议', '会做饭,安静,小可爱', '墨尔本', null, '墨尔本大学 (Parkville)', 'silvia', 'MM176786274', null, '', '', null, '本人墨大本科在读 作息良好 一般都泡图书馆有轻微洁癖 会做饭  好相处 照片就pyq看？？\n抽烟的话希望能去阳台抽\n两个房间差不多 区别就是一明一暗）', '1', '77', null, '2', '1', '2019-10-18 05:38:24', '2019-10-18 05:38:24', '', '', '爱干净！！！这是最重要的 剩下的都没这个重要 哈哈哈哈哈哈', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('192', '7883', 'B000000192', 'uts女生想找本科女生一起takestudio', '400', '女性', '接受', '不接受', '2020-03-01', '租期可议', '会做饭,不开派对,单身狗,吃货一枚,逗比', '悉尼', null, '悉尼科技大学(City)', 'nicole', 'lily804992117', '473487967', '', '', null, '以后可能会多煮饭 个人好相处', '1', '17', null, '0', '1', '2019-10-21 22:34:49', '2019-10-21 22:34:49', '', '', '愿意一起煮饭 好相处 性格好 ', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('193', '7973', 'B000000193', '80 a\'beckett st', '300', '男性', '接受', '不接受', '2019-11-18', '3-6个月', '爱运动,不开派对,会做饭,中二,戏精本精,小可爱,麦霸,单身狗,逗比', '墨尔本', null, '墨尔本大学语言学校 (Hawthorn)', '李世洲', '1074978242', '13660100251', '1074978242@qq.com', '/uploads/houses/2019110809461215731775727233.jpg', null, '广东广州人，3月入学墨尔本大学研究生，会做简单的饭菜。金牛座，平时安静话比较少，但活泼的时候也很活泼。晚上很安静，一定不会吵室友。\n喜欢游戏、动漫、健身。空闲时间这三个爱好会平分时间。', '1', '43', '2019-10-28 12:09:43', '0', '1', '2019-10-28 12:03:31', '2019-11-08 09:46:13', '', '', '一个好相处，干净的室友就完事了', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('194', '7810', 'B000000194', 'south cross火车站公寓招室友', '330', '男性', '不接受', '接受', '2019-10-31', '租期可议', '夜猫子,会做饭,吃货一枚,逗比', '墨尔本', null, '其他', 'wang', 'RaitoJulancha', '0452527090', '', '', null, '帮朋友发这个招室友！\n现居住的为男生，已毕业，在上班朝九晚五型。比较安静，平时喜欢打打游戏看看书出去旅游。\n男生自己take了整套公寓，空一间房，现招一室友！\n公寓步行去south cross 火车站只要三分钟。楼下即各大电车站，11，48，96等都经过楼下电车站。旁边餐厅超市全部齐全。24小时门店和超市也有不少\n公寓自带健身房和游泳池！还有桑拿和spa！', '0', '5', null, '0', '1', '2019-10-29 19:48:44', '2019-10-29 19:48:44', '', '', '只要好说话就好啦！', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('195', '8036', 'B000000195', 'cbd好房全城最低价166全包，带泳池健身房', '166', '女性', '不接受', '不接受', '2019-11-05', '租期可议', '安静,不开派对,会做饭,爱运动,小可爱,学渣,文艺范,逗比,赌神,IT民工,中二,吃货一枚,中华小当家,麦霸,戏精本精,学霸,单身狗,懒癌患者,高富帅,篮球,足球,爱美剧,吃鸡达人,天然呆', '墨尔本', null, 'LaTrobe University(市中心)', '于', 'watermelonlikeme', '0480188383', '', '/uploads/houses/2019110514033115729338118142.jpg', null, '宇宙中心CBD高档公寓大厅卧出租，近语言班，近southern cross，city最低价！！！每周166全包\n\n1.available 时间：now，租期到1.25，到期可以续约，租期可商量\n2.价格166全包\n3.屋内设施：床，书桌，椅子，衣柜，落地窗阳光充足，空调，微波炉，烤箱，冰箱，洗衣机，超快的无线网，全套厨具，枕头被子可提供\n4.公寓设施：泳池，健身房，网球场，BBQ，电子门卡进出（绝对安全）\n5.走出公寓30秒就是电车站，5分钟就是southern cross, coles, chemist, outlets...\n6.室友都很好，都上班\n7.厅卧不靠近厨房，无油烟，面积大\n欢迎预约看房，电话短信，价格可商量\n地址668 Bourke Street\n+61480188383\nwx：watermelonlikeme', '1', '26', null, '0', '1', '2019-11-05 14:03:32', '2019-11-05 14:03:32', '', '', '宇宙中心CBD高档公寓大厅卧出租，近语言班，近southern cross，city最低价！！！每周166全包\n\n1.available 时间：now，租期到1.25，到期可以续约，租期可商量\n2.价格166全包\n3.屋内设施：床，书桌，椅子，衣柜，落地窗阳光充足，空调，微波炉，烤箱，冰箱，洗衣机，超快的无线网，全套厨具，枕头被子可提供\n4.公寓设施：泳池，健身房，网球场，BBQ，电子门卡进出（绝对安全）\n5.走出公寓30秒就是电车站，5分钟就是southern cross, coles, chemist, outlets...\n6.室友都很好，都上班\n7.厅卧不靠近厨房，无油烟，面积大\n欢迎预约看房，电话短信，价格可商量\n地址668 Bourke Street\n+61480188383\nwx：watermelonlikeme', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('196', '2517', 'B000000196', '近莫那什caufield校区好公寓！', '250', '男性', '不接受', '不接受', '2019-12-05', '租期可议', '不开派对,安静', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Nicole', 'njz1231', '0478111661', '', '/uploads/houses/2019111007321115733423315140.jpg', null, '安静上班族 希望我们互相尊重～', '1', '23', null, '0', '1', '2019-11-10 07:32:11', '2019-11-10 07:32:11', '', '', '安静不开派对 为人正直和善啦', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('197', '4823', 'B000000197', 'RMIT/墨大找室友', '300', '女性', '不接受', '不接受', '2020-02-23', '租期可议', '不开派对,会做饭,文艺范,中二', '墨尔本', null, 'RMIT University (市中心)	', '砒霜', '705048301', null, '', '/uploads/houses/2019111515210515738024659570.jpg', null, '1.\n是明年RMIT本科学生\n爱干净+好相处，爱好很广泛。可活跃可安静。\n\n\n2.\n位置要在CBD附近，租金接受每人300以内的，有长租打算最好。\n\n起租期最好和我相差半个月内，偏好有独卫，相对不在意公寓的新旧程度，安全第一。有看上的房子，细节可以一起商量。可以一起take房子买家具or直接找全家具，都不介意。\n\n', '2', '7', null, '2', '1', '2019-11-15 15:21:06', '2019-11-15 15:21:06', '', '', '最好是女性。要求性格不坏，讲卫生，无不良生活作息(如随意带人回家/夜间party)。抽烟和养宠物如果几乎完全(重点）可以不影响他人也可接受。\n\n是RMIT的学生就更好啦!\n\n如果想一起去看展一起分享有趣的日常就更好了(做梦ing)', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('198', '8225', 'B000000198', '希望一起租个二室', '330', '女性', '不接受', '不接受', '2020-02-18', '租期可议', '安静,吃货一枚,天然呆', '墨尔本', null, '墨尔本大学 (Parkville)', '郭天玥', 'gty1005874750', null, '', '', null, '很安静，爱干净\n爱泡图书馆\n不抽烟，不喝酒不带人回家\n', '2', '45', null, '3', '1', '2019-11-17 12:39:28', '2019-11-17 12:39:28', '', '', '希望我的小仙女舍友也能够爱安静\n不抽烟不带人回家\n一起交流学习\n', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('199', '8225', 'B000000199', 'Victoria', '750', '女性', '不接受', '不接受', '2020-02-17', '租期可议', '安静,不开派对', '墨尔本', null, '墨尔本大学 (Parkville)', '郭天', 'gty1005874750', '', '', '', null, '墨大2020年三月研究生\n不抽烟，不喝酒不带人回家很安静爱干净', '2', '25', null, '0', '1', '2019-11-27 14:01:19', '2019-11-27 14:01:19', '', '', '希望\n不抽烟，不喝酒不带人回家，喜欢安静，作息规律\n', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('200', '7450', 'B000000200', '墨大附近求合租', '300', '女性', '接受', '接受', '2020-02-25', '6-12个月', '不开派对,安静,会做饭,爱运动,小可爱', '墨尔本', null, '墨尔本大学 (Parkville)', 'vicky', '465735292', null, '', '', null, '喜欢健身 可以做饭 爱干净 ', '1', '43', null, '0', '1', '2019-11-30 12:43:09', '2019-11-30 12:43:09', '', '', '愿意收拾自己的部分 如果喜欢健身喜欢去电音节就更好了', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('201', '8369', 'B000000201', '找女生舍友', '300', '女性', '接受', '不接受', '2020-02-10', '6-12个月', '安静,不开派对', '墨尔本', null, '莫纳什大学 (Clayton）', 'Viola', 'm18801582932', '0426770953', '1747621334@qq.com', '', null, '一起合租校区附近的公寓', '1', '24', null, '0', '1', '2019-12-03 12:39:34', '2019-12-03 12:39:34', '', '', '女生', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('202', '4610', 'B000000202', '找个室友一起take一间公寓', '270', '女性', '接受', '不接受', '2020-02-20', '6-12个月', '夜猫子,安静,单身狗,吃货一枚', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Neoma', '18186761919', null, '13733531302@163.com', '', null, '商科硕士研一，喜欢干净整洁，很乐意和室友一起聊天和分享食物', '2', '9', null, '0', '1', '2019-12-03 17:15:02', '2019-12-03 17:17:01', '', '', '希望找个爱干净，不抽烟喝酒的室友，一起take一间二月底或三月初的房间', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('203', '8419', 'B000000203', 'monash caufield附近的两室两卫', '300', '男性', '接受', '不接受', '2019-12-15', '租期可议', '', '墨尔本', null, '莫纳什大学 (Caulfield)', '陈先生', '18677431152', null, '', '/uploads/houses/2019120320184915753755295262.jpg', null, '爱干净，很好相处', '1', '40', null, '0', '1', '2019-12-03 20:18:50', '2019-12-03 20:18:50', '', '', '合得来的就好', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('204', '6861', 'B000000204', 'southyarra caulfield女生', '300', '女性', '接受', '接受', '2020-02-25', '租期可议', '', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Lea', 'lsy970914', '0416267900', '', '', null, 'moansh 研3月入学找二月底一起take两室的女孩子，south yarra ，ct ，caulfield都可以，', '1', '26', null, '0', '1', '2019-12-08 21:22:14', '2019-12-08 21:22:14', '', '', '爱干净，不吵', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('205', '8475', 'B000000205', 'Parkville主卧，近墨大', '240', '男性', '接受', '接受', '2019-12-09', '少于3个月', '安静,会做饭,不开派对,爱运动,铲屎官,IT民工', '墨尔本', null, '墨尔本大学 (Parkville)', 'tron', 'ysc2133', '0449980723', '', '/uploads/houses/2019120909152715758541270804.jpg', null, 'Parkville  主卧1间招租，带独立卫浴\n30/11号可入住，长短租均可\n短租$240/week 包水电网 即日起到三月\n长租请加微信详谈\n\n公寓位于92 Cade Way Parkville，社区安全、环境安静优雅，交通便捷，适宜学习与生活。公寓配套免费健身房，游泳池和公共聚会空间，是健康生活的良所；毗邻墨尔本大学和Monash parkville两校区，公寓楼下有直达墨大公交505，无需换乘，是墨大学生和mansh药学院学生的不二之选；出门步行10-15min，有多趟电车直达city，经济便捷，同样欢迎上班的朋友。\n\n房屋设施一应俱全，可拎包入住\n家里有两只猫，不咬人、不傲娇、特别乖、随便撸，欢迎干净整洁的朋友入住\n\n咨询请加微信：ysc2133   加微信请备注。\n或电话（咨询）：0449980723', '1', '17', null, '0', '1', '2019-12-09 09:15:28', '2019-12-09 09:15:28', '', '', '干净整洁\n', '24-30岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('206', '8260', 'B000000206', '想在极光take两室一卫的房子，找合租', '720', '女性', '不接受', '不接受', '2020-02-11', '租期可议', '安静,吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', 'Ariel', '18234127093', '18234127093', 'guoyuanyuan0028@126.com', '', null, '墨大3月入学IT研究生', '1', '16', null, '0', '1', '2019-12-11 19:04:13', '2019-12-11 19:04:13', '', '', '租房需求一直\n想在city离车站近的地方住，最好是极光\n可以一起玩和学习的小伙伴', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('207', '8511', 'B000000207', '近墨大', '300', '男性', '接受', '不接受', '2020-01-20', '6-12个月', '篮球,爱运动,不开派对,长腿欧巴', '墨尔本', null, '墨尔本大学 (Parkville)', '黄靖博', '154239938', '0420481012', '154239938@qq.com', '/uploads/houses/2019121217360715761433675917.jpg', null, '健身房打球 墨大建筑设计本科', '1', '25', null, '1', '1', '2019-12-12 17:36:08', '2019-12-12 17:36:08', '', '', '无不良嗜好', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('208', '6817', 'B000000208', 'Unilodge两房求室友', '250', '女性', '接受', '不接受', '2020-02-01', '6-12个月', '会做饭,中二,不开派对', '墨尔本', null, '墨尔本大学 (Parkville)', 'Lily', 'LYYLILY1111', '0457283201', '', '', null, '想住墨大附近的学生公寓。欢迎作息规律的妹子来扰', '1', '27', null, '2', '1', '2019-12-17 21:24:07', '2019-12-17 21:24:07', '', '', '作息规律，研究生最佳。希望爱干净，能聊得来', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('209', '1413', 'B000000209', 'city两室一卫次卧找室友', '290', '女性', '不接受', '不接受', '2020-01-02', '租期可议', '安静,爱运动,会做饭', '墨尔本', null, '墨尔本大学 (Parkville)', 'HelenZhao', '1290274705', '0481987358', '', '', null, '墨大science，开学大三，经常泡图书馆，摩羯座', '1', '54', null, '2', '1', '2019-12-20 10:18:40', '2019-12-20 10:18:40', '', '', '性格相投的小仙女', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('210', '8764', 'B000000210', 'Southbank三室找室友', '300', '中性', '接受', '接受', '2020-01-11', '6-12个月', '安静,会做饭,爱运动,不开派对,学霸', '墨尔本', null, '墨尔本大学 (Parkville)', 'Melody', '15928040567', '0411558002', '', '/uploads/houses/2019123119532615777932060871.jpg', null, 'Southbank 1月高性价比三室求合租。\n\n现有一性价比好房780 per week三室两卫求室友一起 take，没有二房东，客厅不住人。  \n\n超大客厅，超大阳台。\n\n我们是一对安静爱做饭的好couple，都是墨大的学生。\n我们已经在栋楼住了两年了，体验很好，合约到期想换楼层更高的。这栋楼非常安全，设施完善(游泳池，健身房，网球场, bbq)，楼管负责好说话。\n\n我们已经有大部分的家具和厨具，包括冰箱，洗衣机，沙发，大电视，餐桌，switch游戏等等。我们现在的室友要回国，可以转卖全套卧室家具。\n\n现在距离开学时间还早，就算 take不成功，还有很多时间看别的房。有兴趣的请加我微信15928040567。', '1', '30', null, '1', '1', '2019-12-31 19:53:26', '2019-12-31 19:53:26', '', '', '没啥不良习惯都行', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('211', '8810', 'B000000211', '毕业找室友合租', '300', '男性', '接受', '不接受', '2020-02-01', '租期可议', '会做饭,爱运动,篮球', '墨尔本', null, '其他', 'Leo', null, '0415551005', '', '', null, '墨大毕业生，想找男生一起合租take房子。有意愿的朋友可以先发短信联系我', '1', '21', null, '0', '1', '2020-01-03 06:55:16', '2020-01-03 06:55:16', '', '', '限男生，不抽烟无不良嗜好，安静不吵闹，不开派对', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('212', '7782', 'B000000212', '测试用请无视', '255', '女性', '接受', '接受', '2020-02-03', '少于3个月', '不开派对,懒癌患者', '墨尔本', null, '墨尔本大学 (Parkville)', '张', 'Zk33', '15389059016', '', '', null, '11', '2', '3', null, '0', '1', '2020-01-03 15:18:12', '2020-01-03 15:18:12', '', '', '11', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('213', '7782', 'B000000213', '22', '200', '男性', '接受', '接受', '2020-02-04', '少于3个月', '中二,爱运动', '墨尔本', null, '墨尔本大学语言学校 (Hawthorn)', '张凯', null, '18217373761', '', '', null, '22', '1', '10', null, '0', '1', '2020-01-03 15:24:50', '2020-01-03 15:24:50', '', '', '22', '18岁以下', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('214', '8827', 'B000000214', 'uts master ', '350', '女性', '接受', '不接受', '2020-04-15', '3-6个月', '不开派对,爱美剧,吃鸡达人', '悉尼', null, '悉尼科技大学(City)', 'Carina', '13373035047', '13373035047', '935483937@qq.com', '', null, '这个人很懒什么都没有留下', '1', '15', null, '0', '1', '2020-01-03 20:44:10', '2020-01-03 20:44:10', '', '', '女生 master ', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('215', '8197', 'B000000215', 'unilodge swanston 570 ', '280', '男性', '不接受', '接受', '2020-02-10', '6-12个月', '', '墨尔本', null, '墨尔本大学 (Parkville)', '赵越', '18855170233', '18647979645', 'zhaoyue74.love@163.com', '', null, '作息正常 无不良嗜好', '1', '14', null, '0', '1', '2020-01-05 11:44:21', '2020-01-05 11:44:21', '', '', '作息正常 无不良嗜好', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('216', '6637', 'B000000216', 'Bundoora 69站步行3分钟', '169', '女性', '接受', '接受', '2020-02-08', '租期可议', '', '墨尔本', null, 'RMIT University (Bundoora)', '张家港墨尔本', '568071392', '0420680312', '568071392@qq.com', '/uploads/houses/2020011204390315787751430173.jpg', null, 'Bundoora北区86路电车69站处，townhouse三层&nbsp;4卧3卫2车位1园子招舍友一起住，可四人，目前两男一女，最好再来一女子平衡下，有合租经验定期会打扫卫生就行。2/9号可拎包入住，单磨砂窗的750/月，包网和煤气，水电share，电费随房租月初结，水费三月一结。电车去city最快可40分钟，&nbsp;家门口对面就是足球俱乐部有健身房，边上就是M80去机场方便。电车3分钟到北区rmit，附近有coles亚超饭店和工厂店购物中心;&nbsp;向南3分钟也有centre亚超快餐hotel等;&nbsp;10分钟到La&nbsp;trobe。单间有空调衣柜衣架卷帘书桌椅镜子床头柜床和床垫等等。公共区域有厨房盥洗室二楼厕所三楼浴室车库二楼大阳台等，内置东西除私人物品外基本都可共用，欢迎预约看房，有意入住需要更多图请私聊。电话不通请短信:&nbsp;0420680312，微信或QQ:&nbsp;568071392，加时请备注租房,&nbsp;谢谢大家帮忙推广。', '1', '24', null, '2', '1', '2020-01-06 07:55:02', '2020-01-12 04:39:03', '', '', 'Bundoora北区86路电车69站处，townhouse三层 4卧3卫2车位1园子招舍友一起住，可四人，目前两男一女，最好再来一女子平衡下，有合租经验定期会打扫卫生就行。2/9号可拎包入住，单磨砂窗的750/月，包网和煤气，水电share，电费随房租月初结，水费三月一结。电车去city最快可40分钟， 家门口对面就是足球俱乐部有健身房，边上就是M80去机场方便。电车3分钟到北区rmit，附近有coles亚超饭店和工厂店购物中心; 向南3分钟也有centre亚超快餐hotel等; 10分钟到La trobe。单间有空调衣柜衣架卷帘书桌椅镜子床头柜床和床垫等等。公共区域有厨房盥洗室二楼厕所三楼浴室车库二楼大阳台等，内置东西除私人物品外基本都可共用，欢迎预约看房，有意入住需要更多图请私聊。电话不通请短信: 0420680312，微信或QQ: 568071392，加时请备注租房, 谢谢大家帮忙推广。', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('217', '8451', 'B000000217', 'Victoria one  有房', '370', '男性', '接受', '不接受', '2020-02-15', '租期可议', '夜猫子,学渣,单身狗,懒癌患者,逗比,IT民工,天然呆', '墨尔本', null, '墨尔本大学 (Parkville)', '曾嘉', 'z740130226', '0439699531', '', '', null, 'Hawthorne二月语言班开学&nbsp;&nbsp;如果能找到同学那最好&nbsp;平时喜欢窝家里自闭&nbsp;打游戏这样子&nbsp;偶尔会学做饭', '1', '31', null, '0', '1', '2020-01-07 13:11:26', '2020-01-27 20:12:54', '', '', '想要一个女生舍友 不求洁癖只求讲卫生 摆个姑娘在家里养眼 ', '18-24岁', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('218', '5851', 'B000000218', '两房一厅找室友 bills全包', '245', '女性', '不接受', '不接受', '2020-02-10', '少于3个月', '安静,会做饭,不开派对', '墨尔本', null, '莫纳什大学 (Caulfield)', 'Jackie', 'jackie688767', '0459599863', '', '/uploads/houses/2020011310245815788822985165.jpg', null, '本人陪读妈妈，带一个读小学小朋友，现在take,了一个两房一卫unit,在mornash&nbsp;caulfield。', '1', '31', null, '0', '1', '2020-01-11 17:06:27', '2020-01-13 10:24:58', '', '', '找一位爱干净整洁，安静，无不良嗜好有爱心的室友。男女不限。房间是双人房有queen size床，书桌，三门衣柜。包水，电，网，煤气，车位。详细的可以加微信或者电话详谈。每个月租金$980.包所有bills ,拎包入住。', '30岁以上', null, null, '有房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('219', '9082', 'B000000219', '两室一卫找室友', '350', '男性', '不接受', '不接受', '2020-03-01', '3-6个月', '不开派对,会做饭,逗比,天然呆,爱美剧,吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', 'Vince', 'w42d777', '15051712333', '', '', null, '作息规律，安静。以日常学习为主。', '1', '18', null, '1', '1', '2020-01-18 12:37:51', '2020-01-18 12:37:51', '', '', '希望爱干净，安静，作息正常，学习为主。', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('220', '8971', 'B000000220', '靠近墨大找室友', '350', '男性', '接受', '不接受', '2020-02-18', '租期可议', '安静', '墨尔本', null, '墨尔本大学 (Parkville)', 'loul', '79795288', null, '79795288@qq.com', '', null, '不抽烟不喝酒，轻洁癖，墨大学生', '1', '7', null, '0', '1', '2020-01-22 17:47:38', '2020-01-23 15:32:25', '', '', '男女不限，情侣不行，不在屋内抽烟', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('221', '9243', 'B000000221', 'Ct RMIT学生找室友', '350', '男性', '不接受', '接受', '2020-02-20', '6-12个月', '会做饭,安静,夜猫子', '墨尔本', null, 'RMIT University (市中心)	', '蔡卓甫', '690930944', '0478194888', '', '', null, '本人RMIT&nbsp;MLA学生，&nbsp;找室友&nbsp;&nbsp;经常不在家在学校画图所以不会有太多家里的事&nbsp;&nbsp;只求房子离学校越近越好因为总是在学校下半夜才能回家', '1', '4', null, '0', '1', '2020-01-30 19:29:28', '2020-02-01 21:05:30', '', '', '室友只要相处和谐就好啦  大家都善于沟通就ok', '24-30岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('222', '1431', 'B000000222', 'city，墨大，rmit，couple找合租', '350', '女性', '接受', '不接受', '2020-03-01', '租期可议', '会做饭,安静,不开派对,吃货一枚', '墨尔本', null, '墨尔本大学 (Parkville)', 'Megan', '870750108', null, '', '', null, '墨大商科女，rmit设计男couple. 会煮饭，好说话，爱干净', '1', '2', null, '0', '1', '2020-02-08 13:04:54', '2020-02-08 13:04:54', '', '', '相处得来即可，无太大要求', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);
INSERT INTO `tk_roommates` VALUES ('223', '9450', 'B000000223', 'cau city south Yarra 附近', '300', '女性', '不接受', '接受', '2020-03-01', '租期可议', '安静,爱运动,不开派对', '墨尔本', null, '莫纳什大学 (Caulfield)', 'nicole', 'xx867186808', null, '', '', null, '找女生室友 不带人回家过夜(女性朋友偶尔当然可以)，爱干净，喜欢运动。', '1', '3', null, '0', '1', '2020-02-15 17:16:26', '2020-02-15 17:16:26', '', '', '爱干净，不带人过夜。', '18-24岁', null, null, '无房', '', '0000-00-00 00:00:00', null);

-- ----------------------------
-- Table structure for `tk_user`
-- ----------------------------
DROP TABLE IF EXISTS `tk_user`;
CREATE TABLE `tk_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(256) DEFAULT NULL,
  `unionid` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `avaurl` varchar(255) DEFAULT NULL COMMENT '头像',
  `tel` varchar(11) DEFAULT NULL,
  `wchat` varchar(255) DEFAULT NULL COMMENT '微信号',
  `real_name` varchar(100) DEFAULT NULL COMMENT '姓名',
  `email` varchar(100) DEFAULT NULL,
  `count` int(11) DEFAULT '0' COMMENT '收藏房源数',
  `status` tinyint(3) DEFAULT '0' COMMENT '0：用户；1：房东',
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `topavailable` int(11) DEFAULT '15',
  `sex` varchar(255) DEFAULT NULL COMMENT '性别',
  `birth` date DEFAULT NULL COMMENT '生日',
  `spec` text COMMENT '简介，个性签名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tk_user
-- ----------------------------

-- ----------------------------
-- Table structure for `xcx_banner`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_banner`;
CREATE TABLE `xcx_banner` (
  `b_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_title` varchar(255) DEFAULT NULL COMMENT '广告标题',
  `b_cover` text COMMENT '封面图',
  `b_type` tinyint(255) DEFAULT NULL COMMENT '跳转类型：1，站内；2外部公众号；3别的小程序',
  `b_url` varchar(255) DEFAULT NULL COMMENT '跳转地址',
  `b_status` tinyint(1) DEFAULT NULL COMMENT '状态：1正常；2下线',
  `b_add_time` datetime DEFAULT NULL COMMENT '添加时间',
  `b_update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `b_admin` int(11) DEFAULT NULL COMMENT '操作管理员',
  PRIMARY KEY (`b_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of xcx_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `xcx_collect`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_collect`;
CREATE TABLE `xcx_collect` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏id',
  `cl_user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `cl_house_id` int(11) DEFAULT NULL COMMENT 'type= 1 房源id ； type = 2 找室友id',
  `cl_addtime` datetime DEFAULT NULL COMMENT '收藏时间',
  `cl_type` tinyint(1) DEFAULT NULL COMMENT '收藏类型：1房源：2找室友id',
  PRIMARY KEY (`cl_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=FIXED COMMENT='收藏表';

-- ----------------------------
-- Records of xcx_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `xcx_helpme`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_helpme`;
CREATE TABLE `xcx_helpme` (
  `h_id` int(11) NOT NULL AUTO_INCREMENT,
  `h_phone` varchar(255) DEFAULT NULL COMMENT '电话',
  `h_wechat` varchar(255) DEFAULT NULL COMMENT '微信',
  `h_price_min` varchar(255) DEFAULT NULL COMMENT '预算最小价格',
  `h_price_max` varchar(255) DEFAULT NULL COMMENT '预算最大价格',
  `h_house_type` varchar(255) DEFAULT NULL COMMENT '租房类型',
  `h_house_style` varchar(255) DEFAULT NULL COMMENT '租房方式',
  `h_room_type` varchar(255) DEFAULT NULL COMMENT '居室',
  `h_regin` varchar(255) DEFAULT NULL COMMENT '租房区域',
  `h_need` varchar(255) DEFAULT NULL COMMENT '租房需求',
  `h_addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `h_is_review` tinyint(1) DEFAULT NULL COMMENT '是否回访：1是；2否',
  `h_review` text COMMENT '回访内容',
  `h_admin` int(10) DEFAULT NULL COMMENT '回访管理员',
  PRIMARY KEY (`h_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='帮我找房';

-- ----------------------------
-- Records of xcx_helpme
-- ----------------------------

-- ----------------------------
-- Table structure for `xcx_loop_msg`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_loop_msg`;
CREATE TABLE `xcx_loop_msg` (
  `lm_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播信息表id',
  `lm_title` varchar(255) DEFAULT NULL COMMENT '轮播text',
  `lm_ add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`lm_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='轮播信息表';

-- ----------------------------
-- Records of xcx_loop_msg
-- ----------------------------
INSERT INTO `xcx_loop_msg` VALUES ('1', '轻言微语正在找房。', '2020-03-05 14:22:55');
INSERT INTO `xcx_loop_msg` VALUES ('2', 'snowLi正在找室友。', '2020-03-06 14:23:34');
INSERT INTO `xcx_loop_msg` VALUES ('3', '张凯正在寻找墨尔本大学附近2室一厅', '2020-03-05 14:55:14');
INSERT INTO `xcx_loop_msg` VALUES ('4', '萌萌正在寻找墨尔本大学附近3室一厅', '2020-03-05 14:55:43');
INSERT INTO `xcx_loop_msg` VALUES ('5', '舒淇正在寻找墨尔本大学附近3室一厅', '2020-03-26 14:56:48');

-- ----------------------------
-- Table structure for `xcx_search_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_search_keywords`;
CREATE TABLE `xcx_search_keywords` (
  `sk_id` int(11) NOT NULL AUTO_INCREMENT,
  `sk_keywords` varchar(255) DEFAULT NULL COMMENT '搜索关键词',
  `sk_userid` int(11) DEFAULT NULL COMMENT '用户id',
  `sk_type` varchar(255) DEFAULT NULL COMMENT '搜索类型：1房源：2找室友',
  PRIMARY KEY (`sk_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of xcx_search_keywords
-- ----------------------------

-- ----------------------------
-- Table structure for `xcx_view_history`
-- ----------------------------
DROP TABLE IF EXISTS `xcx_view_history`;
CREATE TABLE `xcx_view_history` (
  `vh_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '浏览历史',
  `vh_userid` int(11) DEFAULT NULL COMMENT '用户id',
  `vh_house_id` int(11) DEFAULT NULL COMMENT '房源id或找室友id',
  `vh_type` tinyint(255) DEFAULT NULL COMMENT '浏览类型1房源；2找室友',
  `vh_add_time` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`vh_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=FIXED COMMENT='浏览历史表';

-- ----------------------------
-- Records of xcx_view_history
-- ----------------------------
