-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: wp_game_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.13-MariaDB

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
-- Table structure for table `answer_blocks`
--

DROP TABLE IF EXISTS `answer_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_blocks` (
  `ab_id` int(11) NOT NULL AUTO_INCREMENT,
  `ab_round_id` int(11) NOT NULL,
  `ab_text` varchar(100) DEFAULT NULL,
  `ab_condition_1_id` int(11) DEFAULT NULL,
  `ab_condition_between` enum('A','O') DEFAULT NULL,
  `ab_condition_2_id` int(11) DEFAULT NULL,
  `ab_auto_set` int(11) DEFAULT NULL,
  `ab_unset` int(11) DEFAULT NULL,
  PRIMARY KEY (`ab_id`),
  KEY `answer_blocks_FK` (`ab_condition_1_id`),
  KEY `answer_blocks_FK_1` (`ab_condition_2_id`),
  KEY `answer_blocks_FK_2` (`ab_auto_set`),
  KEY `answer_blocks_FK_3` (`ab_unset`),
  KEY `answer_blocks_FK_4` (`ab_round_id`),
  CONSTRAINT `answer_blocks_FK` FOREIGN KEY (`ab_condition_1_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `answer_blocks_FK_1` FOREIGN KEY (`ab_condition_2_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `answer_blocks_FK_2` FOREIGN KEY (`ab_auto_set`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `answer_blocks_FK_3` FOREIGN KEY (`ab_unset`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `answer_blocks_FK_4` FOREIGN KEY (`ab_round_id`) REFERENCES `rounds` (`round_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_blocks`
--

LOCK TABLES `answer_blocks` WRITE;
/*!40000 ALTER TABLE `answer_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(120) NOT NULL,
  `category_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (23,'Central City','2020-12-17 02:14:16');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conditions`
--

DROP TABLE IF EXISTS `conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conditions` (
  `condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `condition_name` varchar(100) NOT NULL,
  PRIMARY KEY (`condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conditions`
--

LOCK TABLES `conditions` WRITE;
/*!40000 ALTER TABLE `conditions` DISABLE KEYS */;
INSERT INTO `conditions` VALUES (1,'item1'),(2,'item2'),(3,'item3'),(4,'item4'),(5,'item5'),(6,'item6'),(7,'r1a1'),(8,'r1a2'),(9,'r1a3'),(10,'r1a4'),(11,'r1a5'),(12,'r1a6'),(13,'r2a1'),(14,'r2a2'),(15,'r2a3'),(16,'r2a4'),(17,'r2a5'),(18,'r2a6'),(19,'r3a1'),(20,'r3a2'),(21,'r3a3'),(22,'r3a4'),(23,'r3a5'),(24,'r3a6'),(25,'r4a1'),(26,'r4a2'),(27,'r4a3'),(28,'r4a4'),(29,'r4a5'),(30,'r4a6'),(31,'r5a1'),(32,'r5a2'),(33,'r5a3'),(34,'r5a4'),(35,'r5a5'),(36,'r5a6'),(37,'r6a1'),(38,'r6a2'),(39,'r6a3'),(40,'r6a4'),(41,'r6a5'),(42,'r6a6'),(43,'r7a1'),(44,'r7a2'),(45,'r7a3'),(46,'r7a4'),(47,'r7a5'),(48,'r7a6'),(49,'r8a1'),(50,'r8a2'),(51,'r8a3'),(52,'r8a4'),(53,'r8a5'),(54,'r8a6'),(55,'r9a1'),(56,'r9a2'),(57,'r9a3'),(58,'r9a4'),(59,'r9a5'),(60,'r9a6'),(61,'r10a1'),(62,'r10a2'),(63,'r10a3'),(64,'r10a4'),(65,'r10a5'),(66,'r10a6'),(67,'end1'),(68,'end2'),(69,'end3'),(70,'end4'),(71,'end5'),(72,'target1'),(73,'target2'),(74,'target3'),(75,'target4'),(76,'target5'),(77,'target6');
/*!40000 ALTER TABLE `conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_conditions`
--

DROP TABLE IF EXISTS `game_conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_conditions` (
  `gc_id` int(11) NOT NULL AUTO_INCREMENT,
  `gc_game_id` int(11) DEFAULT NULL,
  `gc_condition_id` int(11) DEFAULT NULL,
  `gc_condition_type` varchar(20) NOT NULL,
  `gc_condition_value` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`gc_id`),
  KEY `game_conditions_FK_1` (`gc_game_id`),
  KEY `game_conditions_FK` (`gc_condition_id`),
  CONSTRAINT `game_conditions_FK` FOREIGN KEY (`gc_condition_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `game_conditions_FK_1` FOREIGN KEY (`gc_game_id`) REFERENCES `games` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_conditions`
--

LOCK TABLES `game_conditions` WRITE;
/*!40000 ALTER TABLE `game_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_category_id` int(11) NOT NULL,
  `game_title` varchar(255) NOT NULL,
  `game_author` varchar(100) NOT NULL,
  `game_picture` varchar(255) DEFAULT NULL,
  `game_audio` varchar(255) DEFAULT NULL,
  `game_active` enum('0','1') NOT NULL DEFAULT '1',
  `game_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`game_id`),
  KEY `games_FK` (`game_category_id`),
  CONSTRAINT `games_FK` FOREIGN KEY (`game_category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (6,23,'Title for cool Storys','marcos','https://randomwordgenerator.com/img/picture-generator/57e0d5474257a914f1dc8460962e33791c3ad6e04e5074417d2e7ed69e45cc_640.jpg','https://www.random.org/audio-noise/?channels=2&amp;volume=100&amp;rate=16000&amp;size=8&amp;date=2020-12-16&amp;format=wav&amp;deliver=browser','1','2020-12-17 02:15:05'),(7,23,'Title for another cool Story','Jack','https://randomwordgenerator.com/img/picture-generator/52e4d1424f5aa914f1dc8460962e33791c3ad6e04e5074417d2e72d2954ac5_640.jpg','https://www.random.org/audio-noise/?channels=2&amp;volume=100&amp;rate=16000&amp;size=8&amp;date=2020-12-16&amp;format=wav&amp;deliver=browser','1','2020-12-17 02:16:04');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rounds`
--

DROP TABLE IF EXISTS `rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rounds` (
  `round_id` int(11) NOT NULL AUTO_INCREMENT,
  `round_game_id` int(11) NOT NULL,
  `round_number` int(11) NOT NULL,
  PRIMARY KEY (`round_id`),
  KEY `rounds_FK` (`round_game_id`),
  CONSTRAINT `rounds_FK` FOREIGN KEY (`round_game_id`) REFERENCES `games` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rounds`
--

LOCK TABLES `rounds` WRITE;
/*!40000 ALTER TABLE `rounds` DISABLE KEYS */;
/*!40000 ALTER TABLE `rounds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `text_blocks`
--

DROP TABLE IF EXISTS `text_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `text_blocks` (
  `tb_id` int(11) NOT NULL AUTO_INCREMENT,
  `tb_round_id` int(11) NOT NULL,
  `tb_text` varchar(100) DEFAULT NULL,
  `tb_condition_1_id` int(11) DEFAULT NULL,
  `tb_condition_between` enum('A','O') DEFAULT NULL,
  `tb_condition_2_id` int(11) DEFAULT NULL,
  `tb_auto_set` int(11) DEFAULT NULL,
  PRIMARY KEY (`tb_id`),
  KEY `text_blocks_FK` (`tb_condition_1_id`),
  KEY `text_blocks_FK_1` (`tb_condition_2_id`),
  KEY `text_blocks_FK_2` (`tb_auto_set`),
  KEY `text_blocks_FK_3` (`tb_round_id`),
  CONSTRAINT `text_blocks_FK` FOREIGN KEY (`tb_condition_1_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `text_blocks_FK_1` FOREIGN KEY (`tb_condition_2_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `text_blocks_FK_2` FOREIGN KEY (`tb_auto_set`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `text_blocks_FK_3` FOREIGN KEY (`tb_round_id`) REFERENCES `rounds` (`round_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `text_blocks`
--

LOCK TABLES `text_blocks` WRITE;
/*!40000 ALTER TABLE `text_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `text_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'wp_game_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-27  6:55:38
