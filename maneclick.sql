CREATE DATABASE  IF NOT EXISTS `maneclick` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `maneclick`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: maneclick
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `archiveslp`
--

DROP TABLE IF EXISTS `archiveslp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archiveslp` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `slpID` int(11) DEFAULT NULL,
  `slpName` varchar(50) DEFAULT NULL,
  `archivedDate` varchar(255) DEFAULT 'CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP()',
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archiveslp`
--

LOCK TABLES `archiveslp` WRITE;
/*!40000 ALTER TABLE `archiveslp` DISABLE KEYS */;
/*!40000 ALTER TABLE `archiveslp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datasheet`
--

DROP TABLE IF EXISTS `datasheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datasheet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `patientID` int(11) DEFAULT NULL,
  `slpID` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `Valid_Til` date DEFAULT NULL,
  `Eval_Date` date DEFAULT NULL,
  `Interpretation` varchar(5000) DEFAULT NULL,
  `FuncOutcome` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datasheet`
--

LOCK TABLES `datasheet` WRITE;
/*!40000 ALTER TABLE `datasheet` DISABLE KEYS */;
INSERT INTO `datasheet` VALUES (1,1,1,NULL,'2024-03-11','2024-03-11','123','456');
/*!40000 ALTER TABLE `datasheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datasheet_items`
--

DROP TABLE IF EXISTS `datasheet_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datasheet_items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DSID` int(11) DEFAULT NULL,
  `Particular` varchar(45) DEFAULT NULL,
  `promptID` int(11) DEFAULT NULL,
  `Remarks` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datasheet_items`
--

LOCK TABLES `datasheet_items` WRITE;
/*!40000 ALTER TABLE `datasheet_items` DISABLE KEYS */;
INSERT INTO `datasheet_items` VALUES (1,1,'1',1,'1'),(2,1,'1',2,'1'),(3,1,'2',NULL,'2'),(4,1,'2',NULL,'2');
/*!40000 ALTER TABLE `datasheet_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disorder`
--

DROP TABLE IF EXISTS `disorder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disorder` (
  `disorderID` int(11) NOT NULL AUTO_INCREMENT,
  `disorderName` varchar(50) DEFAULT NULL,
  `disorderDesc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`disorderID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disorder`
--

LOCK TABLES `disorder` WRITE;
/*!40000 ALTER TABLE `disorder` DISABLE KEYS */;
INSERT INTO `disorder` VALUES (1,'disorder 1','sample disorder 1'),(2,'disorder 2','sample disorder 2'),(3,'disorder 3','sample disorder 3'),(4,'disorder 4','sample disorder 4'),(5,'disorder 5','sample disorder 5');
/*!40000 ALTER TABLE `disorder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `graph`
--

DROP TABLE IF EXISTS `graph`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `graph` (
  `id` int(11) NOT NULL,
  `patientID` int(11) DEFAULT NULL,
  `slpID` int(11) DEFAULT NULL,
  `sessionScore` int(11) DEFAULT NULL,
  `prevScore` int(11) DEFAULT NULL,
  `forecastedScore` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graph`
--

LOCK TABLES `graph` WRITE;
/*!40000 ALTER TABLE `graph` DISABLE KEYS */;
/*!40000 ALTER TABLE `graph` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patientarchive`
--

DROP TABLE IF EXISTS `patientarchive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patientarchive` (
  `archiveID` int(11) NOT NULL AUTO_INCREMENT,
  `adminID` int(11) DEFAULT NULL,
  `archivedDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` varchar(255) DEFAULT NULL,
  `patientID` int(11) DEFAULT NULL,
  `patientInfo` varchar(255) DEFAULT NULL,
  `therapyInfo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`archiveID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patientarchive`
--

LOCK TABLES `patientarchive` WRITE;
/*!40000 ALTER TABLE `patientarchive` DISABLE KEYS */;
/*!40000 ALTER TABLE `patientarchive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contactNum` varchar(45) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `disorder` varchar(50) DEFAULT NULL,
  `guardian` varchar(150) DEFAULT NULL,
  `Sex` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isActive` tinyint(4) DEFAULT 1,
  `slpID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,'Sample','Sample',NULL,NULL,'2020-02-20','sample address','1','none','Male','2024-03-09 16:45:53',0,1),(3,'G','G',NULL,'G','2024-01-01','G','2','G','Male','2024-03-09 16:45:53',1,2),(4,'asd','ASD',NULL,'W','1999-09-23','f','3','Q','Male','2024-03-09 16:45:53',1,2),(5,'ASD','ASD',NULL,'ASD','1999-01-01','ASD','4','ASD','Male','2024-03-09 16:45:53',1,2),(6,'qwe','qwe',NULL,'sd','1999-01-01','asd','5','wsdf','Male','2024-03-09 16:45:53',1,2),(7,'asdfg','qwert',NULL,'12345678900','1999-01-01','asdzxc','1','zxcasd','Male','2024-03-09 16:45:53',1,1),(8,'G','G',NULL,'020202','1999-01-01','G','2','G','Female','2024-03-09 16:45:53',1,1),(9,'qwertyuiop','qwertyuiop',NULL,'0101010101','2024-01-01','qwertyuiop','3','qwertyuiop','Female','2024-03-09 16:47:19',1,1);
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prompt`
--

DROP TABLE IF EXISTS `prompt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prompt` (
  `promptID` int(11) NOT NULL AUTO_INCREMENT,
  `promptName` varchar(50) DEFAULT NULL,
  `promptDesc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`promptID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prompt`
--

LOCK TABLES `prompt` WRITE;
/*!40000 ALTER TABLE `prompt` DISABLE KEYS */;
INSERT INTO `prompt` VALUES (1,'Mastered','Mastered'),(2,'CIP','Correct Independent Production'),(3,'TP','Tactile Prompt'),(4,'VP','Verbal Prompt'),(5,'VsP','Visual Prompt'),(6,'HUHA','Hand-Under-Hand Assistance');
/*!40000 ALTER TABLE `prompt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slp`
--

DROP TABLE IF EXISTS `slp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `Sex` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contactNum` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `IDNumber` varchar(100) DEFAULT NULL,
  `IDPath` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slp`
--

LOCK TABLES `slp` WRITE;
/*!40000 ALTER TABLE `slp` DISABLE KEYS */;
INSERT INTO `slp` VALUES (1,'Sample','Sample','usapangonyep@gmail.com','M','1999-10-01','sample address','09876543210','2024-02-28 16:33:07','1','1.jpg'),(2,'G','G','G@G.G','Male',NULL,'G',NULL,'2024-02-28 16:33:07','asdasd','2.png'),(3,'Dr','Pathology','Email@email.com','Male',NULL,'Somewhere under the sun',NULL,'2024-02-28 16:33:07','2','3.jpg'),(4,'SLP123','SLP123','email@email.com','Male',NULL,'123',NULL,'2024-02-28 16:33:07','123321','4.png'),(5,'','','','Male',NULL,'',NULL,'2024-02-28 16:20:24','3',NULL),(6,'','','','Male',NULL,'',NULL,'2024-02-28 16:20:24','4',NULL),(7,'','','','Male',NULL,'',NULL,'2024-02-28 16:20:24','5',NULL),(8,'','','','Male',NULL,'',NULL,'2024-02-28 16:20:24','6',NULL),(9,'Sample','Pathologist','Google@gmail.com','Male',NULL,'Municipality, Province, ZIP Code',NULL,'2024-02-22 12:28:29','123','SLP_9_SR 13653 Feb 6, 2024.jpg'),(10,'Google123','123','11','Male',NULL,'11',NULL,'2024-02-22 12:35:46','1111','SLP_10_Gas 300 01-31-2024.jpg'),(11,'Google123','7','7','Male','1111-07-07','7',NULL,'2024-02-22 12:37:56','7','SLP_11_attendance Jan 22-25 2024.PNG'),(12,'010101','010101','010101','Male','1010-01-01','010101','10101','2024-03-06 16:43:28','010101','SLP_12_attendance.png');
/*!40000 ALTER TABLE `slp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slparchive`
--

DROP TABLE IF EXISTS `slparchive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slparchive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slpID` int(11) DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL,
  `slpName` varchar(50) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `slpInfo` varchar(255) DEFAULT NULL,
  `archivedDate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slparchive`
--

LOCK TABLES `slparchive` WRITE;
/*!40000 ALTER TABLE `slparchive` DISABLE KEYS */;
/*!40000 ALTER TABLE `slparchive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription` (
  `subscriptionID` int(11) NOT NULL AUTO_INCREMENT,
  `subscriptionType` varchar(50) DEFAULT NULL,
  `payRefNumber` int(11) DEFAULT NULL,
  `Sub_Start` date DEFAULT NULL,
  `Sub_End` date DEFAULT NULL,
  PRIMARY KEY (`subscriptionID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription`
--

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
INSERT INTO `subscription` VALUES (1,'Free',0,NULL,NULL);
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `summative`
--

DROP TABLE IF EXISTS `summative`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `summative` (
  `summativeID` int(11) NOT NULL AUTO_INCREMENT,
  `graphID` int(11) DEFAULT NULL,
  `dataSheetID` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`summativeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `summative`
--

LOCK TABLES `summative` WRITE;
/*!40000 ALTER TABLE `summative` DISABLE KEYS */;
/*!40000 ALTER TABLE `summative` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_acc`
--

DROP TABLE IF EXISTS `tbl_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_acc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `Password_hash` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `AccType` varchar(45) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SubID` int(11) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `createdAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_acc`
--

LOCK TABLES `tbl_acc` WRITE;
/*!40000 ALTER TABLE `tbl_acc` DISABLE KEYS */;
INSERT INTO `tbl_acc` VALUES (1,'admin','$2y$10$z6fCA5Aszshb1TwkT5TqE.n9ZDnZLa9CuA3n4gC.woLZBjzu8FfPK','admin','ADMIN',0,NULL,1,'2024-02-09 10:50:00'),(2,'slp','$2y$10$qm5714gz.1Ka6LBLqfH94uTDI9ir3Ad/hL1vm24OLyVK.XGhO6I.q','slp','SLP',1,NULL,1,'2024-02-28 07:25:18'),(3,'SLP1','$2y$10$3YoAD1udNyig7si.hs0XV.o6awucfgPv/5I0NsY6/.exlhu8fin6y',NULL,'SLP',3,NULL,1,'2024-03-02 14:30:16'),(4,'SLP123','$2y$10$z6fCA5Aszshb1TwkT5TqE.n9ZDnZLa9CuA3n4gC.woLZBjzu8FfPK',NULL,'SLP',4,NULL,1,'2024-03-02 14:28:29'),(5,'','$2y$10$9t/6FLsbyy2t/ek93Rww3OrUlNX3TwyXxSjAQp6kUJvefLX0wmGWa',NULL,'SLP',5,NULL,0,'2024-02-22 12:05:19'),(6,'','$2y$10$UAQqKCIKGRqi/132qWOmr.vp54VLnaxr6aMaF3Xtv1SZ1jSBAgiZ6',NULL,'SLP',6,NULL,0,'2024-02-22 12:12:15'),(7,'','$2y$10$mVRHuHyGyFpVKd7WqzMdqufQRQdoHe2qEu3Vix5al2LWFAA1khcs.',NULL,'SLP',7,NULL,0,'2024-02-22 12:13:16'),(8,'','$2y$10$IMFxjY2.X99lSGvZZFrOFev8qVCCN2d4ILTzOmjRra8AdHRYZ4PwW',NULL,'SLP',8,NULL,2,'2024-03-02 14:32:58'),(9,'SamplePathologist','$2y$10$RJLzdIxYX/ixwDo1Yop0iOdz3di5FydRcxEQvQyUEH8lAoy/cVf9S',NULL,'SLP',9,NULL,2,'2024-03-02 14:32:41'),(10,'11','$2y$10$gtCUydKumIF2sudzwFSDleCLcK4DVNgWdxgYUv5dTN5PM8yjFyyri',NULL,'SLP',10,NULL,0,'2024-02-22 12:35:46'),(11,'7','$2y$10$vymsn0Cu0Af1vIn886dJp.LNRO3ju1LIgOayiMBCTU7Gri/5JrSGK',NULL,'SLP',11,NULL,0,'2024-02-22 12:37:56'),(12,'010101','$2y$10$XEuQWAqmTgAMfMWjQJlxHuQz/2SgzQakIPwD5h6.2xhrkSmo9MlOu',NULL,'SLP',12,1,1,'2024-03-06 16:44:17');
/*!40000 ALTER TABLE `tbl_acc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'maneclick'
--

--
-- Dumping routines for database 'maneclick'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_slp` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_slp`()
BEGIN
SELECT 
    t1.ID,
    t1.Fname,
    t1.Lname,
    t2.Username,
    t1.Birthdate,
    t1.Email,
    t1.contactNum,
    CASE 
		WHEN t2.isActive = 0 THEN 'For Approval'
        WHEN t2.isActive = 1 THEN 'Approved'
        WHEN t2.isActive = 2 THEN 'Disapproved'
	END as 'SLPStatus',
    t2.isActive,
    t3.subscriptiontype,
    t1.IDNumber,
    t1.IDPath
FROM
    slp t1
    INNER JOIN tbl_acc t2 ON t1.ID = t2.UserID
    LEFT JOIN subscription t3 ON t2.SubID = t3.subscriptionid
WHERE
    t2.AccType = 'SLP'
ORDER BY
	t1.ID DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_Datasheet` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Datasheet`(IN p_SLPID INT, IN p_PID INT)
BEGIN
	Select
		CONCAT(p.lname, ', ', p.fname) as PName,
        p.ID as PID,
        p.sex as PSex,
        p.slpID as SLPID,
        CONCAT(s.lname, ', ', s.fname) as SLPName,
        d.disordername as PDisorder
	FROM Patients p
    INNER JOIN disorder d ON p.disorder = d.disorderID
    INNER JOIN SLP s ON p.slpid = s.ID
    WHERE
		p.slpID = p_SLPID AND p.id = p_PID;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_login` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_login`(IN p_uname varchar(255))
BEGIN
SELECT 
    t1.`Password_hash`,
    t1.`AccType`,
    t1.`isActive`,
    t1.`USERID`,
    t1.`SubID`,
    t2.`subscriptiontype` as 'SubsType',
    t3.`Fname`
FROM
    tbl_acc t1
        LEFT JOIN
    subscription t2 ON t1.`SubID` = t2.`SubscriptionID`
		LEFT JOIN
	slp t3 on t1.`USERID` = t3.`ID`
WHERE
	t1.`username` = p_uname;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_Signup` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_Signup`(
    IN p_username varchar(250),
    IN p_Password_hash varchar(250),
    IN p_AccType varchar(250),
    IN p_UserID varchar(250),    
    IN p_subs varchar(50),
    IN p_payref varchar(255)
)
BEGIN
    INSERT INTO subscription(subscriptionType, payRefNumber) VALUES (p_subs, p_payref);
    SET @lastInsertID = LAST_INSERT_ID();
    INSERT INTO tbl_acc (username, Password_hash, AccType, UserID, SubID) VALUES (p_username, p_Password_hash, p_AccType, p_UserID, @lastInsertID);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-13 15:31:17
