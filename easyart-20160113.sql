-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: easyart
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `estilo`
--

DROP TABLE IF EXISTS `estilo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estilo` (
  `estilo_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `estilo_nombre` varchar(200) DEFAULT NULL,
  `estilo_valor` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`estilo_id`),
  UNIQUE KEY `estilo_id` (`estilo_id`),
  UNIQUE KEY `estilo_nombre` (`estilo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estilo`
--

LOCK TABLES `estilo` WRITE;
/*!40000 ALTER TABLE `estilo` DISABLE KEYS */;
INSERT INTO `estilo` VALUES (1,'background-color','#'),(2,'background-image','/easyart/img/bg/image00042.png');
/*!40000 ALTER TABLE `estilo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galeria`
--

DROP TABLE IF EXISTS `galeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galeria` (
  `galeria_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `galeria_url` varchar(2000) DEFAULT NULL,
  `galeria_titulo` varchar(200) DEFAULT NULL,
  `galeria_descripcion` varchar(3000) DEFAULT NULL,
  `galeria_nombre` varchar(300) DEFAULT NULL,
  `galeria_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `galeria_estado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`galeria_id`),
  UNIQUE KEY `galeria_id` (`galeria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeria`
--

LOCK TABLES `galeria` WRITE;
/*!40000 ALTER TABLE `galeria` DISABLE KEYS */;
INSERT INTO `galeria` VALUES (4,'/easyart/img/carrusel/bgimage_1.jpg','vinilos decorativos','vinilos decorativos','vinilos decorativos','2016-01-06 21:01:35',1),(5,'/easyart/img/carrusel/bgimage_3.jpg','personalizados','vinilos personalizados','vinilos personalizados','2016-01-06 21:02:08',1),(6,'/easyart/img/carrusel/bgimage_4.jpg','decorativos','vinilos decorativos','vinilos decorativos','2016-01-06 21:02:45',1),(7,'/easyart/img/carrusel/bgimage_5.jpg','instalacion','servicio de instalacion','servicio de instalacion','2016-01-06 21:03:24',1),(8,'/easyart/img/carrusel/bgimage_6.jpg','infantil','decoracion infantil','decoracion infantil','2016-01-06 21:03:48',1);
/*!40000 ALTER TABLE `galeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_articulo`
--

DROP TABLE IF EXISTS `gd_articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_articulo` (
  `articulo_id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_categoria` varchar(45) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'Sin categoria',
  `articulo_orden` int(11) NOT NULL DEFAULT '-1',
  `articulo_estado` tinyint(1) NOT NULL DEFAULT '1',
  `articulo_especial` tinyint(1) NOT NULL DEFAULT '0',
  `articulo_autor` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `articulo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `articulo_titulo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `articulo_contenido` text COLLATE latin1_spanish_ci,
  `articulo_image` varchar(45) COLLATE latin1_spanish_ci DEFAULT 'img/',
  `articulo_slug` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `articulo_descripcion` varchar(1000) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`articulo_id`),
  UNIQUE KEY `articulo_titulo` (`articulo_titulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_articulo`
--

LOCK TABLES `gd_articulo` WRITE;
/*!40000 ALTER TABLE `gd_articulo` DISABLE KEYS */;
/*!40000 ALTER TABLE `gd_articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_categoria`
--

DROP TABLE IF EXISTS `gd_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `categoria_orden` int(11) NOT NULL DEFAULT '-1',
  `categoria_estado` tinyint(1) NOT NULL DEFAULT '0',
  `categoria_grupo` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `categoria_propietario` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`categoria_id`),
  UNIQUE KEY `categoria_nombre` (`categoria_nombre`),
  KEY `fk_categoria_grupo_idx` (`categoria_grupo`),
  KEY `fk_categoria_propietario_idx` (`categoria_propietario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_categoria`
--

LOCK TABLES `gd_categoria` WRITE;
/*!40000 ALTER TABLE `gd_categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `gd_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_componente`
--

DROP TABLE IF EXISTS `gd_componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_componente` (
  `componente_id` int(11) NOT NULL AUTO_INCREMENT,
  `componente_nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `componente_slug` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `componente_enlace` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `componente_archivo` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `componente_estado` tinyint(4) NOT NULL DEFAULT '1',
  `componente_url` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`componente_id`),
  UNIQUE KEY `componente_id_UNIQUE` (`componente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_componente`
--

LOCK TABLES `gd_componente` WRITE;
/*!40000 ALTER TABLE `gd_componente` DISABLE KEYS */;
INSERT INTO `gd_componente` VALUES (1,'Control de Inicio de Sesion','control-de-inicio-de-sesion','admin/login','auth.php',1,'http://localhost/easyapp/admin/login'),(2,'Cierre de Sesion','cierre-de-sesion','admin/logout','auth.php',1,'http://localhost/easyapp/admin/logout'),(3,'Cambios el Saman','cambios-el-saman','inicio','inicio.php',1,'http://localhost/easyapp/'),(4,'Panel de Control del Sistema','panel-de-control-del-sistema','admin/admin','admin.php',1,'http://localhost/easyapp/admin/'),(5,'Gestor de Usuarios','gestor-de-usuarios','admin/usuario','usuario.php',1,'http://localhost/easyapp/admin/usuario'),(6,'Crear Usuario','crear-usuario','admin/usuario_crear','usuario.php',1,'http://localhost/easyapp/admin/usuario/add'),(7,'Editar Usuario','editar-usuario','admin/usuario_editar','usuario.php',1,'http://localhost/easyapp/admin/usuario/edit/'),(8,'Eliminar Usuario','eliminar-usuario','admin/usuario/delete','usuario.php',1,'http://localhost/easyapp/admin/usuario/delete/'),(9,'Permisos de Usuario','permisos-de-usuario','admin/usuario_acceso','usuario.php',1,'http://localhost/easyapp/admin/usuario/acceso/'),(10,'Gestor de Grupos','gestor-de-grupos','admin/grupo','grupo.php',1,'http://localhost/easyapp/admin/grupo'),(11,'Agregar Grupo','agregar-grupo','admin/grupo_crear','grupo.php',1,'http://localhost/easyapp/admin/grupo/add'),(12,'Modificar Grupo','modificar-grupo','admin/grupo_editar','grupo.php',1,'http://localhost/easyapp/admin/grupo/edit/'),(13,'Eliminar Grupo','eliminar-grupo','admin/grupo/delete','grupo.php',1,'http://localhost/easyapp/admin/grupo/delete/'),(14,'Permisos de Grupo','permisos-de-grupo','admin/grupo_acceso','grupo.php',1,'http://localhost/easyapp/admin/grupo/acceso/'),(15,'Gestor de Permisos','gestor-de-permisos','admin/permisos','permisos.php',1,'http://localhost/easyapp/admin/permisos'),(16,'Agregar Permisos','agregar-permisos','admin/permisos_crear','permisos.php',1,'http://localhost/easyapp/admin/permisos/add'),(17,'Modificar Permisos','modificar-permisos','admin/permisos_editar','permisos.php',1,'http://localhost/easyapp/admin/permisos/edit/'),(18,'Eliminar Permisos','eliminar-permisos','admin/permisos/delete','permisos.php',1,'http://localhost/easyapp/admin/permisos/delete/'),(19,'Creador de Menu','creador-de-menu','admin/menu','menu.php',1,'http://localhost/easyapp/admin/menu'),(20,'Crear Acceso en Menu','crear-acceso-en-menu','admin/menu_crear','menu.php',1,'http://localhost/easyapp/admin/menu/add'),(21,'Editar Accesos en Menu','editar-accesos-en-menu','admin/menu_editar','menu.php',1,'http://localhost/easyapp/admin/menu/edit/'),(22,'Quitar del Menu','quitar-del-menu','admin/menu/delete','menu.php',1,'http://localhost/easyapp/admin/menu/delete/'),(23,'Permisos de Acceso al Menu','permisos-de-acceso-al-menu','admin/menu_acceso','menu.php',1,'http://localhost/easyapp/admin/menu/acceso/'),(24,'Crear Clase de Elementos','crear-clase-de-elementos','admin/menu_clase','menu.php',1,'http://localhost/easyapp/admin/menu/add/clase'),(25,'Crear Grupo de Elementos','crear-grupo-de-elementos','admin/menu_grupo','menu.php',1,'http://localhost/easyapp/admin/menu/add/grupo'),(26,'Gestor de Articulos','gestor-de-articulos','admin/articulo','articulo.php',1,'http://localhost/easyapp/admin/articulo'),(27,'Agregar Articulo','agregar-articulo','admin/articulo_crear','articulo.php',1,'http://localhost/easyapp/admin/articulo/add'),(28,'Modificar Articulo','modificar-articulo','admin/articulo_editar','articulo.php',1,'http://localhost/easyapp/admin/articulo/edit/'),(29,'Eliminar Articulo','eliminar-articulo','admin/articulo/delete','articulo.php',1,'http://localhost/easyapp/admin/articulo/delete/'),(30,'Gestór de Categorias','gest-r-de-categorias','admin/categoria','categoria.php',1,'http://localhost/easyapp/admin/categoria'),(31,'Crear Categoria','crear-categoria','admin/categoria_crear','categoria.php',1,'http://localhost/easyapp/admin/categoria/add'),(32,'Editar Categoria','editar-categoria','admin/categoria_editar','categoria.php',1,'http://localhost/easyapp/admin/categoria/edit/'),(33,'Eliminar Categoria','eliminar-categoria','admin/categoria/delete','categoria.php',1,'http://localhost/easyapp/admin/categoria/delete/'),(219,'Administrador de Productos','administrador-de-productos','admin/producto','producto.php',1,'http://localhost/easyapp/admin/producto'),(220,'Lista de elementos del carrusel','lista-de-elementos-del-carrusel','admin/elementos','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elementos'),(221,'Agregar elemento al carrusel','agregar-elemento-al-carrusel','admin/elemento_nuevo','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_nuevo'),(222,'Editar elemento al carrusel','editar-elemento-al-carrusel','admin/elemento_editar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_editar'),(223,'Borrar elemento al carrusel','borrar-elemento-al-carrusel','admin/elemento_borrar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_borrar'),(224,'Publicar elemento al carrusel','publicar-elemento-al-carrusel','admin/elemento_publicar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_publicar'),(225,'Destacar producto','destacar-producto','admin/elemento_destacar','producto.php',1,'http://localhost/easyapp/admin/producto/elemento_destacar'),(226,'Grupos de productos','grupos-de-productos','admin/producto_grupo','producto.php',1,'http://localhost/easyapp/admin/producto/producto_grupo'),(227,'Categorias de producto','categorias-de-producto','admin/producto_categoria','producto.php',1,'http://localhost/easyapp/admin/producto/producto_categoria'),(228,'Imagenes del producto','imagenes-del-producto','admin/producto_imagen','producto_imagen.php',1,'http://localhost/easyapp/admin/producto/imagenes'),(229,'Lista de Imagenes del producto','lista-de-imagenes-del-producto','admin/producto/imagenes/imagenes_producto','producto_imagen.php',1,'http://localhost/easyapp/admin/producto/imagenes/imagenes_producto'),(230,'Agregar imagen del producto','agregar-imagen-del-producto','admin/producto/imagenes/agregar_imagen','producto_imagen.php',1,'http://localhost/easyapp/admin/producto/imagenes/agregar_imagen'),(231,'Borrar imagen del producto','borrar-imagen-del-producto','admin/producto/imagenes/borrar_imagen','producto_imagen.php',1,'http://localhost/easyapp/admin/producto/imagenes/borrar'),(232,'publicar imagen del producto','','admin/producto/imagenes/publicar_imagen','producto_imagen.php',1,'http://localhost/easyapp/admin/producto/imagenes/publicar_imagen'),(233,'Administrador de Imagenes del Carrusel','administrador-de-imagenes-del-carrusel','admin/carrusel','carrusel.php',1,'http://localhost/easyapp/admin/carrusel'),(235,'Publicación de Novedades','publicaci-n-de-novedades','admin/novedades','novedades.php',1,'http://localhost/easyapp/admin/novedades'),(236,'Lista de Novedades','lista-de-novedades','admin/novedades_lista','novedades.php',1,'http://localhost/easyapp/admin/novedades/elementos'),(237,'Nueva Novedad','nueva-novedad','admin/novedades_agregar','novedades.php',1,'http://localhost/easyapp/admin/novedades/elemento_nuevo'),(238,'Editar Novedad','editar-novedad','admin/novedades_editar','novedades.php',1,'http://localhost/easyapp/admin/novedades/elemento_editar'),(239,'Borrar Novedad','borrar-novedad','admin/novedades_borrar','novedades.php',1,'http://localhost/easyapp/admin/novedades/elemento_borrar'),(240,'Publicar Novedad','publicar-novedad','admin/novedades_publicar','novedades.php',1,'http://localhost/easyapp/admin/novedades/elemento_publicar'),(241,'Destacar Novedad','destacar-novedad','admin/novedades_destcar','novedades.php',1,'http://localhost/easyapp/admin/novedades/elemento_destacar'),(243,'Estilos de la Pagina','estilos-de-la-pagina','admin/estilos','estilos.php',1,'http://localhost/easyapp/admin/estilos'),(244,'Modificar Estilos de la Pagina','modificar-estilos-de-la-pagina','admin/estilos_cambiar','estilos.php',1,'http://localhost/easyapp/admin/estilos/cambiar');
/*!40000 ALTER TABLE `gd_componente` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `gd_componente_AFTER_INSERT` 
AFTER INSERT ON `gd_componente` FOR EACH ROW
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE grupo char(55);
    DECLARE grupos CURSOR FOR SELECT grupo_nombre FROM gd_grupo;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN grupos;
        ins_loop: LOOP
            FETCH grupos INTO grupo;
            IF done THEN
                LEAVE ins_loop;
            END IF;
            INSERT INTO gd_permisos_grupo (permisos_grupo_componente, permisos_grupo_nombre) 
            VALUES (NEW.componente_id, grupo) on duplicate key update
            permisos_grupo_nombre = grupo, 
            permisos_grupo_componente = NEW.componente_id;
        END LOOP;
    CLOSE grupos;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gd_grupo`
--

DROP TABLE IF EXISTS `gd_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_grupo` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `grupo_estado` tinyint(1) NOT NULL DEFAULT '1',
  `grupo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`grupo_id`),
  UNIQUE KEY `grupo_nombre` (`grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_grupo`
--

LOCK TABLES `gd_grupo` WRITE;
/*!40000 ALTER TABLE `gd_grupo` DISABLE KEYS */;
INSERT INTO `gd_grupo` VALUES (25,'admin',1,'2016-01-06 04:26:38');
/*!40000 ALTER TABLE `gd_grupo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_spanish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `gd_grupo_AFTER_INSERT` AFTER INSERT ON `gd_grupo` FOR EACH ROW
BEGIN
INSERT INTO gd_permisos_grupo (permisos_grupo_nombre, permisos_grupo_componente) 
SELECT NEW.grupo_nombre AS grupo_nombre, componente_id FROM gd_componente 
on duplicate key update 
permisos_grupo_nombre = permisos_grupo_nombre, 
permisos_grupo_componente = permisos_grupo_componente;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_spanish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `gd_grupo_AFTER_UPDATE` 
AFTER UPDATE ON `gd_grupo` FOR EACH ROW
BEGIN
INSERT INTO gd_permisos_grupo (permisos_grupo_nombre, permisos_grupo_componente) 
SELECT NEW.grupo_nombre AS grupo_nombre, componente_id FROM gd_componente 
on duplicate key update 
permisos_grupo_nombre = permisos_grupo_nombre, 
permisos_grupo_componente = permisos_grupo_componente;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gd_menu`
--

DROP TABLE IF EXISTS `gd_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_clase` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_titulo` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_enlace` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_componente` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_orden` int(11) NOT NULL,
  `menu_grupo` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_menu`
--

LOCK TABLES `gd_menu` WRITE;
/*!40000 ALTER TABLE `gd_menu` DISABLE KEYS */;
INSERT INTO `gd_menu` VALUES (1,'Administracion','Gestión de Usuarios','http://localhost/easyapp/admin/usuario','Gestor de Usuarios',0,'Usuarios'),(2,'Administracion','Crear Usuario','http://localhost/easyapp/admin/usuario/add','Crear Usuario',1,'Usuarios'),(3,'Administracion','Editor de Menu','http://localhost/easyapp/admin/menu','Creador de Menu',4,'Menu'),(4,'Administracion','Gestión de Grupos','http://localhost/easyapp/admin/grupo','Gestor de Grupos',2,'Grupos'),(5,'Contenido','Gestión de Articulos','http://localhost/easyapp/admin/articulo','Gestor de Articulos',10,'Articulos'),(23,'Contenido','Carrusel','http://localhost/easyapp/admin/carrusel','Administrador de Imagenes del Carrusel',11,'Articulos'),(24,'Contenido','Productos','http://localhost/easyapp/admin/producto','Administrador de Productos',12,'Articulos'),(25,'Contenido','Novedades','http://localhost/easyapp/admin/novedades','Publicación de Novedades',15,'Articulos'),(26,'Contenido','Estilos','http://localhost/easyapp/admin/estilos','Estilos de la Pagina',16,'Articulos');
/*!40000 ALTER TABLE `gd_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_menu_clase`
--

DROP TABLE IF EXISTS `gd_menu_clase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_menu_clase` (
  `menu_clase_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_clase_nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_clase_orden` int(11) NOT NULL DEFAULT '1',
  `menu_clase_estado` tinyint(4) NOT NULL DEFAULT '1',
  `menu_clase_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_clase_id`),
  UNIQUE KEY `menu_grupo_nombre_UNIQUE` (`menu_clase_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_menu_clase`
--

LOCK TABLES `gd_menu_clase` WRITE;
/*!40000 ALTER TABLE `gd_menu_clase` DISABLE KEYS */;
INSERT INTO `gd_menu_clase` VALUES (1,'Administracion',1,1,'2015-08-04 04:24:56'),(2,'Contenido',1,1,'2015-08-04 04:29:09');
/*!40000 ALTER TABLE `gd_menu_clase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_menu_grupo`
--

DROP TABLE IF EXISTS `gd_menu_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_menu_grupo` (
  `menu_grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_grupo_nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `menu_grupo_orden` int(11) NOT NULL DEFAULT '1',
  `menu_grupo_estado` tinyint(4) NOT NULL DEFAULT '1',
  `menu_grupo_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_grupo_id`),
  UNIQUE KEY `menu_grupo_nombre_UNIQUE` (`menu_grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_menu_grupo`
--

LOCK TABLES `gd_menu_grupo` WRITE;
/*!40000 ALTER TABLE `gd_menu_grupo` DISABLE KEYS */;
INSERT INTO `gd_menu_grupo` VALUES (1,'Usuarios',1,1,'2015-08-04 04:25:09'),(2,'Menu',1,1,'2015-08-04 04:26:36'),(3,'Grupos',1,1,'2015-08-04 04:27:33'),(4,'Articulos',1,1,'2015-08-04 04:29:17');
/*!40000 ALTER TABLE `gd_menu_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_permisos_grupo`
--

DROP TABLE IF EXISTS `gd_permisos_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_permisos_grupo` (
  `permisos_grupo_nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `permisos_grupo_componente` int(11) NOT NULL,
  `permisos_grupo_estado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permisos_grupo_componente`,`permisos_grupo_nombre`),
  UNIQUE KEY `uk_grupo_componente` (`permisos_grupo_nombre`,`permisos_grupo_componente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_permisos_grupo`
--

LOCK TABLES `gd_permisos_grupo` WRITE;
/*!40000 ALTER TABLE `gd_permisos_grupo` DISABLE KEYS */;
INSERT INTO `gd_permisos_grupo` VALUES ('admin',1,1),('admin',2,1),('admin',3,1),('admin',4,1),('admin',5,1),('admin',6,1),('admin',7,1),('admin',8,1),('admin',9,1),('admin',10,1),('admin',11,1),('admin',12,1),('admin',13,1),('admin',14,1),('admin',15,1),('admin',16,1),('admin',17,1),('admin',18,1),('admin',19,1),('admin',20,1),('admin',21,1),('admin',22,1),('admin',23,1),('admin',24,1),('admin',25,1),('admin',26,1),('admin',27,1),('admin',28,1),('admin',29,1),('admin',30,1),('admin',31,1),('admin',32,1),('admin',33,1),('admin',219,1),('admin',220,1),('admin',221,1),('admin',222,1),('admin',223,1),('admin',224,1),('admin',225,1),('admin',226,1),('admin',227,1),('admin',228,1),('admin',229,1),('admin',230,1),('admin',231,1),('admin',232,1),('admin',233,1),('admin',234,0),('admin',235,1),('admin',236,1),('admin',237,1),('admin',238,1),('admin',239,1),('admin',240,1),('admin',241,1),('admin',242,0),('admin',243,1),('admin',244,1);
/*!40000 ALTER TABLE `gd_permisos_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_permisos_menu`
--

DROP TABLE IF EXISTS `gd_permisos_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_permisos_menu` (
  `permisos_menu_grupo` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `permisos_menu_elemento` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`permisos_menu_grupo`,`permisos_menu_elemento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_permisos_menu`
--

LOCK TABLES `gd_permisos_menu` WRITE;
/*!40000 ALTER TABLE `gd_permisos_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `gd_permisos_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_permisos_usuario`
--

DROP TABLE IF EXISTS `gd_permisos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_permisos_usuario` (
  `permisos_usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `permisos_usuario_sid` varchar(55) COLLATE latin1_spanish_ci DEFAULT NULL,
  `permisos_usuario_componente` int(11) NOT NULL,
  `permisos_usuario_estado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permisos_usuario_id`),
  UNIQUE KEY `uk_usuario_componente` (`permisos_usuario_sid`,`permisos_usuario_componente`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_permisos_usuario`
--

LOCK TABLES `gd_permisos_usuario` WRITE;
/*!40000 ALTER TABLE `gd_permisos_usuario` DISABLE KEYS */;
INSERT INTO `gd_permisos_usuario` VALUES (1,'admin',1,1),(2,'admin',2,1),(3,'admin',3,1),(4,'admin',4,1),(5,'admin',5,1),(6,'admin',6,1),(7,'admin',7,1),(8,'admin',8,1),(9,'admin',9,1),(10,'admin',10,1),(11,'admin',11,1),(12,'admin',12,1),(13,'admin',13,1),(14,'admin',14,1),(15,'admin',15,1),(16,'admin',16,1),(17,'admin',17,1),(18,'admin',18,1),(19,'admin',19,1),(20,'admin',20,1),(21,'admin',21,1),(22,'admin',22,1),(23,'admin',23,1),(24,'admin',24,1),(25,'admin',25,1),(26,'admin',26,1),(27,'admin',27,1),(28,'admin',28,1),(29,'admin',29,1),(30,'admin',30,1),(31,'admin',31,1),(32,'admin',32,1),(33,'admin',33,1),(64,'admin',219,1),(65,'admin',220,1),(66,'admin',221,1),(67,'admin',222,1),(68,'admin',223,1),(69,'admin',224,1),(70,'admin',225,1),(71,'admin',226,1),(72,'admin',227,1),(73,'admin',228,1),(74,'admin',229,1),(75,'admin',230,1),(76,'admin',231,1),(77,'admin',232,1),(78,'admin',233,1),(80,'admin',235,1),(81,'admin',236,1),(82,'admin',237,1),(83,'admin',238,1),(84,'admin',239,1),(85,'admin',240,1),(86,'admin',241,1),(89,'admin',243,1),(90,'admin',244,1);
/*!40000 ALTER TABLE `gd_permisos_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_usuario`
--

DROP TABLE IF EXISTS `gd_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_usuario` (
  `usuario_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_apellido` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_email` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_sid` varchar(55) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_clave` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_estado` tinyint(4) DEFAULT '1',
  `usuario_grupo` varchar(45) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_sid` (`usuario_sid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_usuario`
--

LOCK TABLES `gd_usuario` WRITE;
/*!40000 ALTER TABLE `gd_usuario` DISABLE KEYS */;
INSERT INTO `gd_usuario` VALUES (6,'admin','sistema','administrador@sistema.com','admin','$2y$12$TBVJBoCVAMn.swXXEIzlgOJjLtU69bWBEpEgfU0IORWWB4/BNPt0C','2016-01-06 04:26:38',1,'admin');
/*!40000 ALTER TABLE `gd_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `novedades`
--

DROP TABLE IF EXISTS `novedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novedades` (
  `novedades_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `novedades_titulo` varchar(200) NOT NULL,
  `novedades_resumen` varchar(300) NOT NULL,
  `novedades_contenido` varchar(5000) NOT NULL,
  `novedades_imagen_url` varchar(300) NOT NULL,
  `novedades_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `novedades_autor` varchar(100) NOT NULL,
  `novedades_estado` tinyint(1) DEFAULT '0',
  `novedades_destacado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`novedades_id`),
  UNIQUE KEY `novedades_id` (`novedades_id`),
  UNIQUE KEY `novedades_titulo` (`novedades_titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `novedades`
--

LOCK TABLES `novedades` WRITE;
/*!40000 ALTER TABLE `novedades` DISABLE KEYS */;
INSERT INTO `novedades` VALUES (4,'Publicacion de Prueba','Resumen de la publicacion de prueba hay que buscarle lugar','<p>aqui va todo el contenido de la novedad de prueba se supone que el editor ayudara a la edicion del contenido permitiendo jaustar el texto para dar una mejor experiencia a los usuarios</p>','/easyart/img/novedades/13.jpg','2016-01-12 19:24:10','admin',1,1),(5,'asdasd','asdasdsad','<p>asdasdasd12312312</p>','/easyart/img/novedades/2.jpg','2016-01-12 19:53:48','admin',1,0),(6,'Segunda publicación de prueba','prueba de contenido','<p>&nbsp; &nbsp; &nbsp; &nbsp; Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; Fusce convallis, mauris imperdiet gravida bibendum, nisl turpis suscipit mauris, sed placerat ipsum urna sed risus. In convallis tellus a mauris. Curabitur non elit ut libero tristique sodales. Mauris a lacus. Donec mattis semper leo. In hac habitasse platea dictumst. Vivamus facilisis diam at odio. Mauris dictum, nisi eget consequat elementum, lacus ligula molestie metus, non feugiat orci magna ac sem. Donec turpis. Donec vitae metus. Morbi tristique neque eu mauris. Quisque gravida ipsum non sapien. Proin turpis lacus, scelerisque vitae, elementum at, lobortis ac, quam. Aliquam dictum eleifend risus. In hac habitasse platea dictumst. Etiam sit amet diam. Suspendisse odio. Suspendisse nunc. In semper bibendum libero.</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;Proin nonummy, lacus eget pulvinar lacinia, pede felis dignissim leo, vitae tristique magna lacus sit amet eros. Nullam ornare. Praesent odio ligula, dapibus sed, tincidunt eget, dictum ac, nibh. Nam quis lacus. Nunc eleifend molestie velit. Morbi lobortis quam eu velit. Donec euismod vestibulum massa. Donec non lectus. Aliquam commodo lacus sit amet nulla. Cras dignissim elit et augue. Nullam non diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In hac habitasse platea dictumst. Aenean vestibulum. Sed lobortis elit quis lectus. Nunc sed lacus at augue bibendum dapibus.</p>','/easyart/img/novedades/5.jpg','2016-01-12 19:56:04','admin',1,0);
/*!40000 ALTER TABLE `novedades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `producto_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_url` varchar(2000) DEFAULT NULL,
  `producto_resumen` varchar(200) DEFAULT NULL,
  `producto_descripcion` varchar(3000) DEFAULT NULL,
  `producto_nombre` varchar(300) DEFAULT NULL,
  `producto_grupo` varchar(300) DEFAULT NULL,
  `producto_existencias` int(11) DEFAULT NULL,
  `producto_precio` decimal(10,0) DEFAULT NULL,
  `producto_categoria` varchar(300) DEFAULT NULL,
  `producto_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `producto_estado` tinyint(1) DEFAULT '0',
  `producto_destacado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `producto_id` (`producto_id`),
  KEY `categoria_idx` (`producto_categoria`),
  KEY `grupo_idx` (`producto_grupo`),
  CONSTRAINT `categoria` FOREIGN KEY (`producto_categoria`) REFERENCES `producto_categoria` (`producto_categoria_nombre`) ON UPDATE CASCADE,
  CONSTRAINT `grupo` FOREIGN KEY (`producto_grupo`) REFERENCES `producto_grupo` (`producto_grupo_nombre`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,NULL,'Sin descripción especifica de este producto','<p>asdasdadasd</p>','Producto de prueba','sdasdasd',123,123123,'vinilos','2016-01-05 23:27:47',1,1),(2,NULL,'hermoso vinilo para la habitacion de los niños','<p>vinilo para los ni&ntilde;os donde podran escribir o dibujar tanto como ellos quieran, una gran oportunidad de fomentar la creatividad de tus hijos sin afectar la apariencia de tu hogar</p>\n<p>DIMENSIONES:</p>\n<ul>\n<li>alto: 90 cm&nbsp;</li>\n<li>ancho: 80 cm</li>\n</ul>','LETTERS HOME','niños',5,89500,'vinilos','2016-01-08 18:33:50',1,1),(3,NULL,'MIAMI SKYLINE','<h2 style=\"margin: 0px; padding: 0px; font-size: 2em; line-height: 1.25; font-weight: normal; font-family: Ebrima, Tahoma; text-transform: uppercase; color: #555555;\">MIAMI SKYLINE</h2>','MIAMI SKYLINE','sala',5,69900,'vinilos','2016-01-08 19:44:38',1,1),(4,NULL,'CEBRA POP ART','<h1 style=\"box-sizing: border-box; margin: 0px; font-size: 18px; font-family: SegoeUILight; font-weight: normal; line-height: 22px; color: #555555; padding: 0px 0px 10px; text-transform: uppercase;\">CEBRA POP ART</h1>\n<p>dimensiones:</p>\n<ul>\n<li>alto: 110 cm</li>\n<li>ancho: 110 cm</li>\n</ul>','CEBRA POP ART','habitacion',5,99900,'vinilos','2016-01-08 19:51:51',1,1),(5,NULL,'VINILO AUTOADHERIBLE DE FACIL INSTALACIÓN','<p><span style=\"color: #666666; font-family: SegoeUILight; font-size: 16px; line-height: 20px;\">El&nbsp;</span><strong style=\"box-sizing: border-box; color: #666666; font-family: SegoeUILight; font-size: 16px; line-height: 20px;\">Amor</strong><span style=\"color: #666666; font-family: SegoeUILight; font-size: 16px; line-height: 20px;\">, ese sentimiento que siempre nos acompa&ntilde;a en nuestras vidas, que nos hace buscar insistentemente entre la gran multitud a esa persona con la que pasar el resto de los d&iacute;as y que nos hace ser felices. Y... una vez encontrado, &iquest;c&oacute;mo no vas a celebrarlo?. Te damos una idea para decorar tu casa, tu hogar: un&nbsp;</span><strong style=\"box-sizing: border-box; color: #666666; font-family: SegoeUILight; font-size: 16px; line-height: 20px;\">vinilo decorativo romantico</strong><span style=\"color: #666666; font-family: SegoeUILight; font-size: 16px; line-height: 20px;\">: un coraz&oacute;n, una mirada, una frase sugerente, un abrazo o sencillamente una pareja d&aacute;ndose un beso tierno.</span></p>','CORAZONES COLGANTES','habitacion',5,79900,'vinilos','2016-01-08 20:19:14',1,1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `easyart`.`producto_BEFORE_INSERT` BEFORE INSERT ON `producto` FOR EACH ROW
BEGIN
insert into producto_categoria (producto_categoria_nombre) values (new.producto_categoria) on duplicate key update producto_categoria_nombre = new.producto_categoria;
insert into producto_grupo (producto_grupo_nombre, producto_grupo_categoria) values (new.producto_grupo, new.producto_categoria) on duplicate key update producto_grupo_categoria = new.producto_categoria, producto_grupo_nombre = new.producto_grupo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `easyart`.`producto_BEFORE_UPDATE` BEFORE UPDATE ON `producto` FOR EACH ROW
BEGIN
insert into producto_categoria (producto_categoria_nombre) values (new.producto_categoria) on duplicate key update producto_categoria_nombre = new.producto_categoria;
insert into producto_grupo (producto_grupo_nombre, producto_grupo_categoria) values (new.producto_grupo, new.producto_categoria) on duplicate key update producto_grupo_categoria = new.producto_categoria, producto_grupo_nombre = new.producto_grupo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `producto_categoria`
--

DROP TABLE IF EXISTS `producto_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_categoria` (
  `producto_categoria_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_categoria_nombre` varchar(500) DEFAULT NULL,
  `producto_categoria_estado` tinyint(1) DEFAULT '1',
  `producto_categoria_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_categoria_id`),
  UNIQUE KEY `producto_categoria_id` (`producto_categoria_id`),
  UNIQUE KEY `producto_categoria_nombre` (`producto_categoria_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
INSERT INTO `producto_categoria` VALUES (4,'asdasdasd',1,'2016-01-05 23:27:47'),(5,'vinilos',1,'2016-01-08 18:33:50');
/*!40000 ALTER TABLE `producto_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_grupo`
--

DROP TABLE IF EXISTS `producto_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_grupo` (
  `producto_grupo_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_grupo_nombre` varchar(500) DEFAULT NULL,
  `producto_grupo_categoria` varchar(500) NOT NULL,
  `producto_grupo_estado` tinyint(1) DEFAULT '1',
  `producto_grupo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_grupo_id`),
  UNIQUE KEY `producto_grupo_id` (`producto_grupo_id`),
  UNIQUE KEY `producto_grupo_nombre` (`producto_grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_grupo`
--

LOCK TABLES `producto_grupo` WRITE;
/*!40000 ALTER TABLE `producto_grupo` DISABLE KEYS */;
INSERT INTO `producto_grupo` VALUES (1,'sdasdasd','vinilos',1,'2016-01-05 23:27:47'),(2,'habitacion','vinilos',1,'2016-01-08 18:33:50'),(5,'niños','vinilos',1,'2016-01-08 20:03:40'),(6,'sala','vinilos',1,'2016-01-08 20:03:54'),(10,'zona2','vinilos',1,'2016-01-08 20:10:08');
/*!40000 ALTER TABLE `producto_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_imagen`
--

DROP TABLE IF EXISTS `producto_imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_imagen` (
  `producto_imagen_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto_imagen_nombre` varchar(300) DEFAULT NULL,
  `producto_imagen_producto` bigint(20) DEFAULT NULL,
  `producto_imagen_titulo` varchar(200) DEFAULT NULL,
  `producto_imagen_descripcion` varchar(3000) DEFAULT NULL,
  `producto_imagen_url` varchar(3000) DEFAULT NULL,
  `producto_imagen_estado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`producto_imagen_id`),
  UNIQUE KEY `producto_imagen_id` (`producto_imagen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_imagen`
--

LOCK TABLES `producto_imagen` WRITE;
/*!40000 ALTER TABLE `producto_imagen` DISABLE KEYS */;
INSERT INTO `producto_imagen` VALUES (1,'asdads',1,'asdasdasd','asdasdasd','/easyart/img/productos/vinilo-mariposas_mv078.jpg',1),(2,'LETTERS HOME',2,'LETTERS HOME','LETTERS HOME','/easyart/img/productos/pz027.jpg',1),(3,'MIAMI SKYLINE',3,'MIAMI SKYLINE','MIAMI SKYLINE','/easyart/img/productos/miami_skyline.jpg',1),(4,'CEBRA POP ART',4,'CEBRA POP ART','CEBRA POP ART','/easyart/img/productos/cebra-pop-art.jpg',1),(5,'location.reload();',4,'location.reload();','location.reload();','/easyart/img/productos/vinilo-decorativo-circo_mv380.jpg',1),(6,'asd',4,'imagen del producto elegido','vista frontal','/easyart/img/productos/vinilo-mariposas_mv078.jpg',1),(7,'asdasdasd',4,'asdads','asdasdasd','/easyart/img/productos/vinilo-mariposas_mv078.jpg',1),(8,'asd',4,'imagen del producto elegido','vista frontal','/easyart/img/productos/miami_skyline.jpg',1),(9,'VINILO AUTOADHERIBLE DE FACIL INSTALACIÓN',5,'VINILO AUTOADHERIBLE DE FACIL INSTALACIÓN','VINILO AUTOADHERIBLE DE FACIL INSTALACIÓN','/easyart/img/productos/corazones-colgantes.jpg',1),(10,'asdasdasdasd',1,'asdasdasdasd','asdasdasdasd','/easyart/img/productos/1.jpg',0);
/*!40000 ALTER TABLE `producto_imagen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'easyart'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-13 13:38:51
