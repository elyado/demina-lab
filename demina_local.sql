/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.2.2-MariaDB, for osx10.20 (arm64)
--
-- Host: localhost    Database: demina
-- ------------------------------------------------------
-- Server version	12.2.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `activity_types`
--

DROP TABLE IF EXISTS `activity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activity_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_types`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `activity_types` WRITE;
/*!40000 ALTER TABLE `activity_types` DISABLE KEYS */;
INSERT INTO `activity_types` VALUES
(1,'Cineclub','cineclub','Proyecciones semanales y programación especial de cine.',NULL,NULL,1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(2,'Taller','taller','Procesos formativos impartidos por talleristas externos o colaboradores.',NULL,NULL,1,2,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(3,'Exposición','exposicion','Muestras individuales, colectivas o experimentales.',NULL,NULL,1,3,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(4,'Teatro','teatro','Obras escénicas y microteatro.',NULL,NULL,0,4,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(5,'Danza','danza','Presentaciones, laboratorios y acciones corporales.',NULL,NULL,0,5,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(6,'Conversatorio','conversatorio','Charlas, diálogos y encuentros críticos.',NULL,NULL,0,6,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(7,'Conferencia','conferencia','Presentaciones académicas, artísticas o culturales.',NULL,NULL,0,7,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(8,'Concierto','concierto','Presentaciones musicales en vivo.',NULL,NULL,0,8,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(9,'Cena','cena','Encuentros gastronómicos y cenas especiales.',NULL,NULL,0,9,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(10,'Cata','cata','Catas de vino, mezcal u otras experiencias de degustación.',NULL,NULL,0,10,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(11,'Fiesta / Encuentro','fiesta-encuentro','Eventos sociales, fiestas y encuentros comunitarios.',NULL,NULL,0,11,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(12,'Comida','comida','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n\n',NULL,'sparkles',1,0,'2026-05-12 22:37:27','2026-05-12 22:37:27');
/*!40000 ALTER TABLE `activity_types` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `artworks`
--

DROP TABLE IF EXISTS `artworks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `artworks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `artist_id` bigint(20) unsigned DEFAULT NULL,
  `exhibition_id` bigint(20) unsigned DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `technique` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_for_sale` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(12,2) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'MXN',
  `status` enum('available','sold','not_for_sale','reserved') NOT NULL DEFAULT 'not_for_sale',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artworks_slug_unique` (`slug`),
  KEY `artworks_artist_id_foreign` (`artist_id`),
  KEY `artworks_exhibition_id_foreign` (`exhibition_id`),
  CONSTRAINT `artworks_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `people` (`id`) ON DELETE SET NULL,
  CONSTRAINT `artworks_exhibition_id_foreign` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artworks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `artworks` WRITE;
/*!40000 ALTER TABLE `artworks` DISABLE KEYS */;
INSERT INTO `artworks` VALUES
(1,'Nueva Obra','nueva-obra',1,1,'2020','mixta','20 20 ','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','artworks/01KRD86PQM42874CJ6JXYWDRRE.png',1,20000.00,'MXN','available','2026-05-12 10:47:56','2026-05-12 10:47:56');
/*!40000 ALTER TABLE `artworks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `calls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `call_type` enum('exhibition','workshop','event','residency','collaboration','press','general') NOT NULL DEFAULT 'general',
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `requirements` longtext DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `form_url` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','open','closed','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calls_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calls`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `calls` WRITE;
/*!40000 ALTER TABLE `calls` DISABLE KEYS */;
INSERT INTO `calls` VALUES
(1,'Convocatoria','convocatoria','general','Una convocatoria','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','<p>varias cosas</p><p>otra cosa</p>','2026-05-11','2026-06-07','https://googleforms.com','calls/covers/01KRDBD9D5D306NP7E8SP2H5HW.png','open','2026-05-12 11:43:58','2026-05-12 11:43:58');
/*!40000 ALTER TABLE `calls` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `type` enum('event','exhibition','archive','press','workshop','space','general') NOT NULL DEFAULT 'general',
  `description` text DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Categoría uno','categoria-uno','general','Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.',NULL,0,1,'2026-05-12 11:18:43','2026-05-12 11:18:43'),
(2,'Agenda','agenda','event','Eventos y programación general de Demina.','#111111',1,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(3,'Cineclub','cineclub','event','Proyecciones, ciclos y funciones especiales.','#111111',2,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(4,'Talleres','talleres','workshop','Procesos formativos, laboratorios y talleres.','#111111',3,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(5,'Exposiciones','exposiciones','exhibition','Muestras individuales, colectivas y experimentales.','#111111',4,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(6,'Archivo','archivo','archive','Material documental, memoria visual y registros del espacio.','#111111',5,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(7,'Prensa','prensa','press','Notas, menciones y publicaciones sobre Demina.','#111111',6,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(8,'Espacios','espacios','space','Áreas físicas y dispositivos del laboratorio.','#111111',7,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(9,'General','general','general','Contenido general del sitio.','#111111',8,1,'2026-05-12 11:47:38','2026-05-12 11:47:38'),
(10,'categoia dos','categoia-dos','space','Categoria dos',NULL,9,1,'2026-05-12 22:30:31','2026-05-12 22:30:53');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `is_general` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipment_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
INSERT INTO `equipment` VALUES
(1,'Sistema de bocinas','sistema-de-bocinas','Equipo general de audio para eventos.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(2,'Proyector general','proyector-general','Proyector móvil para distintos espacios.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(3,'Proyector Caja Negra','proyector-caja-negra','Proyector propio de la Caja Negra.',1,0,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(4,'Bocina Bluetooth grande','bocina-bluetooth-grande','Bocina portátil para actividades diversas.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(5,'Sillas','sillas','Sillas disponibles para eventos, talleres y proyecciones.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(6,'Iluminación','iluminacion','Equipo básico de iluminación.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(7,'Pantalla','pantalla','Pantalla para proyecciones.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(8,'Barra','barra','Barra para servicio en actividades.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(9,'Mesas','mesas','Mesas de apoyo para talleres, cenas y eventos.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(10,'Cocina equipada','cocina-equipada','Cocina disponible para cenas y actividades gastronómicas.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(11,'Ventiladores','ventiladores','Ventiladores para uso general.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(12,'Wifi','wifi','Conexión inalámbrica a internet.',1,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(13,'Lamparas Led','lamparas-led','Lamparas led multicolor, muchas cosas',1,1,'2026-05-12 22:24:21','2026-05-12 22:24:21');
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `equipment_space`
--

DROP TABLE IF EXISTS `equipment_space`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_space` (
  `equipment_id` bigint(20) unsigned NOT NULL,
  `space_id` bigint(20) unsigned NOT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`equipment_id`,`space_id`),
  KEY `equipment_space_space_id_foreign` (`space_id`),
  CONSTRAINT `equipment_space_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `equipment_space_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_space`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `equipment_space` WRITE;
/*!40000 ALTER TABLE `equipment_space` DISABLE KEYS */;
INSERT INTO `equipment_space` VALUES
(13,1,NULL),
(13,2,NULL),
(13,3,NULL),
(13,4,NULL),
(13,5,NULL);
/*!40000 ALTER TABLE `equipment_space` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `event_categories`
--

DROP TABLE IF EXISTS `event_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_categories` (
  `event_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`event_id`,`category_id`),
  KEY `event_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `event_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_categories_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `event_categories` WRITE;
/*!40000 ALTER TABLE `event_categories` DISABLE KEYS */;
INSERT INTO `event_categories` VALUES
(4,10);
/*!40000 ALTER TABLE `event_categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `event_people`
--

DROP TABLE IF EXISTS `event_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_people` (
  `event_id` bigint(20) unsigned NOT NULL,
  `person_id` bigint(20) unsigned NOT NULL,
  `role_label` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`event_id`,`person_id`),
  KEY `event_people_person_id_foreign` (`person_id`),
  CONSTRAINT `event_people_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_people_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_people`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `event_people` WRITE;
/*!40000 ALTER TABLE `event_people` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_people` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `event_tags`
--

DROP TABLE IF EXISTS `event_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_tags` (
  `event_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`event_id`,`tag_id`),
  KEY `event_tags_tag_id_foreign` (`tag_id`),
  CONSTRAINT `event_tags_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_tags`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `event_tags` WRITE;
/*!40000 ALTER TABLE `event_tags` DISABLE KEYS */;
INSERT INTO `event_tags` VALUES
(4,7);
/*!40000 ALTER TABLE `event_tags` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `film_title` varchar(220) DEFAULT NULL,
  `film_original_title` varchar(220) DEFAULT NULL,
  `film_director` varchar(180) DEFAULT NULL,
  `film_country` varchar(120) DEFAULT NULL,
  `film_year` year(4) DEFAULT NULL,
  `film_duration_minutes` int(11) DEFAULT NULL,
  `film_classification` varchar(50) DEFAULT NULL,
  `film_genre` varchar(150) DEFAULT NULL,
  `film_synopsis` longtext DEFAULT NULL,
  `film_trailer_url` text DEFAULT NULL,
  `film_poster_image` varchar(255) DEFAULT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL,
  `activity_type_id` bigint(20) unsigned DEFAULT NULL,
  `space_id` bigint(20) unsigned DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_all_day` tinyint(1) NOT NULL DEFAULT 0,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `recurrence_rule` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `recovery_fee` decimal(10,2) DEFAULT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT 0,
  `requires_registration` tinyint(1) NOT NULL DEFAULT 0,
  `registration_url` text DEFAULT NULL,
  `external_ticket_url` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived','cancelled') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 1,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_slug_unique` (`slug`),
  KEY `events_activity_type_id_foreign` (`activity_type_id`),
  KEY `events_space_id_foreign` (`space_id`),
  KEY `events_start_date_index` (`start_date`),
  KEY `events_status_index` (`status`),
  KEY `events_is_featured_index` (`is_featured`),
  CONSTRAINT `events_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `events_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES
(4,'Cuarto Evento','cuarto-evento','nuevo','descropcion','<p>Tunguska event the only home we&#039;ve ever known venture tendrils of gossamer clouds citizens of distant epochs globular star cluster. The carbon in our apple pies muse about Apollonius of Perga a very small stage in a vast cosmic arena bits of moving fluff hundreds of thousands? Another world from which we spring muse about intelligent beings are creatures of the cosmos Cambrian explosion. How far away vastness is bearable only through love a still more glorious dawn awaits vastness is bearable only through love two ghostly white figures in coveralls and helmets are softly dancing something incredible is waiting to be known and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7,5,'2026-05-16',NULL,'14:42:00',NULL,0,0,NULL,12.00,22.00,0,0,NULL,NULL,'events/covers/01KRPNVP187CSRCWM3K7FK5GPE.png','events/posters/01KRPNVP19DHMAST0NEXA5VSPV.jpg','published',1,1,NULL,NULL,NULL,'2026-05-16 02:39:45','2026-05-16 02:42:19'),
(6,'Batman','batman',NULL,NULL,'<p></p>','Batman','Batman night man','Cronenberg','EEUU',2010,140,'C','Acción','<p>Tunguska event the only home we&#039;ve ever known venture tendrils of gossamer clouds citizens of distant epochs globular star cluster. The carbon in our apple pies muse about Apollonius of Perga a very small stage in a vast cosmic arena bits of moving fluff hundreds of thousands? Another world from which we spring muse about intelligent beings are creatures of the cosmos Cambrian explosion. How far away vastness is bearable only through love a still more glorious dawn awaits vastness is bearable only through love two ghostly white figures in coveralls and helmets are softly dancing something incredible is waiting to be known and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>','https://www.youtube.com/watch?v=789hEqi1I9I','events/cineclub/posters/01KRRZM2P1PFDJ4V3J9VZ0V10Q.png',NULL,1,5,'2026-05-16',NULL,'20:00:00',NULL,0,0,NULL,NULL,10.00,0,0,NULL,NULL,'events/cineclub/covers/01KRRYW2V30M8MBJXTD5ECY2EJ.png',NULL,'published',1,1,NULL,NULL,NULL,'2026-05-16 23:55:44','2026-05-17 01:46:14');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `exhibition_events`
--

DROP TABLE IF EXISTS `exhibition_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exhibition_events` (
  `exhibition_id` bigint(20) unsigned NOT NULL,
  `event_id` bigint(20) unsigned NOT NULL,
  `relation_label` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`exhibition_id`,`event_id`),
  KEY `exhibition_events_event_id_foreign` (`event_id`),
  CONSTRAINT `exhibition_events_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exhibition_events_exhibition_id_foreign` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibition_events`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `exhibition_events` WRITE;
/*!40000 ALTER TABLE `exhibition_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `exhibition_events` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `exhibition_people`
--

DROP TABLE IF EXISTS `exhibition_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exhibition_people` (
  `exhibition_id` bigint(20) unsigned NOT NULL,
  `person_id` bigint(20) unsigned NOT NULL,
  `role_label` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`exhibition_id`,`person_id`),
  KEY `exhibition_people_person_id_foreign` (`person_id`),
  CONSTRAINT `exhibition_people_exhibition_id_foreign` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exhibition_people_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibition_people`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `exhibition_people` WRITE;
/*!40000 ALTER TABLE `exhibition_people` DISABLE KEYS */;
INSERT INTO `exhibition_people` VALUES
(1,1,NULL),
(2,1,NULL),
(3,1,NULL);
/*!40000 ALTER TABLE `exhibition_people` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `exhibition_spaces`
--

DROP TABLE IF EXISTS `exhibition_spaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exhibition_spaces` (
  `exhibition_id` bigint(20) unsigned NOT NULL,
  `space_id` bigint(20) unsigned NOT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`exhibition_id`,`space_id`),
  KEY `exhibition_spaces_space_id_foreign` (`space_id`),
  CONSTRAINT `exhibition_spaces_exhibition_id_foreign` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exhibition_spaces_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibition_spaces`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `exhibition_spaces` WRITE;
/*!40000 ALTER TABLE `exhibition_spaces` DISABLE KEYS */;
INSERT INTO `exhibition_spaces` VALUES
(1,5,NULL),
(2,5,NULL),
(3,1,NULL);
/*!40000 ALTER TABLE `exhibition_spaces` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `exhibitions`
--

DROP TABLE IF EXISTS `exhibitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exhibitions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `curatorial_text` longtext DEFAULT NULL,
  `curator_id` bigint(20) unsigned DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `opening_date` date DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `exhibition_type` enum('collective','individual','duo','other') NOT NULL DEFAULT 'collective',
  `status` enum('draft','current','upcoming','past','archived') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 1,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exhibitions_slug_unique` (`slug`),
  KEY `exhibitions_curator_id_foreign` (`curator_id`),
  KEY `exhibitions_start_date_end_date_index` (`start_date`,`end_date`),
  KEY `exhibitions_status_index` (`status`),
  CONSTRAINT `exhibitions_curator_id_foreign` FOREIGN KEY (`curator_id`) REFERENCES `people` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exhibitions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `exhibitions` WRITE;
/*!40000 ALTER TABLE `exhibitions` DISABLE KEYS */;
INSERT INTO `exhibitions` VALUES
(1,'Nuevo Expo','nuevo-expo','cuata','Nueva expo de arte en demina','<p>Jean-François Champollion conciencia cuerpo calloso otro mundo grandes nubes turbulentas nacimiento. Rico en cultivos de átomos pesados creados en el interior de estrellas en colapso, algo increíble espera ser conocido como paroxismo de muerte global Mar de la Tranquilidad. Permanencia de las estrellas con bonitas historias para las cuales hay poca evidencia buena, la ceniza de la alquimia estelar, afirmaciones extraordinarias requieren evidencia extraordinaria, algo increíble está esperando ser conocido, corazones de las estrellas y miles de millones y miles de millones y miles de millones y miles de millones y miles de millones y miles de millones.</p>',1,'2026-05-11','2026-06-26','2026-05-11','22:26:00','exhibitions/covers/01KS5T2SHAW0AX25Q2BT6KFBPP.jpg','exhibitions/posters/01KS5T2SHC8Z0A0AJVHEWSKTNN.jpg','collective','current',1,1,'Nuevo cartel demin','expo nueva en demina','2026-05-12 04:27:16','2026-05-12 10:28:12','2026-05-21 23:42:09'),
(2,'Expo de junio','expo-de-junio','Junio','calor y arte','<p>Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we&#039;ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>',1,'2026-06-10','2026-07-23','2026-06-09','16:55:00','exhibitions/covers/01KS5T1T2M9R0450DNTVT4982T.jpg','exhibitions/posters/01KS5T1T2PHM40WV4WH4QJERYM.png','collective','upcoming',1,1,'arte y calor','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n','2026-05-12 18:55:39','2026-05-13 00:56:05','2026-05-21 23:41:36'),
(3,'Muejeres Sol','muejeres-sol','mujeres en el arte','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars \n','<p>Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we&#039;ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>',1,'2026-03-07','2026-04-25','2026-04-07',NULL,'exhibitions/covers/01KS5T3NPVQX0T9XJAPGMYKG5M.png','exhibitions/posters/01KS5T3NPXGKR2S3Z94T4JG1N8.png','collective','past',0,1,NULL,NULL,NULL,'2026-05-13 03:43:50','2026-05-21 23:42:38');
/*!40000 ALTER TABLE `exhibitions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `film_screenings`
--

DROP TABLE IF EXISTS `film_screenings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `film_screenings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `film_id` bigint(20) unsigned NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `film_screenings_event_id_foreign` (`event_id`),
  KEY `film_screenings_film_id_foreign` (`film_id`),
  CONSTRAINT `film_screenings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `film_screenings_film_id_foreign` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film_screenings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `film_screenings` WRITE;
/*!40000 ALTER TABLE `film_screenings` DISABLE KEYS */;
/*!40000 ALTER TABLE `film_screenings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `films`
--

DROP TABLE IF EXISTS `films`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `films` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `original_title` varchar(220) DEFAULT NULL,
  `slug` varchar(240) NOT NULL,
  `director` varchar(180) DEFAULT NULL,
  `country` varchar(120) DEFAULT NULL,
  `release_year` year(4) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `classification` varchar(50) DEFAULT NULL,
  `genre` varchar(150) DEFAULT NULL,
  `synopsis` longtext DEFAULT NULL,
  `trailer_url` text DEFAULT NULL,
  `poster_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `films_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `films`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `films` WRITE;
/*!40000 ALTER TABLE `films` DISABLE KEYS */;
INSERT INTO `films` VALUES
(1,'Paris Texas','Paris Texas','paris-texas','Win Wnders','EEUU',1985,160,'C','Drama','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','https://youtube.com','films/posters/01KRDAXTF52BEWCBDE2EW91G56.jpg','2026-05-12 11:35:31','2026-05-12 11:35:31'),
(2,'FUll moon','FUll moon','full-moon','Win Wnders','México',2022,120,'C','Drama','<p>Tunguska event the only home we&#039;ve ever known venture tendrils of gossamer clouds citizens of distant epochs globular star cluster. The carbon in our apple pies muse about Apollonius of Perga a very small stage in a vast cosmic arena bits of moving fluff hundreds of thousands? Another world from which we spring muse about intelligent beings are creatures of the cosmos Cambrian explosion. How far away vastness is bearable only through love a still more glorious dawn awaits vastness is bearable only through love two ghostly white figures in coveralls and helmets are softly dancing something incredible is waiting to be known and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>','https://youtube.com','films/posters/01KRRVGXN0AZWQ0GWT29XK4DX8.png','2026-05-16 22:57:13','2026-05-16 22:57:13');
/*!40000 ALTER TABLE `films` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `media_items`
--

DROP TABLE IF EXISTS `media_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) DEFAULT NULL,
  `slug` varchar(240) DEFAULT NULL,
  `media_type` enum('image','video','audio','pdf','poster','document','other') NOT NULL,
  `file_path` text DEFAULT NULL,
  `external_url` text DEFAULT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `credit` varchar(255) DEFAULT NULL,
  `recorded_at` date DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_archive` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `media_items_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_items`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `media_items` WRITE;
/*!40000 ALTER TABLE `media_items` DISABLE KEYS */;
INSERT INTO `media_items` VALUES
(1,'Media item nuevo','media-item-nuevo','pdf','media/files/01KS603SNDP9HDYPW2F704CVGD.jpg','https://saganipsum.com/','media/thumbnails/01KS605R68R1ZCAV9V5Z231C5N.jpg','cartelito chido','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','texto alterno chido','Un autor','2026-05-07',2020,1,1,0,'2026-05-12 10:50:11','2026-05-22 01:28:37');
/*!40000 ALTER TABLE `media_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `media_relations`
--

DROP TABLE IF EXISTS `media_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `media_item_id` bigint(20) unsigned NOT NULL,
  `related_type` varchar(100) NOT NULL,
  `related_id` bigint(20) unsigned NOT NULL,
  `relation_label` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_relations_media_item_id_foreign` (`media_item_id`),
  KEY `media_relations_related_type_related_id_index` (`related_type`,`related_id`),
  CONSTRAINT `media_relations_media_item_id_foreign` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_relations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `media_relations` WRITE;
/*!40000 ALTER TABLE `media_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_relations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `media_tags`
--

DROP TABLE IF EXISTS `media_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `media_tags` (
  `media_item_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`media_item_id`,`tag_id`),
  KEY `media_tags_tag_id_foreign` (`tag_id`),
  CONSTRAINT `media_tags_media_item_id_foreign` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `media_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_tags`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `media_tags` WRITE;
/*!40000 ALTER TABLE `media_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_tags` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_05_11_233120_create_demina_core_tables',2),
(5,'2026_05_11_234034_create_demina_programming_tables',3),
(6,'2026_05_12_003410_create_demina_exhibition_tables',4),
(7,'2026_05_12_003620_create_demina_media_press_forms_tables',5),
(8,'2026_05_12_003926_create_demina_final_base_tables',6),
(9,'2026_05_15_193517_add_cover_image_path_to_events_table',7),
(10,'2026_05_15_215106_add_home_images_to_site_settings_table',8),
(11,'2026_05_16_171549_add_cineclub_fields_to_events_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `name` varchar(180) DEFAULT NULL,
  `status` enum('subscribed','unsubscribed') NOT NULL DEFAULT 'subscribed',
  `source` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `newsletter_subscribers` VALUES
(1,'elyado@gmail.com','Yadin Rodriguez','subscribed','web','2026-05-12 22:21:36','2026-05-12 22:21:36');
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `template` varchar(100) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES
(1,'Nosotros','nosotros','Un espacio abierto, crítico, experimental, comunitario e irreverente.','<p>Demina es un espacio independiente en Acapulco dedicado a activar procesos de creación, exhibición, formación, archivo y convivencia alrededor del arte contemporáneo.</p>','pages/covers/01KRD7Q3ACJ3BV5J8111XGW85G.png','about','published','Nosotros | Demina','Conoce qué es Demina Laboratorio de Artes y su trabajo en Acapulco.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(2,'Inicio','inicio','Demina Laboratorio de Artes: espacio autogestionado para creación, exhibición y experimentación contemporánea en Acapulco.','<p>Demina es un laboratorio de artes, autogestionado para la creación y experimentación de arte contemporáneo. Es galería, cineclub, espacio de encuentro, taller, archivo vivo y plataforma comunitaria.</p>',NULL,'home','published','Demina Laboratorio de Artes','Laboratorio autogestionado de artes contemporáneas en Acapulco, Guerrero.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(3,'Espacios','espacios','Galerías, caja negra, azotea, taberna y dispositivos curatoriales.','<p>Demina se organiza como un conjunto de espacios flexibles para exposiciones, talleres, cine, danza, microteatro, conciertos, catas, encuentros y procesos experimentales.</p>',NULL,'spaces','published','Espacios | Demina','Conoce los espacios físicos y dispositivos de Demina Laboratorio de Artes.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(4,'Agenda','agenda','Consulta la programación de eventos, talleres, cineclub y exposiciones.','<p>Agenda de actividades, exposiciones, talleres, cineclub, encuentros y eventos especiales de Demina.</p>',NULL,'default','published','Agenda | Demina','Programación de actividades de Demina Laboratorio de Artes.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(5,'Archivo','archivo','Memoria visual, registros, documentos y materiales del laboratorio.','<p>El archivo de Demina reúne registros, imágenes, documentos, prensa, piezas audiovisuales y materiales derivados de sus procesos artísticos y comunitarios.</p>',NULL,'archive','published','Archivo | Demina','Archivo multimedia y documental de Demina Laboratorio de Artes.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(6,'Contacto','contacto','Contacto, ubicación y redes sociales de Demina.','<p>Escríbenos para propuestas, colaboraciones, visitas, talleres, exposiciones o uso de espacios.</p>',NULL,'contact','published','Contacto | Demina','Contacta a Demina Laboratorio de Artes en Acapulco.','2026-05-12 11:47:38','2026-05-12 11:47:38','2026-05-12 11:47:38');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `partner_type` enum('space','collective','institution','artist_group','sponsor','other') NOT NULL DEFAULT 'other',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partners_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES
(1,'Aliado Uno','aliado-uno','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n\n','partners/01KREEYR1D7JDGWDCVWVWEDXBF.png','https://elyado.com','sponsor',1,1,'2026-05-12 22:05:10','2026-05-12 22:05:10');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `people` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `role_type` enum('artist','curator','workshop_facilitator','musician','speaker','performer','team','collaborator','other') NOT NULL DEFAULT 'artist',
  `bio` longtext DEFAULT NULL,
  `short_bio` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `portrait_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `people_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES
(1,'Yadin Rodriguez','yadin-rodriguez','artist','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','Artista audiovisual','yadin_rock@hotmail.com','8110775112','https://elyado.com','https://instagram.com/demina','https://instagram.com/demina','people/portraits/01KRD82T5PNN50HG38JY7K8G25.png',1,1,'2026-05-12 10:45:49','2026-05-12 10:45:49');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `press_items`
--

DROP TABLE IF EXISTS `press_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `press_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `media_outlet` varchar(180) DEFAULT NULL,
  `author` varchar(180) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `external_url` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `press_items_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `press_items`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `press_items` WRITE;
/*!40000 ALTER TABLE `press_items` DISABLE KEYS */;
INSERT INTO `press_items` VALUES
(1,'Titulo prensa','titulo-prensa','el sur','autor prens','2026-05-14','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? ','Another world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n\nAnother world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n\n','https://saganipsum.com/','press/covers/01KS5Y5PRG2F0003G9T3K1F3TR.png','press/files/01KS5Y5PRKV4MJD11P2KA9GVBE.png','published',1,'nota de prensa','nota de prensa seo','2026-05-12 22:16:28','2026-05-22 00:53:38'),
(2,'Inauguran con polémica película, “Caja Negra” en Acapulco','inauguran-con-polemica-pelicula-caja-negra-en-acapulco','Página Zero','Miguel Benitez','2025-10-05','Demina Laboratorio de Artes un espacio independiente en el puerto de Acapulco, y en continuo proceso de crecimiento , ahora abre a la comunidad artística y al público la “Caja Negra”, un espacio dedicado a la experimentación interdisciplinaria.','Se proyectó Saló o los 120 días de Sodoma de Pier Paolo Pasolini.\n\nDemina Laboratorio de Artes un espacio independiente en el puerto de Acapulco, y en continuo proceso de crecimiento , ahora abre a la comunidad artística y al público la “Caja Negra”, un espacio dedicado a la experimentación interdisciplinaria.\n\nLa cual funcionará además para la proyección de peliculas y documentales dentro de su cine club denominado “Cine en la azotea”; un espacio para que los artístitas puedan dejar volar su creatividad y crear nuevas piezas artísticas.\n\nCabe recordar Demina Laboratorio de Artes cuenta dos espacios de galerias para exposiciones, una terraza para proyección de películas, el cual también funciona para presentaciones de libros y de piezas de teatro en pequeño formato; así como de un espacio para Residencia de Artistas y a partir de ahora de una \"Caja Negra\".\n\nCon la presencia de una veintena de personas, entre ellas artistas, creadores y amigos se realizó la proyección de la película \'Saló o los 120 días de Sodoma\' de Pier Paolo Pasolini.\n\nAl final, entre todos los asistentes se realizó un debate sobre el polémico filme y su relación con los la actualidad que se vive en el mundo, pasando por el actuar de las elites, hasta llegar a los procesos de censura que se empieza a vivir en diversas partes del mundo, llegando a la conclusión que es un filme que a pesar de haberse filmado hace 50 años sea tan vigente en pleno 2025.\n\nFoto: Miguel Benítez.','https://paginazero.com.mx/inauguran-con-polemica-pelicula-caja-negra-en-acapulco','press/covers/01KS5X23J27RWVZFZD008BP1X7.png',NULL,'published',1,NULL,NULL,'2026-05-22 00:34:12','2026-05-22 00:34:12');
/*!40000 ALTER TABLE `press_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `press_relations`
--

DROP TABLE IF EXISTS `press_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `press_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `press_item_id` bigint(20) unsigned NOT NULL,
  `related_type` varchar(100) NOT NULL,
  `related_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `press_relations_press_item_id_foreign` (`press_item_id`),
  KEY `press_relations_related_type_related_id_index` (`related_type`,`related_id`),
  CONSTRAINT `press_relations_press_item_id_foreign` FOREIGN KEY (`press_item_id`) REFERENCES `press_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `press_relations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `press_relations` WRITE;
/*!40000 ALTER TABLE `press_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `press_relations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `proposal_type` enum('exhibition','workshop','event','space_use','press','collaboration','other') NOT NULL,
  `call_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(180) NOT NULL,
  `email` varchar(180) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `instagram` varchar(180) DEFAULT NULL,
  `title` varchar(220) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `preferred_space_id` bigint(20) unsigned DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `estimated_duration` varchar(120) DEFAULT NULL,
  `technical_needs` text DEFAULT NULL,
  `budget_description` text DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `status` enum('new','reviewing','accepted','rejected','archived') NOT NULL DEFAULT 'new',
  `internal_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposals_call_id_foreign` (`call_id`),
  KEY `proposals_preferred_space_id_foreign` (`preferred_space_id`),
  CONSTRAINT `proposals_call_id_foreign` FOREIGN KEY (`call_id`) REFERENCES `calls` (`id`) ON DELETE SET NULL,
  CONSTRAINT `proposals_preferred_space_id_foreign` FOREIGN KEY (`preferred_space_id`) REFERENCES `spaces` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposals`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `proposals` WRITE;
/*!40000 ALTER TABLE `proposals` DISABLE KEYS */;
INSERT INTO `proposals` VALUES
(1,'collaboration',1,'Presentación','elyado@gmail.com','8110775112','https://instagram.com','Nuevo Expo','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>',5,'2026-05-12','12','agua y luz','12','proposals/attachments/01KRDBHAPNK9NNKWJ0AAP4TXJ2.png','new','not ainterna','2026-05-12 11:46:10','2026-05-12 11:46:10');
/*!40000 ALTER TABLE `proposals` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `workshop_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(180) NOT NULL,
  `email` varchar(180) DEFAULT NULL,
  `phone` varchar(80) DEFAULT NULL,
  `number_of_people` int(11) NOT NULL DEFAULT 1,
  `payment_method` enum('cash','transfer','none','other') NOT NULL DEFAULT 'none',
  `payment_status` enum('pending','paid','not_required') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `status` enum('new','confirmed','cancelled','attended','no_show') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_event_id_foreign` (`event_id`),
  KEY `registrations_workshop_id_foreign` (`workshop_id`),
  CONSTRAINT `registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  CONSTRAINT `registrations_workshop_id_foreign` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` VALUES
(1,NULL,1,'Yadin Rodriguez','elyado@gmail.com','8110775112',1,'transfer','pending','notas','confirmed','2026-05-12 21:57:55','2026-05-12 21:57:55');
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('rrVZ5yHbn85xu1V9e5G6cnUgyJtMnQE5YUhapHGQ',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ6QTREOG9hODFSdzlFUW5IdUw2VTViYk43WjN3eGpXTnVpZVhmaTRIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9kZW1pbmEudGVzdFwvYXJjaGl2byIsInJvdXRlIjoiYXJjaGl2ZS5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX3dlYiI6ImMyZDYzZDk4NWQxNmZiYTg3YjViMDg1ZDc0NGNjM2RiZDNhNDc3YjYxNWE5ZDliMTFhOTRhOGQ4NGQxNWQzMzUiLCJ0YWJsZXMiOnsiZDY5MTk4OGNlMDk3YWYzODc3NDYzYjdiODY0OTljZDVfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0aXRsZSIsImxhYmVsIjoiRXhwb3NpY2lcdTAwZjNuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImN1cmF0b3IubmFtZSIsImxhYmVsIjoiQ3VyYWRvclwvYSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJleGhpYml0aW9uX3R5cGUiLCJsYWJlbCI6IlRpcG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhcnRfZGF0ZSIsImxhYmVsIjoiSW5pY2lvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImVuZF9kYXRlIiwibGFiZWwiOiJDaWVycmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhdHVzIiwibGFiZWwiOiJFc3RhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfZmVhdHVyZWQiLCJsYWJlbCI6IkRlc3RhY2FkYSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzaG93X29uX2hvbWUiLCJsYWJlbCI6IkluaWNpbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiZDRiMmMwMDliMTNkZGM3ZWM3OGI0OGQ3MzViZDU5ZjlfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjb3Zlcl9pbWFnZSIsImxhYmVsIjoiSW1hZ2VuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRpdGxlIiwibGFiZWwiOiJUXHUwMGVkdHVsbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJtZWRpYV9vdXRsZXQiLCJsYWJlbCI6Ik1lZGlvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImF1dGhvciIsImxhYmVsIjoiQXV0b3IiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicHVibGlzaGVkX2RhdGUiLCJsYWJlbCI6IlB1YmxpY2FkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJleHRlcm5hbF91cmwiLCJsYWJlbCI6IlVSTCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJmaWxlX3BhdGgiLCJsYWJlbCI6IkFyY2hpdm8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhdHVzIiwibGFiZWwiOiJFc3RhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfZmVhdHVyZWQiLCJsYWJlbCI6IkRlc3RhY2FkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzZW9fdGl0bGUiLCJsYWJlbCI6IlRcdTAwZWR0dWxvIFNFTyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiQWN0dWFsaXphZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sImNiNjFiNDNkZjE3NTBmYWIxZTRjMzM1MDljYzE1NDRiX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibmFtZSIsImxhYmVsIjoiTm9tYnJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNsdWciLCJsYWJlbCI6IlNsdWciLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY29sb3IiLCJsYWJlbCI6IkNvbG9yIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Imljb24iLCJsYWJlbCI6Ilx1MDBjZGNvbm8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfcmVjdXJyaW5nIiwibGFiZWwiOiJSZWN1cnJlbnRlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNvcnRfb3JkZXIiLCJsYWJlbCI6Ik9yZGVuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWFkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJBY3R1YWxpemFkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiZGRjMWQwOGViZWZhNjUyMjkwM2FiMWYzN2MzY2I4YWNfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOb21icmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic2x1ZyIsImxhYmVsIjoiU2x1ZyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0eXBlIiwibGFiZWwiOiJUaXBvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNvbG9yIiwibGFiZWwiOiJDb2xvciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzb3J0X29yZGVyIiwibGFiZWwiOiJPcmRlbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19hY3RpdmUiLCJsYWJlbCI6IkFjdGl2YSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjcmVhdGVkX2F0IiwibGFiZWwiOiJDcmVhZGEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiQWN0dWFsaXphZGEiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sIjk4MDgyZjQwZmM5ZDk5ZmFlMDM1OTA2YzVhYWFmMzMwX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibmFtZSIsImxhYmVsIjoiTm9tYnJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNsdWciLCJsYWJlbCI6IlNsdWciLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYWRhIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InVwZGF0ZWRfYXQiLCJsYWJlbCI6IkFjdHVhbGl6YWRhIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCI3ZmUyZjllZjUzYmY1MWJmOGE0Y2RhNDlmMGYwNjlmMV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRpdGxlIiwibGFiZWwiOiJUaXRsZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzbHVnIiwibGFiZWwiOiJTbHVnIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImFydGlzdF9pZCIsImxhYmVsIjoiQXJ0aXN0IGlkIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImV4aGliaXRpb25faWQiLCJsYWJlbCI6IkV4aGliaXRpb24gaWQiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoieWVhciIsImxhYmVsIjoiWWVhciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ0ZWNobmlxdWUiLCJsYWJlbCI6IlRlY2huaXF1ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJkaW1lbnNpb25zIiwibGFiZWwiOiJEaW1lbnNpb25zIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImltYWdlX3BhdGgiLCJsYWJlbCI6IkltYWdlIHBhdGgiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfZm9yX3NhbGUiLCJsYWJlbCI6IklzIGZvciBzYWxlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InByaWNlIiwibGFiZWwiOiJQcmljZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJjdXJyZW5jeSIsImxhYmVsIjoiQ3VycmVuY3kiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhdHVzIiwibGFiZWwiOiJTdGF0dXMiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJVcGRhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCJkOGNkMjMwODU0MWNkZjllN2U1ZjcwY2ZmZDljOGYzZF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5vbWJyZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJldmVudC50aXRsZSIsImxhYmVsIjoiRXZlbnRvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndvcmtzaG9wLnRpdGxlIiwibGFiZWwiOiJUYWxsZXIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZW1haWwiLCJsYWJlbCI6IkNvcnJlbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwaG9uZSIsImxhYmVsIjoiVGVsXHUwMGU5Zm9ubyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJudW1iZXJfb2ZfcGVvcGxlIiwibGFiZWwiOiJQZXJzb25hcyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwYXltZW50X21ldGhvZCIsImxhYmVsIjoiTVx1MDBlOXRvZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicGF5bWVudF9zdGF0dXMiLCJsYWJlbCI6IlBhZ28iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhdHVzIiwibGFiZWwiOiJFc3RhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiRmVjaGEgZGUgcmVnaXN0cm8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidXBkYXRlZF9hdCIsImxhYmVsIjoiQWN0dWFsaXphZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfV0sImY4NWQwZmIxOWQ2ZGMxYjg3MWM5MzdkYTYxZTE4ODZlX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidGl0bGUiLCJsYWJlbCI6IlRhbGxlciIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJmYWNpbGl0YXRvci5uYW1lIiwibGFiZWwiOiJUYWxsZXJpc3RhIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImV2ZW50LnRpdGxlIiwibGFiZWwiOiJFdmVudG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY29zdCIsImxhYmVsIjoiQ29zdG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2FwYWNpdHkiLCJsYWJlbCI6IkN1cG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3RhdHVzIiwibGFiZWwiOiJFc3RhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfV0sIjk3OTJiNmRlNTczMTU2ZWMwNDVlYTgxODgxYmUzZDNkX2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidGl0bGUiLCJsYWJlbCI6IlBcdTAwZTFnaW5hIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNsdWciLCJsYWJlbCI6IlNsdWciLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoidGVtcGxhdGUiLCJsYWJlbCI6IlBsYW50aWxsYSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0dXMiLCJsYWJlbCI6IkVzdGFkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwdWJsaXNoZWRfYXQiLCJsYWJlbCI6IlB1YmxpY2FkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XSwiZTU2MTA3MTU3MWNmYTM5ODE2M2YzOGI3YzBmODkyZWVfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOb21icmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicm9sZV90eXBlIiwibGFiZWwiOiJUaXBvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImVtYWlsIiwibGFiZWwiOiJDb3JyZW8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaW5zdGFncmFtX3VybCIsImxhYmVsIjoiSW5zdGFncmFtIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpmYWxzZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlzX2ZlYXR1cmVkIiwibGFiZWwiOiJEZXN0YWNhZG8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfYWN0aXZlIiwibGFiZWwiOiJBY3Rpdm8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfV0sImMzODY4M2UwODYyNzhlZWEwMzljMWNjNDk2MjdkZWM4X2NvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaW1hZ2VfcGF0aCIsImxhYmVsIjoiRm90byIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJuYW1lIiwibGFiZWwiOiJOb21icmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicm9sZSIsImxhYmVsIjoiUm9sIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImVtYWlsIiwibGFiZWwiOiJDb3JyZW8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaW5zdGFncmFtX3VybCIsImxhYmVsIjoiSW5zdGFncmFtIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpmYWxzZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNvcnRfb3JkZXIiLCJsYWJlbCI6Ik9yZGVuIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImlzX2FjdGl2ZSIsImxhYmVsIjoiQWN0aXZvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWF0ZWRfYXQiLCJsYWJlbCI6IkNyZWFkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJBY3R1YWxpemFkbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9XSwiYjc1YTlhOWY2ZTAyZjk4OGU5MzdhODgxZGYxN2ZlZDNfY29sdW1ucyI6W3sidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJsb2dvX3BhdGgiLCJsYWJlbCI6IkxvZ28iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibmFtZSIsImxhYmVsIjoiTm9tYnJlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNsdWciLCJsYWJlbCI6IlNsdWciLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6ZmFsc2UsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0Ijp0cnVlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicGFydG5lcl90eXBlIiwibGFiZWwiOiJUaXBvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6IndlYnNpdGVfdXJsIiwibGFiZWwiOiJTaXRpbyB3ZWIiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOmZhbHNlfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic29ydF9vcmRlciIsImxhYmVsIjoiT3JkZW4iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiaXNfYWN0aXZlIiwibGFiZWwiOiJBY3Rpdm8iLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYWRvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InVwZGF0ZWRfYXQiLCJsYWJlbCI6IkFjdHVhbGl6YWRvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCI2ZDYxOWQwMGNiYTgxMWM5NzM2NTEzYmMxNmQyYmM2YV9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNpdGVfbmFtZSIsImxhYmVsIjoiU2l0ZSBuYW1lIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRhZ2xpbmUiLCJsYWJlbCI6IlRhZ2xpbmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY2l0eSIsImxhYmVsIjoiQ2l0eSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzdGF0ZSIsImxhYmVsIjoiU3RhdGUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY291bnRyeSIsImxhYmVsIjoiQ291bnRyeSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJwaG9uZSIsImxhYmVsIjoiUGhvbmUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoid2hhdHNhcHAiLCJsYWJlbCI6IldoYXRzYXBwIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImVtYWlsIiwibGFiZWwiOiJFbWFpbCBhZGRyZXNzIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Imluc3RhZ3JhbV91cmwiLCJsYWJlbCI6Ikluc3RhZ3JhbSB1cmwiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZmFjZWJvb2tfdXJsIiwibGFiZWwiOiJGYWNlYm9vayB1cmwiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoieW91dHViZV91cmwiLCJsYWJlbCI6IllvdXR1YmUgdXJsIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRpa3Rva191cmwiLCJsYWJlbCI6IlRpa3RvayB1cmwiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoibG9nb19wYXRoIiwibGFiZWwiOiJMb2dvIHBhdGgiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiZmF2aWNvbl9wYXRoIiwibGFiZWwiOiJGYXZpY29uIHBhdGgiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3JlYXRlZF9hdCIsImxhYmVsIjoiQ3JlYXRlZCBhdCIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjpmYWxzZSwiaXNUb2dnbGVhYmxlIjp0cnVlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOnRydWV9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ1cGRhdGVkX2F0IiwibGFiZWwiOiJVcGRhdGVkIGF0IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOmZhbHNlLCJpc1RvZ2dsZWFibGUiOnRydWUsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6dHJ1ZX1dLCJiNjgzYzQ0NDRmMGFmZmExNTIwZDEzMTM3MDUwNTMxMF9jb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InRpdGxlIiwibGFiZWwiOiJUXHUwMGVkdHVsbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJtZWRpYV90eXBlIiwibGFiZWwiOiJUaXBvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImNyZWRpdCIsImxhYmVsIjoiQ3JcdTAwZTlkaXRvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6dHJ1ZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpmYWxzZX0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InJlY29yZGVkX2F0IiwibGFiZWwiOiJGZWNoYSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJ5ZWFyIiwibGFiZWwiOiJBXHUwMGYxbyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJpc19mZWF0dXJlZCIsImxhYmVsIjoiRGVzdGFjYWRvIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InNob3dfaW5fYXJjaGl2ZSIsImxhYmVsIjoiQXJjaGl2byIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJzb3J0X29yZGVyIiwibGFiZWwiOiJPcmRlbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XX0sImZpbGFtZW50IjpbXX0=',1779393265);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(150) NOT NULL DEFAULT 'Demina Laboratorio de Artes',
  `tagline` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `manifesto` longtext DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(150) NOT NULL DEFAULT 'Acapulco',
  `state` varchar(150) NOT NULL DEFAULT 'Guerrero',
  `country` varchar(150) NOT NULL DEFAULT 'México',
  `phone` varchar(50) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `google_maps_url` text DEFAULT NULL,
  `press_kit_url` text DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hero_image_path` varchar(255) DEFAULT NULL,
  `community_image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES
(1,'Demina Laboratorio de Artes','Laboratorio autogestionado para la creación y experimentación de arte contemporáneo','Demina es un espacio independiente en Acapulco dedicado a exposiciones, cineclub, talleres, archivo, encuentros y experimentación artística.','<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','Inalambrica 99A, Interior 2\nEntre Calles Costera M Aleman y Pinzona Subir x gas Manzanillo, izquierda edificio blanco','Acapulco','Guerrero','México','8110775112','8110775112','elyado@gmail.com','https://instagram.com/demina','https://instagram.com/demina','https://instagram.com/demina','https://instagram.com/demina','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3818.5004464284148!2d-99.90866462392249!3d16.851120883947424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85caf73e9e6db82d%3A0x591ecdcf29a971d3!2sDEMINA%20Laboratorio%20de%20Artes!5e0!3m2!1ses!2smx!4v1779390781841!5m2!1ses!2smx\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"','https://maps.app.goo.gl/PR2t6xpkKesG1PGf6','site/01KRPTZRGYDC8KCSZ0YCZJMD2Q.png','site/01KRPTZRH3MXXJQNBBFBRXKNSQ.svg','2026-05-12 07:00:58','2026-05-22 01:13:36','site/home/01KRRQWE3NNEQA55NPX391JWQE.png','site/home/01KRPTWH2NKQV2XHK11KZ47SJE.png');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `space_images`
--

DROP TABLE IF EXISTS `space_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `space_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `space_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(180) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `space_images_space_id_foreign` (`space_id`),
  CONSTRAINT `space_images_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `space_images`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `space_images` WRITE;
/*!40000 ALTER TABLE `space_images` DISABLE KEYS */;
INSERT INTO `space_images` VALUES
(1,5,'spaces/01KRPMAJ7BCN265KWKVF9AVXPG.jpg','azotea','azote demina suave','azotea demina',1,'2026-05-12 22:28:11','2026-05-16 02:12:55'),
(2,4,'spaces/01KRPMBA5G8KNHZAXDCSJBA25H.jpg','La caja negra','La caja negra','la caja negra',1,'2026-05-16 02:07:10','2026-05-16 02:13:20');
/*!40000 ALTER TABLE `space_images` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `spaces`
--

DROP TABLE IF EXISTS `spaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `spaces` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `floor_level` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `usage_description` text DEFAULT NULL,
  `schedule_description` text DEFAULT NULL,
  `rental_available` tinyint(1) NOT NULL DEFAULT 0,
  `barter_available` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `cover_image` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spaces_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spaces`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `spaces` WRITE;
/*!40000 ALTER TABLE `spaces` DISABLE KEYS */;
INSERT INTO `spaces` VALUES
(1,'Galería Primer Piso','galeria-primer-piso','Espacio abierto para exposiciones y encuentros.',NULL,NULL,'Primer piso',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,1,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(2,'Casa Canera Cuata','casa-canera-cuata','Réplica 1:1 y dispositivo curatorial dentro de Demina.',NULL,NULL,'Primer piso',NULL,NULL,NULL,0,1,0,1,NULL,NULL,NULL,2,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(3,'Galería Segundo Piso','galeria-segundo-piso','Segundo nivel expositivo del edificio.',NULL,'<p></p>','Segundo piso',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,3,'2026-05-12 07:00:58','2026-05-16 23:20:25'),
(4,'Caja Negra','caja-negra','Espacio oscuro para cine, danza, proyección y microteatro.',NULL,NULL,'Segundo piso',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,4,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(5,'Azotea','azotea','Terraza multifuncional para cine, conciertos, catas y encuentros.',NULL,NULL,'Azotea',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,5,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(6,'Espacio Neutral','espacio-neutral','Área flexible para talleres, reuniones y actividades experimentales.',NULL,NULL,'Variable',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,6,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(7,'La Taberna','la-taberna','Bar pequeño y punto de encuentro en la azotea.',NULL,NULL,'Azotea',NULL,NULL,NULL,1,1,0,1,NULL,NULL,NULL,7,'2026-05-12 07:00:58','2026-05-12 07:00:58'),
(8,'Cocina','cocina','La cocina','Espacio para preparar alimentos','<p>Todo comienza en el estomago, el espacio para preparar alimentos, puedes solicitar el espacio y preparar alimentos, dar talleres o vender tus productos</p>','Azotea',10,'Cocinar alimentos\nPreparar alimentos','10 am a 10 pm',1,1,1,1,'spaces/covers/01KRD7AMKA8FB7CYE55ZBJPEMR.png','La cocina de demina','La cocina de demina',1,'2026-05-12 10:32:36','2026-05-12 10:32:36');
/*!40000 ALTER TABLE `spaces` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES
(1,'Etiqueta uno','etiqueta-uno','2026-05-12 11:19:01','2026-05-12 11:19:01'),
(2,'arte contemporáneo','arte-contemporaneo','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(3,'cine','cine','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(4,'taller','taller','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(5,'comunidad','comunidad','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(6,'experimental','experimental','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(7,'Acapulco','acapulco','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(8,'Guerrero','guerrero','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(9,'autogestión','autogestion','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(10,'archivo','archivo','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(11,'performance','performance','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(12,'sonido','sonido','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(13,'cuerpo','cuerpo','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(14,'territorio','territorio','2026-05-12 11:47:38','2026-05-12 11:47:38'),
(15,'Arte sonoro','arte-sonoro','2026-05-12 22:34:34','2026-05-12 22:34:34');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `role` varchar(180) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES
(1,'Yadin Rodriguez','banda','leve biografía oh yeah .\nAnother world rogue Cambrian explosion Sea of Tranquility a still more glorious dawn awaits courage of our questions? Encyclopaedia galactica the sky calls to us rich in mystery decipherment a mote of dust suspended in a sunbeam dispassionate extraterrestrial observer? The sky calls to us hearts of the stars dispassionate extraterrestrial observer hearts of the stars preserve and cherish that pale blue dot citizens of distant epochs? Network of wormholes extraordinary claims require extraordinary evidence the ash of stellar alchemy star stuff harvesting star light hundreds of thousands the only home we\'ve ever known and billions upon billions upon billions upon billions upon billions upon billions upon billions.\n\n','team-members/01KREERTE6NJ2NZ1J2F4YPNFCS.png','elyado@gmail.com','https://instagram.com/demina',2,1,'2026-05-12 22:01:56','2026-05-12 22:01:56');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'deminadmin','elyado@gmail.com',NULL,'$2y$12$ighjn9hLM2gnJvoxFttaHekuT3VA8l1c7t56Iqpr4pq8lwOxtEJca','kDccJyzz028BRn7p9mrPVOK5ki4b7g9L1ijdJ8ijwbXZ21iADFpV6KCKdNEX','2026-05-12 05:25:37','2026-05-12 05:25:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `workshops`
--

DROP TABLE IF EXISTS `workshops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `workshops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(220) NOT NULL,
  `slug` varchar(240) NOT NULL,
  `facilitator_id` bigint(20) unsigned DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `materials` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `commission_percentage` decimal(5,2) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `registration_instructions` text DEFAULT NULL,
  `payment_methods` set('cash','transfer','online','other') DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workshops_slug_unique` (`slug`),
  KEY `workshops_event_id_foreign` (`event_id`),
  KEY `workshops_facilitator_id_foreign` (`facilitator_id`),
  CONSTRAINT `workshops_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  CONSTRAINT `workshops_facilitator_id_foreign` FOREIGN KEY (`facilitator_id`) REFERENCES `people` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workshops`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `workshops` WRITE;
/*!40000 ALTER TABLE `workshops` DISABLE KEYS */;
INSERT INTO `workshops` VALUES
(1,NULL,'Taller de bordado','taller-de-bordado',1,'<p>Seres inteligentes el cielo nos llama reino de las galaxias concepto de la explosión cámbrica número uno al borde de la eternidad. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit afirmaciones extraordinarias requieren evidencia extraordinaria Neque porro quisquam est vel illum qui dolorem eum fugiat quo voluptas nulla pariatur un amanecer aún más glorioso espera el único hogar que hemos conocido? A lo largo de los siglos hay criaturas del cosmos, cientos de miles, dos figuras blancas fantasmales con monos y cascos, bailan suavemente en el Mar de la Tranquilidad, rico en misterio y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles y miles.</p>','Papel y lapiz',100.00,20.00,30,'Instrucciones de llenado','cash,transfer,online,other','published','2026-05-12 11:32:42','2026-05-12 11:32:42');
/*!40000 ALTER TABLE `workshops` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-05-21 14:10:45
