-- MySQL dump 10.13  Distrib 5.5.28, for Win32 (x86)
--
-- Host: localhost    Database: ci_easyui_sys
-- ------------------------------------------------------
-- Server version	5.5.28-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adm_node`
--

DROP TABLE IF EXISTS `adm_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `code` varchar(30) NOT NULL COMMENT 'code',
  `name` varchar(50) NOT NULL COMMENT 'name',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'status',
  `remark` varchar(255) NOT NULL COMMENT 'remark',
  `sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT 'sort',
  `pId` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT 'pid',
  `level` tinyint(1) unsigned NOT NULL COMMENT 'level',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'type',
  `groupId` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '所属菜单组（配置文件）',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'createtime',
  `createUid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'createrid',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'updatetime',
  `updateUid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'updaterid',
  PRIMARY KEY (`id`),
  KEY `level` (`level`) USING BTREE,
  KEY `name` (`code`) USING BTREE,
  KEY `pid` (`pId`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=342 DEFAULT CHARSET=utf8 COMMENT='权限节点表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_node`
--

LOCK TABLES `adm_node` WRITE;
/*!40000 ALTER TABLE `adm_node` DISABLE KEYS */;
/*!40000 ALTER TABLE `adm_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_users`
--

DROP TABLE IF EXISTS `adm_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '当前表用户主键，并非CRM用户表主键',
  `userId` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号或大客户客户编号',
  `userType` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型 0=>员工 1=>大客户',
  `deptId` varchar(16) NOT NULL COMMENT '部门代码,并非ID',
  `isSecretary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为秘书 0=>不是 1=>秘书',
  `isCashier` tinyint(1) unsigned NOT NULL COMMENT '是否出纳',
  `code` varchar(32) NOT NULL DEFAULT '0' COMMENT '工号（用户编码）',
  `uName` varchar(32) NOT NULL COMMENT '用户名',
  `name` varchar(16) NOT NULL COMMENT '真实姓名',
  `enName` varchar(16) NOT NULL COMMENT '英文名',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 (1=正常 0=标志删除（禁用）)',
  `createTime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `createUid` int(11) unsigned NOT NULL COMMENT '创建人',
  `lastLoginTime` int(11) unsigned NOT NULL COMMENT '最后登录时间',
  `salesMan` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否统计用户业务数据',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '用户email地址',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `updateTime` int(11) unsigned NOT NULL COMMENT '用户信息更新时间',
  `pId` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2813 DEFAULT CHARSET=utf8 COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_users`
--

LOCK TABLES `adm_users` WRITE;
/*!40000 ALTER TABLE `adm_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `adm_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-06 20:04:39
