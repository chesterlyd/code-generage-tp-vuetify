/*
 Navicat Premium Data Transfer

 Source Server         : 
 Source Server Type    : MySQL
 Source Server Version : 50734
 Source Host           : 
 Source Schema         : 

 Target Server Type    : MySQL
 Target Server Version : 50734
 File Encoding         : 65001

 Date: 11/11/2021 17:44:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account` varchar(128) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `is_disable` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否禁用',
  `create_operator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `delete_time` int(10) unsigned DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `accountUnique` (`account`) USING BTREE,
  KEY `admin_create_time_index` (`create_time`) USING BTREE,
  KEY `admin_delete_time_index` (`delete_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='后台 —— 管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES (1, 'admin', '$2y$10$jZFrrO1c5FCYwDOGMETEiuOHvDBxcqJOjWr/qRs2pM2eIrHpan8Oe', '管理员', 2, 0, 1550059258, 1633764876, NULL);
COMMIT;

-- ----------------------------
-- Table structure for auth_group
-- ----------------------------
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(2048) NOT NULL DEFAULT '',
  `create_operator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='后台 —— 用户组';

-- ----------------------------
-- Records of auth_group
-- ----------------------------
BEGIN;
INSERT INTO `auth_group` VALUES (1, '管理员', 1, '', 0);
COMMIT;

-- ----------------------------
-- Table structure for auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (
  `uid` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台 —— 用户组权限';

-- ----------------------------
-- Records of auth_group_access
-- ----------------------------
BEGIN;
INSERT INTO `auth_group_access` VALUES (1, 1);
COMMIT;

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '父级id',
  `name` varchar(80) NOT NULL COMMENT '节点',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pid` int(10) unsigned DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `condition` varchar(1024) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COMMENT='后台 —— 权限';

SET FOREIGN_KEY_CHECKS = 1;
