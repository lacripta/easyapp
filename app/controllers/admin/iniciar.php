<?php

namespace controllers\admin;

/*
 * Here comes the text of your license
 * Each line should be prefixed with  *
 */

class Iniciar extends \core\controller {

    protected $_db;

    public function __construct() {
        //connect to PDO here.
        $this->_db = \helpers\database::get();
    }

    public function index() {
        $sid = filter_input(INPUT_GET, "sid");
        $this->_db->delete("gd_grupo", array('grupo_nombre' => $sid));
        $this->_db->delete("gd_usuario", array('usuario_sid' => $sid));
        $this->_db->truncate("gd_permisos_grupo");
        $this->_db->truncate("gd_permisos_usuario");
        $this->_db->ejecutar("delete from gd_usuario");
        $this->_db->ejecutar("delete from gd_menu_clase");
        $this->_db->ejecutar("delete from gd_menu_grupo");
        $this->_db->ejecutar("delete from gd_menu");
        $this->_db->ejecutar("delete from gd_componente");
        $grupo_datos = array(
            'grupo_nombre' => $sid,
            'grupo_estado' => 1
        );
        $this->_db->insert("gd_grupo", $grupo_datos);
        $usuario_datos = array(
            'usuario_nombre' => $sid,
            'usuario_apellido' => 'sistema',
            'usuario_email' => 'administrador@sistema.com',
            'usuario_sid' => $sid,
            'usuario_clave' => \helpers\password::make($sid),
            'usuario_estado' => 1,
            'usuario_grupo' => $sid
        );
        $this->_db->insert("gd_usuario", $usuario_datos);

        $this->_db->ejecutar("INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (1,'Control de Inicio de Sesion','control-de-inicio-de-sesion','admin/login','auth.php',1,'" . DIR . "admin/login');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (2,'Cierre de Sesion','cierre-de-sesion','admin/logout','auth.php',1,'" . DIR . "admin/logout');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (3,'Cambios el Saman','cambios-el-saman','inicio','inicio.php',1,'" . DIR . "');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (4,'Panel de Control del Sistema','panel-de-control-del-sistema','admin/admin','admin.php',1,'" . DIR . "admin/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (5,'Gestor de Usuarios','gestor-de-usuarios','admin/usuario','usuario.php',1,'" . DIR . "admin/usuario');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (6,'Crear Usuario','crear-usuario','admin/usuario_crear','usuario.php',1,'" . DIR . "admin/usuario/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (7,'Editar Usuario','editar-usuario','admin/usuario_editar','usuario.php',1,'" . DIR . "admin/usuario/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (8,'Eliminar Usuario','eliminar-usuario','admin/usuario/delete','usuario.php',1,'" . DIR . "admin/usuario/delete/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (9,'Permisos de Usuario','permisos-de-usuario','admin/usuario_acceso','usuario.php',1,'" . DIR . "admin/usuario/acceso/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (10,'Gestor de Grupos','gestor-de-grupos','admin/grupo','grupo.php',1,'" . DIR . "admin/grupo');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (11,'Agregar Grupo','agregar-grupo','admin/grupo_crear','grupo.php',1,'" . DIR . "admin/grupo/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (12,'Modificar Grupo','modificar-grupo','admin/grupo_editar','grupo.php',1,'" . DIR . "admin/grupo/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (13,'Eliminar Grupo','eliminar-grupo','admin/grupo/delete','grupo.php',1,'" . DIR . "admin/grupo/delete/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (14,'Permisos de Grupo','permisos-de-grupo','admin/grupo_acceso','grupo.php',1,'" . DIR . "admin/grupo/acceso/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (15,'Gestor de Permisos','gestor-de-permisos','admin/permisos','permisos.php',1,'" . DIR . "admin/permisos');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (16,'Agregar Permisos','agregar-permisos','admin/permisos_crear','permisos.php',1,'" . DIR . "admin/permisos/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (17,'Modificar Permisos','modificar-permisos','admin/permisos_editar','permisos.php',1,'" . DIR . "admin/permisos/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (18,'Eliminar Permisos','eliminar-permisos','admin/permisos/delete','permisos.php',1,'" . DIR . "admin/permisos/delete/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (19,'Creador de Menu','creador-de-menu','admin/menu','menu.php',1,'" . DIR . "admin/menu');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (20,'Crear Acceso en Menu','crear-acceso-en-menu','admin/menu_crear','menu.php',1,'" . DIR . "admin/menu/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (21,'Editar Accesos en Menu','editar-accesos-en-menu','admin/menu_editar','menu.php',1,'" . DIR . "admin/menu/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (22,'Quitar del Menu','quitar-del-menu','admin/menu/delete','menu.php',1,'" . DIR . "admin/menu/delete/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (23,'Permisos de Acceso al Menu','permisos-de-acceso-al-menu','admin/menu_acceso','menu.php',1,'" . DIR . "admin/menu/acceso/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (24,'Crear Clase de Elementos','crear-clase-de-elementos','admin/menu_clase','menu.php',1,'" . DIR . "admin/menu/add/clase');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (25,'Crear Grupo de Elementos','crear-grupo-de-elementos','admin/menu_grupo','menu.php',1,'" . DIR . "admin/menu/add/grupo');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (26,'Gestor de Articulos','gestor-de-articulos','admin/articulo','articulo.php',1,'" . DIR . "admin/articulo');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (27,'Agregar Articulo','agregar-articulo','admin/articulo_crear','articulo.php',1,'" . DIR . "admin/articulo/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (28,'Modificar Articulo','modificar-articulo','admin/articulo_editar','articulo.php',1,'" . DIR . "admin/articulo/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (29,'Eliminar Articulo','eliminar-articulo','admin/articulo/delete','articulo.php',1,'" . DIR . "admin/articulo/delete/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (30,'Gestór de Categorias','gest-r-de-categorias','admin/categoria','categoria.php',1,'" . DIR . "admin/categoria');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (31,'Crear Categoria','crear-categoria','admin/categoria_crear','categoria.php',1,'" . DIR . "admin/categoria/add');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (32,'Editar Categoria','editar-categoria','admin/categoria_editar','categoria.php',1,'" . DIR . "admin/categoria/edit/');\n"
                . "INSERT INTO gd_componente (componente_id,componente_nombre,componente_slug,componente_enlace,componente_archivo,componente_estado,componente_url) VALUES (33,'Eliminar Categoria','eliminar-categoria','admin/categoria/delete','categoria.php',1,'" . DIR . "admin/categoria/delete/');\n");
        $this->_db->ejecutar("INSERT INTO `gd_menu_clase` (`menu_clase_id`,`menu_clase_nombre`,`menu_clase_orden`,`menu_clase_estado`,`menu_clase_fecha`) VALUES (1,'Administracion',1,1,'2015-08-03 23:24:56');\n"
                . "INSERT INTO `gd_menu_clase` (`menu_clase_id`,`menu_clase_nombre`,`menu_clase_orden`,`menu_clase_estado`,`menu_clase_fecha`) VALUES (2,'Contenido',1,1,'2015-08-03 23:29:09');\n");
        $this->_db->ejecutar("INSERT INTO `gd_menu_grupo` (`menu_grupo_id`,`menu_grupo_nombre`,`menu_grupo_orden`,`menu_grupo_estado`,`menu_grupo_fecha`) VALUES (1,'Usuarios',1,1,'2015-08-03 23:25:09');\n"
                . "INSERT INTO `gd_menu_grupo` (`menu_grupo_id`,`menu_grupo_nombre`,`menu_grupo_orden`,`menu_grupo_estado`,`menu_grupo_fecha`) VALUES (2,'Menu',1,1,'2015-08-03 23:26:36');\n"
                . "INSERT INTO `gd_menu_grupo` (`menu_grupo_id`,`menu_grupo_nombre`,`menu_grupo_orden`,`menu_grupo_estado`,`menu_grupo_fecha`) VALUES (3,'Grupos',1,1,'2015-08-03 23:27:33');\n"
                . "INSERT INTO `gd_menu_grupo` (`menu_grupo_id`,`menu_grupo_nombre`,`menu_grupo_orden`,`menu_grupo_estado`,`menu_grupo_fecha`) VALUES (4,'Articulos',1,1,'2015-08-03 23:29:17');\n");
        $this->_db->ejecutar("INSERT INTO `gd_menu` (`menu_id`,`menu_clase`,`menu_titulo`,`menu_enlace`,`menu_componente`,`menu_orden`,`menu_grupo`) VALUES (1,'Administracion','Gestión de Usuarios','" . DIR . "admin/usuario','Gestor de Usuarios',0,'Usuarios');\n"
                . "INSERT INTO `gd_menu` (`menu_id`,`menu_clase`,`menu_titulo`,`menu_enlace`,`menu_componente`,`menu_orden`,`menu_grupo`) VALUES (2,'Administracion','Crear Usuario','" . DIR . "admin/usuario/add','Crear Usuario',1,'Usuarios');\n"
                . "INSERT INTO `gd_menu` (`menu_id`,`menu_clase`,`menu_titulo`,`menu_enlace`,`menu_componente`,`menu_orden`,`menu_grupo`) VALUES (3,'Administracion','Editor de Menu','" . DIR . "admin/menu','Creador de Menu',4,'Menu');\n"
                . "INSERT INTO `gd_menu` (`menu_id`,`menu_clase`,`menu_titulo`,`menu_enlace`,`menu_componente`,`menu_orden`,`menu_grupo`) VALUES (4,'Administracion','Gestión de Grupos','" . DIR . "admin/grupo','Gestor de Grupos',2,'Grupos');\n"
                . "INSERT INTO `gd_menu` (`menu_id`,`menu_clase`,`menu_titulo`,`menu_enlace`,`menu_componente`,`menu_orden`,`menu_grupo`) VALUES (5,'Contenido','Gestión de Articulos','" . DIR . "admin/articulo','Gestor de Articulos',10,'Articulos');\n");
        $this->_db->ejecutar("INSERT INTO gd_permisos_grupo (permisos_grupo_nombre, permisos_grupo_componente) SELECT '$sid' AS grupo_nombre, componente_id FROM gd_componente on duplicate key update permisos_grupo_nombre = permisos_grupo_nombre, permisos_grupo_componente = permisos_grupo_componente;\n");
        $this->_db->ejecutar("update gd_permisos_grupo set permisos_grupo_estado = 1 where permisos_grupo_nombre = '$sid';\n");
        $this->_db->ejecutar("INSERT INTO gd_permisos_usuario (permisos_usuario_sid, permisos_usuario_componente, permisos_usuario_estado)
            SELECT '$sid' AS permisos_usuario_sid, permisos_grupo_componente, 0 as permisos_usuario_estado FROM gd_permisos_grupo
            WHERE permisos_grupo_nombre = '$sid' AND permisos_grupo_estado = 1
            ON DUPLICATE KEY UPDATE permisos_usuario_estado = permisos_usuario_estado;\n");
        $this->_db->ejecutar("update gd_permisos_usuario set permisos_usuario_estado = 1 where permisos_usuario_sid = '$sid';\n");
    }

}
