-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: actividades
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `abilities`
--

DROP TABLE IF EXISTS `abilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `abilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `only_owned` tinyint(1) NOT NULL DEFAULT '0',
  `options` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `abilities_scope_index` (`scope`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abilities`
--

LOCK TABLES `abilities` WRITE;
/*!40000 ALTER TABLE `abilities` DISABLE KEYS */;
INSERT INTO `abilities` VALUES (2,'crear-proyecto','crear proyecto',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:15','2019-01-31 22:01:15'),(3,'editar-proyecto','editar proyecto',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:15','2019-01-31 22:01:15'),(4,'borrar-proyecto','borrar proyecto',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(5,'bajar-proyecto','bajar proyecto',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(6,'cerrar-proyecto','cerrar proyecto',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(7,'crear-actividad','crear actividad',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(8,'crear-avance','crear avance',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(9,'modificar-avance','modificar avance',NULL,NULL,0,NULL,NULL,'2019-01-31 22:01:16','2019-01-31 22:01:16'),(10,'*','All abilities',NULL,'*',0,NULL,NULL,'2019-02-01 02:00:41','2019-02-01 02:00:41'),(11,'crear-proyecto','Crear proyecto proyectos',NULL,'App\\Proyectos',0,NULL,NULL,'2019-02-01 02:13:34','2019-02-01 02:13:34'),(12,'mantenimientos-general','Mantenimientos Generales',NULL,NULL,0,NULL,NULL,'2019-02-02 03:23:50','2019-02-02 03:23:50'),(13,'reportes','Reportes',NULL,NULL,0,NULL,NULL,'2019-02-02 04:51:25','2019-02-02 04:51:25');
/*!40000 ALTER TABLE `abilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assigned_roles`
--

DROP TABLE IF EXISTS `assigned_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assigned_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restricted_to_id` int(10) unsigned DEFAULT NULL,
  `restricted_to_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  KEY `assigned_roles_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `assigned_roles_role_id_index` (`role_id`),
  KEY `assigned_roles_scope_index` (`scope`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigned_roles`
--

LOCK TABLES `assigned_roles` WRITE;
/*!40000 ALTER TABLE `assigned_roles` DISABLE KEYS */;
INSERT INTO `assigned_roles` VALUES (1,17,'App\\User',NULL,NULL,NULL),(3,18,'App\\User',NULL,NULL,NULL),(3,19,'App\\User',NULL,NULL,NULL),(3,20,'App\\User',NULL,NULL,NULL),(2,21,'App\\User',NULL,NULL,NULL),(3,22,'App\\User',NULL,NULL,NULL),(3,23,'App\\User',NULL,NULL,NULL),(3,24,'App\\User',NULL,NULL,NULL),(3,25,'App\\User',NULL,NULL,NULL),(1,26,'App\\User',NULL,NULL,NULL),(2,27,'App\\User',NULL,NULL,NULL),(3,28,'App\\User',NULL,NULL,NULL),(3,29,'App\\User',NULL,NULL,NULL),(3,30,'App\\User',NULL,NULL,NULL),(3,31,'App\\User',NULL,NULL,NULL),(3,32,'App\\User',NULL,NULL,NULL),(1,33,'App\\User',NULL,NULL,NULL),(2,34,'App\\User',NULL,NULL,NULL),(3,35,'App\\User',NULL,NULL,NULL),(1,36,'App\\User',NULL,NULL,NULL),(3,37,'App\\User',NULL,NULL,NULL),(3,38,'App\\User',NULL,NULL,NULL),(3,39,'App\\User',NULL,NULL,NULL),(3,40,'App\\User',NULL,NULL,NULL),(3,41,'App\\User',NULL,NULL,NULL),(3,42,'App\\User',NULL,NULL,NULL),(3,43,'App\\User',NULL,NULL,NULL),(3,44,'App\\User',NULL,NULL,NULL),(3,45,'App\\User',NULL,NULL,NULL),(2,46,'App\\User',NULL,NULL,NULL),(3,47,'App\\User',NULL,NULL,NULL),(3,48,'App\\User',NULL,NULL,NULL),(3,49,'App\\User',NULL,NULL,NULL),(2,50,'App\\User',NULL,NULL,NULL),(3,51,'App\\User',NULL,NULL,NULL),(3,52,'App\\User',NULL,NULL,NULL),(3,53,'App\\User',NULL,NULL,NULL),(2,54,'App\\User',NULL,NULL,NULL),(1,55,'App\\User',NULL,NULL,NULL),(3,56,'App\\User',NULL,NULL,NULL),(3,57,'App\\User',NULL,NULL,NULL),(3,58,'App\\User',NULL,NULL,NULL),(1,59,'App\\User',NULL,NULL,NULL),(2,60,'App\\User',NULL,NULL,NULL),(3,61,'App\\User',NULL,NULL,NULL),(3,62,'App\\User',NULL,NULL,NULL),(3,63,'App\\User',NULL,NULL,NULL),(3,64,'App\\User',NULL,NULL,NULL),(3,65,'App\\User',NULL,NULL,NULL),(3,66,'App\\User',NULL,NULL,NULL),(2,67,'App\\User',NULL,NULL,NULL),(3,68,'App\\User',NULL,NULL,NULL),(3,69,'App\\User',NULL,NULL,NULL),(3,70,'App\\User',NULL,NULL,NULL),(3,71,'App\\User',NULL,NULL,NULL),(1,72,'App\\User',NULL,NULL,NULL),(2,73,'App\\User',NULL,NULL,NULL),(3,74,'App\\User',NULL,NULL,NULL),(3,75,'App\\User',NULL,NULL,NULL),(2,76,'App\\User',NULL,NULL,NULL),(2,77,'App\\User',NULL,NULL,NULL),(3,78,'App\\User',NULL,NULL,NULL),(3,79,'App\\User',NULL,NULL,NULL),(3,80,'App\\User',NULL,NULL,NULL),(3,81,'App\\User',NULL,NULL,NULL),(3,82,'App\\User',NULL,NULL,NULL),(3,83,'App\\User',NULL,NULL,NULL),(3,84,'App\\User',NULL,NULL,NULL),(3,85,'App\\User',NULL,NULL,NULL),(2,86,'App\\User',NULL,NULL,NULL),(3,87,'App\\User',NULL,NULL,NULL),(3,88,'App\\User',NULL,NULL,NULL),(3,89,'App\\User',NULL,NULL,NULL);
/*!40000 ALTER TABLE `assigned_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cab_actividad`
--

DROP TABLE IF EXISTS `cab_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cab_actividad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned DEFAULT NULL,
  `id_grupo` int(10) unsigned DEFAULT NULL,
  `tipo_recurso` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_responsable` int(10) unsigned NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duracion` int(11) DEFAULT NULL,
  `activo` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_refertiempo` int(11) unsigned DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `notifica` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `fecha_completo` timestamp NULL DEFAULT NULL,
  `fecha_baja` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_iduser` (`id_user`),
  KEY `fk_idgrupo` (`id_grupo`),
  KEY `fk_idrefertiempo` (`id_refertiempo`),
  KEY `fk_id_responsable` (`id_responsable`),
  CONSTRAINT `fk_id_responsable` FOREIGN KEY (`id_responsable`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idgrupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_trabajos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idrefertiempo` FOREIGN KEY (`id_refertiempo`) REFERENCES `param_referenciales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_iduser` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cab_actividad`
--

LOCK TABLES `cab_actividad` WRITE;
/*!40000 ALTER TABLE `cab_actividad` DISABLE KEYS */;
INSERT INTO `cab_actividad` VALUES (26,89,NULL,'u',17,'Trabajo de Titulación','Proyecto que se desglosa en 4 partes, para realizar el proceso de investigación y desarrollo del trabajo de titulación',4,'1',15,'2018-10-15 05:00:00','s','2019-02-15 05:00:00',NULL,NULL,'2019-03-06 02:30:35','2019-03-06 07:15:41',NULL),(27,NULL,7,'gt',17,'Proyecto Productores','Prueba 11',1,'0',13,'2019-03-06 21:43:35','s','2019-03-07 21:43:35',NULL,'2019-03-07 17:32:04','2019-03-07 02:43:55','2019-03-07 17:32:04','2019-03-07 17:32:04'),(28,89,NULL,'u',17,'Implementación Plataforma web','es una implementación con pruebas',5,'1',12,'2019-03-07 17:48:11','s','2019-03-07 22:48:11',NULL,NULL,'2019-03-07 22:50:47','2019-03-07 22:50:47',NULL);
/*!40000 ALTER TABLE `cab_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_actividad`
--

DROP TABLE IF EXISTS `det_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_actividad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(10) unsigned NOT NULL,
  `id_responsable` int(11) unsigned DEFAULT NULL,
  `id_tipoactividad` int(10) unsigned DEFAULT NULL,
  `id_prioridad` int(11) unsigned DEFAULT NULL,
  `nombre` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `id_refertiempo` int(11) unsigned DEFAULT NULL,
  `ultavance` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `fecha_ultavance` timestamp NULL DEFAULT NULL,
  `activo` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idcabecera` (`id_cabecera`),
  KEY `fk_idresponsable` (`id_responsable`),
  KEY `fk_idrefer_tiempo` (`id_refertiempo`),
  KEY `fk_idtipoactividad` (`id_tipoactividad`),
  KEY `fk_idprioridad` (`id_prioridad`),
  CONSTRAINT `fk_idcabecera` FOREIGN KEY (`id_cabecera`) REFERENCES `cab_actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idprioridad` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idrefer_tiempo` FOREIGN KEY (`id_refertiempo`) REFERENCES `param_referenciales` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idresponsable` FOREIGN KEY (`id_responsable`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idtipoactividad` FOREIGN KEY (`id_tipoactividad`) REFERENCES `tipo_actividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_actividad`
--

LOCK TABLES `det_actividad` WRITE;
/*!40000 ALTER TABLE `det_actividad` DISABLE KEYS */;
INSERT INTO `det_actividad` VALUES (67,26,89,2,4,'Desarrollo de Capítulo 1 - anteproyecto','2018-10-15 05:00:00',2,14,'100%','2018-10-29 05:00:00','2019-03-06 00:13:43','0','2019-03-06 04:48:20','2019-03-06 00:13:43',NULL),(68,26,89,2,5,'Desarollo de Capítulo 1 - Objetivos, Alcance, Estructura base del documento de titulación','2018-10-23 00:25:33',3,14,'100%','2018-11-13 00:25:33','2019-03-06 03:45:47','0','2019-03-06 05:26:41','2019-03-06 03:45:47',NULL),(69,26,89,2,5,'Desarrollo de Capítulo 1 - Metodología de Investigación y Referencias Bibliográficas','2018-10-29 05:00:00',2,14,'100%','2018-11-12 05:00:00','2019-03-06 03:57:29','0','2019-03-06 07:15:04','2019-03-06 03:57:29',NULL),(70,26,89,4,5,'Revisión de Capítulo 1','2018-11-05 05:00:00',1,14,'100%','2018-11-12 05:00:00','2019-03-06 15:57:04','0','2019-03-06 07:17:38','2019-03-06 15:57:04',NULL),(71,26,89,2,5,'Desarrollo de Capítulo 2 - Marco Teórico','2018-11-12 05:00:00',2,14,'100%','2018-11-26 05:00:00','2019-03-06 16:09:34','0','2019-03-06 07:31:01','2019-03-06 16:09:34',NULL),(72,26,89,2,5,'Desarrollo de Capítulo 2 - Marco Conceptual','2018-11-19 15:30:00',2,14,'100%','2018-12-03 15:30:00','2019-03-06 16:19:47','0','2019-03-06 07:34:54','2019-03-06 16:19:47',NULL),(73,26,89,2,5,'Desarrollo de Capítulo 2 - Ámbito de Aplicación','2018-11-26 15:30:00',1,14,'100%','2018-12-03 15:30:00','2019-03-06 16:28:12','0','2019-03-06 07:37:11','2019-03-06 16:28:12',NULL),(74,26,89,4,5,'Revisión de Capítulo 2','2018-11-26 05:00:00',1,14,'100%','2018-12-03 05:00:00','2019-03-06 16:21:53','0','2019-03-06 07:38:45','2019-03-06 16:21:53',NULL),(75,26,89,2,3,'Desarrollo de Capítulo 3 - Metodología de la Investigación','2018-12-03 05:00:00',15,13,'100%','2018-12-18 05:00:00','2019-03-06 16:32:53','0','2019-03-06 07:43:19','2019-03-06 16:32:53',NULL),(76,26,89,2,3,'Desarrollo de Capítulo 3 - Metodología de Desarrollo','2018-12-17 05:00:00',15,13,'100%','2019-01-01 05:00:00','2019-03-06 16:35:13','0','2019-03-06 07:45:22','2019-03-06 16:35:13',NULL),(77,26,89,2,5,'Desarrollo de Capítulo 3 - Análisis de Resultados','2018-12-17 05:00:00',3,13,'100%','2018-12-20 05:00:00','2019-03-06 16:36:26','0','2019-03-06 07:47:04','2019-03-06 16:36:26',NULL),(78,26,89,4,5,'Revisión de Capítulo 3','2018-12-24 15:00:00',3,13,'100%','2018-12-27 15:00:00','2019-03-06 16:37:18','0','2019-03-06 07:48:48','2019-03-06 16:37:18',NULL),(79,26,89,6,5,'Desarrollo de Capítulo 4 - Diseño, codificación, creación de la aplicación web','2019-01-02 15:00:00',1,15,'100%','2019-02-02 15:00:00','2019-03-06 16:44:13','0','2019-03-06 07:54:06','2019-03-06 16:44:13',NULL),(80,26,89,2,3,'Desarrollo de Capítulo 4 - Documentación de la propuesta y desarrollo de la solución tecnológica','2019-02-04 05:00:00',1,14,'100%','2019-02-11 05:00:00','2019-03-06 16:51:09','0','2019-03-06 07:59:43','2019-03-06 16:51:09',NULL),(81,26,89,4,3,'Revisión de los módulos de la aplicación web - Revisión de la documentación del capítulo 4','2019-02-11 15:30:00',3,13,'100%','2019-02-14 15:30:00','2019-03-06 16:55:07','0','2019-03-06 08:03:01','2019-03-06 16:55:07',NULL),(84,27,64,2,4,'Actividad 111','2019-03-06 21:47:01',2,12,'80%','2019-03-06 23:47:01','2019-03-07 17:09:57','0','2019-03-07 02:47:37','2019-03-07 17:32:04','2019-03-07 17:32:04'),(85,27,63,2,5,'Actividad 22','2019-03-06 21:47:37',2,12,NULL,'2019-03-06 23:47:37',NULL,'0','2019-03-07 02:48:15','2019-03-07 17:32:04','2019-03-07 17:32:04'),(86,28,89,6,5,'Actividad Instalación de paquetes','2019-03-07 17:51:59',2,12,'40%','2019-03-07 19:51:59','2019-03-07 18:24:47','1','2019-03-07 22:52:48','2019-03-07 18:24:47',NULL);
/*!40000 ALTER TABLE `det_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (2,'Estado 20%','20%','2019-01-20 03:52:59','2019-01-20 04:02:00',NULL),(3,'Estado 40%','40%','2019-01-20 03:54:08','2019-01-20 03:54:08',NULL),(4,'Estado 60%','60%','2019-01-20 03:54:38','2019-01-20 03:54:38',NULL),(5,'Estado 80%','80%','2019-01-20 03:54:53','2019-01-20 03:54:53',NULL),(6,'Estado 100%','100%','2019-01-27 22:08:13','2019-01-27 22:08:13',NULL);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_trabajos`
--

DROP TABLE IF EXISTS `grupos_trabajos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupos_trabajos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuarios` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_trabajos`
--

LOCK TABLES `grupos_trabajos` WRITE;
/*!40000 ALTER TABLE `grupos_trabajos` DISABLE KEYS */;
INSERT INTO `grupos_trabajos` VALUES (7,'Productores',';57;58;63;64;',';adriana.bayona;fernando.vallejo;belen.landivar;jose.haz;','2019-03-07 02:30:05','2019-03-07 02:41:43',NULL);
/*!40000 ALTER TABLE `grupos_trabajos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historia_actividad`
--

DROP TABLE IF EXISTS `historia_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historia_actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(11) unsigned DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fechahistoria` timestamp NULL DEFAULT NULL,
  `observacion` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idcabecera_historia` (`id_cabecera`),
  CONSTRAINT `fk_idcabecera_historia` FOREIGN KEY (`id_cabecera`) REFERENCES `cab_actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historia_actividad`
--

LOCK TABLES `historia_actividad` WRITE;
/*!40000 ALTER TABLE `historia_actividad` DISABLE KEYS */;
INSERT INTO `historia_actividad` VALUES (1,27,'Baja','2019-03-07 17:32:04','Proyecto de Prueba','2019-03-07 17:32:04','2019-03-07 17:32:04',NULL);
/*!40000 ALTER TABLE `historia_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (36,'2014_10_12_000000_create_users_table',1),(37,'2014_10_12_100000_create_password_resets_table',1),(38,'2019_01_03_154548_create_roles_table',1),(39,'2019_01_03_155042_create_rol_user_table',1),(40,'2019_01_03_155326_create_param_referenciales_table',1),(41,'2019_01_03_160212_create_tipo_prioridad_table',1),(42,'2019_01_03_160922_create_tipo_actividades_table',1),(43,'2019_01_03_161413_create_grupos_trabajos_table',1),(44,'2019_01_03_161554_create_estado_table',1),(45,'2019_01_03_161752_create_cab_actividad_table',1),(46,'2019_01_03_162514_create_det_actividad_table',1),(47,'2019_01_03_163741_create_seg_actividades_table',1),(48,'2019_01_03_164142_create_bitacora_actividades_table',1),(49,'2019_01_31_154146_create_bouncer_tables',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `param_referenciales`
--

DROP TABLE IF EXISTS `param_referenciales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `param_referenciales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grupo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `param_referenciales`
--

LOCK TABLES `param_referenciales` WRITE;
/*!40000 ALTER TABLE `param_referenciales` DISABLE KEYS */;
INSERT INTO `param_referenciales` VALUES (1,'UCSG-email','para','info@edu.ucsgede.edu.ec','Es el email por default','2019-01-07 23:49:33','2019-01-08 00:00:19','2019-01-08 00:00:19'),(2,'General-Actividades','Tipo','Principal','Clasificación Principal','2019-01-09 00:15:14','2019-01-09 00:15:14',NULL),(3,'General-Actividades','Tipo','Secundario','Clasificación Secundaria','2019-01-09 00:17:19','2019-01-09 00:17:19',NULL),(4,'Seguridad','Roles','Administrador','clasificación de rol tipo administrador','2019-01-10 21:53:43','2019-01-10 22:08:31',NULL),(5,'Seguridad','Roles','Supervisor','clasificación de rol tipo supervisor','2019-01-10 21:54:32','2019-01-10 22:08:43',NULL),(6,'Seguridad','Roles','Recurso','clasificación de rol tipo recurso','2019-01-10 21:55:01','2019-01-10 22:08:57',NULL),(12,'Proyecto','Tiempo','Hora','Intervalo de tiempo - Hora',NULL,NULL,NULL),(13,'Proyecto','Tiempo','Día','Intervalo de tiempo - Día',NULL,NULL,NULL),(14,'Proyecto','Tiempo','Semana','Intervalo de tiempo - Semana',NULL,NULL,NULL),(15,'Proyecto','Tiempo','Mes','Intervalo de tiempo - Mes',NULL,NULL,NULL),(16,'Proyecto','Tiempo','Año','Intervalo de tiempo - Año',NULL,NULL,NULL),(17,'Correo','Asunto-Proyectos','Asignación de Proyectos','Asunto del correo para notificar los correos','2019-03-06 03:48:42','2019-03-06 03:48:42',NULL),(18,'Correo','Email-Administrador','crispal94@hotmail.com','Correo del administrador de la plataforma','2019-03-06 04:15:47','2019-03-06 04:36:37',NULL),(19,'Correo','Asunto-Actividades','Asignación de Actividades','Asunto del correo de notificación de actividad para notificar los correos','2019-03-06 04:43:37','2019-03-06 04:43:37',NULL),(20,'Correo','Asunto-Avances','Registro de Avances','Asunto del correo de notificación de avance para notificar los correos','2019-03-06 05:03:04','2019-03-06 05:03:04',NULL);
/*!40000 ALTER TABLE `param_referenciales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `ability_id` int(10) unsigned NOT NULL,
  `entity_id` int(10) unsigned NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forbidden` tinyint(1) NOT NULL DEFAULT '0',
  `scope` int(11) DEFAULT NULL,
  KEY `permissions_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `permissions_ability_id_index` (`ability_id`),
  KEY `permissions_scope_index` (`scope`),
  CONSTRAINT `permissions_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `abilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (2,1,'roles',0,NULL),(3,1,'roles',0,NULL),(4,1,'roles',0,NULL),(5,1,'roles',0,NULL),(6,1,'roles',0,NULL),(7,1,'roles',0,NULL),(8,1,'roles',0,NULL),(9,1,'roles',0,NULL),(7,2,'roles',0,NULL),(8,2,'roles',0,NULL),(9,2,'roles',0,NULL),(8,3,'roles',0,NULL),(9,3,'roles',0,NULL),(10,1,'roles',0,NULL),(13,2,'roles',0,NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prioridades`
--

DROP TABLE IF EXISTS `prioridades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prioridades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peso` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prioridades`
--

LOCK TABLES `prioridades` WRITE;
/*!40000 ALTER TABLE `prioridades` DISABLE KEYS */;
INSERT INTO `prioridades` VALUES (3,'Urgente',100,'2019-03-06 02:21:22','2019-03-06 02:21:22',NULL),(4,'Normal',20,'2019-03-06 02:21:41','2019-03-06 02:21:41',NULL),(5,'Importante',80,'2019-03-06 02:23:06','2019-03-06 02:23:06',NULL);
/*!40000 ALTER TABLE `prioridades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`,`scope`),
  KEY `roles_scope_index` (`scope`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrador',NULL,NULL,'2019-01-31 21:19:34','2019-01-31 21:19:34',NULL),(2,'super','Supervisor',NULL,NULL,'2019-01-31 21:42:01','2019-01-31 21:42:01',NULL),(3,'recur','Recurso',NULL,NULL,'2019-01-31 21:42:01','2019-01-31 21:42:01',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_tipo`
--

DROP TABLE IF EXISTS `roles_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_tipo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_roles` int(11) unsigned DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idroles_tipo` (`id_roles`),
  CONSTRAINT `fk_idroles_tipo` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_tipo`
--

LOCK TABLES `roles_tipo` WRITE;
/*!40000 ALTER TABLE `roles_tipo` DISABLE KEYS */;
INSERT INTO `roles_tipo` VALUES (4,1,'Director de Operaciones e Ingeniería',NULL,NULL,NULL),(5,3,'Camarógrafo','2019-03-05 22:29:44','2019-03-05 22:29:44',NULL),(6,2,'Director de Cámaras','2019-03-05 22:30:15','2019-03-05 22:30:15',NULL),(7,3,'Operador de Sonido','2019-03-05 22:34:37','2019-03-05 22:34:58',NULL),(8,3,'Diseñador Gráfico','2019-03-05 22:35:22','2019-03-05 22:35:22',NULL),(9,1,'Editor','2019-03-05 22:36:23','2019-03-05 22:36:23',NULL),(10,2,'Jefe de Posproducción','2019-03-05 22:37:27','2019-03-05 22:37:27',NULL),(11,3,'Asistente','2019-03-05 22:37:56','2019-03-05 22:37:56',NULL),(12,3,'Tramoya','2019-03-05 22:41:51','2019-03-05 22:41:51',NULL),(13,3,'Asistente Técnico','2019-03-05 22:42:41','2019-03-05 22:42:41',NULL),(14,3,'Luminito','2019-03-05 22:43:04','2019-03-05 22:43:04',NULL),(15,3,'Técnico en Redes y Servidores','2019-03-05 22:44:01','2019-03-05 22:44:01',NULL),(16,3,'Operador de Servidores','2019-03-05 22:44:36','2019-03-05 22:44:55',NULL),(17,3,'Asistente de Electricidad','2019-03-05 22:45:28','2019-03-05 22:45:28',NULL),(18,3,'Asistente de Ingeniería','2019-03-05 22:47:50','2019-03-05 22:47:50',NULL),(19,2,'Jefe de Ingeniería','2019-03-05 22:48:16','2019-03-05 22:48:16',NULL),(20,3,'Videotecario','2019-03-05 22:48:35','2019-03-05 22:48:35',NULL),(21,2,'Jefe del Departamento Web y Comunicaciones','2019-03-05 22:52:38','2019-03-05 22:52:38',NULL),(22,3,'Web Master Departamento Web y Comunicaciones','2019-03-05 22:53:15','2019-03-05 22:53:15',NULL),(23,3,'Mensajero','2019-03-05 22:53:41','2019-03-05 22:53:41',NULL),(24,3,'Secretaría Administrativa','2019-03-05 22:54:07','2019-03-05 22:54:07',NULL),(25,2,'Coordinador General','2019-03-05 22:54:59','2019-03-05 22:54:59',NULL),(26,3,'Anchor','2019-03-05 22:59:00','2019-03-05 22:59:00',NULL),(27,3,'Productor','2019-03-05 22:59:39','2019-03-05 22:59:39',NULL),(28,2,'Jefe de Producción y Programación','2019-03-05 23:00:53','2019-03-05 23:00:53',NULL),(29,3,'Maquillador','2019-03-05 23:01:14','2019-03-05 23:01:14',NULL),(30,2,'Reportero - Investigador','2019-03-05 23:01:32','2019-03-05 23:01:32',NULL),(31,2,'Productor General','2019-03-05 23:01:55','2019-03-05 23:01:55',NULL),(32,3,'Editor de Contenido','2019-03-05 23:02:33','2019-03-05 23:02:33',NULL),(33,3,'Operador','2019-03-05 23:03:06','2019-03-05 23:03:06',NULL),(34,3,'Redactor','2019-03-05 23:03:41','2019-03-05 23:03:41',NULL);
/*!40000 ALTER TABLE `roles_tipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seg_actividades`
--

DROP TABLE IF EXISTS `seg_actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seg_actividades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(10) unsigned NOT NULL,
  `id_detalle` int(10) unsigned NOT NULL,
  `id_estado` int(10) unsigned NOT NULL,
  `avance` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secuencial_avance` bigint(20) DEFAULT NULL,
  `fechaavance` timestamp NULL DEFAULT NULL,
  `observacion` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seg_actividades_id_cabecera_foreign` (`id_cabecera`),
  KEY `seg_actividades_id_detalle_foreign` (`id_detalle`),
  KEY `seg_actividades_id_estado_foreign` (`id_estado`),
  CONSTRAINT `seg_actividades_id_cabecera_foreign` FOREIGN KEY (`id_cabecera`) REFERENCES `cab_actividad` (`id`),
  CONSTRAINT `seg_actividades_id_detalle_foreign` FOREIGN KEY (`id_detalle`) REFERENCES `det_actividad` (`id`),
  CONSTRAINT `seg_actividades_id_estado_foreign` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seg_actividades`
--

LOCK TABLES `seg_actividades` WRITE;
/*!40000 ALTER TABLE `seg_actividades` DISABLE KEYS */;
INSERT INTO `seg_actividades` VALUES (85,26,67,2,'20%',1,'2019-03-06 00:06:45','Planteamiento de problema y objetivos','2019-03-06 00:06:49','2019-03-06 00:06:49',NULL),(86,26,67,3,'40%',2,'2019-03-06 00:12:09','Desarrollo de metodología de investigación','2019-03-06 00:12:12','2019-03-06 00:12:12',NULL),(87,26,67,4,'60%',3,'2019-03-06 00:13:11','Desarrollo de justificación del anteproyecto','2019-03-06 00:13:14','2019-03-06 00:13:14',NULL),(88,26,67,6,'100%',4,'2019-03-06 00:13:41','Desarrollo de Alcance y aprobación de tema para trabajo de titulación','2019-03-06 00:13:43','2019-03-06 00:13:43',NULL),(89,26,68,2,'20%',1,'2019-03-06 03:32:22','Desarrollo de objetivos específicos, desarrollo de la pregunta de investigación','2019-03-06 03:32:29','2019-03-06 03:32:29',NULL),(90,26,68,3,'40%',2,'2019-03-06 03:43:01','Desarrollo de planteamiento del problema e introducción a el problema','2019-03-06 03:43:08','2019-03-06 03:43:08',NULL),(91,26,68,4,'60%',3,'2019-03-06 03:43:43','Documentación del alcance y justificación','2019-03-06 03:43:55','2019-03-06 03:43:55',NULL),(92,26,68,5,'80%',4,'2019-03-06 03:45:27','Modificación del alcance y pregunta de investigación','2019-03-06 03:45:27','2019-03-06 03:45:27',NULL),(93,26,68,6,'100%',5,'2019-03-06 03:45:47','Revisión y modificación del alcance','2019-03-06 03:45:47','2019-03-06 03:45:47',NULL),(94,26,69,3,'40%',1,'2019-03-06 03:55:19','Investigación de la metodología de investigación','2019-03-06 03:55:19','2019-03-06 03:55:19',NULL),(95,26,69,4,'60%',2,'2019-03-06 03:55:58','Investigación del enfoque y técnicas para la metodología de investigación','2019-03-06 03:55:58','2019-03-06 03:55:58',NULL),(96,26,69,5,'80%',3,'2019-03-06 03:56:44','Organización de las fuentes bibliográficas con el software Zotero para la citaciones con el formato APA 6','2019-03-06 03:56:44','2019-03-06 03:56:44',NULL),(97,26,69,6,'100%',4,'2019-03-06 03:57:29','Investigación de la metodología de desarrollo (Programación Extrema)','2019-03-06 03:57:29','2019-03-06 03:57:29',NULL),(98,26,70,6,'100%',1,'2019-03-06 15:57:04','Cambios en la información encontrado del capitulo 1','2019-03-06 15:57:04','2019-03-06 15:57:04',NULL),(99,26,71,2,'20%',1,'2019-03-06 16:05:09','Investigación: importancia de la comunicación y comunicación organizacional','2019-03-06 16:05:09','2019-03-06 16:05:09',NULL),(100,26,71,3,'40%',2,'2019-03-06 16:06:43','Investigación: comunicación estratégica y la comunicación en las comunidades universitarias','2019-03-06 16:06:43','2019-03-06 16:06:43',NULL),(101,26,71,4,'60%',3,'2019-03-06 16:08:10','Investigación: La Comunicación en las comunidades universitarias','2019-03-06 16:08:10','2019-03-06 16:08:10',NULL),(102,26,71,5,'80%',4,'2019-03-06 16:08:55','Investigación: La Comunicación Institucional como base para la Competitividad','2019-03-06 16:08:55','2019-03-06 16:08:55',NULL),(103,26,71,6,'100%',5,'2019-03-06 16:09:34','Investigación: Control Interno y Sistema de Gestión de Tareas','2019-03-06 16:09:34','2019-03-06 16:09:34',NULL),(104,26,72,2,'20%',1,'2019-03-06 16:12:09','Investigación: Ingeniería de Procesos Web','2019-03-06 16:12:09','2019-03-06 16:12:09',NULL),(105,26,72,3,'40%',2,'2019-03-06 16:13:11','Investigación: Servidor Web y Aplicación Web','2019-03-06 16:13:11','2019-03-06 16:13:11',NULL),(106,26,72,4,'60%',3,'2019-03-06 16:18:17','Investigación: Front-end y Back-end','2019-03-06 16:18:17','2019-03-06 16:18:17',NULL),(107,26,72,5,'80%',4,'2019-03-06 16:18:54','Investigación: Lenguajes de Programación Web =','2019-03-06 16:18:54','2019-03-06 16:18:54',NULL),(108,26,72,6,'100%',5,'2019-03-06 16:19:47','Investigación: Base de Datos y Capas de Desarrollo de Software','2019-03-06 16:19:48','2019-03-06 16:19:48',NULL),(109,26,74,6,'100%',1,'2019-03-06 16:21:53','Cambios y modificaciones en el contenido de la información del capítulo 2','2019-03-06 16:21:53','2019-03-06 16:21:53',NULL),(110,26,73,2,'20%',1,'2019-03-06 16:24:25','Investigación: Historia de la televisión','2019-03-06 16:24:25','2019-03-06 16:24:25',NULL),(111,26,73,3,'40%',2,'2019-03-06 16:27:08','Investigación: Televisión universitaria','2019-03-06 16:27:08','2019-03-06 16:27:08',NULL),(112,26,73,4,'60%',3,'2019-03-06 16:27:34','Investigación: Historia del canal de radio y televisión UCSG','2019-03-06 16:27:34','2019-03-06 16:27:34',NULL),(113,26,73,6,'100%',4,'2019-03-06 16:28:11','Investigación: Funciones de producción y operacionales del canal de radio y televisión UCSG','2019-03-06 16:28:12','2019-03-06 16:28:12',NULL),(114,26,75,3,'40%',1,'2019-03-06 16:31:29','Investigación: Investigación descriptiva','2019-03-06 16:31:29','2019-03-06 16:31:29',NULL),(115,26,75,4,'60%',2,'2019-03-06 16:31:58','Investigación: Enfoque Cualitativo','2019-03-06 16:31:58','2019-03-06 16:31:58',NULL),(116,26,75,6,'100%',3,'2019-03-06 16:32:53','Herramientas de investigación: Entrevistas al personal del canal de la universidad','2019-03-06 16:32:53','2019-03-06 16:32:53',NULL),(117,26,76,2,'20%',1,'2019-03-06 16:34:13','Investigación: Características de la programación ágil (XP)','2019-03-06 16:34:13','2019-03-06 16:34:13',NULL),(118,26,76,4,'60%',2,'2019-03-06 16:34:34','Investigación: Fases de la programación ágil (XP)','2019-03-06 16:34:34','2019-03-06 16:34:34',NULL),(119,26,76,5,'80%',3,'2019-03-06 16:34:49','Investigación: Ciclo de la programación ágil (XP)','2019-03-06 16:34:49','2019-03-06 16:34:49',NULL),(120,26,76,6,'100%',4,'2019-03-06 16:35:13','Investigación: Actividades básicas de la programación ágil (XP)','2019-03-06 16:35:13','2019-03-06 16:35:13',NULL),(121,26,77,6,'100%',1,'2019-03-06 16:36:26','Análisis y síntesis de los resultados obtenidos de las entrevistas realizadas','2019-03-06 16:36:26','2019-03-06 16:36:26',NULL),(122,26,78,6,'100%',1,'2019-03-06 16:37:18','Revisión y cambios en el contenido del capítulo 3','2019-03-06 16:37:18','2019-03-06 16:37:18',NULL),(123,26,79,2,'20%',1,'2019-03-06 16:38:10','Desarrollo de módulo de seguridad y roles, registro y login de usuarios','2019-03-06 16:38:10','2019-03-06 16:38:10',NULL),(124,26,79,3,'40%',2,'2019-03-06 16:39:42','Desarrollo de módulo de parámetros generales y grupo de trabajos','2019-03-06 16:39:42','2019-03-06 16:39:42',NULL),(125,26,79,4,'60%',3,'2019-03-06 16:40:16','Desarrollo de módulo para crear proyectos, actividades y avances','2019-03-06 16:40:16','2019-03-06 16:40:16',NULL),(126,26,79,5,'80%',4,'2019-03-06 16:40:44','Desarrollo de módulo de reportes: general, novedades e historia','2019-03-06 16:40:44','2019-03-06 16:40:44',NULL),(127,26,79,6,'100%',5,'2019-03-06 16:44:13','Optimización de procesos y mejoras contínuas a los módulos','2019-03-06 16:44:13','2019-03-06 16:44:13',NULL),(128,26,80,2,'20%',1,'2019-03-06 16:47:47','Documentación: Introducción, objetivo y responsables','2019-03-06 16:47:48','2019-03-06 16:47:48',NULL),(129,26,80,3,'40%',2,'2019-03-06 16:48:18','Documentación: Descripción de la plataforma web','2019-03-06 16:48:18','2019-03-06 16:48:18',NULL),(130,26,80,4,'60%',3,'2019-03-06 16:49:28','Documentación: Diagrama de Procesos, Modelo Entidad-relación','2019-03-06 16:49:28','2019-03-06 16:49:28',NULL),(131,26,80,5,'80%',4,'2019-03-06 16:50:40','Documentación: Modelos-Eloquent ORM, Vistas, Controladores','2019-03-06 16:50:40','2019-03-06 16:50:40',NULL),(132,26,80,6,'100%',5,'2019-03-06 16:51:09','Documentación: Implementación','2019-03-06 16:51:09','2019-03-06 16:51:09',NULL),(133,26,81,6,'100%',1,'2019-03-06 16:55:07','Cambios y mejoras en la documentación de todos los capítulos, desarrollo de la resumen, introducción, conclusiones y recomendaciones','2019-03-06 16:55:07','2019-03-06 16:55:07',NULL),(134,27,84,3,'40%',1,'2019-03-07 17:08:13','dsdsdd','2019-03-07 17:08:19','2019-03-07 17:32:04','2019-03-07 17:32:04'),(135,27,84,4,'60%',2,'2019-03-07 17:09:07','dsdsdsds','2019-03-07 17:09:10','2019-03-07 17:32:04','2019-03-07 17:32:04'),(136,27,84,5,'80%',3,'2019-03-07 17:09:52','dsdsdsdsd','2019-03-07 17:09:57','2019-03-07 17:32:04','2019-03-07 17:32:04'),(137,28,86,3,'40%',1,'2019-03-07 18:24:47','hola 12','2019-03-07 18:24:26','2019-03-07 18:24:47',NULL);
/*!40000 ALTER TABLE `seg_actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seg_novedades`
--

DROP TABLE IF EXISTS `seg_novedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seg_novedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cabecera` int(11) unsigned DEFAULT NULL,
  `id_avance` int(11) unsigned DEFAULT NULL,
  `id_actividad` int(11) unsigned DEFAULT NULL,
  `estado_nuevo` varchar(150) DEFAULT NULL,
  `estado_anterior` varchar(150) DEFAULT NULL,
  `observacion_anterior` varchar(1000) DEFAULT NULL,
  `observacion_nuevo` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `fecha_anterior` timestamp NULL DEFAULT NULL,
  `fecha_nuevo` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idcabecera_novedades` (`id_cabecera`),
  KEY `fk_idavance` (`id_avance`),
  KEY `fk_idactividad` (`id_actividad`),
  CONSTRAINT `fk_idactividad` FOREIGN KEY (`id_actividad`) REFERENCES `det_actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idavance` FOREIGN KEY (`id_avance`) REFERENCES `seg_actividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idcabecera_novedades` FOREIGN KEY (`id_cabecera`) REFERENCES `cab_actividad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seg_novedades`
--

LOCK TABLES `seg_novedades` WRITE;
/*!40000 ALTER TABLE `seg_novedades` DISABLE KEYS */;
INSERT INTO `seg_novedades` VALUES (1,28,137,86,'40%','40%','hola','hola 12','2019-03-07 18:24:47','2019-03-07 18:24:47',NULL,'2019-03-07 18:24:21','2019-03-07 18:24:47');
/*!40000 ALTER TABLE `seg_novedades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_actividades`
--

DROP TABLE IF EXISTS `tipo_actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_actividades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_referencia` int(10) unsigned NOT NULL,
  `descripcion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_actividades_id_referencia_foreign` (`id_referencia`),
  CONSTRAINT `tipo_actividades_id_referencia_foreign` FOREIGN KEY (`id_referencia`) REFERENCES `param_referenciales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_actividades`
--

LOCK TABLES `tipo_actividades` WRITE;
/*!40000 ALTER TABLE `tipo_actividades` DISABLE KEYS */;
INSERT INTO `tipo_actividades` VALUES (2,2,'Documentación','2019-03-06 02:23:35','2019-03-06 02:23:35',NULL),(3,2,'Investigación','2019-03-06 02:23:56','2019-03-06 02:23:56',NULL),(4,3,'Revisión','2019-03-06 02:24:09','2019-03-06 02:24:36',NULL),(5,3,'Modificación','2019-03-06 02:24:23','2019-03-06 02:24:23',NULL),(6,2,'Desarrollo de Software','2019-03-06 02:25:41','2019-03-06 02:25:41',NULL);
/*!40000 ALTER TABLE `tipo_actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_roltipo` int(11) unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_idroltipo` (`id_roltipo`),
  CONSTRAINT `fk_idroltipo` FOREIGN KEY (`id_roltipo`) REFERENCES `roles_tipo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (17,4,'César Abel Moreno Redrobán','cesar.moreno','cesar.moreno@cu.ucsg.eduu.ec',NULL,'$2y$10$JwTmOnyE/0QA4r9eRutp3Oka.bMMPBsKOl2.suXE6ZCxHA97pXFzS','bYRRyrbNJT83OybC3nHdcXBLQ33n06sCepVLiv3vZjyl7QDZXJtCtcrmd2rH','2019-03-05 20:58:41','2019-03-07 22:30:16',NULL),(18,11,'Priscila Reyes','priscila.reyes','priscila.reyes@ucsg.com',NULL,'$2y$10$aHxUMOCN4YSTCrdnwZfNweSzHrsIrs3bDJDAAxnxjLv4I2JeaQ3O.',NULL,'2019-03-05 23:10:18','2019-03-05 23:10:18',NULL),(19,12,'Arámbulo Michael','arambulo.michael','arambulo.michael@ucsgtv.com',NULL,'$2y$10$RoTI0qQlu/CMvqonY8QhxOAAw4ppJlYrsmlY9YZ77XXzjmchHuIvC',NULL,'2019-03-05 23:14:07','2019-03-05 23:14:07',NULL),(20,7,'Edward Barrera','edward.barrera','edward.barrera@ucsgtv.com',NULL,'$2y$10$.UBJgTA85qNapVb7m.A3wOj6NGOFdGbIH9/i66jvCgbCCq9UftRbC',NULL,'2019-03-05 23:17:47','2019-03-05 23:17:47',NULL),(21,6,'Johan Pachar','johan.pachar','johan.pachar@ucsgtv.com',NULL,'$2y$10$Gu71vk4oD1P9cdq.MWMXe.9.fqC3VPuAuNZfFsmMLg.bGdOWUBgU.',NULL,'2019-03-05 23:18:33','2019-03-05 23:18:33',NULL),(22,5,'Andrés Isaac Benitez Quezada','andres.benitez','andres.benitez@ucsgtv.com',NULL,'$2y$10$b2UNOn3.fRz9MlEr/Hz6U..tjC2gNRWFqFsPquY1ywr3zZ7bQiXSC',NULL,'2019-03-05 23:20:59','2019-03-05 23:20:59',NULL),(23,14,'Gerardo Gaona','gerardo.gaona','gerardo.gaona@ucsgtv.com',NULL,'$2y$10$hOdCCiBGSM4rVT//08eCVuiAO5nSi0Rk5NvuRGCOSLtN5FPtjy7MS',NULL,'2019-03-05 23:21:33','2019-03-05 23:21:33',NULL),(24,5,'Carlos Robalino','carlos.robalino','carlos.robalino@ucsgtv.com',NULL,'$2y$10$GPe/WI5YteMFVB5qZ2rzsetg5BanzSH85yd7St2XNzydr0idBWJ6O',NULL,'2019-03-05 23:23:49','2019-03-05 23:23:49',NULL),(25,8,'Jannina Cabrera','jannina.cabrera','jannina.cabrera@ucsgtv.com',NULL,'$2y$10$YLZs61U.DZIPqbw1q6V9j.mJD6cj/7yRUpCan1ObrOsnYDy2VVI/6',NULL,'2019-03-05 23:24:52','2019-03-05 23:24:52',NULL),(26,9,'Marco Faicán','marco.faican','marco.faican@ucsgtv.com',NULL,'$2y$10$RJwwfA4eAPz.LHzS1ZVaV.0tdvSgwQA8TFwppPb7B6WQveqBRjteS',NULL,'2019-03-05 23:25:32','2019-03-05 23:25:32',NULL),(27,10,'Victor Patricio Flores Herrera','victor.flores','victor.flores@ucsgtv.com',NULL,'$2y$10$qnq2m59740QCQiapW2J1R.he.0wjvFohvp18Ql68/LzDvsdNySHLS',NULL,'2019-03-05 23:26:39','2019-03-05 23:26:39',NULL),(28,5,'Adrián García Cabrera','adrian.garcia','adrian.garcia@ucstv.com',NULL,'$2y$10$hnWbxh4ecOQcnaKGDqGjBeRFkZxNe4SVo6s71G5IAIPvgos1u91Yq',NULL,'2019-03-05 23:28:52','2019-03-05 23:28:52',NULL),(29,11,'Karola Herrera Bermeo','karola.herrera','karola.herrera@ucsgtv.com',NULL,'$2y$10$ek4sSJk6JIrXkjJyX0muO.bFubcEa/A2D1QrwfYrB22q0u8BuqSrO',NULL,'2019-03-05 23:29:33','2019-03-05 23:29:33',NULL),(30,8,'David Izurieta','david.izurieta','david.izurieta@ucsgtv.com',NULL,'$2y$10$bWoZGBCE6Tqyisxy1mMPpepQoI9Qe5SDyLu7eC4STeFTtNeV15U0a',NULL,'2019-03-05 23:33:25','2019-03-05 23:33:25',NULL),(31,5,'Cesár Pantoja Jurado','cesar.pantoja','cesar.pantoja@ucsgtv.com',NULL,'$2y$10$bAVe/0h0B5cppeUosAUtt.JzDNGalXLafCWRM9.OTrbcE9nnoPcku',NULL,'2019-03-05 23:34:26','2019-03-05 23:34:26',NULL),(32,15,'Andrés Mechan Vaca','andres.mechan','andres.mechan@ucsgtv.com',NULL,'$2y$10$klAjjpcsuEQV4LEeAmlw5.upCSaJ/EecK7hEsF2snSrxMYBdRLdHq',NULL,'2019-03-05 23:35:28','2019-03-05 23:35:28',NULL),(33,9,'Valentina Zavala','valentina.zavala','valentina.zavala@ucsgtv.com',NULL,'$2y$10$D13o.ctXgD61rlcX06Ke5uJydvVJshVI4iSGJE5epExe63PjWJ6DC',NULL,'2019-03-05 23:36:33','2019-03-05 23:36:33',NULL),(34,6,'Byron Mosquera','byron.mosquera','byron.mosquera@ucsgtv.com',NULL,'$2y$10$Cxvx7q1gIsLSw9GOC0iUOupbPX4px7zLMA2CwDFxo28R9DVTOwd6a',NULL,'2019-03-05 23:37:13','2019-03-05 23:37:13',NULL),(35,13,'Ronald Eduardo Noriega Moreno','ronald.noriega','ronald.noriega@ucsgtv.com',NULL,'$2y$10$g8q51n/xdDbAyCA78cltcOC/HQUEheZUgm7vsUVuspyIFcLMhI29i',NULL,'2019-03-05 23:39:12','2019-03-05 23:39:12',NULL),(36,9,'Andrea Naula','andrea.naula','andrea.naula@ucsgtv.com',NULL,'$2y$10$O5KcwnMjAMcEhwF3tkJhYeRvElnBRBNKbmLclSp/PXkUj5vExFQPq',NULL,'2019-03-05 23:39:49','2019-03-05 23:39:49',NULL),(37,15,'Sonia Ordoñez Yagual','sonia.ordoñez','sonia.ordonez@ucsgtv.com',NULL,'$2y$10$tX4PKXF5pGb9CcOaQyQVm.6CFd2MIJj9/sSZNnCv8alFRSHnDSaYq',NULL,'2019-03-05 23:41:19','2019-03-05 23:41:19',NULL),(38,16,'Jonathan Dender','jonathan.dender','jonathan.dender@ucsgtv.com',NULL,'$2y$10$uucnkECS1jlDcoLwLU8sVOGaTztw2ZRhU8FntKuQYum8h.RYvgGn6',NULL,'2019-03-05 23:44:09','2019-03-05 23:44:09',NULL),(39,16,'Jean Carlos Pichardo Duarte','jean.pichardo','jean.pichardo@ucsgtv.com',NULL,'$2y$10$J50yVWHhS5IUUtT8hYHvQuDKIl9mhvXNFNMPXP/zGLuQecq7.F.EW',NULL,'2019-03-05 23:48:13','2019-03-05 23:48:13',NULL),(40,14,'Paúl Salazar','paul.salazar','paul.salazar@ucsgtv.com',NULL,'$2y$10$zNrFuwh0lZlxBkKd99XfnOfs9g/iXuLHb5le0ruu5/WjW5AX9Ozei',NULL,'2019-03-05 23:52:51','2019-03-05 23:52:51',NULL),(41,5,'Vicente Sarmiento de Luca','vicente.sarmiento','vicente.sarmiento@ucsgtv.com',NULL,'$2y$10$hHiKEv/c4LR9ixSAOs8//ucn8vVeMLKEgxxJ8T8fFWus2yajVvRxm',NULL,'2019-03-05 23:53:28','2019-03-05 23:53:28',NULL),(42,17,'Carlos Luis Sánchez','carlos.sanchez','carlos.sanchez@ucsgtv.com',NULL,'$2y$10$ta3xVoZY6PAoomfTPTLluuvOCNFjQaEry9V272vOFOMFbtReqE0IO',NULL,'2019-03-05 23:55:24','2019-03-05 23:55:24',NULL),(43,18,'Rafael Albán','rafael.alban','rafael.alban@ucsgtv.com',NULL,'$2y$10$VH9IfjvbaEihQBCLmt5jUu7BFTp53QYr0jltI./HM02LXVYdtYdiS',NULL,'2019-03-05 23:56:05','2019-03-05 23:56:05',NULL),(44,8,'Manuel Gordon','manuel.gordon','manuel.gordon@ucsgtv.com',NULL,'$2y$10$wCSspkuV6aGFbeLZyGoUGuVOLQ2.HEVbgHugRTs1ltglqZiXG1uB.',NULL,'2019-03-06 00:48:52','2019-03-06 00:48:52',NULL),(45,7,'Alejandro Gabriel Vera Bowen','alejandro.vera','alejandro.vera@ucsgtv.com',NULL,'$2y$10$DvpbZcQrivg0hnUDWptTiOnF7aR4FxxW9cVtFRB6KaC.HbF5uw/B2',NULL,'2019-03-06 01:15:02','2019-03-06 01:15:02',NULL),(46,19,'Jhon Rafael Villacís Castillo','jhon.villacis','jhon.villacis@ucsgtv.com',NULL,'$2y$10$xqzsbMIdf45xFAVWgv../ec3KqKi3pLwigQtObfrWiUAjhVOeZq3e',NULL,'2019-03-06 01:15:45','2019-03-06 01:15:45',NULL),(47,5,'Pedro Villegas','pedro.villegas','pedro.villegas@ucsgtv.com',NULL,'$2y$10$vR9gGYS5C6t8iWKUTg4KtOoO1X2/HxA7Y/2VbRC4bhdoIcF4boqja',NULL,'2019-03-06 01:16:11','2019-03-06 01:16:11',NULL),(48,20,'Michelle Boada','michelle.boada','michelle.boada@ucsgtv.com',NULL,'$2y$10$6D5oStIfF/8a2hCpObkhyOBMc69VQdK/j2YtrjuwXIV82t8hskiY2',NULL,'2019-03-06 01:16:41','2019-03-06 01:16:41',NULL),(49,5,'Ramón Alarcón','ramon.alarcon','ramon.alarcon@ucsgtv.com',NULL,'$2y$10$AKUOhFIqQv1IPxoc8SZ6tuBo6Dh2s8pZrhrth4IzLRK9OFaCwzavy',NULL,'2019-03-06 01:17:12','2019-03-06 01:17:12',NULL),(50,21,'Vicky Chóez Game','vicky.choez','vicky.choez@ucsgtv.com',NULL,'$2y$10$ubV4UdmoCFQBjZ0hZ7PDh./9fleO5h6xM7usylpMpP4LR.QHFDbo.',NULL,'2019-03-06 01:17:48','2019-03-06 01:17:48',NULL),(51,22,'Mayra Cortez','mayra.cortez','mayra.cortez@ucsgtv.com',NULL,'$2y$10$DohGRqcenhc1kprEER8//e1U8zixjDfh0PNKTq3/P25LVCVBp.Qj.',NULL,'2019-03-06 01:18:23','2019-03-06 01:18:23',NULL),(52,23,'Raúl García Suárez','raul.garcia','raul.garcia@ucsgtv.com',NULL,'$2y$10$QKy3/WpqSnHP5YLMKFEto.bzolkSStBj.9fOCbC1z3e6zAN4feA/O',NULL,'2019-03-06 01:19:23','2019-03-06 01:19:23',NULL),(53,24,'Sara Tola Ponguillo','sara.tola','sara.tola@ucsgtv.com',NULL,'$2y$10$40Dd2MgE2n/ru.5N4M3Rk.oesmmCwqp11MjPLkbm.DwPFZdFVX3Le',NULL,'2019-03-06 01:19:56','2019-03-06 01:19:56',NULL),(54,25,'Ronald Mayer','ronald.mayer','ronald.mayer@ucsgtv.com',NULL,'$2y$10$sVnsmu3LLJ2f40KRziA8XuI30O7zouwIf13yZeAZJKV90RaFjqg5O',NULL,'2019-03-06 01:24:44','2019-03-06 01:24:44',NULL),(55,9,'Iván Villafuerte','ivan.villafuerte','ivan.villafuerte@ucsgtv.com',NULL,'$2y$10$GAv88oyDNgtkj3kNcG39xueYO8ui5Jdem.zAwv5SDlF2L2HplMV06',NULL,'2019-03-06 01:25:17','2019-03-06 01:25:17',NULL),(56,26,'María Bernanda Cevallos','maria.bernanda','maria.bernanda@ucsgtv.com',NULL,'$2y$10$K/WEMQX/TVlewBxuoqKfee5tntm7jZ0jtXI26UxVL0JsGRuOI1Gr6',NULL,'2019-03-06 01:26:52','2019-03-06 01:26:52',NULL),(57,27,'Adriana Lissette Bayona Carrera','adriana.bayona','adriana.bayona@ucsgtv.com',NULL,'$2y$10$wnu95ji5rwFTYxLJLosume74SP./H0hoQBZdsaXuxcMfjI8.SK4Km',NULL,'2019-03-06 01:27:32','2019-03-06 01:27:32',NULL),(58,27,'Fernando Vallejo','fernando.vallejo','fernando.vallejo@ucsgtv.com',NULL,'$2y$10$/3fEpC2b9hX3koM9LhQIYOUf1MfW8c1MscLbg/oHrREuaWBOb0uda',NULL,'2019-03-06 01:28:12','2019-03-06 01:28:12',NULL),(59,9,'José Daniel Cuesta Ricaurte','jose.cuesta','jose.cuesta@ucsgtv.com',NULL,'$2y$10$ajcAPtt6yHnSll5RJgpa2uUEYOeFAldiOLxx9bBKf6L/o.vWcmV8i',NULL,'2019-03-06 01:29:01','2019-03-06 01:29:01',NULL),(60,28,'Gioconda García Gaete','gioconda.garcia','gioconda.garcia@ucsgtv.com',NULL,'$2y$10$HPZpkXdClHeMIPj07sW.0eqoVgieBkUjkWtxVWsvGwsOtlURGTCZW',NULL,'2019-03-06 01:30:50','2019-03-06 01:30:50',NULL),(61,29,'Eva Paladines','eva.paladines','eva.paladines@ucsgtv.com',NULL,'$2y$10$qDCfGq7JfCqC8ND6acF4ueVt79U.eArZfpjp.IeulI2c98sQhetNm',NULL,'2019-03-06 01:31:17','2019-03-06 01:31:17',NULL),(62,29,'Tedhy Palacios','tedhy.palacios','tedhy.palacios@ucsgtv.com',NULL,'$2y$10$qJsFMosuetY8Gm6IhO/j5O4ptSWZw4j2z5KOIBfNvL5GX6fIxNKCO',NULL,'2019-03-06 01:32:10','2019-03-06 01:32:10',NULL),(63,27,'Belén Landívar','belen.landivar','belen.landivar@ucsgtv.com',NULL,'$2y$10$4WfAT3uBh4sw4N1wCsuQhuDHR9feLbtkiG/jQnfK7rAmHuwoNM6RO',NULL,'2019-03-06 01:32:51','2019-03-06 01:32:51',NULL),(64,27,'José Luis Haz','jose.haz','jose.haz@ucsgtv.com',NULL,'$2y$10$bxugS5KVYnpPi8HUSS7U/eXhLWu./Iil7z4H4Rl0RsLtZN/wj1.CK',NULL,'2019-03-06 01:33:28','2019-03-06 01:33:28',NULL),(65,26,'Luis Landires','luis.landires','luis.landires@ucsgtv.com',NULL,'$2y$10$DDXSmdIAysr2CZT5uM3/0.j3kiKjMFPOyv4X8FjE./SI6rIEwQHv.',NULL,'2019-03-06 01:34:29','2019-03-06 01:34:29',NULL),(66,26,'Israel Mosquera','israel.mosquera','israel.mosquera@ucsgtv.com',NULL,'$2y$10$He5h/MLzS227BCRz70Dlbu7w7wI.pExbaVVDNS.JrnhVWfGwW.pLG',NULL,'2019-03-06 01:35:11','2019-03-06 01:35:11',NULL),(67,30,'Andrés Chiriboga','andres.chiriboga','andres.chiriboga@ucsgtv.com',NULL,'$2y$10$U4p2Si3IgQft1o1I6WYT7uUUJs7piJlnNr9KAAJ8cnJ.MTqH6aKde',NULL,'2019-03-06 01:35:48','2019-03-06 01:35:48',NULL),(68,26,'Germán Gallardo','german.gallardo','german.gallardo@ucsgtv.com',NULL,'$2y$10$dMgUf4QbPkjlND21vWq5GeVCoAxfY2.3FC7F6av43uOuzPIjVxY4C',NULL,'2019-03-06 01:37:57','2019-03-06 01:37:57',NULL),(69,26,'Jorge Akel','jorge.akel','jorge.akel@ucsgtv.com',NULL,'$2y$10$N9sOAeH4YHIksjJUltYN7OCe5jhPfwEdym.1am3QRvw1r3il3Pooi',NULL,'2019-03-06 01:40:05','2019-03-06 01:40:05',NULL),(70,26,'Sergio Basantes','sergio.basantes','sergio.basantes@ucsgtv.com',NULL,'$2y$10$5WKMxo4K9KZpda4i9VqJI.BetF/hegJEqfJRKWvO/k2nNedD5DRYy',NULL,'2019-03-06 01:40:46','2019-03-06 01:40:46',NULL),(71,26,'Andrea González','andrea.gonzalez','andrea.gonzalez@ucsgtv.com',NULL,'$2y$10$UDI2e3ii/BnqVQALrscu3ON5.d7q8a1NrWyI2GycsrPNIBVFjnZoO',NULL,'2019-03-06 01:41:20','2019-03-06 01:41:20',NULL),(72,9,'Luis Polo','luis.polo','luis.polo@ucsgtv.com',NULL,'$2y$10$C1u.FgPhhMzqF7XNyXs2Kur/8IHATEp/3mPPm7K8Fi1IJ1mRWsim6',NULL,'2019-03-06 01:41:45','2019-03-06 01:41:45',NULL),(73,31,'Nancy Mosquera','nancy.mosquera','nancy.mosquera@ucsgtv.com',NULL,'$2y$10$iIcXG2Pe5EPDp2iT0Us9ve3udHqLV.XO1iG.DK0pI9/kTxuSyk/iy',NULL,'2019-03-06 01:42:33','2019-03-06 01:42:33',NULL),(74,27,'Verónica Henk','veronica.henk','veronica.henk@ucsgtv.com',NULL,'$2y$10$X51EiPdY1Sxate.Hi4hndOrtiRx5ADaWEryH2vEBFeLZy5ReqFm2m',NULL,'2019-03-06 01:43:16','2019-03-06 01:43:16',NULL),(75,27,'Karina Hernández','karina.hernandez','karina.hernandez@ucsgtv.com',NULL,'$2y$10$L6EyF3STgVAu.nWYHFOZ5eFtoYhf8.nw5IKbBIGDxW7WoBr2fKobu',NULL,'2019-03-06 01:43:54','2019-03-06 01:43:54',NULL),(76,30,'Evelyn Palacios','evelyn.palacios','evelyn.palacios@ucsgtv.com',NULL,'$2y$10$ETbZlOGKQw7eG2JFlAJBoeWHF3TN4lCYnuJ64ztXIpbs41Nzg3gbm',NULL,'2019-03-06 01:45:00','2019-03-06 01:45:00',NULL),(77,30,'María de Los Angeles Rendón','maria.rendon','maria.rendon@ucsgtv.com',NULL,'$2y$10$3gxJqo/StDGjX7mmtqg.fOpTeQLj1lLrNOb2Uyrc5vvxgQmpnBTy.',NULL,'2019-03-06 01:46:04','2019-03-06 01:46:04',NULL),(78,32,'Carlos Julio Paredes','carlos.paredes','carlos.paredes@ucsgtv.com',NULL,'$2y$10$SfWT3mZJ./Vb2CZ175xnPeWLTUtSsJw/Wx3ebyfLcD/WHTYFggOLa',NULL,'2019-03-06 01:46:56','2019-03-06 01:46:56',NULL),(79,34,'Martha Cecilia Cantos Pérez','martha.cantos','martha.cantos@ucsgtv.com',NULL,'$2y$10$Qpza/8RZ.hu2iFJ/4m6iCeMm3qUoo7l5VJK1jWT4EuL3uoRnXpici',NULL,'2019-03-06 01:48:04','2019-03-06 01:48:04',NULL),(80,27,'Denisse Gonzaga Landin','denisse.gonzaga','denisse.gonzaga@ucsgtv.com',NULL,'$2y$10$kkEMdYJExph1BoRSAwtav.H5WeEaqAoGmyGTlwyH4CfW8JGRfu.MO',NULL,'2019-03-06 01:48:43','2019-03-06 01:48:43',NULL),(81,33,'Esther Alexandra Lamilla Luna','esther.alexandra','esther.alexandra@ucsgtv.com',NULL,'$2y$10$MCRje85M8fZiVDnPvoAp.ezY3DwC/yhtCU4XalNF67keBGkZ5UA16',NULL,'2019-03-06 01:49:22','2019-03-06 01:49:22',NULL),(82,34,'Pablo Villareal','pablo.villareal','pablo.villareal@ucsgtv.com',NULL,'$2y$10$0J3i7tQ2Eustg7OBhEKNU.MFJaXoyHeEJ3zHHQygcW8cvdF3YLiEu',NULL,'2019-03-06 01:49:57','2019-03-06 01:49:57',NULL),(83,11,'Lilibeth Rodríguez Mendoza','lilibeth.rodriguez','lilibeth.rodriguez@ucsgtv.com',NULL,'$2y$10$MtWBkPJTF5uP9eiioy8nZOsLKIoplHk7eAG8W0XuIEWJ23krDlPci',NULL,'2019-03-06 01:51:14','2019-03-06 01:51:14',NULL),(84,34,'Isabel Ronquillo','isabel.ronquillo','isabel.ronquillo@ucsgtv.com',NULL,'$2y$10$M58amxZb2ZSKGz9Mxoumvuf792F6RbyH4xI4VdC5KN4DKSG3y0m86',NULL,'2019-03-06 01:51:57','2019-03-06 01:51:57',NULL),(85,33,'Jimmy Vera','jimmy.vera','jimmy.vera@ucsgtv.com',NULL,'$2y$10$TiONmmx3DUUE.AGxH/NWXeHMaj9XOjZhVU/aQHXc5U0tDGcOj58c.',NULL,'2019-03-06 01:53:05','2019-03-06 01:53:05',NULL),(86,30,'Carlos Alberto Rivera Arce','carlos.rivera','carlos.rivera@ucsgtv.com',NULL,'$2y$10$LukYblNuXDCqEIkFYaVzvuDJO1idz4b75dYLy.yvuAtyVrtJTUTkS',NULL,'2019-03-06 01:54:49','2019-03-06 01:54:49',NULL),(87,34,'Xavier Méndez','xavier.mendez','xavier.mendez@ucsgtv.com',NULL,'$2y$10$GEr/Kx9myKMIjS/ORUY.wOtNAmsZCcrLMkTLQxD/IwiSZkNSewos.',NULL,'2019-03-06 01:55:30','2019-03-06 01:55:30',NULL),(88,33,'Emanuel Martínez','emanuel.martinez','emanuel.martinez@ucsgtv.com',NULL,'$2y$10$b7lx7XP7pCLK7y4FTtnlQe5mfkN2llOVx8G0TCVUY3rbf37KoscG2',NULL,'2019-03-06 01:56:04','2019-03-06 01:56:04',NULL),(89,33,'Christian Andrés Palacios Menéndez','christian.palacios','crispal94@hotmail.com',NULL,'$2y$10$sOyrLtEtNNi/YoaZ/I0qo.xpuXUILlLwfOQMHPPMcjTF5LYTIKw9S','eS2PGg7wjCIwdCfZwPWodmClftCIaMrvONbIdwrjszCjrmQcWXJUZzMPi112','2019-03-06 02:19:29','2019-03-06 02:19:29',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-09 21:35:51
