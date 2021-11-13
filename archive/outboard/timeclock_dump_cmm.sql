-- MySQL dump 10.11
--
-- Host: localhost    Database: timeclock
-- ------------------------------------------------------
-- Server version	5.0.67-0ubuntu6

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
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `audit` (
  `modified_by_ip` varchar(39) NOT NULL default '',
  `modified_by_user` varchar(50) NOT NULL default '',
  `modified_when` bigint(14) NOT NULL,
  `modified_from` bigint(14) NOT NULL,
  `modified_to` bigint(14) NOT NULL,
  `modified_why` varchar(250) NOT NULL default '',
  `user_modified` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`modified_when`),
  UNIQUE KEY `modified_when` (`modified_when`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbversion`
--

DROP TABLE IF EXISTS `dbversion`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `dbversion` (
  `dbversion` decimal(5,1) NOT NULL default '0.0',
  PRIMARY KEY  (`dbversion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `dbversion`
--

LOCK TABLES `dbversion` WRITE;
/*!40000 ALTER TABLE `dbversion` DISABLE KEYS */;
INSERT INTO `dbversion` VALUES ('1.4');
/*!40000 ALTER TABLE `dbversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `employees` (
  `empfullname` varchar(50) NOT NULL default '',
  `tstamp` bigint(14) default NULL,
  `employee_passwd` varchar(25) NOT NULL default '',
  `displayname` varchar(50) NOT NULL default '',
  `email` varchar(75) NOT NULL default '',
  `groups` varchar(50) NOT NULL default '',
  `office` varchar(50) NOT NULL default '',
  `admin` tinyint(1) NOT NULL default '0',
  `reports` tinyint(1) NOT NULL default '0',
  `time_admin` tinyint(1) NOT NULL default '0',
  `disabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`empfullname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES ('admin',NULL,'xyOOcl2V/Cocg','administrator','it@spindletopoil.com','Office Employees','Spindletop',1,1,1,0),('cmiller',1429225374,'xyA6RtyA9oFUk','Cody Miller','cmiller@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('jzalazar',1429046643,'xyVSuHLjceD92','Jorge Zalazar','jzalazar@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('falao',1429045649,'xyVSuHLjceD92','Farida Alao','falao@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('abarajaz',1429045621,'xyVSuHLjceD92','Amanda Barajaz','abarajaz@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('mboos',1429045667,'xyVSuHLjceD92','Michael Boos','mboos@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('bcasey',1429045639,'xyVSuHLjceD92','Brice Casey','bcasey@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('bchambliss',1429045632,'xyVSuHLjceD92','Bret Chambliss','bchambliss@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('dchivvis',1429045643,'xyVSuHLjceD92','Dave Chivvis','dchivvis@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('bcorbin',1429046671,'xyVSuHLjceD92','Bob Corbin','bcorbin@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('wcrick',1429045672,'xyVSuHLjceD92','Wendi Crick','wcrick@spindletopoil.com','Office Employees','Spindletop',0,0,0,0),('jfinley',1429045663,'xyVSuHLjceD92','Joseph Finley','jfinley@spindletopoil.com','Office Employees','Spindletop',0,0,0,0);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `groups` (
  `groupname` varchar(50) NOT NULL default '',
  `groupid` int(10) NOT NULL auto_increment,
  `officeid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES ('Office Employees',1,1);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `info` (
  `fullname` varchar(50) NOT NULL default '',
  `inout` varchar(50) NOT NULL default '',
  `timestamp` bigint(14) default NULL,
  `notes` varchar(250) default NULL,
  `ipaddress` varchar(39) NOT NULL default '',
  KEY `fullname` (`fullname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `info`
--

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
INSERT INTO `info` VALUES ('cmiller','in',1429045121,'','192.168.1.146'),('jzalazar','in',1429045137,'this is a test note.','192.168.1.146'),('cmiller','out',1429045353,'','192.168.1.146'),('cmiller','in',1429045360,'','192.168.1.146'),('abarajaz','in',1429045621,'','192.168.1.146'),('bcorbin','in',1429045628,'','192.168.1.146'),('bchambliss','in',1429045632,'','192.168.1.146'),('bcasey','in',1429045639,'','192.168.1.146'),('dchivvis','break',1429045643,'','192.168.1.146'),('falao','out',1429045649,'','192.168.1.146'),('jzalazar','in',1429045659,'','192.168.1.146'),('jfinley','in',1429045663,'','192.168.1.146'),('mboos','lunch',1429045667,'','192.168.1.146'),('wcrick','out',1429045672,'','192.168.1.146'),('cmiller','out',1429045692,'this is an example note','192.168.1.146'),('jzalazar','out',1429046643,'','192.168.1.50'),('bcorbin','break',1429046671,'to lunch ','192.168.1.50'),('cmiller','in',1429131701,'test note','192.168.1.146'),('cmiller','lunch',1429225374,'otl back at 2pm','192.168.1.155');
/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metars`
--

DROP TABLE IF EXISTS `metars`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `metars` (
  `metar` varchar(255) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `station` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`station`),
  UNIQUE KEY `station` (`station`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `metars`
--

LOCK TABLES `metars` WRITE;
/*!40000 ALTER TABLE `metars` DISABLE KEYS */;
/*!40000 ALTER TABLE `metars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offices`
--

DROP TABLE IF EXISTS `offices`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `offices` (
  `officename` varchar(50) NOT NULL default '',
  `officeid` int(10) NOT NULL auto_increment,
  PRIMARY KEY  (`officeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `offices`
--

LOCK TABLES `offices` WRITE;
/*!40000 ALTER TABLE `offices` DISABLE KEYS */;
INSERT INTO `offices` VALUES ('Spindletop',1);
/*!40000 ALTER TABLE `offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `punchlist`
--

DROP TABLE IF EXISTS `punchlist`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `punchlist` (
  `punchitems` varchar(50) NOT NULL default '',
  `color` varchar(7) NOT NULL default '',
  `in_or_out` tinyint(1) default NULL,
  PRIMARY KEY  (`punchitems`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `punchlist`
--

LOCK TABLES `punchlist` WRITE;
/*!40000 ALTER TABLE `punchlist` DISABLE KEYS */;
INSERT INTO `punchlist` VALUES ('in','#009900',1),('out','#FF0000',0),('break','#FF9900',0),('lunch','#0000FF',0);
/*!40000 ALTER TABLE `punchlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-05 19:56:41
