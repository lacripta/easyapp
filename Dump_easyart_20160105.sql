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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeria`
--

LOCK TABLES `galeria` WRITE;
/*!40000 ALTER TABLE `galeria` DISABLE KEYS */;
INSERT INTO `galeria` VALUES (1,'/easyart/img/carrusel/www.gif','adadfasd','assdffdadsa','asasdasd','2015-12-30 02:07:09',0),(2,'/easyart/img/carrusel/reduce-reultiliza-y-recicla.jpg','ñlsdfñlsdfñlk|s','ñlskdfñldskflñ','ñlwñlñl','2015-12-30 02:08:07',1),(3,'/easyart/img/carrusel/rrrlogo.gif','lksdflksdjflksdfjkl','sdksdklfklsjdflksdj','ñkddflkdsflkj','2015-12-30 02:08:30',1);
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
  `articulo_categoria` varchar(45) NOT NULL DEFAULT 'Sin categoria',
  `articulo_orden` int(11) NOT NULL DEFAULT '-1',
  `articulo_estado` tinyint(1) NOT NULL DEFAULT '1',
  `articulo_especial` tinyint(1) NOT NULL DEFAULT '0',
  `articulo_autor` varchar(45) NOT NULL,
  `articulo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `articulo_titulo` varchar(500) NOT NULL,
  `articulo_contenido` text,
  `articulo_image` varchar(45) DEFAULT 'img/',
  `articulo_slug` varchar(45) NOT NULL,
  `articulo_descripcion` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`articulo_id`),
  UNIQUE KEY `articulo_titulo` (`articulo_titulo`),
  KEY `fk_autor` (`articulo_autor`),
  KEY `fk_categoria` (`articulo_categoria`),
  CONSTRAINT `fk_autor` FOREIGN KEY (`articulo_autor`) REFERENCES `gd_usuario` (`usuario_sid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_categoria` FOREIGN KEY (`articulo_categoria`) REFERENCES `gd_categoria` (`categoria_nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
  `categoria_nombre` varchar(255) NOT NULL,
  `categoria_orden` int(11) NOT NULL DEFAULT '-1',
  `categoria_estado` tinyint(1) NOT NULL DEFAULT '0',
  `categoria_grupo` varchar(45) NOT NULL,
  `categoria_propietario` varchar(45) NOT NULL,
  PRIMARY KEY (`categoria_id`),
  UNIQUE KEY `categoria_nombre` (`categoria_nombre`),
  KEY `fk_categoria_grupo` (`categoria_grupo`),
  KEY `fk_categoria_propietario` (`categoria_propietario`),
  CONSTRAINT `fk_categoria_grupo` FOREIGN KEY (`categoria_grupo`) REFERENCES `gd_grupo` (`grupo_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_categoria_propietario` FOREIGN KEY (`categoria_propietario`) REFERENCES `gd_usuario` (`usuario_sid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
  `componente_nombre` varchar(255) NOT NULL,
  `componente_slug` varchar(255) NOT NULL,
  `componente_enlace` varchar(255) NOT NULL,
  `componente_archivo` varchar(255) NOT NULL,
  `componente_estado` tinyint(4) NOT NULL DEFAULT '1',
  `componente_url` varchar(255) NOT NULL,
  PRIMARY KEY (`componente_id`),
  UNIQUE KEY `componente_nombre` (`componente_nombre`),
  UNIQUE KEY `componente_enlace_UNIQUE` (`componente_enlace`),
  UNIQUE KEY `componente_url_UNIQUE` (`componente_url`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_componente`
--

LOCK TABLES `gd_componente` WRITE;
/*!40000 ALTER TABLE `gd_componente` DISABLE KEYS */;
INSERT INTO `gd_componente` VALUES (1,'Control de Inicio de Sesion','control-de-inicio-de-sesion','admin/login','auth.php',1,'http://localhost/easyapp/admin/login'),(2,'Cierre de Sesion','cierre-de-sesion','admin/logout','auth.php',1,'http://localhost/easyapp/admin/logout'),(3,'Cambios el Saman','cambios-el-saman','inicio','inicio.php',1,'http://localhost/easyapp/'),(4,'Panel de Control del Sistema','panel-de-control-del-sistema','admin/admin','admin.php',1,'http://localhost/easyapp/admin/'),(5,'Gestor de Usuarios','gestor-de-usuarios','admin/usuario','usuario.php',1,'http://localhost/easyapp/admin/usuario'),(6,'Crear Usuario','crear-usuario','admin/usuario_crear','usuario.php',1,'http://localhost/easyapp/admin/usuario/add'),(7,'Editar Usuario','editar-usuario','admin/usuario_editar','usuario.php',1,'http://localhost/easyapp/admin/usuario/edit/'),(8,'Eliminar Usuario','eliminar-usuario','admin/usuario/delete','usuario.php',1,'http://localhost/easyapp/admin/usuario/delete/'),(9,'Permisos de Usuario','permisos-de-usuario','admin/usuario_acceso','usuario.php',1,'http://localhost/easyapp/admin/usuario/acceso/'),(10,'Gestor de Grupos','gestor-de-grupos','admin/grupo','grupo.php',1,'http://localhost/easyapp/admin/grupo'),(11,'Agregar Grupo','agregar-grupo','admin/grupo_crear','grupo.php',1,'http://localhost/easyapp/admin/grupo/add'),(12,'Modificar Grupo','modificar-grupo','admin/grupo_editar','grupo.php',1,'http://localhost/easyapp/admin/grupo/edit/'),(13,'Eliminar Grupo','eliminar-grupo','admin/grupo/delete','grupo.php',1,'http://localhost/easyapp/admin/grupo/delete/'),(14,'Permisos de Grupo','permisos-de-grupo','admin/grupo_acceso','grupo.php',1,'http://localhost/easyapp/admin/grupo/acceso/'),(15,'Gestor de Permisos','gestor-de-permisos','admin/permisos','permisos.php',1,'http://localhost/easyapp/admin/permisos'),(16,'Agregar Permisos','agregar-permisos','admin/permisos_crear','permisos.php',1,'http://localhost/easyapp/admin/permisos/add'),(17,'Modificar Permisos','modificar-permisos','admin/permisos_editar','permisos.php',1,'http://localhost/easyapp/admin/permisos/edit/'),(18,'Eliminar Permisos','eliminar-permisos','admin/permisos/delete','permisos.php',1,'http://localhost/easyapp/admin/permisos/delete/'),(19,'Creador de Menu','creador-de-menu','admin/menu','menu.php',1,'http://localhost/easyapp/admin/menu'),(20,'Crear Acceso en Menu','crear-acceso-en-menu','admin/menu_crear','menu.php',1,'http://localhost/easyapp/admin/menu/add'),(21,'Editar Accesos en Menu','editar-accesos-en-menu','admin/menu_editar','menu.php',1,'http://localhost/easyapp/admin/menu/edit/'),(22,'Quitar del Menu','quitar-del-menu','admin/menu/delete','menu.php',1,'http://localhost/easyapp/admin/menu/delete/'),(23,'Permisos de Acceso al Menu','permisos-de-acceso-al-menu','admin/menu_acceso','menu.php',1,'http://localhost/easyapp/admin/menu/acceso/'),(24,'Crear Clase de Elementos','crear-clase-de-elementos','admin/menu_clase','menu.php',1,'http://localhost/easyapp/admin/menu/add/clase'),(25,'Crear Grupo de Elementos','crear-grupo-de-elementos','admin/menu_grupo','menu.php',1,'http://localhost/easyapp/admin/menu/add/grupo'),(26,'Gestor de Articulos','gestor-de-articulos','admin/articulo','articulo.php',1,'http://localhost/easyapp/admin/articulo'),(27,'Agregar Articulo','agregar-articulo','admin/articulo_crear','articulo.php',1,'http://localhost/easyapp/admin/articulo/add'),(28,'Modificar Articulo','modificar-articulo','admin/articulo_editar','articulo.php',1,'http://localhost/easyapp/admin/articulo/edit/'),(29,'Eliminar Articulo','eliminar-articulo','admin/articulo/delete','articulo.php',1,'http://localhost/easyapp/admin/articulo/delete/'),(30,'Gestór de Categorias','gest-r-de-categorias','admin/categoria','categoria.php',1,'http://localhost/easyapp/admin/categoria'),(31,'Crear Categoria','crear-categoria','admin/categoria_crear','categoria.php',1,'http://localhost/easyapp/admin/categoria/add'),(32,'Editar Categoria','editar-categoria','admin/categoria_editar','categoria.php',1,'http://localhost/easyapp/admin/categoria/edit/'),(33,'Eliminar Categoria','eliminar-categoria','admin/categoria/delete','categoria.php',1,'http://localhost/easyapp/admin/categoria/delete/'),(34,'Administrador de Imagenes del Carrusel','administrador-de-imagenes-del-carrusel','admin/carrusel','carrusel.php',1,'http://localhost/easyapp/admin/carrusel'),(35,'Lista de elementos del carrusel','lista-de-elementos-del-carrusel','admin/elementos','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elementos'),(36,'Agregar elemento al carrusel','agregar-elemento-al-carrusel','admin/elemento_nuevo','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_nuevo'),(37,'Editar elemento al carrusel','editar-elemento-al-carrusel','admin/elemento_editar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_editar'),(38,'Borrar elemento al carrusel','borrar-elemento-al-carrusel','admin/elemento_borrar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_borrar'),(39,'Publicar elemento al carrusel','publicar-elemento-al-carrusel','admin/elemento_publicar','carrusel.php',1,'http://localhost/easyapp/admin/carrusel/elemento_publicar'),(40,'Administrador de Productos','administrador-de-productos','admin/producto','producto.php',1,'http://localhost/easyapp/admin/producto'),(41,'Destacar producto','destacar-producto','admin/elemento_destacar','producto.php',1,'http://localhost/easyapp/admin/producto/elemento_destacar'),(42,'Grupos de productos','grupos-de-productos','admin/producto_grupo','producto.php',1,'http://localhost/easyapp/admin/producto/producto_grupo'),(43,'Categorias de producto','categorias-de-producto','admin/producto_categoria','producto.php',1,'http://localhost/easyapp/admin/producto/producto_categoria');
/*!40000 ALTER TABLE `gd_componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_grupo`
--

DROP TABLE IF EXISTS `gd_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_grupo` (
  `grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_nombre` varchar(45) NOT NULL,
  `grupo_estado` tinyint(1) NOT NULL DEFAULT '1',
  `grupo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`grupo_id`),
  UNIQUE KEY `grupo_nombre` (`grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_grupo`
--

LOCK TABLES `gd_grupo` WRITE;
/*!40000 ALTER TABLE `gd_grupo` DISABLE KEYS */;
INSERT INTO `gd_grupo` VALUES (1,'admin',1,'2015-12-30 01:55:53');
/*!40000 ALTER TABLE `gd_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_menu`
--

DROP TABLE IF EXISTS `gd_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_clase` varchar(255) NOT NULL,
  `menu_titulo` varchar(255) NOT NULL,
  `menu_enlace` varchar(255) NOT NULL,
  `menu_componente` varchar(255) NOT NULL,
  `menu_orden` int(11) NOT NULL DEFAULT '-1',
  `menu_grupo` varchar(45) NOT NULL,
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_titulo_UNIQUE` (`menu_titulo`),
  KEY `fk_componente` (`menu_componente`),
  KEY `fk_menu_clase` (`menu_clase`),
  KEY `fk_menu_grupo` (`menu_grupo`),
  KEY `fk_menu_url` (`menu_enlace`),
  CONSTRAINT `fk_componente` FOREIGN KEY (`menu_componente`) REFERENCES `gd_componente` (`componente_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_clase` FOREIGN KEY (`menu_clase`) REFERENCES `gd_menu_clase` (`menu_clase_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_grupo` FOREIGN KEY (`menu_grupo`) REFERENCES `gd_menu_grupo` (`menu_grupo_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_menu_url` FOREIGN KEY (`menu_enlace`) REFERENCES `gd_componente` (`componente_url`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_menu`
--

LOCK TABLES `gd_menu` WRITE;
/*!40000 ALTER TABLE `gd_menu` DISABLE KEYS */;
INSERT INTO `gd_menu` VALUES (1,'Administracion','Gestión de Usuarios','http://localhost/easyapp/admin/usuario','Gestor de Usuarios',0,'Usuarios'),(2,'Administracion','Crear Usuario','http://localhost/easyapp/admin/usuario/add','Crear Usuario',1,'Usuarios'),(3,'Administracion','Editor de Menu','http://localhost/easyapp/admin/menu','Creador de Menu',4,'Menu'),(4,'Administracion','Gestión de Grupos','http://localhost/easyapp/admin/grupo','Gestor de Grupos',2,'Grupos'),(5,'Contenido','Gestión de Articulos','http://localhost/easyapp/admin/articulo','Gestor de Articulos',10,'Articulos');
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
  `menu_clase_nombre` varchar(255) NOT NULL,
  `menu_clase_orden` int(11) NOT NULL DEFAULT '1',
  `menu_clase_estado` tinyint(4) NOT NULL DEFAULT '1',
  `menu_clase_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_clase_id`),
  UNIQUE KEY `menu_grupo_nombre_UNIQUE` (`menu_clase_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
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
  `menu_grupo_nombre` varchar(255) NOT NULL,
  `menu_grupo_orden` int(11) NOT NULL DEFAULT '1',
  `menu_grupo_estado` tinyint(4) NOT NULL DEFAULT '1',
  `menu_grupo_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_grupo_id`),
  UNIQUE KEY `menu_grupo_nombre_UNIQUE` (`menu_grupo_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
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
  `permisos_grupo_id` int(11) NOT NULL AUTO_INCREMENT,
  `permisos_grupo_nombre` varchar(45) NOT NULL,
  `permisos_grupo_componente` int(11) NOT NULL,
  `permisos_grupo_estado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permisos_grupo_id`),
  UNIQUE KEY `uk_grupo_componente` (`permisos_grupo_nombre`,`permisos_grupo_componente`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_permisos_grupo`
--

LOCK TABLES `gd_permisos_grupo` WRITE;
/*!40000 ALTER TABLE `gd_permisos_grupo` DISABLE KEYS */;
INSERT INTO `gd_permisos_grupo` VALUES (1,'admin',27,1),(2,'admin',11,1),(3,'admin',16,1),(4,'admin',3,1),(5,'admin',2,1),(6,'admin',1,1),(7,'admin',19,1),(8,'admin',20,1),(9,'admin',31,1),(10,'admin',24,1),(11,'admin',25,1),(12,'admin',6,1),(13,'admin',21,1),(14,'admin',32,1),(15,'admin',7,1),(16,'admin',29,1),(17,'admin',33,1),(18,'admin',13,1),(19,'admin',18,1),(20,'admin',8,1),(21,'admin',26,1),(22,'admin',30,1),(23,'admin',10,1),(24,'admin',15,1),(25,'admin',5,1),(26,'admin',28,1),(27,'admin',12,1),(28,'admin',17,1),(29,'admin',4,1),(30,'admin',23,1),(31,'admin',14,1),(32,'admin',9,1),(33,'admin',22,1);
/*!40000 ALTER TABLE `gd_permisos_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gd_permisos_menu`
--

DROP TABLE IF EXISTS `gd_permisos_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gd_permisos_menu` (
  `permisos_menu_grupo` varchar(45) NOT NULL,
  `permisos_menu_elemento` varchar(255) NOT NULL,
  `gd_permisos_menucol` varchar(45) DEFAULT '1',
  PRIMARY KEY (`permisos_menu_grupo`,`permisos_menu_elemento`),
  KEY `fk_permiso_menu_enlace` (`permisos_menu_elemento`),
  CONSTRAINT `fk_permiso:menu_grupo` FOREIGN KEY (`permisos_menu_grupo`) REFERENCES `gd_grupo` (`grupo_nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_permiso_menu_enlace` FOREIGN KEY (`permisos_menu_elemento`) REFERENCES `gd_menu` (`menu_enlace`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
  `permisos_usuario_sid` varchar(45) NOT NULL,
  `permisos_usuario_componente` int(11) NOT NULL,
  `permisos_usuario_estado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permisos_usuario_id`),
  UNIQUE KEY `uk_usuario_componente` (`permisos_usuario_sid`,`permisos_usuario_componente`),
  KEY `fk_permisosu_componente` (`permisos_usuario_componente`),
  CONSTRAINT `fk_permisosu_componente` FOREIGN KEY (`permisos_usuario_componente`) REFERENCES `gd_componente` (`componente_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_permisos_sid` FOREIGN KEY (`permisos_usuario_sid`) REFERENCES `gd_usuario` (`usuario_sid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_permisos_usuario`
--

LOCK TABLES `gd_permisos_usuario` WRITE;
/*!40000 ALTER TABLE `gd_permisos_usuario` DISABLE KEYS */;
INSERT INTO `gd_permisos_usuario` VALUES (1,'admin',27,1),(2,'admin',11,1),(3,'admin',16,1),(4,'admin',3,1),(5,'admin',2,1),(6,'admin',1,1),(7,'admin',19,1),(8,'admin',20,1),(9,'admin',31,1),(10,'admin',24,1),(11,'admin',25,1),(12,'admin',6,1),(13,'admin',21,1),(14,'admin',32,1),(15,'admin',7,1),(16,'admin',29,1),(17,'admin',33,1),(18,'admin',13,1),(19,'admin',18,1),(20,'admin',8,1),(21,'admin',26,1),(22,'admin',30,1),(23,'admin',10,1),(24,'admin',15,1),(25,'admin',5,1),(26,'admin',28,1),(27,'admin',12,1),(28,'admin',17,1),(29,'admin',4,1),(30,'admin',23,1),(31,'admin',14,1),(32,'admin',9,1),(33,'admin',22,1);
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
  `usuario_nombre` varchar(255) NOT NULL,
  `usuario_apellido` varchar(255) NOT NULL,
  `usuario_email` varchar(255) NOT NULL,
  `usuario_sid` varchar(255) NOT NULL,
  `usuario_clave` varchar(255) NOT NULL,
  `usuario_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_estado` tinyint(4) NOT NULL DEFAULT '1',
  `usuario_grupo` varchar(45) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_sid` (`usuario_sid`),
  KEY `fk_usuario_grupo` (`usuario_grupo`),
  CONSTRAINT `fk_usuario_grupo` FOREIGN KEY (`usuario_grupo`) REFERENCES `gd_grupo` (`grupo_nombre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gd_usuario`
--

LOCK TABLES `gd_usuario` WRITE;
/*!40000 ALTER TABLE `gd_usuario` DISABLE KEYS */;
INSERT INTO `gd_usuario` VALUES (1,'admin','sistema','administrador@sistema.com','admin','$2y$12$AJACO8htJjYzYGz7dwNEl.qn/I0RD3i8/Y8zqLiQmDzjwLprCGdda','2015-12-30 01:55:54',1,'admin');
/*!40000 ALTER TABLE `gd_usuario` ENABLE KEYS */;
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
  UNIQUE KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
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
insert into producto_grupo (producto_grupo_nombre, producto_categoria_nombre) values (new.producto_grupo, new.producto_categoria) on duplicate key update producto_grupo_categoria = new.producto_categoria, producto_grupo_nombre = new.producto_grupo;
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
  `producto_categoria_estado` tinyint(1) DEFAULT '0',
  `producto_categoria_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_categoria_id`),
  UNIQUE KEY `producto_categoria_id` (`producto_categoria_id`),
  UNIQUE KEY `producto_categoria_nombre` (`producto_categoria_nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_categoria`
--

LOCK TABLES `producto_categoria` WRITE;
/*!40000 ALTER TABLE `producto_categoria` DISABLE KEYS */;
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
  `producto_grupo_categoria` varchar(500) DEFAULT NULL,
  `producto_grupo_estado` tinyint(1) DEFAULT '0',
  `producto_grupo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`producto_grupo_id`),
  UNIQUE KEY `producto_grupo_id` (`producto_grupo_id`),
  UNIQUE KEY `producto_grupo_nombre` (`producto_grupo_nombre`),
  UNIQUE KEY `producto_grupo_categoria` (`producto_grupo_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_grupo`
--

LOCK TABLES `producto_grupo` WRITE;
/*!40000 ALTER TABLE `producto_grupo` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_imagen`
--

LOCK TABLES `producto_imagen` WRITE;
/*!40000 ALTER TABLE `producto_imagen` DISABLE KEYS */;
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

-- Dump completed on 2016-01-05 11:57:43
