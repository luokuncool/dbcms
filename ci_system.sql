-- MySQL dump 10.13  Distrib 5.5.17, for Win32 (x86)
--
-- Host: localhost    Database: ci_system
-- ------------------------------------------------------
-- Server version	5.5.17

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `group_id` int(3) NOT NULL DEFAULT '-1' COMMENT '分组id',
  `reg_time` int(10) NOT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `login_times` int(4) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_sid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_time` int(10) DEFAULT NULL,
  `active_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','luokun',NULL,'b269ef79ec23d1693e2ac529868ff72d','1',1,0,1406633549,9,'0.0.0.0','89e0dcdd85b843bd3799c5ce7e38579d',1406633549,'bf0b38c7ab2a38b38f4f66275d55eca9'),(2,'luokuncool','诚实的小猴子','1907148656@qq.com','b269ef79ec23d1693e2ac529868ff72d','1',1,1406642264,1406785798,5,'127.0.0.1','7bba82379444054d47ad31bdcbe04351',1406785798,'b4f4ecf1533c1daab8960d2747270856'),(4,'test','admin88','1917148656@qq.com','b269ef79ec23d1693e2ac529868ff72d','1',1,1406688568,NULL,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group`
--

DROP TABLE IF EXISTS `admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `purview_key` text COLLATE utf8_unicode_ci,
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group`
--

LOCK TABLES `admin_group` WRITE;
/*!40000 ALTER TABLE `admin_group` DISABLE KEYS */;
INSERT INTO `admin_group` VALUES (1,'超级管理员','a:27:{i:0;s:1:\"1\";i:1;s:2:\"25\";i:2;s:1:\"2\";i:3;s:1:\"5\";i:4;s:1:\"6\";i:5;s:1:\"7\";i:6;s:1:\"8\";i:7;s:1:\"4\";i:8;s:1:\"3\";i:9;s:1:\"9\";i:10;s:2:\"12\";i:11;s:2:\"14\";i:12;s:2:\"15\";i:13;s:2:\"16\";i:14;s:2:\"17\";i:15;s:2:\"18\";i:16;s:2:\"19\";i:17;s:2:\"10\";i:18;s:2:\"11\";i:19;s:2:\"26\";i:20;s:2:\"27\";i:21;s:2:\"28\";i:22;s:2:\"29\";i:23;s:2:\"30\";i:24;s:2:\"31\";i:25;s:2:\"20\";i:26;s:2:\"21\";}','超级管理员'),(2,'副管理员','a:18:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";i:7;s:1:\"8\";i:8;s:1:\"9\";i:9;s:2:\"12\";i:10;s:2:\"14\";i:11;s:2:\"15\";i:12;s:2:\"16\";i:13;s:2:\"17\";i:14;s:2:\"18\";i:15;s:2:\"19\";i:16;s:2:\"10\";i:17;s:2:\"11\";}','');
/*!40000 ALTER TABLE `admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) NOT NULL,
  `menu_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sequence` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `router_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FOREIGN` (`admin_id`),
  CONSTRAINT `ForeignKey` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (20,1,'密码修改','/admin/index/change_password',255,20),(22,1,'站点信息','/admin/index/site_info',255,1),(23,1,'资料修改','/admin/index/self_info',255,21),(24,1,'添加管理员','/admin/admin/add_admin',255,18),(25,1,'添加分类','/admin/article/add_sort',255,2),(26,1,'分类列表','/admin/article/sort_list',255,5),(27,1,'添加文章','/admin/article/add_article',255,4),(28,1,'文章列表','/admin/article/index',255,3),(29,1,'管理组列表','/admin/admin/group_list',255,9),(30,1,'添加管理组','/admin/admin/add_group',255,12),(31,1,'管理员列表','/admin/admin/admin_list',255,16),(32,1,'链接列表','/admin/link/index',255,32),(33,1,'添加链接','/admin/link/add_link',255,35);
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_router`
--

DROP TABLE IF EXISTS `admin_router`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `directory` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `side_menu` tinyint(1) NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `menu_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `purview_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '其它',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_router`
--

LOCK TABLES `admin_router` WRITE;
/*!40000 ALTER TABLE `admin_router` DISABLE KEYS */;
INSERT INTO `admin_router` VALUES (1,'admin/','index','site_info',1,0,'站点信息','站点信息','系统管理'),(2,'admin/','article','add_sort',1,1,'添加分类','添加分类','文章管理'),(3,'admin/','article','index',1,7,'文章列表','文章列表','文章管理'),(4,'admin/','article','add_article',1,6,'添加文章','添加文章','文章管理'),(5,'admin/','article','sort_list',1,2,'分类列表','分类列表','文章管理'),(6,'admin/','article','sequence_sort',0,3,'分类排序','分类排序','文章管理'),(7,'admin/','article','delete_sort',0,4,'删除分类','删除分类','文章管理'),(8,'admin/','article','edit_sort',0,5,'编辑分类','编辑分类','文章管理'),(9,'admin/','admin','group_list',1,0,'管理组列表','查看管理组','管理员'),(10,'admin/','index','logout',0,0,'admin/index/logout','退出登录','其它'),(11,'admin/','index','clear_cache',0,0,'admin/index/clear_cache','清空缓存','其它'),(12,'admin/','admin','add_group',1,0,'添加管理组','添加管理组','管理员'),(14,'admin/','admin','edit_group',0,0,'admin/admin/edit_group','编辑管理组','管理员'),(15,'admin/','admin','delete_group',0,0,'admin/admin/delete_group','删除管理组','管理员'),(16,'admin/','admin','admin_list',1,0,'管理员列表','查看管理员','管理员'),(17,'admin/','admin','delete_admin',0,0,'admin/admin/delte_admin','删除管理员','管理员'),(18,'admin/','admin','add_admin',1,0,'添加管理员','添加管理员','管理员'),(19,'admin/','admin','edit_admin',0,0,'admin/admin/edit_admin','编辑管理员','管理员'),(20,'admin/','index','change_password',1,0,'密码修改','密码修改','个人中心'),(21,'admin/','index','self_info',1,0,'资料修改','资料修改','个人中心'),(25,'admin/','article','delete_article',0,0,'admin/article/delete_article','删除文章','文章管理'),(26,'admin/','admin_menu','delete_menu',0,0,'admin/admin_menu/delete_menu','删除常用菜单','其它'),(27,'admin/','admin_menu','add_menu',0,0,'admin/admin_menu/add_menu','添加常用菜单','其它'),(28,'admin/','admin_menu','menu_list',0,0,'admin/admin_menu/menu_list','查看常用菜单','其它'),(29,'admin/','admin_menu','sequence_menu',0,0,'admin/admin_menu/sequence_menu','排序常用菜单','其它'),(30,'admin/','article','edit_article',0,0,'admin/article/edit_article','编辑文章','其它'),(31,'admin/','admin_menu','edit_menu',0,0,'admin/admin_menu/edit_menu','编辑常用菜单','其它'),(32,'admin/','link','index',1,0,'链接列表','链接列表','网站链接'),(35,'admin/','link','add_link',1,0,'添加链接','添加链接','网站链接'),(36,'admin/','link','edit_link',0,0,'编辑链接','编辑链接','网站链接'),(39,'admin/','link','delete_link',0,0,'admin/link/delete_link','删除链接','网站链接');
/*!40000 ALTER TABLE `admin_router` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `article_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `sort_id` int(3) NOT NULL DEFAULT '1',
  `article_pic` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '????',
  `add_time` int(10) NOT NULL,
  `click_number` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (55,'百外卖订餐门户 完工验收中','1',0,16,NULL,'<img src=\"/upload_files/image/20140730/20140730160252_56818.gif\" alt=\"\" />',NULL,1406707445,0);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_sort`
--

DROP TABLE IF EXISTS `article_sort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_sort` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `alias` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` int(3) NOT NULL DEFAULT '0',
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_sort`
--

LOCK TABLES `article_sort` WRITE;
/*!40000 ALTER TABLE `article_sort` DISABLE KEYS */;
INSERT INTO `article_sort` VALUES (16,'默认分类','1',0,'default',0,'默认分类');
/*!40000 ALTER TABLE `article_sort` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `sort_id` int(3) NOT NULL DEFAULT '1',
  `link_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `link_pic` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '????',
  `add_time` int(10) NOT NULL,
  `click_number` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'新浪','1',0,1,'http://www.sina.com','','',NULL,1406793780,0),(2,'百度','1',0,1,'http://www.baidu.com','','',NULL,1406793926,0),(3,'腾讯网','1',0,1,'http://www.qq.com','','',NULL,1406793955,0);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_sort`
--

DROP TABLE IF EXISTS `link_sort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link_sort` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `sequence` int(3) NOT NULL DEFAULT '0',
  `alias` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`,`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_sort`
--

LOCK TABLES `link_sort` WRITE;
/*!40000 ALTER TABLE `link_sort` DISABLE KEYS */;
INSERT INTO `link_sort` VALUES (1,'文字友情连接','1',0,0,'文字友情连接','文字友情连接'),(2,'图片友情链接','1',0,0,'图片友情链接','图片友情链接');
/*!40000 ALTER TABLE `link_sort` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'文章标题','test','文章内容'),(2,'标题','','内容'),(3,'文章添加','','新闻添加'),(4,'文章添加','','新闻添加'),(5,'0','','0');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site`
--

DROP TABLE IF EXISTS `site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `site_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellphone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icp` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `third_code` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site`
--

LOCK TABLES `site` WRITE;
/*!40000 ALTER TABLE `site` DISABLE KEYS */;
INSERT INTO `site` VALUES (1,'伯仁网络网站管理系统','http://www.boren.cn','成都伯仁网络科技有限公司','四川省 成都市 成华区 万年场 花样年花郡 9栋1002室','610056','0825-88888888','13888138888','1907148656@qq.com','ICP证0343434541号1','');
/*!40000 ALTER TABLE `site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `reg_time` int(10) NOT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `login_times` int(4) NOT NULL DEFAULT '0',
  `last_login_ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_sid` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_time` int(10) DEFAULT NULL,
  `active_token` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-01 15:55:48
