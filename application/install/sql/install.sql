/*
 Navicat Premium Data Transfer

 Source Server         : IMX
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : mysql57.rdsmavnlp4c2sa1.rds.su.baidubce.com:3306
 Source Schema         : im3

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 30/08/2018 16:25:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}admin`;
CREATE TABLE `{#pre#}admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `login_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '后台登录 用户名或手机号',
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '后台登录密码',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '账号状态:0-锁定;1-正常',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '账号类型:0-客户管理员;1-超级管理员;2-普通管理员',
  `join_time` int(11) NOT NULL COMMENT '账号创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user`(`login_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for app
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}app`;
CREATE TABLE `{#pre#}app`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'App_Key',
  `secret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'App_Secret',
  `aid` int(11) NOT NULL COMMENT '绑定管理员admin表',
  `domain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '域名',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:0-禁用;1-启用',
  `configs` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '网易配置',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '设备标识表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}apply`;
CREATE TABLE `{#pre#}apply`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '申请表id',
  `user_id` int(11) NOT NULL COMMENT '申请人用户id',
  `type` tinyint(1) NOT NULL COMMENT '申请类型1-好友;2-群组',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '申请内容',
  `created` int(11) NOT NULL COMMENT '申请时间',
  `to_id` int(11) NOT NULL COMMENT '审核方id1-用户id;2-群组id',
  `review` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '审核反馈内容',
  `updated` int(11) NOT NULL COMMENT '审核时间',
  `status` tinyint(1) NOT NULL COMMENT '审核状态0-未处理;1-同意;2-拒绝',
  `read_time` int(11) DEFAULT NULL COMMENT '已读时间,作为消息盒子的标识',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '申请表-用于好友申请 和 群组创建邀请和申请加群' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for blacklist
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}blacklist`;
CREATE TABLE `{#pre#}blacklist`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `black_user_id` int(11) NOT NULL COMMENT '黑名单用户id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户黑名单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for chat_group
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}chat_group`;
CREATE TABLE `{#pre#}chat_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送者的用户id',
  `group_id` int(11) NOT NULL COMMENT '接收群的群组id',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '群聊内容',
  `created` int(11) NOT NULL COMMENT '发送时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '群组聊天内容记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for chat_user
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}chat_user`;
CREATE TABLE `{#pre#}chat_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '发送者用户id',
  `receiver_id` int(11) NOT NULL COMMENT '接收者用户id',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送内容',
  `created` int(11) NOT NULL COMMENT '发送时间',
  `read_time` int(11) NOT NULL COMMENT '接收时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '好友聊天内容记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}files`;
CREATE TABLE `{#pre#}files`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '上传者的用户id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件名称',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件路径',
  `size` int(11) NOT NULL COMMENT '文件大小',
  `mime` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件类型',
  `is_delete` tinyint(1) DEFAULT 0 COMMENT '0为正常，1删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '上传文件/图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for group_user
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}group_user`;
CREATE TABLE `{#pre#}group_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `group_id` int(11) NOT NULL COMMENT '群组id',
  `user_id` int(11) NOT NULL COMMENT '群组成员id',
  `is_admin` int(11) NOT NULL DEFAULT 0 COMMENT '0:普通组员;1:群主;2:管理员',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `is_admin`(`is_admin`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '群组成员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}groups`;
CREATE TABLE `{#pre#}groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '群主id',
  `user_id` int(11) NOT NULL COMMENT '群主用户id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '群组名称',
  `avatar` int(11) NOT NULL COMMENT '群组头像_files_id',
  `des` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '群组描述',
  `is_group` tinyint(1) NOT NULL DEFAULT 2 COMMENT '0-解散;1-群组/[1-我的好友分组;2-群组]',
  `created` int(11) NOT NULL COMMENT '群组创建时间',
  `updated` int(11) NOT NULL COMMENT '群组更新时间(最近更新时间)',
  `team_id` int(11) NOT NULL COMMENT '第三方服务平台群组id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '群组群主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for im_version
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}im_version`;
CREATE TABLE `{#pre#}im_version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'IM版本表id',
  `aid` int(11) NOT NULL COMMENT '管理员id',
  `im_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IM版本号',
  `im_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IM显示名称',
  `im_powerby` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IM版权信息',
  `im_record` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'IM备案号',
  `im_des` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'im简介',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kefu
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}kefu`;
CREATE TABLE `{#pre#}kefu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客服表主键',
  `user_id` int(11) NOT NULL COMMENT '客服用户id',
  `seller_id` int(11) NOT NULL COMMENT '客户id,绑定users表',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '客服状态0-禁用;1-启用',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '客服类型0-商家客服;1-平台客服',
  `pwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客服密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客户创建的客服表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kefu_set
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}kefu_set`;
CREATE TABLE `{#pre#}kefu_set`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '客服设置id',
  `seller_id` int(11) NOT NULL COMMENT '商家id',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1-顺序2-随机',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kefu_wait
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}kefu_wait`;
CREATE TABLE `{#pre#}kefu_wait`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '商城会员id',
  `to_id` int(11) NOT NULL COMMENT '客服id',
  `socre` tinyint(3) NOT NULL COMMENT '0-100评分',
  `last_time` int(11) NOT NULL COMMENT '最后一次会话时间',
  `seller_id` int(11) DEFAULT 0 COMMENT '商家ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_active
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}user_active`;
CREATE TABLE `{#pre#}user_active`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `online` tinyint(1) NOT NULL COMMENT '是否在线;0-离线;1-在线;2-隐身',
  `login_ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录ip地址',
  `login_dev` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录设备',
  `last_login_time` int(11) NOT NULL COMMENT '最近一次的登录时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户活跃记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_friend
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}user_friend`;
CREATE TABLE `{#pre#}user_friend`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `friend_id` int(11) NOT NULL COMMENT '好友id',
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '好友备注信息',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户好友备注表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_profile
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}user_profile`;
CREATE TABLE `{#pre#}user_profile`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `nickname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户昵称',
  `avatar` int(11) NOT NULL COMMENT '用户头像_files_id',
  `created` int(11) NOT NULL COMMENT '用户注册时间',
  `updated` int(11) NOT NULL COMMENT '用户信息更新时间',
  `sign` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户个人签名',
  `mobile` int(11) NOT NULL COMMENT '用户手机号码',
  `sex` tinyint(1) NOT NULL COMMENT '用户性别:0-女;1-男;2-保密',
  `birthday` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户生日',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户信息汇总表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `{#pre#}users`;
CREATE TABLE `{#pre#}users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户唯一识别名称',
  `app_id` int(11) NOT NULL COMMENT '应用id',
  `status` tinyint(1) NOT NULL COMMENT '用户状态0:禁用1:启用',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户类型0-普通用户;1-后台管理员;2-客服',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '网易登录的token',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户注册表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
