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
  `ab_round_id` int(11) DEFAULT NULL,
  `ab_text` varchar(100) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
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
  `condition_value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conditions`
--

LOCK TABLES `conditions` WRITE;
/*!40000 ALTER TABLE `conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `conditions` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
  CONSTRAINT `text_blocks_FK` FOREIGN KEY (`tb_condition_1_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `text_blocks_FK_1` FOREIGN KEY (`tb_condition_2_id`) REFERENCES `conditions` (`condition_id`),
  CONSTRAINT `text_blocks_FK_2` FOREIGN KEY (`tb_auto_set`) REFERENCES `conditions` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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

-- Dump completed on 2020-12-16 20:08:01
