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
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno` (
  `id_aluno` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `ra` varchar(50) DEFAULT NULL,
  `rm` varchar(50) DEFAULT NULL,
  `turma` varchar(100) DEFAULT NULL,
  `serie` varchar(100) DEFAULT NULL,
  `curso` varchar(100) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_aluno`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'Aluno Registrado','11111','22222','B','3','Marketing',1,2);
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aluno_has_projeto`
--

DROP TABLE IF EXISTS `aluno_has_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno_has_projeto` (
  `id_aluno` int NOT NULL,
  `id_projeto` int NOT NULL,
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_aluno`,`id_projeto`),
  KEY `fk_aluno_has_projeto_projeto1_idx` (`id_projeto`),
  KEY `fk_aluno_has_projeto_aluno1_idx` (`id_aluno`),
  CONSTRAINT `fk_aluno_has_projeto_aluno1` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `fk_aluno_has_projeto_projeto1` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id_projeto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno_has_projeto`
--

LOCK TABLES `aluno_has_projeto` WRITE;
/*!40000 ALTER TABLE `aluno_has_projeto` DISABLE KEYS */;
/*!40000 ALTER TABLE `aluno_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

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
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_avaliacao`),
  KEY `fk_usuario_avaliacao_idx` (`id_usuario`),
  KEY `fk_projeto_avaliacao_idx` (`id_projeto`),
  CONSTRAINT `fk_projeto_avaliacao` FOREIGN KEY (`id_projeto`) REFERENCES `projeto` (`id_projeto`) ON DELETE RESTRICT,
  CONSTRAINT `fk_usuario_avaliacao` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `curso_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem`
--

DROP TABLE IF EXISTS `mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mensagem` (
  `id_mensagem` int NOT NULL AUTO_INCREMENT,
  `id_remetente` int NOT NULL,
  `tipo_remetente` enum('administrador','professor') NOT NULL,
  `id_destinatario` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  `lida` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_mensagem`),
  KEY `id_remetente` (`id_remetente`),
  KEY `id_destinatario` (`id_destinatario`),
  CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem`
--

LOCK TABLES `mensagem` WRITE;
/*!40000 ALTER TABLE `mensagem` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pergunta`
--

DROP TABLE IF EXISTS `pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pergunta` (
  `id_pergunta` int NOT NULL AUTO_INCREMENT,
  `texto_pergunta` varchar(255) NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `ativo` tinyint(1) DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pergunta`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta`
--

LOCK TABLES `pergunta` WRITE;
/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
INSERT INTO `pergunta` VALUES (1,'A apresentação foi clara e fácil de entender?',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(2,'Como você avalia o conteúdo apresentado no projeto',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(3,'O projeto foi bem organizado?',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(4,'O projeto foi interessante',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(5,'Como você avalia a participação dos alunos durante a apresentação?',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(6,'Houve alguma dificuldade técnica durante a apresentação?',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45'),(7,'Você recomendaria esse projeto a outros?',0,1,'2025-02-23 17:40:45','2025-02-23 17:40:45');
/*!40000 ALTER TABLE `pergunta` ENABLE KEYS */;
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
  `resumo` varchar(200) DEFAULT NULL,
  `descricao` varchar(2000) NOT NULL,
  `sala_id_sala` int NOT NULL,
  `material_apoio` varchar(255) DEFAULT NULL,
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_projeto`),
  KEY `fk_projeto_sala1_idx` (`sala_id_sala`),
  CONSTRAINT `fk_projeto_sala1` FOREIGN KEY (`sala_id_sala`) REFERENCES `sala` (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
/*!40000 ALTER TABLE `projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resposta`
--

DROP TABLE IF EXISTS `resposta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resposta` (
  `id_resposta` int NOT NULL AUTO_INCREMENT,
  `id_avaliacao` int NOT NULL,
  `id_pergunta` int NOT NULL,
  `versao_pergunta_texto` varchar(255) NOT NULL,
  `resposta` varchar(1000) NOT NULL,
  `tipo_resposta` enum('numerica','texto') NOT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_resposta`),
  KEY `id_avaliacao` (`id_avaliacao`),
  KEY `id_pergunta` (`id_pergunta`),
  CONSTRAINT `resposta_ibfk_1` FOREIGN KEY (`id_avaliacao`) REFERENCES `avaliacao` (`id_avaliacao`),
  CONSTRAINT `resposta_ibfk_2` FOREIGN KEY (`id_pergunta`) REFERENCES `pergunta` (`id_pergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resposta`
--

LOCK TABLES `resposta` WRITE;
/*!40000 ALTER TABLE `resposta` DISABLE KEYS */;
/*!40000 ALTER TABLE `resposta` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala`
--

LOCK TABLES `sala` WRITE;
/*!40000 ALTER TABLE `sala` DISABLE KEYS */;
INSERT INTO `sala` VALUES (1,'0'),(2,'1'),(3,'2'),(4,'3'),(5,'4'),(6,'5'),(7,'6'),(8,'7'),(9,'8'),(10,'9'),(11,'10'),(12,'11'),(13,'12'),(14,'13'),(15,'14'),(16,'15'),(17,'16'),(18,'17'),(19,'18'),(20,'19'),(21,'20'),(22,'21'),(23,'22'),(24,'23'),(25,'24'),(26,'25'),(27,'26'),(28,'27'),(29,'28'),(30,'29'),(31,'30'),(32,'outro'),(33,'Quadra'),(34,'RUA');
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tema`
--

LOCK TABLES `tema` WRITE;
/*!40000 ALTER TABLE `tema` DISABLE KEYS */;
INSERT INTO `tema` VALUES (1,'Administração'),(2,'Agricultura'),(3,'Alimentação'),(4,'Assistência a idosos'),(5,'Assistência social'),(6,'Bem-estar animal'),(7,'Ciências\nComunicação'),(8,'Cooperação internacional'),(9,'Cultura'),(10,'Cultura digital'),(11,'Culinária'),(12,'Dança'),(13,'Democracia'),(14,'Desenvolvimento comunitário'),(15,'Desenvolvimento infantil'),(16,'Desenvolvimento sustentável'),(17,'Direitos das minorias'),(18,'Direitos humanos'),(19,'Diversidade'),(20,'Economia'),(21,'Economia criativa'),(22,'Educação'),(23,'Educação financeira'),(24,'Empreendedorismo'),(25,'Enfermagem'),(26,'Energia'),(27,'Esportes'),(28,'Ética'),(29,'Fotografia'),(30,'Física'),(31,'Geografia'),(32,'Gestão de resíduos'),(33,'Gestão de recursos naturais'),(34,'Governança'),(35,'Habitação'),(36,'História'),(37,'Igualdade de gênero'),(38,'Inclusão social'),(39,'Inovação'),(40,'Lazer e entretenimento'),(41,'Meio ambiente'),(42,'Mobilidade'),(43,'Música'),(44,'Nutrição'),(45,'Patrimônio histórico'),(46,'Planejamento familiar'),(47,'Políticas públicas'),(48,'Prevenção de desastres'),(49,'Preservação da água'),(50,'Qualidade de vida'),(51,'Saúde'),(52,'Segurança'),(53,'Segurança alimentar'),(54,'Sustentabilidade'),(55,'Tecnologia'),(56,'Teatro'),(57,'Trabalho'),(58,'Transporte'),(59,'Turismo'),(60,'Turismo sustentável'),(61,'Urbanismo'),(62,'Voluntariado');
/*!40000 ALTER TABLE `tema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tema_has_projeto`
--

DROP TABLE IF EXISTS `tema_has_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tema_has_projeto` (
  `tema_id_tema` int NOT NULL,
  `projeto_id_projeto` int NOT NULL,
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tema_id_tema`,`projeto_id_projeto`),
  KEY `fk_projeto_has_tema_tema1_idx` (`projeto_id_projeto`),
  KEY `fk_projeto_has_tema_projeto1_idx` (`tema_id_tema`),
  KEY `idx_projeto_tema_id_projeto` (`tema_id_tema`),
  KEY `idx_projeto_tema_id_tema` (`projeto_id_projeto`),
  CONSTRAINT `fk_tema_has_projeto_projeto1` FOREIGN KEY (`projeto_id_projeto`) REFERENCES `projeto` (`id_projeto`),
  CONSTRAINT `fk_tema_has_projeto_tema1` FOREIGN KEY (`tema_id_tema`) REFERENCES `tema` (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tema_has_projeto`
--

LOCK TABLES `tema_has_projeto` WRITE;
/*!40000 ALTER TABLE `tema_has_projeto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tema_has_projeto` ENABLE KEYS */;
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
  `email` varchar(150) DEFAULT NULL,
  `frase_seguranca` varchar(150) DEFAULT NULL,
  `sexo` varchar(50) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tipo_usuario` tinyint NOT NULL DEFAULT '1',
  `ativo` tinyint DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  KEY `idx_sexo` (`sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador Geral','teste@teste','teste','masculino','2006-07-29',NULL,2,1,'2025-02-27 13:04:41','2025-02-27 13:04:41'),(2,'Aluno','aluno@aluno.com','aluno','masculino','2006-07-29',NULL,3,1,'2025-02-27 13:14:32','2025-02-27 13:19:02'),(3,'Usuário comum','user@user','user','masculino','2006-07-29',NULL,1,1,'2025-02-28 14:55:31','2025-02-28 14:55:31'),(4,'Professor','professor@professor','professor','masculino','2006-07-29',NULL,4,1,'2025-02-28 15:04:22','2025-02-28 15:04:22'),(5,'Yoshida','yoshida@yoshida.com','yoshida','masculino','2006-07-29',NULL,1,1,'2025-03-03 17:23:53','2025-03-03 17:23:53'),(6,'Teste','teste00@teste','teste','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:03:43','2025-03-05 19:03:43'),(7,'Teste','teste00@teste','teste','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:04:46','2025-03-05 19:04:46'),(8,'Teste01','teste01@teste','teste','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:06:17','2025-03-05 19:06:17'),(9,'Teste02','teste02@teste','teste','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:08:12','2025-03-05 19:08:12');
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

-- Dump completed on 2025-03-05 20:00:43
