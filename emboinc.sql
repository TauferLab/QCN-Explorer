-- MySQL dump 10.13  Distrib 5.1.66, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: emboinc
-- ------------------------------------------------------
-- Server version	5.1.66

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
-- Table structure for table `instances`
--

DROP TABLE IF EXISTS `instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `busy` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instances`
--

LOCK TABLES `instances` WRITE;
/*!40000 ALTER TABLE `instances` DISABLE KEYS */;
INSERT INTO `instances` VALUES (1,0),(2,0),(3,0);
/*!40000 ALTER TABLE `instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sim_ID` int(11) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `running` tinyint(1) NOT NULL DEFAULT '0',
  `submit_time` datetime NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `complete_time` datetime DEFAULT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `user_trace` text,
  `wu_trace` text,
  `debug` tinyint(1) DEFAULT NULL,
  `verbose` tinyint(1) NOT NULL DEFAULT '0',
  `rand_num_seed` int(11) DEFAULT NULL,
  `cuttime` int(11) DEFAULT NULL,
  `sim_start_time` int(11) DEFAULT NULL,
  `trickle_ups` tinyint(1) NOT NULL DEFAULT '1',
  `description` text,
  `perfect_hosts` tinyint(1) NOT NULL,
  `weibull` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (2,3,1,0,'2012-05-17 11:08:30','2012-05-23 13:55:09','2012-05-23 13:55:39',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(3,3,1,0,'2012-05-17 11:08:38','2012-05-23 13:55:10','2012-05-23 13:55:40',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(4,3,1,0,'2012-05-17 11:09:06','2012-05-23 13:55:11','2012-05-23 13:55:41',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(5,3,1,0,'2012-05-17 11:09:07','2012-05-23 13:57:01','2012-05-23 13:57:31',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(6,3,1,0,'2012-05-17 11:09:07','2012-05-23 13:57:02','2012-05-23 13:57:32',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(7,3,1,0,'2012-05-17 11:09:07','2012-05-23 13:57:03','2012-05-23 13:57:33',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(8,3,1,0,'2012-05-17 11:09:08','2012-05-23 13:58:50','2012-05-23 13:59:20',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(9,3,1,0,'2012-05-17 11:09:08','2012-05-23 13:58:51','2012-05-23 13:59:21',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(10,3,1,0,'2012-05-17 11:09:08','2012-05-23 13:58:52','2012-05-23 13:59:22',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(11,3,1,0,'2012-05-17 11:09:08','2012-05-23 14:00:12','2012-05-23 14:00:42',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(12,3,1,0,'2012-05-17 11:09:09','2012-05-23 14:00:13','2012-05-23 14:00:43',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(13,3,1,0,'2012-05-17 11:09:09','2012-05-23 14:00:14','2012-05-23 14:00:44',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(14,3,1,0,'2012-05-17 11:09:09','2012-05-23 14:01:06','2012-05-23 14:01:21',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(15,3,1,0,'2012-05-23 14:03:03','2012-05-23 14:03:17','2012-05-23 14:03:32',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(16,3,1,0,'2012-05-23 14:03:03','2012-05-23 14:03:18','2012-05-23 14:03:33',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(17,3,1,0,'2012-05-23 14:03:03','2012-05-23 14:03:19','2012-05-23 14:03:34',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(18,3,1,0,'2012-05-23 14:03:04','2012-05-23 14:06:04','2012-05-23 14:06:19',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(19,3,1,0,'2012-05-23 14:03:04','2012-05-23 14:06:05','2012-05-23 14:06:20',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(20,3,1,0,'2012-05-23 14:03:04','2012-05-23 14:06:06','2012-05-23 14:06:21',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(21,3,1,0,'2012-05-23 14:03:04','2012-05-23 14:07:15','2012-05-23 14:07:30',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(22,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:07:16','2012-05-23 14:07:31',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(23,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:07:17','2012-05-23 14:07:32',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(24,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:09:50','2012-05-23 14:10:05',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(25,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:09:51','2012-05-23 14:10:06',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(26,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:09:52','2012-05-23 14:10:07',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(27,3,1,0,'2012-05-23 14:03:05','2012-05-23 14:19:40','2012-05-23 14:19:55',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(28,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:22:55','2012-05-23 14:22:56',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(29,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:23:09','2012-05-23 14:23:10',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(30,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:23:10','2012-05-23 14:23:11',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(31,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:24:36','2012-05-23 14:24:37',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(32,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:24:37','2012-05-23 14:24:38',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(33,3,1,0,'2012-05-23 14:03:06','2012-05-23 14:34:44','2012-05-23 14:34:45',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(34,3,1,0,'2012-05-23 14:34:50','2012-05-23 14:34:59','2012-05-23 14:35:00',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(35,3,1,0,'2012-05-23 14:34:51','2012-05-23 14:35:00','2012-05-23 14:35:01',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(36,3,1,0,'2012-05-23 14:34:51','2012-05-23 14:36:12','2012-05-23 14:36:13',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(37,3,1,0,'2012-05-23 14:34:51','2012-05-23 14:36:13','2012-05-23 14:36:14',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(38,3,1,0,'2012-05-23 14:34:52','2012-05-23 14:36:54','2012-05-23 14:36:55',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(39,3,1,0,'2012-05-23 14:34:53','2012-05-23 14:36:55','2012-05-23 14:36:56',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(40,3,1,0,'2012-05-23 14:34:53','2012-05-23 14:37:14','2012-05-23 14:37:15',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(41,3,1,0,'2012-05-23 14:34:54','2012-05-23 14:37:15','2012-05-23 14:37:16',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(42,3,1,0,'2012-05-23 14:34:54','2012-05-23 14:37:43','2012-05-23 14:37:44',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(43,3,1,0,'2012-05-23 14:34:55','2012-05-23 14:37:44','2012-05-23 14:37:45',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(44,3,0,0,'2012-05-23 14:34:55',NULL,NULL,0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(45,3,0,0,'2012-05-23 14:34:56',NULL,NULL,0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(46,3,0,0,'2012-05-23 14:34:57',NULL,NULL,0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(47,4,0,0,'2012-06-29 11:56:08',NULL,NULL,0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulations`
--

DROP TABLE IF EXISTS `simulations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `simulations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `save_time` datetime NOT NULL,
  `owner` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `user_trace` text,
  `wu_trace` text,
  `debug` tinyint(1) DEFAULT NULL,
  `verbose` tinyint(1) NOT NULL DEFAULT '0',
  `rand_num_seed` int(11) DEFAULT NULL,
  `cuttime` int(11) DEFAULT NULL,
  `sim_start_time` int(11) DEFAULT NULL,
  `trickle_ups` tinyint(1) NOT NULL DEFAULT '1',
  `description` text,
  `perfect_hosts` tinyint(1) NOT NULL,
  `weibull` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulations`
--

LOCK TABLES `simulations` WRITE;
/*!40000 ALTER TABLE `simulations` DISABLE KEYS */;
INSERT INTO `simulations` VALUES (1,'2012-05-16 13:10:24',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(2,'2012-05-16 13:10:53',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(3,'2012-05-16 13:14:11',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(4,'2012-06-29 11:56:06',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0),(5,'0000-00-00 00:00:00',0,'somethingorother','USERTRACE','WORKUNITTRACE',0,0,0,30,0,1,'',0,0);
/*!40000 ALTER TABLE `simulations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userCake_Groups`
--

DROP TABLE IF EXISTS `userCake_Groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userCake_Groups` (
  `Group_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Group_Name` varchar(225) NOT NULL,
  PRIMARY KEY (`Group_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userCake_Groups`
--

LOCK TABLES `userCake_Groups` WRITE;
/*!40000 ALTER TABLE `userCake_Groups` DISABLE KEYS */;
INSERT INTO `userCake_Groups` VALUES (1,'Standard User');
/*!40000 ALTER TABLE `userCake_Groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userCake_Users`
--

DROP TABLE IF EXISTS `userCake_Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userCake_Users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(150) NOT NULL,
  `Username_Clean` varchar(150) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `ActivationToken` varchar(225) NOT NULL,
  `LastActivationRequest` int(11) NOT NULL,
  `LostPasswordRequest` int(1) NOT NULL DEFAULT '0',
  `Active` int(1) NOT NULL,
  `Group_ID` int(11) NOT NULL,
  `SignUpDate` int(11) NOT NULL,
  `LastSignIn` int(11) NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userCake_Users`
--

LOCK TABLES `userCake_Users` WRITE;
/*!40000 ALTER TABLE `userCake_Users` DISABLE KEYS */;
INSERT INTO `userCake_Users` VALUES (1,'admin','admin','eabde3600683cd332afa4edd144cdf9b999e031ef7a298d0c240a6dff8bb7d34c','sam@udel.edu','4fd9c7ba4b830ca7eb214e32ce756c61',1334686462,0,1,1,1334686462,1334686476);
/*!40000 ALTER TABLE `userCake_Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-01-31 13:30:12
