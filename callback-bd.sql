CREATE DATABASE  IF NOT EXISTS `callback_bd` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `callback_bd`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: callback_bd
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avaliacao` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `id_projeto` int NOT NULL,
  `id_usuario` int NOT NULL,
  `data_avaliacao` date NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `nota` float NOT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `fk_usuario_avaliacao_idx` (`id_usuario`),
  KEY `fk_projeto_avaliacao_idx` (`id_projeto`),
  CONSTRAINT `fk_projeto_avaliacao` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id_projeto`) ON DELETE RESTRICT,
  CONSTRAINT `fk_usuario_avaliacao` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` VALUES (1,1,1,'2024-09-13','Muito bom',9),(2,2,2,'2024-09-13','Sem comentario',5),(3,1,2,'2024-09-13','Sem comentario',4);
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso` (
  `id_curso` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (1,'Administração'),(2,'Ciências Biologicas'),(3,'Desenho de contrução civil'),(4,'Desenvolvimento de Sistemas'),(5,'Edificações'),(6,'Enfermagem'),(7,'Gastronomia'),(8,'Informática para internet'),(9,'Logística'),(10,'Marketing'),(11,'Mecânica'),(12,'Nutrição');
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso_has_projeto`
--

DROP TABLE IF EXISTS `curso_has_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso_has_projeto` (
  `curso_id_curso` int NOT NULL,
  `projeto_id_projeto` int NOT NULL,
  PRIMARY KEY (`curso_id_curso`,`projeto_id_projeto`),
  KEY `fk_curso_has_projeto_projeto1_idx` (`projeto_id_projeto`),
  KEY `fk_curso_has_projeto_curso1_idx` (`curso_id_curso`),
  CONSTRAINT `fk_curso_has_projeto_curso1` FOREIGN KEY (`curso_id_curso`) REFERENCES `curso` (`id_curso`),
  CONSTRAINT `fk_curso_has_projeto_projeto1` FOREIGN KEY (`projeto_id_projeto`) REFERENCES `projeto` (`id_projeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso_has_projeto`
--

LOCK TABLES `curso_has_projeto` WRITE;
/*!40000 ALTER TABLE `curso_has_projeto` DISABLE KEYS */;
INSERT INTO `curso_has_projeto` VALUES (10,1),(1,2);
/*!40000 ALTER TABLE `curso_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integrante`
--

DROP TABLE IF EXISTS `integrante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `integrante` (
  `id_integrante` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id_integrante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integrante`
--

LOCK TABLES `integrante` WRITE;
/*!40000 ALTER TABLE `integrante` DISABLE KEYS */;
INSERT INTO `integrante` VALUES (1,'Ana'),(2,'Bernardo'),(3,'Clóvis');
/*!40000 ALTER TABLE `integrante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integrante_has_projeto`
--

DROP TABLE IF EXISTS `integrante_has_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `integrante_has_projeto` (
  `id_integrante` int NOT NULL,
  `id_projeto` int NOT NULL,
  PRIMARY KEY (`id_integrante`,`id_projeto`),
  KEY `fk_integrante_has_projeto_projeto1_idx` (`id_projeto`),
  KEY `fk_integrante_has_projeto_integrante1_idx` (`id_integrante`),
  CONSTRAINT `fk_integrante_has_projeto_integrante1` FOREIGN KEY (`id_integrante`) REFERENCES `integrante` (`id_integrante`),
  CONSTRAINT `fk_integrante_has_projeto_projeto1` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id_projeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integrante_has_projeto`
--

LOCK TABLES `integrante_has_projeto` WRITE;
/*!40000 ALTER TABLE `integrante_has_projeto` DISABLE KEYS */;
INSERT INTO `integrante_has_projeto` VALUES (1,1),(1,2),(2,2),(3,2);
/*!40000 ALTER TABLE `integrante_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projeto`
--

DROP TABLE IF EXISTS `projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projeto` (
  `id_projeto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `sala_id_sala` int NOT NULL,
  PRIMARY KEY (`id_projeto`),
  KEY `fk_projeto_sala1_idx` (`sala_id_sala`),
  CONSTRAINT `fk_projeto_sala1` FOREIGN KEY (`sala_id_sala`) REFERENCES `sala` (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
INSERT INTO `projeto` VALUES (1,'Projeto do marketing','Um projeto bem legal sobre marketing',25),(2,'Projeto de Administração','Um projeto bem legal sobre administração',2);
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projeto_has_tema`
--

DROP TABLE IF EXISTS `projeto_has_tema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projeto_has_tema` (
  `projeto_id_projeto` int NOT NULL,
  `tema_id_tema` int NOT NULL,
  PRIMARY KEY (`projeto_id_projeto`,`tema_id_tema`),
  KEY `fk_projeto_has_tema_tema1_idx` (`tema_id_tema`),
  KEY `fk_projeto_has_tema_projeto1_idx` (`projeto_id_projeto`),
  KEY `idx_projeto_tema_id_projeto` (`projeto_id_projeto`),
  KEY `idx_projeto_tema_id_tema` (`tema_id_tema`),
  CONSTRAINT `fk_projeto_has_tema_projeto1` FOREIGN KEY (`projeto_id_projeto`) REFERENCES `projeto` (`id_projeto`),
  CONSTRAINT `fk_projeto_has_tema_tema1` FOREIGN KEY (`tema_id_tema`) REFERENCES `tema` (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto_has_tema`
--

LOCK TABLES `projeto_has_tema` WRITE;
/*!40000 ALTER TABLE `projeto_has_tema` DISABLE KEYS */;
INSERT INTO `projeto_has_tema` VALUES (2,1),(2,9),(2,11),(1,14);
/*!40000 ALTER TABLE `projeto_has_tema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sala`
--

DROP TABLE IF EXISTS `sala`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sala` (
  `id_sala` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) NOT NULL,
  PRIMARY KEY (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala`
--

LOCK TABLES `sala` WRITE;
/*!40000 ALTER TABLE `sala` DISABLE KEYS */;
INSERT INTO `sala` VALUES (1,'0'),(2,'1'),(3,'2'),(4,'3'),(5,'4'),(6,'5'),(7,'6'),(8,'7'),(9,'8'),(10,'9'),(11,'10'),(12,'11'),(13,'12'),(14,'13'),(15,'14'),(16,'15'),(17,'16'),(18,'17'),(19,'18'),(20,'19'),(21,'20'),(22,'21'),(23,'22'),(24,'23'),(25,'24'),(26,'25'),(27,'26'),(28,'27'),(29,'28'),(30,'29'),(31,'30');
/*!40000 ALTER TABLE `sala` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tema`
--

DROP TABLE IF EXISTS `tema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tema` (
  `id_tema` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id_tema`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tema`
--

LOCK TABLES `tema` WRITE;
/*!40000 ALTER TABLE `tema` DISABLE KEYS */;
INSERT INTO `tema` VALUES (1,'Administracao'),(2,'Biologia'),(3,'Ciências'),(4,'Física'),(5,'Geografia'),(6,'História'),(7,'Matemática'),(8,'Tecnologia'),(9,'Turismo'),(10,'Logística'),(11,'Empreendedorismo'),(12,'Culinária'),(13,'Nutrição'),(14,'Marketing');
/*!40000 ALTER TABLE `tema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `frase_seguranca` varchar(255) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `idx_sexo` (`sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Maria Josefina','Feminino','Fui na roça','2006-09-17'),(2,'Mario José','Masculino','Tava eu e o jorginho apavorando na festa','1979-09-17');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-17 10:04:28
