<?php

namespace controllers\admin;

use \helpers\url,
    \helpers\session,
    \core\view;

class Usuario extends \core\controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {
        $this->_componente = new \models\admin\componente();
        $this->_model = new \models\admin\usuario();

        $this->clase = "usuario";
        $this->_archivoNombre = "usuario.php";

        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/usuario";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestor de Usuarios";
        $this->_archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "usuario_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/usuario/add";
        $this->_archivo["crear"]["componente_nombre"] = "Crear Usuario";
        $this->_archivo["crear"]["componente_slug"] = url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "usuario_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/usuario/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Editar Usuario";
        $this->_archivo["editar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/usuario/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Usuario";
        $this->_archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_archivo["acceso"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["acceso"]["componente_enlace"] = ADMIN . "usuario_acceso";
        $this->_archivo["acceso"]["componente_url"] = DIR . "admin/usuario/acceso/";
        $this->_archivo["acceso"]["componente_nombre"] = "Permisos de Usuario";
        $this->_archivo["acceso"]["componente_slug"] = url::generateSafeSlug($this->_archivo["acceso"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["usuarios"] = $this->_model->getUsuarios();
        $data["js"] = "
            <script>
                function borrar_usuario(id, sid) {
                    if (confirm('Seguro de eliminar el usuario ' + sid)){
                        window.location.href = '" . DIR . $this->_archivo["borrar"]["componente_enlace"] . "/..' + id;
                    }
                }
            </script>";

        view::admintemplate("header", $data);
        view::render($this->_archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function add() {
        $data["title"] = $this->_archivo["crear"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["grupos"] = $this->_model->getGrupos();
        $data["js"] = "<script>"
                . "$('#nombre').filter_input({"
                . "regex: '[a-zA-Z]',"
                . "events: 'keypress paste'"
                . "});"
                . "$('#apellido').filter_input({"
                . "regex: '[a-zA-Z]',"
                . "events: 'keypress paste'"
                . "});"
                . "</script>";
        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $apellido = filter_input(INPUT_POST, "apellido");
            $email = filter_input(INPUT_POST, "email");
            $usuario = filter_input(INPUT_POST, "usuario");
            $clave = filter_input(INPUT_POST, "clave");
            $grupo = filter_input(INPUT_POST, "grupo");
            if ($nombre === "") {
                $error[] = "Nombre de usuario requerido.";
            }
            if ($apellido === "") {
                $error[] = "Apellido de usuario requerido.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            }
            if ($usuario === "") {
                $error[] = "SID de usuario requerido.";
            }
            if ($clave === "") {
                $error[] = "Clave de usuario requerido.";
            }
            if (!$error) {
                $usuario_datos = array(
                    'usuario_nombre' => $nombre,
                    'usuario_apellido' => $apellido,
                    'usuario_email' => $email,
                    'usuario_sid' => $usuario,
                    'usuario_clave' => \helpers\password::make($clave),
                    'usuario_estado' => 0,
                    'usuario_grupo' => $grupo
                );
                $this->_model->addUsuario($usuario_datos);
                $this->_componente->crearPermisosUsuario($grupo, $usuario, "PERMITIR");
                session::set("estado", "Usuario Creado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["crear"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function edit($usuario_id) {
        $data["title"] = $this->_archivo["editar"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["usuario"] = $this->_model->getUsuario($usuario_id);
        $data["grupos"] = $this->_model->getGrupos();

        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $apellido = filter_input(INPUT_POST, "apellido");
            $email = filter_input(INPUT_POST, "email");
            $usuario = filter_input(INPUT_POST, "usuario");
            $clave = filter_input(INPUT_POST, "clave");
            $estado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            $grupo = filter_input(INPUT_POST, "grupo");
            if ($nombre === "") {
                $error[] = "Nombre de usuario requerido.";
            }
            if ($apellido === "") {
                $error[] = "Apellido de usuario requerido.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            }
            if ($usuario === "") {
                $error[] = "SID de usuario requerido.";
            }
            if (!$error) {

                $usuario_datos = array(
                    'usuario_nombre' => $nombre,
                    'usuario_apellido' => $apellido,
                    'usuario_email' => $email,
                    'usuario_sid' => $usuario,
                    'usuario_estado' => $estado,
                    'usuario_grupo' => $grupo
                );
                if ($clave != "") {
                    $usuario_datos["usuario_clave"] = \helpers\password::make($clave);
                }
                $where = array(
                    'usuario_id' => $usuario_id
                );
                if ($estado == 1) {
                    $this->_componente->crearPermisosUsuario($grupo, $usuario, $estado);
                } else if ($estado == 0) {
                    $this->_componente->borrarPermisosUsuario($usuario);
                }
                $this->_model->updateUsuario($usuario_datos, $where);
                session::set("estado", "Usuario Actualizado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        view::admintemplate("header", $data);
        view::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function delete($id) {
        $datos = array("usuario_id" => $id);
        $this->_model->deleteUsuario($datos);
        $this->_componente->borrarPermisosUsuario($id);
        session::set("estado", "Usuario Eliminado");
        url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

    public function acceso($sid, $grupo) {
        $data["title"] = $this->_archivo["acceso"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["url"] = $this->_archivo["acceso"]["componente_url"];
        $this->_componente->actualizarPermisos($grupo, $sid, 0);
        $data["componentes"] = $this->_componente->permisosUsuario($sid);
        $data["sid"] = $sid;

        view::admintemplate("header", $data);
        view::render($this->_archivo["acceso"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    function generaError($error, $mensaje) {
        $error[] = "$mensaje";
        return 0;
    }

}
