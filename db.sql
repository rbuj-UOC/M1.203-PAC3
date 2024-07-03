-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: database
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `database`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `database` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `database`;

-- MySQL dump 10.13  Distrib 8.0.36, for macos14 (x86_64)
--
-- Host: 127.0.0.1    Database: database
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `categorias_pec3`
--

DROP TABLE IF EXISTS `categorias_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_pec3` (
  `id_categoria` int NOT NULL,
  `nombre_categoria` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `id_caegoria_UNIQUE` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_pec3`
--

LOCK TABLES `categorias_pec3` WRITE;
/*!40000 ALTER TABLE `categorias_pec3` DISABLE KEYS */;
INSERT INTO `categorias_pec3` VALUES (1,'italiana'),(2,'japonesa'),(3,'mexicana'),(4,'tradicional'),(5,'vegana');
/*!40000 ALTER TABLE `categorias_pec3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes_pec3`
--

DROP TABLE IF EXISTS `ingredientes_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes_pec3` (
  `id_ingrediente` int NOT NULL,
  `nombre_ingrediente` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id_ingrediente`),
  UNIQUE KEY `id_ingredient_UNIQUE` (`id_ingrediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes_pec3`
--

LOCK TABLES `ingredientes_pec3` WRITE;
/*!40000 ALTER TABLE `ingredientes_pec3` DISABLE KEYS */;
INSERT INTO `ingredientes_pec3` VALUES (1,'gambones'),(2,'zanahorias'),(3,'harina de tempura'),(4,'jengibre'),(5,'cebollas tiernas'),(6,'arroz'),(7,'salsa de soja'),(8,'semillas de sésamo blanco'),(9,'semillas de sésamo negro'),(10,'huevo'),(11,'atún claro'),(12,'wasabi'),(13,'aguacates'),(14,'salmón'),(15,'vinagre de arroz'),(16,'azúcar'),(17,'pepinillos'),(18,'láminas de nori'),(19,'fideos de arroz'),(20,'sepia'),(21,'cebolla'),(22,'ajo'),(23,'aceitunas negra sin hueso'),(24,'perejil'),(25,'hinojo'),(26,'vino blanco'),(27,'espárragos trigueros'),(28,'pimiento verde'),(29,'pimiento rojo'),(30,'zanahoria baby'),(31,'harina'),(32,'pasta brick'),(33,'mostaza de Dijón'),(34,'limón'),(35,'cilantro'),(36,'pechugas de pollo'),(37,'pimiento amarillo'),(38,'tortillas de trigo'),(39,'salsa mexicana'),(40,'bacalao al punto de sal'),(41,'guisantes'),(42,'albahaca'),(43,'tomates'),(44,'berenjenas'),(45,'fideos de cabello de ángel'),(46,'salsa romesco'),(47,'fumet'),(48,'calamar'),(49,'calabaza'),(50,'judías'),(51,'caldo de verduras'),(52,'pan');
/*!40000 ALTER TABLE `ingredientes_pec3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes_receta_pec3`
--

DROP TABLE IF EXISTS `ingredientes_receta_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes_receta_pec3` (
  `id` int NOT NULL,
  `id_receta` int NOT NULL,
  `id_ingrediente` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_ingredients_recepta_pac3_1_idx` (`id_receta`),
  KEY `fk_ingredients_recepta_pac3_1_idx1` (`id_ingrediente`),
  CONSTRAINT `fk_ingrediente_pec3` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes_pec3` (`id_ingrediente`),
  CONSTRAINT `fk_receta_pec3` FOREIGN KEY (`id_receta`) REFERENCES `recetas_pec3` (`id_receta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes_receta_pec3`
--

LOCK TABLES `ingredientes_receta_pec3` WRITE;
/*!40000 ALTER TABLE `ingredientes_receta_pec3` DISABLE KEYS */;
INSERT INTO `ingredientes_receta_pec3` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,2,6),(7,2,7),(8,2,8),(9,2,9),(10,2,10),(11,2,11),(12,3,7),(13,3,12),(14,3,13),(15,3,14),(16,3,6),(17,3,15),(18,3,16),(19,3,17),(20,3,18),(21,3,4),(22,4,19),(23,4,20),(24,4,21),(25,4,22),(26,4,23),(27,4,24),(28,4,25),(29,4,26),(30,5,1),(31,5,27),(32,5,28),(33,5,29),(34,5,30),(35,5,22),(36,5,21),(37,5,4),(38,5,31),(39,5,16),(40,6,11),(41,6,32),(42,6,24),(43,6,33),(44,6,34),(45,6,35),(46,7,36),(47,7,37),(48,7,29),(49,7,28),(50,7,38),(51,7,21),(52,7,39),(53,8,40),(54,8,22),(55,8,41),(56,8,42),(57,9,43),(58,9,29),(59,9,28),(60,9,44),(61,9,45),(62,9,46),(63,9,47),(64,9,48),(65,10,49),(66,10,30),(67,10,21),(68,10,27),(69,10,50),(70,10,51),(71,10,52);
/*!40000 ALTER TABLE `ingredientes_receta_pec3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_dificultad_pec3`
--

DROP TABLE IF EXISTS `nivel_dificultad_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel_dificultad_pec3` (
  `id_nivel_dificultad` int NOT NULL,
  `nombre_nivel_dificultad` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id_nivel_dificultad`),
  UNIQUE KEY `id_nivell_dificultat_UNIQUE` (`id_nivel_dificultad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_dificultad_pec3`
--

LOCK TABLES `nivel_dificultad_pec3` WRITE;
/*!40000 ALTER TABLE `nivel_dificultad_pec3` DISABLE KEYS */;
INSERT INTO `nivel_dificultad_pec3` VALUES (1,'bajo'),(2,'medio'),(3,'alto');
/*!40000 ALTER TABLE `nivel_dificultad_pec3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recetas_pec3`
--

DROP TABLE IF EXISTS `recetas_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recetas_pec3` (
  `id_receta` int NOT NULL,
  `id_categoria` int DEFAULT NULL,
  `id_nivel_dificultad` int DEFAULT NULL,
  `fecha_publicacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `imagen_receta` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tiempo_preparacion` int DEFAULT NULL,
  `nombre_receta` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `texto_receta` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_receta`),
  UNIQUE KEY `id_recepta_UNIQUE` (`id_receta`),
  KEY `fk_categories_pac3_idx` (`id_categoria`),
  KEY `fk_receptes_pac3_1_idx` (`id_nivel_dificultad`),
  CONSTRAINT `fk_categories_pac3` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_pec3` (`id_categoria`),
  CONSTRAINT `fk_nivel_dificultad_pec3` FOREIGN KEY (`id_nivel_dificultad`) REFERENCES `nivel_dificultad_pec3` (`id_nivel_dificultad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recetas_pec3`
--

LOCK TABLES `recetas_pec3` WRITE;
/*!40000 ALTER TABLE `recetas_pec3` DISABLE KEYS */;
INSERT INTO `recetas_pec3` VALUES (1,2,2,'2024-04-27 08:31:13','/img/Tempura-de-gambones.avif',25,'Tempura de gambones ','<p>Descongela los gambones sumergiéndolos en agua fría unos minutos. Después, pela las colas, pero deja las cabezas.</p>\n<p>Prepara la tempura siguiendo las indicaciones del envase y hasta que quede una textura espessa, pero que corra, y añade la sal, el jengibre y los cubitos.</p>\n<p>Moja la cola de gambón en la pasta de tempura vigilando que la cabeza quede limpia y fríelo en abundante aceite caliente a 180ºC.</p>\n<p>Acompaña los gambones con la zanahoria y la cebolla tierna cortada en juliana. Si dejas las verduras un rato en agua y hielo, quedarán rizadas.</p>'),(2,2,1,'2024-04-28 08:31:13','/img/Rodaja-de-atun.avif',15,'Rodaja de atún a la plancha con sésamo','<p>Deja descongelar las rodajas de atún en una fuente de rejilla en la nevera.</p>\n<p>Colócalas en un plato, rocíalas con 4 cucharadas de salsa de soja y déjalas marinar una hora en la nevera. Después, pasa cada rodaja por la clara de huevo batida y rebózalas con los dos tipos de sésamo mezclados.</p>\n<p>Calienta una plancha, úntala con 1 cucharada de aceite y cocina las rodajas de pescado un par de minutos por cada lado.</p>\n<p>Mientras, calienta el arroz directamente congelado en su misma bolsa en el microondas un par de minutos.</p>\n<p>Sirve el pescado junto con el arroz en los platos de servir y rocía con un poco de salsa de soja.</p>'),(3,2,2,'2024-04-29 08:31:13','/img/Makisushi.avif',45,'Makisushi de salmón y atún','<p>Deja descongelar el atún y el salmón en la nevera en un recipiente con rejilla.</p>\n<p>Limpia el arroz 3 veces y escúrrelo hasta que el agua salga limpia. Ponlo en una cazuela y añádele el doble de su volumen de agua. Hiérvelo a fuego fuerte durante 1 minuto y después continúa la cocción a fuego muy bajo y tapado durante 10 minutos.</p>\n<p>Pasado este tiempo, sácalo del fuego y déjalo reposar 10 minutos más aún tapado. Finalmente, añade el vinagre, la sal, el azúcar y un poco de wasabi, y deja que se enfríe antes de utilizarlo.</p>\n<p>Para hacer el makisushi: corta el salmón y el atún a tiras largas; corta también el aguacate y el pepino a tiras finas y largas.</p>\n<p>Pon una lámina de nori encima de la alfombrita de sushi, esparce por encima un poco de arroz y añádele el salmón o el atún y el aguacate o el pepino, haciendo la combinación que más te guste. Con la ayuda de la alfombrita, envuelve el nori como si se tratara de un canelón y déjalo en la nevera un rato. Después, córtalo en 6 partes.</p>\n<p>Sirve el plato y acompáñalo con salsa de soja, wasabi y el jengibre en conserva.</p>'),(4,2,2,'2024-04-30 08:31:13','/img/Fideos-de-arroz-con-sepia.avif',25,'Fideos de arroz con sepia e hinojo','<p>Descongela las sepias el día anterior en la nevera, encima de un recipiente con rejilla o escurridor, para que los jugos de la descongelación queden aparte.</p>\n<p>Pon a hervir los fideos de arroz en una olla durante 6 minutos, enfríalos con agua fría y escúrrelos. Limpia el hinojo y córtalo a tiras. Resérvalo.</p>\n<p>Corta la sepia a dados de tamaño mediano. En una cazuela con un poco de aceite bien caliente saltea la sepia y retírala. En el mismo aceite pon el ajo y la cebolla, directamente congelados, a fuego bajo.</p>\n<p>Déjalo cocer 5 minutos, añade el hinojo cortado a tiras junto con la sepia y un poco de vino blanco. Déjalo cocer unos 15 minutos.</p>\n<p>Corta a cuartos las aceitunas negras sin hueso. Mezcla los fideos de arroz que tienes reservados y el perejil, directamente congelado, con la sepia estofada, y déjalo unos 2 minutos más para que los fideos se calienten y el perejil proporcione color a toda la elaboración.</p>'),(5,2,1,'2024-05-01 08:31:13','/img/Chop-suei-de-gambones.avif',15,'Chop suei de gambones ','<p>Freir ingredientes.</p>'),(6,2,1,'2024-05-02 08:31:13','/img/Bocados.avif',25,'Bocados de atún con salsa de lima y soja','<p>Deja descongelar el atún en una fuente de rejilla en la nevera. Deja descongelar el perejil en un cuenco.</p>\n<p>Lava las hojas de cilantro, sécalas con papel de cocina, pícalas y mézclalas con el perejil troceado. Sala los dados de atún, úntalos con un poco de mostaza y rebózalos con el perejil y el cilantro.</p>\n<p>Corta las hojas de brick en cuadrados de 10 cm de lado y envuelve los dados con ellas como si de un paquete se tratase.</p>\n<p>Calienta el aceite de oliva en una sartén pequeña y fríe los bocados de dos en dos, dándoles la vuelta para que se doren de forma homogénea. Retíralos con unas pinzas y déjalos escurrir sobre papel absorbente unos instantes.</p>\n<p>En un bol pequeño, mezcla el zumo de limón con la soja. Sirve los tacos de atún con la salsa.</p>'),(7,3,1,'2024-05-03 08:31:13','/img/Tortillas-con-pollo.avif',15,'Tortillas con pollo','<p>Corta las pechugas de pollo a tiras largas y salpimiéntalas. Saltéalas en una sartén con un poco de aceite y resérvalas.</p>\n<p>En la misma sartén saltea un poco de cebolla juliana y cuando esté blanda añade el pimiento tricolor.</p>\n<p>Cuando las verduras estén cocidas, agrega las tiras de pollo y deja cocer todo junto unos minutos.</p>\n<p>Rellena la tortilla y ya la puedes servir acompañada de salsa mexicana. (Se puede añadir salsa al relleno o bien ponerla aparte).</p>'),(8,4,3,'2024-05-04 08:31:13','/img/Bacalao-en-pilpil.avif',50,'Bacalao en pilpil de guisantes','<p>\n<ol>\n<li>Corta los dientes de ajo en finas láminas.</li>\n<li>Calienta el aceite a fuego lento y fríe en él las láminas de ajo hasta que estén completamente doradas.</li>\n<li>Resérvalas sobre un papel absorbente para que queden bien crujientes.</li>\n<li>Baja el fuego al mínimo.</li>\n<li>Presenta el LOMO DE BACALAO con la piel hacia arriba.</li>\n<li>Cocina a fuego mínimo 4-6 minutos, tapado, hasta que el bacalao se vuelva completamente blanco mate.</li>\n<li>Mientras tanto cocina los guisantes al vapor 3-4 minutos, directamente congelados.</li>\n<li>Retira los lomos de bacalao y tritura los jugos del cazo con una batidora eléctrica, hasta montar una emulsión de textura cremosa (pilpil).</li>\n<li>Pica finamente albahaca al gusto y añádela al pilpil.</li>\n<li>Mézclala bien y añade los guisantes ya cocinados.</li>\n<li>Presenta el pilpil de guisantes en un plato hondo y presenta el bacalao encima.</li>\n<li>Acaba de salsear el pescado con el Pilpil y decora con las láminas de ajo y las hojas más tiernas y pequeñas de albahaca.</li>\n</ol>\n</p>'),(9,4,2,'2024-05-05 08:31:13','/img/Fideua-de-calamares.avif',60,'Fideuá de calamares en romesco ','<p>Calienta tu horno a 200-220ºC. Mientras tanto calienta una paellera o sartén apta para horno a fuego fuerte. Saltea el CALAMAR PATAGÓNICO LIMPIO TROCEADO con un chorrito de aceite de oliva y dóralos 1 minuto. Reserva.</p>\n<p>En la misma sartén, a fuego fuerte, añade el PISTO DE VERDURAS directamente congelado con un chorrito de aceite de oliva (sal no). Saltea a fuego fuerte 2-3 minutos y añade el sofrito. Baja el fuego y deja reducir hasta evaporar toda el agua.</p>\n<p>Aún a fuego bajo, añade los fideos y dóralos. Añade un par de cucharadas más de aceite de oliva (2 minutos). Mientras tanto, mezcla el sobre de FUMET CONCENTRADO DE PESCADO DE ROCA con 1 vaso de agua (250 ml.) y llévalo a ebullición.</p>\n<p>Añade de nuevo el CALAMAR PATAGÓNICO TROCEADO a la paellera y sube el fuego de nuevo. Moja con el FUMET DE PESCADO, reparte bien y lleva al horno (6-8 minutos) hasta que se haya consumido todo el caldo. Retira, deja reposar 1 minuto y sirve con una cucharada de salsa romesco.</p>'),(10,5,1,'2024-05-06 08:31:13','/img/Sopa-campestre.avif',30,'Sopa campestre de espárragos y calabaza','<p>Deja descongelar los espárragos en una fuente con rejilla en la nevera y córtalos en trocitos. Retira la piel de calabaza y córtala en dados.</p>\n<p>Calienta el aceite en una cazuela de borde alto y sofríe la cebolla directamente congelada unos 3-4 minutos. Agrega la zanahoria y las judías directamente congeladas, y cubre con el caldo. Condimenta con sal y deja cocer a fuego medio durante 8 minutos.</p>\n<p>Añade los espárragos y la calabaza y cocina 6 minutos más. Rectifica de sal y sirve la sopa en platos soperos. Espolvorea un poco de pimienta por encima y coloca en el centro un puñado de brotes de remolacha. Sirve con pan de pueblo.</p>');
/*!40000 ALTER TABLE `recetas_pec3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_pec3`
--

DROP TABLE IF EXISTS `users_pec3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_pec3` (
  `username` varchar(25) COLLATE utf8mb3_spanish_ci NOT NULL,
  `password` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `apellidos` varchar(45) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_pec3`
--

LOCK TABLES `users_pec3` WRITE;
/*!40000 ALTER TABLE `users_pec3` DISABLE KEYS */;
INSERT INTO `users_pec3` VALUES ('user','$2y$10$ztWipIbbogPRPYVuC7Ax/OAHLD7Luu5tdwe4wGcUof5haclYoZMLq','Robert','Buj Gelonch');
/*!40000 ALTER TABLE `users_pec3` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-07  3:42:25
