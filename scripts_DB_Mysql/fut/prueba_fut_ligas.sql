-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: prueba_fut
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Table structure for table `ligas`
--

DROP TABLE IF EXISTS `ligas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ligas` (
  `id_liga` int(11) NOT NULL AUTO_INCREMENT,
  `id_imagen` longblob,
  `nombre_liga` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_temporada` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `id_tipo_liga` int(11) DEFAULT NULL,
  `id_rama` int(11) DEFAULT NULL,
  `lugar` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `id_cat_liga_estatus` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_liga`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligas`
--

LOCK TABLES `ligas` WRITE;
/*!40000 ALTER TABLE `ligas` DISABLE KEYS */;
INSERT INTO `ligas` VALUES (1,NULL,'Liga Zacapoaxtla','Temp Abril',NULL,NULL,'Zacapoaxtla',NULL,NULL,NULL,1,2),(2,NULL,'Liga Tlatla','Tempo 1',NULL,NULL,'Tlatlauqui',NULL,NULL,NULL,1,3),(3,NULL,'Liga Zaragoza','Temp 2',NULL,NULL,'Zaragoza',NULL,NULL,NULL,1,4),(6,NULL,'Liga Zaca 2','Tempo 4',NULL,NULL,'Zacapoaxtla',NULL,NULL,NULL,1,2),(7,NULL,'Liga Tetela','Temporada A',NULL,NULL,'Tetele de Ocampo',NULL,NULL,NULL,1,2);
/*!40000 ALTER TABLE `ligas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-17 13:56:06
