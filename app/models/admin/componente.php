<?php

namespace models\admin;

use \helpers\session,
    \helpers\url,
    \core\view;

class Componente extends \core\Model {

    public function controlAcceso() {
        if (!session::get("autenticado")) {
            url::redirect(ADMINLOGIN);
        }
        if (!$this->verificarAcceso(session::get("usuario"), "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) {
            $data["error"] = "NO TIENE PERMISO PARA ACCEDER A ESTA PAGINA";
            view::admintemplate('header', $data);
            view::render('error/404', $data);
            view::admintemplate('footer', $data);
            exit;
        }
    }

    public function controlAccesoArchivo() {
        if (!session::get("autenticado")) {
            url::redirect(ARCHIVOLOGIN);
        }
        if (!$this->verificarAcceso(session::get("usuario"), "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) {
            $data["error"] = "NO TIENE PERMISO PARA ACCEDER A ESTA PAGINA";
            view::archivotemplate('header', $data);
            view::render('error/404', $data);
            view::archivotemplate('footer', $data);
            exit;
        }
    }

    public function getComponentes() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "componente ORDER BY componente_archivo, componente_nombre");
    }

    public function permisosComponentes($grupo) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "permisos_grupo inner join (gd_componente) on (componente_id = permisos_grupo_componente AND permisos_grupo_nombre = :grupo);", array(':grupo' => $grupo));
    }

    public function permisosUsuario($sid) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "permisos_usuario inner join(gd_componente) on (componente_id = permisos_usuario_componente AND permisos_usuario_sid = :sid);", array(':sid' => $sid));
    }

    public function getComponentesActivos($sid) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "permisos_usuario inner join(gd_componente) on (componente_id = permisos_usuario_componente AND permisos_usuario_sid = :sid AND permisos_usuario_estado = 1);", array(':sid' => $sid));
    }

    public function getComponente($componenteID) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "componente WHERE componente_id = :id", array(':id' => $componenteID));
    }

    public function getEnlace($enlace) {
        return $this->_db->select("SELECT componente_url FROM " . PREFIX . "componente WHERE componente_enlace = :enlace", array(':enlace' => $enlace))[0]->componente_url;
    }

    public function createComponente($titulo, $enlace, $url, $componentes) {
        $existente = $this->_db->select("SELECT * FROM " . PREFIX . "componente WHERE componente_nombre = :nombre OR componente_enlace = :enlace OR componente_url = :url", array(':nombre' => $titulo, ':enlace' => $enlace, ':url' => $url));
        if (!isset($existente[0]->componente_nombre) && !isset($existente[0]->componente_enlace) && !isset($existente[0]->componente_url)) {
            $this->_db->insert(PREFIX . "componente", $componentes);
        } else {
            $this->_db->update(PREFIX . "componente", $componentes, array('componente_id' => $existente[0]->componente_id));
        }
    }

    public function getPermisosGrupo($grupo) {
        return $this->_db->select("SELECT * FROM gd_permisos_grupo WHERE permisos_grupo_nombre = :grupo;", array(':grupo' => $grupo));
    }

    public function cambiarPermisosGrupo($grupo, $componente, $estado) {
        return $this->_db->update(PREFIX . "permisos_grupo", array('permisos_grupo_estado' => $estado), array('permisos_grupo_nombre' => $grupo, 'permisos_grupo_componente' => $componente));
    }

    public function cambiarPermisosUsuario($sid, $componente, $estado) {
        return $this->_db->update(PREFIX . "permisos_usuario", array('permisos_usuario_estado' => $estado), array('permisos_usuario_sid' => $sid, 'permisos_usuario_componente' => $componente));
    }

    public function getComponentesUsuario($sid) {
        return $this->_db->ejecutar("SELECT * FROM gd_permisos_usuario CROSS JOIN(gd_componente) ON (componente_id = permisos_usuario_componente AND permisos_usuario_sid = '$sid')");
    }

    public function crearPermisosUsuario($grupo, $sid, $estado) {
        switch ($estado) {
            case "PERMITIR":
                $estado = 1;
            case "BLOQUEAR":
                $estado = 0;
        }
        //CAMBIAR EL ESTADO DE ACCESO DE LOS PERMISOS DE UN USUARIO ESPECIFICO
        $this->_db->ejecutar("INSERT INTO gd_permisos_usuario (permisos_usuario_sid, permisos_usuario_componente, permisos_usuario_estado) "
                . "SELECT '$sid' AS permisos_grupo_nombre, permisos_grupo_componente, 1 as permisos_usuario_estado FROM gd_permisos_grupo "
                . "WHERE permisos_grupo_nombre = '$grupo' AND permisos_grupo_estado = 1 "
                . "ON DUPLICATE KEY UPDATE permisos_usuario_estado = $estado; ");
        //ACTUALIZAR LA INFORMACION DE PERMISOS DE ACCESO PARA LOS COMPONENTES DESACTIVADOS
        $this->_db->ejecutar("INSERT INTO gd_permisos_usuario (permisos_usuario_sid, permisos_usuario_componente, permisos_usuario_estado) "
                . "SELECT '$sid' AS permisos_grupo_nombre, permisos_grupo_componente, 0 as permisos_usuario_estado FROM gd_permisos_grupo "
                . "WHERE permisos_grupo_nombre = '$grupo' AND permisos_grupo_estado = 0 "
                . "ON DUPLICATE KEY UPDATE permisos_usuario_estado = 0; ");
    }

    public function actualizarPermisos($grupo, $sid, $estado) {
        $this->_db->ejecutar("INSERT INTO gd_permisos_usuario (permisos_usuario_sid, permisos_usuario_componente, permisos_usuario_estado) "
                . "SELECT '$sid' AS permisos_usuario_sid, permisos_grupo_componente, 0 as permisos_usuario_estado FROM gd_permisos_grupo "
                . "WHERE permisos_grupo_nombre = '$grupo' AND permisos_grupo_estado = 1 "
                . "ON DUPLICATE KEY UPDATE permisos_usuario_estado = permisos_usuario_estado; ");
    }

    public function arreglarPermisosUsuario($grupo, $sid) {
        $this->crearPermisosUsuario($grupo, $sid, "PERMITIR");
    }

    public function borrarPermisosUsuario($sid) {
        if (is_int($sid)) {
            $sid = $this->_db->select("SELECT usuario_sid FROM gd_usuario WHERE usuario_id = :sid;", array(':sid' => $sid))[0]->usuario_sid;
        }
        $this->_db->ejecutar("DELETE FROM gd_permisos_usuario WHERE permisos_usuario_sid = '$sid'");
    }

    public function addComponente($componenteDatos) {
        $this->_db->insert(PREFIX . "componente", $componenteDatos);
    }

    public function updateComponente($componenteDatos, $componenteWhere) {
        $this->_db->update(PREFIX . "componente", $componenteDatos, $componenteWhere);
    }

    public function deleteComponente($componenteCampo) {
        $this->_db->delete(PREFIX . "componente", $componenteCampo);
    }

    public function verificarAcceso($sid, $url) {
        $uri = explode("/..", $url)[0];
        $url = $uri . "/";
        $acceso = $this->_db->select("select * from gd_permisos_usuario join (select * from gd_componente where componente_url = :url or componente_url = :uri) as componente on permisos_usuario_componente = componente.componente_id and permisos_usuario_sid = :sid and permisos_usuario_estado = 1;", array(':sid' => $sid, ':url' => $url, ':uri' => $uri));
        if (strstr($acceso[0]->componente_url, $uri)) {
            return true;
        } else {
            return false;
        }
    }

    public function getElementoMenu($elemento) {
        return $this->_db->select("SELECT * FROM gd_menu JOIN gd_componente ON componente_nombre = menu_componente AND  menu_componente = (select menu_componente from gd_menu where menu_titulo = :elemento) and menu_titulo = :elemento", array(':elemento' => str_replace("%20", " ", $elemento)));
    }

    function subir_imagen($file, $folder) {
        if (isset($_FILES["$file"]) && $_FILES["$file"]["error"] == UPLOAD_ERR_OK) {
            $UploadDirectory = "C:/wamp/www/easyart/img/$folder/"; //specify upload directory ends with / (slash)

            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                die();
            }
            if ($_FILES["$file"]["size"] > 5242880) {
                die("File size is too big!");
            }
            switch (strtolower($_FILES["$file"]['type'])) {
                //allowed file types
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                case 'text/plain':
                case 'text/html': //html file
                case 'application/x-zip-compressed':
                case 'application/pdf':
                case 'application/msword':
                case 'application/vnd.ms-excel':
                case 'video/mp4':
                    break;
                default:
                    die('Unsupported File!'); //output error
            }
            $File_Name = strtolower($_FILES["$file"]['name']);
            $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
            $Random_Number = rand(0, 9999999999); //Random number to be added to name.
            if (move_uploaded_file($_FILES["$file"]['tmp_name'], $UploadDirectory . $File_Name)) {
                //echo $_FILES["$file"]['tmp_name'];
                //echo "{'url':'/easyart/img/$folder/$File_Name'}";
                return ["estado" => TRUE, "url" => "/easyart/img/$folder/$File_Name"];
            } else {
                return ["estado" => FALSE];
            }
        } else {
            return ["estado" => FALSE, "msj" => "Something wrong with upload! Is upload_max_filesize set correctly?"];
        }
    }

}
