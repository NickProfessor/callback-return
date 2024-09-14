CREATE DATABASE  IF NOT EXISTS `callback_bd` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `callback_bd`;
-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: callback_bd
-- ------------------------------------------------------
-- Server version	8.0.26

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
INSERT INTO `projeto` VALUES (1,'Projeto de marketing','Um projeto bem legal sobre marketing',25),(2,'Projeto de Administração','Um projeto bem legal sobre administração',2);
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `projeto_avaliacoes`
--

DROP TABLE IF EXISTS `projeto_avaliacoes`;
/*!50001 DROP VIEW IF EXISTS `projeto_avaliacoes`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projeto_avaliacoes` AS SELECT 
 1 AS `id_projeto`,
 1 AS `projeto_nome`,
 1 AS `total_avaliacoes`,
 1 AS `media_notas`*/;
SET character_set_client = @saved_cs_client;

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
-- Temporary view structure for view `projetos_avaliacoes_adultos`
--

DROP TABLE IF EXISTS `projetos_avaliacoes_adultos`;
/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_adultos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projetos_avaliacoes_adultos` AS SELECT 
 1 AS `id_projeto`,
 1 AS `nome_projeto`,
 1 AS `total_avaliacoes_adultos`,
 1 AS `media_notas_adultos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `projetos_avaliacoes_feminino`
--

DROP TABLE IF EXISTS `projetos_avaliacoes_feminino`;
/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_feminino`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projetos_avaliacoes_feminino` AS SELECT 
 1 AS `id_projeto`,
 1 AS `nome_projeto`,
 1 AS `total_avaliacoes_feminino`,
 1 AS `media_notas_feminino`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `projetos_avaliacoes_jovens`
--

DROP TABLE IF EXISTS `projetos_avaliacoes_jovens`;
/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_jovens`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projetos_avaliacoes_jovens` AS SELECT 
 1 AS `id_projeto`,
 1 AS `nome_projeto`,
 1 AS `total_avaliacoes_jovens`,
 1 AS `media_notas_jovens`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `projetos_avaliacoes_masculino`
--

DROP TABLE IF EXISTS `projetos_avaliacoes_masculino`;
/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_masculino`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projetos_avaliacoes_masculino` AS SELECT 
 1 AS `id_projeto`,
 1 AS `nome_projeto`,
 1 AS `total_avaliacoes_masculino`,
 1 AS `media_notas_masculino`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `projetos_avaliacoes_seniores`
--

DROP TABLE IF EXISTS `projetos_avaliacoes_seniores`;
/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_seniores`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `projetos_avaliacoes_seniores` AS SELECT 
 1 AS `id_projeto`,
 1 AS `nome_projeto`,
 1 AS `total_avaliacoes_seniores`,
 1 AS `media_notas_seniores`*/;
SET character_set_client = @saved_cs_client;

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
  `idade` int NOT NULL,
  `sexo` varchar(50) NOT NULL,
  `frase_seguranca` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Maria Josefina',18,'Feminino','Fui na roça'),(2,'Mario José',45,'Masculino','Tava eu e o jorginho apavorando na festa');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `projeto_avaliacoes`
--

/*!50001 DROP VIEW IF EXISTS `projeto_avaliacoes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projeto_avaliacoes` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `projeto_nome`,count(`a`.`id_avaliacao`) AS `total_avaliacoes`,avg(`a`.`nota`) AS `media_notas` from (`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `projetos_avaliacoes_adultos`
--

/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_adultos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projetos_avaliacoes_adultos` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `nome_projeto`,count(`a`.`id_avaliacao`) AS `total_avaliacoes_adultos`,avg(`a`.`nota`) AS `media_notas_adultos` from ((`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) left join `usuario` `u` on((`a`.`id_usuario` = `u`.`id_usuario`))) where (`u`.`idade` between 22 and 55) group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `projetos_avaliacoes_feminino`
--

/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_feminino`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projetos_avaliacoes_feminino` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `nome_projeto`,count(`a`.`id_avaliacao`) AS `total_avaliacoes_feminino`,avg(`a`.`nota`) AS `media_notas_feminino` from ((`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) left join `usuario` `u` on((`a`.`id_usuario` = `u`.`id_usuario`))) where (`u`.`sexo` = 'Feminino') group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `projetos_avaliacoes_jovens`
--

/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_jovens`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projetos_avaliacoes_jovens` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `nome_projeto`,count(`a`.`id_avaliacao`) AS `total_avaliacoes_jovens`,avg(`a`.`nota`) AS `media_notas_jovens` from ((`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) left join `usuario` `u` on((`a`.`id_usuario` = `u`.`id_usuario`))) where (`u`.`idade` < 22) group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `projetos_avaliacoes_masculino`
--

/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_masculino`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projetos_avaliacoes_masculino` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `nome_projeto`,count(`a`.`id_avaliacao`) AS `total_avaliacoes_masculino`,avg(`a`.`nota`) AS `media_notas_masculino` from ((`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) left join `usuario` `u` on((`a`.`id_usuario` = `u`.`id_usuario`))) where (`u`.`sexo` = 'Masculino') group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `projetos_avaliacoes_seniores`
--

/*!50001 DROP VIEW IF EXISTS `projetos_avaliacoes_seniores`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `projetos_avaliacoes_seniores` AS select `p`.`id_projeto` AS `id_projeto`,`p`.`nome` AS `nome_projeto`,count(`a`.`id_avaliacao`) AS `total_avaliacoes_seniores`,avg(`a`.`nota`) AS `media_notas_seniores` from ((`projeto` `p` left join `avaliacao` `a` on((`p`.`id_projeto` = `a`.`id_projeto`))) left join `usuario` `u` on((`a`.`id_usuario` = `u`.`id_usuario`))) where (`u`.`idade` > 55) group by `p`.`id_projeto` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-13 21:45:13
