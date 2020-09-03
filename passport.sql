CREATE DATABASE passport DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `t_passport_role`;
CREATE TABLE `t_passport_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '超级管理员 {0：否；1：是；}',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 {-1：删除；1：正常；}',
  `sort` int(10) NOT NULL DEFAULT '99' COMMENT '排序（正序）',
  `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

DROP TABLE IF EXISTS `t_passport_user`;
CREATE TABLE `t_passport_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `position` varchar(50) NOT NULL DEFAULT '' COMMENT '职位',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 {-1：删除；1：正常；}',
  `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_email` (`email`),
  KEY `idx_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员表';

DROP TABLE IF EXISTS `t_passport_menu`;
CREATE TABLE `t_passport_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '父级ID {0：顶级菜单；}',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url` varchar(50) NOT NULL DEFAULT '' COMMENT '路由',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 {-1：删除；1：正常；}',
  `sort` int(10) NOT NULL DEFAULT '99' COMMENT '排序（正序）',
  `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='菜单表';

DROP TABLE IF EXISTS `t_passport_permission`;
CREATE TABLE `t_passport_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `url` varchar(2000) NOT NULL DEFAULT '' COMMENT '路由（多个之间用英文逗号隔开）',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 {-1：删除；1：正常；}',
  `sort` int(10) NOT NULL DEFAULT '99' COMMENT '排序（正序）',
  `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

DROP TABLE IF EXISTS `t_passport_role_permission`;
CREATE TABLE `t_passport_role_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `role_id` int(10) unsigned NOT NULL COMMENT '角色ID',
  `permission_id` int(10) unsigned NOT NULL COMMENT '权限ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 {-1：删除；1：正常；}',
  `mtime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `ctime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表';