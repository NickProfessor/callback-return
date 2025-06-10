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
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'Aluno Registrado','11111','22222','B','3','Marketing',1,2),(2,'Aluno05','11111','11111','B','3','8',1,16),(3,'Aluno08','11111','11111','B','3','8',1,19);
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
INSERT INTO `aluno_has_projeto` VALUES (1,10,'2025-03-20 15:37:55','2025-03-20 15:37:55'),(1,14,'2025-04-28 13:12:29','2025-04-28 13:12:29'),(1,16,'2025-03-24 03:05:09','2025-03-24 03:05:09'),(1,17,'2025-03-25 18:01:02','2025-03-25 18:01:02'),(1,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(1,19,'2025-03-27 14:41:01','2025-03-27 14:41:01'),(1,21,'2025-03-27 14:49:45','2025-03-27 14:49:45'),(1,22,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(1,23,'2025-03-27 15:07:49','2025-03-27 15:07:49'),(1,24,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(1,25,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(1,26,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(1,27,'2025-04-28 13:29:43','2025-04-28 13:29:43'),(2,13,'2025-03-21 11:01:46','2025-03-21 11:01:46'),(2,17,'2025-03-25 18:01:02','2025-03-25 18:01:02'),(2,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(2,20,'2025-03-27 14:47:04','2025-03-27 14:47:04'),(2,23,'2025-03-27 15:07:49','2025-03-27 15:07:49'),(3,13,'2025-03-21 11:01:46','2025-03-21 11:01:46'),(3,14,'2025-04-28 13:12:29','2025-04-28 13:12:29'),(3,16,'2025-03-24 03:05:09','2025-03-24 03:05:09'),(3,17,'2025-03-25 18:01:02','2025-03-25 18:01:02'),(3,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(3,21,'2025-03-27 14:49:45','2025-03-27 14:49:45'),(3,22,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(3,24,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(3,25,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(3,26,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(3,27,'2025-04-28 13:29:43','2025-04-28 13:29:43');
/*!40000 ALTER TABLE `aluno_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aluno_has_solicitacao`
--

DROP TABLE IF EXISTS `aluno_has_solicitacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno_has_solicitacao` (
  `aluno_id_aluno` int DEFAULT NULL,
  `solicitacao_id_solicitacao` int DEFAULT NULL,
  KEY `solicitacao_id_solicitacao` (`solicitacao_id_solicitacao`),
  KEY `aluno_id_aluno` (`aluno_id_aluno`),
  CONSTRAINT `aluno_has_solicitacao_ibfk_1` FOREIGN KEY (`solicitacao_id_solicitacao`) REFERENCES `solicitacao_projeto` (`id_solicitacao`),
  CONSTRAINT `aluno_has_solicitacao_ibfk_2` FOREIGN KEY (`aluno_id_aluno`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno_has_solicitacao`
--

LOCK TABLES `aluno_has_solicitacao` WRITE;
/*!40000 ALTER TABLE `aluno_has_solicitacao` DISABLE KEYS */;
INSERT INTO `aluno_has_solicitacao` VALUES (1,4),(3,4);
/*!40000 ALTER TABLE `aluno_has_solicitacao` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` VALUES (1,16,1,'2025-03-24','sem comentario',10,'2025-03-24 03:05:09','2025-03-24 03:05:09'),(2,17,1,'2025-03-25','sem comentario',10,'2025-03-25 18:01:02','2025-03-25 18:01:02'),(3,18,1,'2025-03-27','sem comentario',10,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(4,19,1,'2025-03-27','sem comentario',10,'2025-03-27 14:41:01','2025-03-27 14:41:01'),(5,20,1,'2025-03-27','sem comentario',10,'2025-03-27 14:47:04','2025-03-27 14:47:04'),(6,21,1,'2025-03-27','sem comentario',10,'2025-03-27 14:49:45','2025-03-27 14:49:45'),(7,22,1,'2025-03-27','sem comentario',10,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(8,23,1,'2025-03-27','sem comentario',10,'2025-03-27 15:07:49','2025-03-27 15:07:49'),(9,24,1,'2025-03-27','sem comentario',10,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(10,25,1,'2025-03-28','sem comentario',10,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(11,26,1,'2025-03-28','sem comentario',10,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(12,10,1,'2025-03-31','sem comentario',9,'2025-03-31 03:36:40','2025-04-09 11:30:44'),(13,10,20,'2025-03-31','sem comentario',8,'2025-03-31 03:48:27','2025-04-09 11:30:54'),(18,13,1,'2025-04-03','sss',10,'2025-04-03 03:50:19','2025-04-03 03:50:19'),(19,17,4,'2025-04-04','sem comentario',10,'2025-04-04 02:50:11','2025-04-04 02:50:11'),(20,27,1,'2025-04-28','sem comentario',10,'2025-04-28 12:06:56','2025-04-28 12:06:56');
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
INSERT INTO `curso_has_projeto` VALUES (1,10),(1,13),(2,14),(3,14),(1,16),(2,17),(1,18),(4,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(2,25),(1,26),(6,27),(8,27);
/*!40000 ALTER TABLE `curso_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso_has_solicitacao`
--

DROP TABLE IF EXISTS `curso_has_solicitacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso_has_solicitacao` (
  `curso_id_curso` int DEFAULT NULL,
  `solicitacao_id_solicitacao` int DEFAULT NULL,
  KEY `solicitacao_id_solicitacao` (`solicitacao_id_solicitacao`),
  KEY `curso_has_curso` (`curso_id_curso`),
  CONSTRAINT `curso_has_solicitacao_ibfk_1` FOREIGN KEY (`solicitacao_id_solicitacao`) REFERENCES `solicitacao_projeto` (`id_solicitacao`),
  CONSTRAINT `curso_has_solicitacao_ibfk_2` FOREIGN KEY (`curso_id_curso`) REFERENCES `curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso_has_solicitacao`
--

LOCK TABLES `curso_has_solicitacao` WRITE;
/*!40000 ALTER TABLE `curso_has_solicitacao` DISABLE KEYS */;
INSERT INTO `curso_has_solicitacao` VALUES (1,3),(2,3),(1,4),(2,4);
/*!40000 ALTER TABLE `curso_has_solicitacao` ENABLE KEYS */;
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
  `tipo_pergunta` enum('sim_nao','texto') NOT NULL,
  `ordem` int NOT NULL DEFAULT '0',
  `ativo` tinyint(1) DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pergunta`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pergunta`
--

LOCK TABLES `pergunta` WRITE;
/*!40000 ALTER TABLE `pergunta` DISABLE KEYS */;
INSERT INTO `pergunta` VALUES (1,'A apresentação foi clara e fácil de entender?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-03 03:22:54'),(2,'Como você avalia o conteúdo apresentado no projeto','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-01 16:56:28'),(3,'O projeto foi bem organizado?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-01 16:56:28'),(4,'O projeto foi interessante?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-03 03:23:03'),(5,'Como você avalia a participação dos alunos durante a apresentação?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-01 16:56:28'),(6,'Houve alguma dificuldade técnica durante a apresentação?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-01 16:56:28'),(7,'Você recomendaria esse projeto a outros?','sim_nao',0,0,'2025-02-23 17:40:45','2025-04-01 16:56:28'),(8,'Quais pontos você acha que tiveram mais destaque nessa apresentação?','texto',0,1,'2025-03-31 04:24:40','2025-04-03 03:28:01'),(9,'O que você aprendeu com essa apresentação?','texto',0,1,'2025-03-31 04:25:07','2025-04-03 03:24:22'),(10,'Voce achou o tema do projeto relevante ao curso?','sim_nao',0,0,'2025-03-31 04:26:24','2025-04-01 16:56:28'),(11,'Teria alguma sugestão de melhoria para o projeto apresentado?','texto',0,0,'2025-03-31 04:27:16','2025-04-01 16:56:28');
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
  `descricao` text,
  `material_apoio` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_projeto`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projeto`
--

LOCK TABLES `projeto` WRITE;
/*!40000 ALTER TABLE `projeto` DISABLE KEYS */;
INSERT INTO `projeto` VALUES (10,'Projeto teste01','Resumos e tal, muito bom o projeto','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam placerat lectus ut sem pretium consequat. In eu pellentesque urna, in blandit tortor. Praesent nisi ligula, porta ac hendrerit nec, vestibulum at risus. Pellentesque in tincidunt velit. Sed imperdiet ante quis magna pharetra eleifend. Integer quis arcu quis orci tincidunt scelerisque. Mauris gravida lectus vel justo hendrerit, ac scelerisque mauris tincidunt. Quisque aliquam, risus sodales lacinia finibus, eros diam posuere diam, commodo semper ipsum massa sed velit. Nam ligula tellus, vulputate in nisl vel, pharetra fringilla neque. Aenean sit amet urna quis sem viverra vehicula.\n\nFusce auctor felis non augue congue convallis. Sed tempor pretium orci at blandit. Donec vestibulum dui dui. Vestibulum nec mattis est. Ut ultricies nunc ac quam facilisis, eget facilisis libero auctor. Sed lacinia condimentum tellus vitae finibus. Nunc elementum mollis sem, non consectetur ante aliquam sed. Donec sit amet eros et quam iaculis iaculis et id diam. In venenatis luctus ex, id tempor eros iaculis vel. Vivamus iaculis ipsum a elementum mattis. Cras tincidunt nisl sodales iaculis ornare. Nulla facilisi. Fusce convallis nisl leo, eget consequat elit ultricies eget. Suspendisse potenti. In convallis eros sapien, bibendum tincidunt libero bibendum et. Nullam non iaculis ante.\n\nNunc sollicitudin, lectus id fermentum aliquet, libero lacus convallis libero, id imperdiet tortor metus eu justo. Cras blandit vehicula nunc, eu lobortis ipsum tincidunt vitae. Donec auctor volutpat cursus. Nullam dapibus magna in metus tristique tincidunt. Cras nec arcu eget sapien cursus placerat non vitae risus. Aliquam nec nisl quis nulla auctor porta. In hac habitasse platea dictumst. In lacinia interdum semper. In hac habitasse platea dictumst. Proin sed dictum tellus, eget lobortis dolor. Vestibulum venenatis facilisis leo, sit amet faucibus nunc sollicitudin id. Nunc viverra interdum felis id luctus. Morbi gravida mi eu velit faucibus, eget aliquet ex ultrices.\n\nNunc urna massa, iaculis vel scelerisque nec, rutrum non eros. Ut fermentum, magna eget gravida rutrum, massa felis congue tellus, eu egestas dolor sapien ut magna. Vivamus sit amet ornare tortor, sed finibus tellus. Nulla et tortor rutrum, interdum orci at, viverra augue. Duis scelerisque dui eu risus gravida, ut porttitor purus volutpat. Cras ornare lectus ut eros scelerisque efficitur non sit amet tellus. Ut purus nisl, accumsan a finibus eu, tempus in purus. Curabitur tincidunt nunc sit amet ornare eleifend. Integer eget viverra lacus. Nulla facilisi. Quisque id sollicitudin libero, ut tempor ligula. Fusce nec nisl nunc. Aenean quis feugiat quam. Ut convallis congue tempor.\n\nDonec id elit risus. Vivamus lobortis neque ultrices, faucibus mauris sit amet, bibendum dui. Praesent imperdiet turpis non ipsum luctus dictum. Maecenas porta mauris turpis, eget mollis neque luctus nec. Sed venenatis libero a imperdiet convallis. Nulla vehicula risus eget enim imperdiet lobortis. Aenean vitae lorem ac risus tristique dictum sed at orci. Vestibulum facilisis consequat metus sed congue.','/../uploads/teste.pdf',1,'2025-03-20 15:34:31','2025-04-10 13:51:13'),(13,'Projeto teste02','Resumos e muito mais, incrível','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus viverra purus sit amet placerat cursus. Aenean eu eros ex. Nunc auctor nunc sem, id commodo justo iaculis ut. Morbi ut eros eu dolor egestas fermentum. Cras velit erat, venenatis id pretium a, varius at massa. In hac habitasse platea dictumst. Aenean lacus sem, dignissim sit amet est consectetur, viverra porttitor metus. Donec quis ullamcorper erat.\n\nSed nec dignissim lacus. Nullam leo mi, elementum nec enim sed, fringilla dignissim dui. Cras pharetra, dui id tincidunt auctor, tellus sapien ultrices mauris, egestas porta turpis nisi sed nulla. Aenean eu risus consequat, malesuada magna id, vulputate erat. Nullam sed dolor accumsan, varius est ut, porttitor diam. Nullam venenatis urna sed sem mollis, at maximus leo accumsan. Pellentesque ex ante, ullamcorper vel eleifend hendrerit, rutrum in nisi. Ut luctus vel quam ut aliquam. Vivamus sed dui aliquam, pretium ex quis, sollicitudin lacus. Integer eu elit sagittis, sollicitudin massa vitae, dictum sem. Vivamus egestas libero elit, non mollis ipsum ornare nec. Sed turpis tortor, posuere sit amet ligula eget, fringilla lobortis elit. Donec tempus at quam sed gravida. Nam bibendum tortor a eros luctus, sit amet iaculis nisl tincidunt.\n\nIn hac habitasse platea dictumst. Morbi interdum, nisi non lobortis condimentum, enim sapien luctus arcu, et semper ex arcu non lacus. Curabitur porttitor urna ligula, dictum accumsan leo molestie nec. Etiam imperdiet luctus turpis, nec tristique lacus feugiat id. Vivamus porttitor blandit lectus id auctor. Donec eu vestibulum nulla, in lobortis nisi. Aliquam erat volutpat.\n\nFusce sodales, lectus quis congue hendrerit, tortor nisl pulvinar turpis, vitae sollicitudin nisl est nec justo. Suspendisse malesuada erat sit amet lacus fringilla elementum. Morbi feugiat dapibus enim eget rhoncus. Aenean non orci eget odio mollis suscipit quis non diam. Aliquam venenatis lectus sem, at eleifend nisl ultrices vel. Pellentesque nunc velit, euismod eget purus a, sagittis fermentum neque. Mauris velit metus, porta sed euismod vel, egestas placerat metus. Morbi venenatis sem ut velit lacinia euismod.\n\nInteger rhoncus mauris turpis, sit amet feugiat urna scelerisque ut. Aenean ac justo molestie purus interdum mollis sit amet at magna. Donec nec leo mauris. Curabitur posuere dui nibh, nec placerat enim porttitor ac. Phasellus egestas elit sit amet dui tincidunt molestie. Mauris nec est ante. Aenean ac mauris non dolor ornare dictum.','/../uploads/teste2.pdf',1,'2025-03-21 11:00:46','2025-04-10 13:51:13'),(14,'Projeto teste03 - alterado','Resumos e muito mais mais, incrível aaaaaaaaaaaaa - alterado','# Título Principal ALTERADO\r\n\r\nEste é um parágrafo de **texto em negrito** e *texto em itálico*.\r\n\r\n## Subtítulo\r\n\r\n- Lista de itens:\r\n  - Item 1\r\n  - Item 2\r\n  - Item 3\r\n\r\n### Outro subtítulo\r\n\r\n1. Item ordenado 1\r\n2. Item ordenado 2\r\n3. Item ordenado 3\r\n\r\n**Links e imagens**:\r\n\r\n- [Link para o Google](https://www.google.com)\r\n- ![Imagem exemplo](https://via.placeholder.com/150)\r\n\r\n> **Citação**: \"Isso é uma citação em bloco.\"\r\n\r\nCódigo:\r\n\r\n```php\r\n<?php\r\n  echo \"Olá, Mundo!\";\r\n?>\r\n','uploads/680fa8ed66e9f.pdf',1,'2025-03-21 11:29:34','2025-04-28 13:12:29'),(16,'Projeto Teste04',NULL,'aaa','uploads/67e0f6151ab53.pdf',1,'2025-03-24 03:05:09','2025-04-10 13:51:13'),(17,'Projeto Teste05',NULL,'Teste\r\nTESTE\r\n\r\n<h1>TESTE</h1>\r\n\r\n-       Teste',NULL,1,'2025-03-25 18:01:02','2025-04-10 13:51:13'),(18,'Projeto Teste06','Testando testando testando testando','AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA',NULL,1,'2025-03-27 13:42:37','2025-04-10 13:51:13'),(19,'Projeto teste07','AA','<h1>Teste</h1>\r\n\r\nTestando de novo (2 linhas _abaixo_)\r\n\r\n[1linha](https://youtube.com)',NULL,1,'2025-03-27 14:41:01','2025-04-10 13:51:13'),(20,'Projeto Teste08','AAA','<h1>Teste</h1>\r\n\r\n\r\n**Teste 2 linhas**\r\n\r\n*Teste 1 linha*',NULL,1,'2025-03-27 14:47:04','2025-04-10 13:51:13'),(21,'Projeto Teste09','AAA','*Teste 01*\r\n\r\n<h1>Teste 02</h1>\r\n\r\n**Teste**',NULL,1,'2025-03-27 14:49:45','2025-04-10 13:51:13'),(22,'Projeto Teste10','tesrw','# Atenção\r\n\r\n*Teste*\r\n\r\n**Teste**\r\n\r\n`Teste`\r\n\r\n- Teste\r\n\r\n1. Teste\r\n\r\n[Teste](https://youtube.com)',NULL,1,'2025-03-27 15:01:42','2025-04-10 13:51:13'),(23,'Projeto teste11','AA','# TESTANDO\r\n\r\n*Teste*\r\n\r\n_Teste_\r\n\r\n- Teste\r\n\r\n1. Teste\r\n\r\n**Teste**\r\n\r\n`Teste`',NULL,1,'2025-03-27 15:07:49','2025-04-10 13:51:13'),(24,'Projeto 11','AAA','# Teste\r\n\r\n*Teste*\r\n\r\n_Teste_\r\n\r\n`Teste`\r\n\r\n- Teste\r\n\r\n**Teste**',NULL,1,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(25,'Projeto Teste 12','AAA','# Teste \r\n\r\n*Teste*\r\n\r\n**Teste**\r\n\r\n`Teste`\r\n\r\n- Teste\r\n\r\n1. Teste\r\n\r\n[Teste](https://www.youtube.com)','uploads/67e63a84d62e8.pdf',1,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(26,'Projeto Teste13','AAA','# Testando sua aplicação\r\n\n\r\n**AAA**\r\n\r\n*Teste*\r\n\r\n> Teste\r\n\r\n\r\n1. Teste\r\n\n\r\n\n\r\n\n\r\n\r\n[Teste](https://www.youtube.com)',NULL,1,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(27,'PROJETO COM PDF - ALTERADO','AAalterado','aaaalterado','uploads/680facf712551.pdf',1,'2025-04-28 12:06:56','2025-04-28 13:29:43');
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
  `resposta_sim_nao` enum('sim','nao') DEFAULT NULL,
  `resposta_texto` text,
  `ativo` tinyint(1) DEFAULT '1',
  `data_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_resposta`),
  KEY `id_avaliacao` (`id_avaliacao`),
  KEY `id_pergunta` (`id_pergunta`),
  CONSTRAINT `resposta_ibfk_1` FOREIGN KEY (`id_avaliacao`) REFERENCES `avaliacao` (`id_avaliacao`),
  CONSTRAINT `resposta_ibfk_2` FOREIGN KEY (`id_pergunta`) REFERENCES `pergunta` (`id_pergunta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resposta`
--

LOCK TABLES `resposta` WRITE;
/*!40000 ALTER TABLE `resposta` DISABLE KEYS */;
INSERT INTO `resposta` VALUES (1,18,8,'TEMPORÁRIO',NULL,'AAA',1,'2025-04-03 03:50:19','2025-04-03 03:50:19'),(2,18,9,'TEMPORÁRIO',NULL,'ttt',1,'2025-04-03 03:50:19','2025-04-03 03:50:19'),(3,19,8,'TEMPORÁRIO',NULL,'TESTE',1,'2025-04-04 02:50:11','2025-04-04 02:50:11'),(4,19,9,'TEMPORÁRIO',NULL,'TESTE',1,'2025-04-04 02:50:11','2025-04-04 02:50:11');
/*!40000 ALTER TABLE `resposta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitacao_projeto`
--

DROP TABLE IF EXISTS `solicitacao_projeto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitacao_projeto` (
  `id_solicitacao` int NOT NULL AUTO_INCREMENT,
  `nome_projeto` varchar(255) DEFAULT NULL,
  `resumo` varchar(200) DEFAULT NULL,
  `descricao` text,
  `material_apoio` varchar(255) DEFAULT NULL,
  `solicitado_por` int DEFAULT NULL,
  `data_solicitacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  PRIMARY KEY (`id_solicitacao`),
  KEY `solicitado_por` (`solicitado_por`),
  CONSTRAINT `solicitacao_projeto_ibfk_1` FOREIGN KEY (`solicitado_por`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitacao_projeto`
--

LOCK TABLES `solicitacao_projeto` WRITE;
/*!40000 ALTER TABLE `solicitacao_projeto` DISABLE KEYS */;
INSERT INTO `solicitacao_projeto` VALUES (1,'Projeto Teste SOLICITACAO','Resumo de SOLICITACAO','DESCRICAO DE SOLICITACAO',NULL,2,'2025-06-03 00:32:25','2025-06-02 19:32:25','pendente'),(3,'AAAAAAAAAAAAAAAAAAAAAAAAAAAA','AAAAAAAAA','aaa','uploads/683e9c4e39648.pdf',2,'2025-06-03 08:55:10','2025-06-03 03:55:10','pendente'),(4,'BBBBBBBBBBBBBBBBB','AAAAAAAA','AAAAAAAAAAAVBB','uploads/683e9d10d64bb.pdf',2,'2025-06-03 08:58:24','2025-06-03 03:58:24','pendente');
/*!40000 ALTER TABLE `solicitacao_projeto` ENABLE KEYS */;
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
INSERT INTO `tema_has_projeto` VALUES (1,10,'2025-03-20 15:36:22','2025-03-20 15:36:22'),(1,13,'2025-03-21 11:01:20','2025-03-21 11:01:20'),(1,16,'2025-03-24 03:05:09','2025-03-24 03:05:09'),(1,17,'2025-03-25 18:01:02','2025-03-25 18:01:02'),(1,19,'2025-03-27 14:41:01','2025-03-27 14:41:01'),(1,20,'2025-03-27 14:47:04','2025-03-27 14:47:04'),(1,21,'2025-03-27 14:49:45','2025-03-27 14:49:45'),(1,22,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(1,23,'2025-03-27 15:07:49','2025-03-27 15:07:49'),(1,24,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(1,25,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(1,26,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(1,27,'2025-04-28 13:29:43','2025-04-28 13:29:43'),(2,10,'2025-03-20 15:36:22','2025-03-20 15:36:22'),(2,13,'2025-03-21 11:01:20','2025-03-21 11:01:20'),(2,19,'2025-03-27 14:41:01','2025-03-27 14:41:01'),(2,20,'2025-03-27 14:47:04','2025-03-27 14:47:04'),(2,21,'2025-03-27 14:49:45','2025-03-27 14:49:45'),(2,22,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(2,23,'2025-03-27 15:07:49','2025-03-27 15:07:49'),(2,24,'2025-03-27 15:12:09','2025-03-27 15:12:09'),(2,25,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(2,26,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(2,27,'2025-04-28 13:29:43','2025-04-28 13:29:43'),(3,19,'2025-03-27 14:41:01','2025-03-27 14:41:01'),(3,22,'2025-03-27 15:01:42','2025-03-27 15:01:42'),(3,25,'2025-03-28 02:58:28','2025-03-28 02:58:28'),(3,26,'2025-03-28 05:01:17','2025-03-28 05:01:17'),(14,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(15,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(16,18,'2025-03-27 13:42:37','2025-03-27 13:42:37'),(31,14,'2025-04-28 13:12:29','2025-04-28 13:12:29'),(32,14,'2025-04-28 13:12:29','2025-04-28 13:12:29'),(33,14,'2025-04-28 13:12:29','2025-04-28 13:12:29'),(33,18,'2025-03-27 13:42:37','2025-03-27 13:42:37');
/*!40000 ALTER TABLE `tema_has_projeto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tema_has_solicitacao`
--

DROP TABLE IF EXISTS `tema_has_solicitacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tema_has_solicitacao` (
  `tema_id_tema` int NOT NULL,
  `solicitacao_id_solicitacao` int DEFAULT NULL,
  KEY `solicitacao_id_solicitacao` (`solicitacao_id_solicitacao`),
  KEY `tema_id_tema` (`tema_id_tema`),
  CONSTRAINT `tema_has_solicitacao_ibfk_1` FOREIGN KEY (`solicitacao_id_solicitacao`) REFERENCES `solicitacao_projeto` (`id_solicitacao`),
  CONSTRAINT `tema_has_solicitacao_ibfk_2` FOREIGN KEY (`tema_id_tema`) REFERENCES `tema` (`id_tema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tema_has_solicitacao`
--

LOCK TABLES `tema_has_solicitacao` WRITE;
/*!40000 ALTER TABLE `tema_has_solicitacao` DISABLE KEYS */;
INSERT INTO `tema_has_solicitacao` VALUES (1,3),(2,3),(1,4),(2,4);
/*!40000 ALTER TABLE `tema_has_solicitacao` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Administrador Geral','teste@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,2,1,'2025-02-27 13:04:41','2025-04-21 14:34:06'),(2,'Aluno','aluno@aluno.com','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,3,1,'2025-02-27 13:14:32','2025-04-21 14:34:06'),(3,'Usuário comum','user@user','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-02-28 14:55:31','2025-04-21 14:34:06'),(4,'Professor','professor@professor','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,4,1,'2025-02-28 15:04:22','2025-04-21 14:34:06'),(5,'Yoshida','yoshida@yoshida.com','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-03 17:23:53','2025-04-21 14:34:06'),(6,'Teste','teste00@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:03:43','2025-04-21 14:34:06'),(7,'Teste','teste00@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:04:46','2025-04-21 14:34:06'),(8,'Teste01','teste01@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:06:17','2025-04-21 14:34:06'),(9,'Teste02','teste02@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-05 19:08:12','2025-04-21 14:34:06'),(10,'Teste03','teste03@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-06 13:49:00','2025-04-21 14:34:06'),(11,'Teste04','teste04@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2006-07-29',NULL,1,1,'2025-03-15 22:33:11','2025-04-21 14:34:06'),(12,'Joan do Nordeste','joan@joan','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2005-07-15',NULL,1,1,'2025-03-17 01:45:36','2025-04-21 14:34:06'),(13,'Aluno02','aluno02@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,1,1,'2025-03-18 14:32:30','2025-04-21 14:34:06'),(14,'Aluno03','aluno03@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,1,1,'2025-03-18 14:34:33','2025-04-21 14:34:06'),(15,'Aluno04','aluno04@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,1,1,'2025-03-18 14:39:58','2025-04-21 14:34:06'),(16,'Aluno05','aluno05@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,1,1,'2025-03-18 14:40:54','2025-04-21 14:34:06'),(17,'Aluno06','aluno06@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,3,1,'2025-03-18 14:50:40','2025-04-21 14:34:06'),(18,'Aluno07','aluno07@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,3,1,'2025-03-18 14:53:05','2025-04-21 14:34:06'),(19,'Aluno08','aluno08@aluno','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','outro','2000-01-01',NULL,3,1,'2025-03-18 15:02:55','2025-04-21 14:34:06'),(20,'Teste05','teste05@teste','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2000-01-01',NULL,1,1,'2025-03-26 17:58:10','2025-04-21 14:34:06'),(21,'Senha tal','senha@senha','$2y$10$qQQIplfDSKuN4.J6E4Xrh.21brTdjjJWbuZm3xufkdQ0Kcxs8Ig8i','masculino','2000-01-01',NULL,1,1,'2025-04-21 14:33:19','2025-04-21 14:33:19');
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

-- Dump completed on 2025-06-03 17:38:12
