<?php

namespace controllers\admin;

use \helpers\url,
    \helpers\session,
    \core\view;

class Grupo extends \core\controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase_grupo;

    public function __construct() {
        $this->_componente = new \models\admin\componente();
        $this->_model = new \models\admin\grupo();
        $this->clase_grupo = "grupo";
        $this->_archivoNombre = "grupo.php";

        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase_grupo;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/grupo";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestor de Grupos";
        $this->_archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "grupo_crear";
        $this->_archivo["crear"]["componente_url"] = $this->_archivo["raiz"]["componente_url"] . "/add";
        $this->_archivo["crear"]["componente_nombre"] = "Agregar Grupo";
        $this->_archivo["crear"]["componente_slug"] = url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "grupo_editar";
        $this->_archivo["editar"]["componente_url"] = $this->_archivo["raiz"]["componente_url"] . "/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Modificar Grupo";
        $this->_archivo["editar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase_grupo . "/delete";
        $this->_archivo["borrar"]["componente_url"] = $this->_archivo["raiz"]["componente_url"] . "/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Grupo";
        $this->_archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_archivo["acceso"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["acceso"]["componente_enlace"] = ADMIN . "grupo_acceso";
        $this->_archivo["acceso"]["componente_url"] = $this->_archivo["raiz"]["componente_url"] . "/acceso/";
        $this->_archivo["acceso"]["componente_nombre"] = "Permisos de Grupo";
        $this->_archivo["acceso"]["componente_slug"] = url::generateSafeSlug($this->_archivo["acceso"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_url"];
        $data["crear"] = $this->_archivo["crear"]["componente_url"];
        $data["grupos"] = $this->_model->getGrupos();
        $data["js"] = "
            <script>
                function borrar_grupo(id, nombre) {
                    if (confirm('Seguro de eliminar el grupo ' + nombre)){
                        window.location.href = '" . DIR . $this->_archivo["borrar"]["componente_enlace"] . "/..' + id;
                    }
                }
            </script>";

        view::admintemplate("header", $data);
        view::render($this->_archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function add() {
        $data["raiz"] = $this->_archivo["raiz"]["componente_url"];
        $data["crear"] = $this->_archivo["crear"]["componente_url"];
        $data["title"] = $this->_archivo["crear"]["componente_nombre"];
        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $estado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            $fecha = filter_input(INPUT_POST, "fecha");
            if ($nombre === "") {
                $error[] = "Nombre de grupo requerido.";
            } else {
                $grupo[] = $this->_model->verificarGrupo($nombre);
                if (count($grupo[0]) > 0) {
                    $error[] = "El nombre de grupo debe ser unico.";
                }
            }
            if (!$error) {
                $grupo_datos = array(
                    'grupo_nombre' => $nombre,
                    'grupo_estado' => $estado,
                    'grupo_fecha' => $fecha
                );
                $this->_model->addGrupo($grupo_datos);
                session::set("estado", "Grupo Creado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        view::admintemplate("header", $data);
        view::render($this->_archivo["crear"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function edit($grupo_id) {
        $data["title"] = $this->_archivo["editar"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_url"];
        $data["clase"] = $this->clase_grupo;
        $data["grupo"] = $this->_model->getGrupo($grupo_id);
        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $estado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            if ($nombre === "") {
                $error[] = "Nombre de grupo requerido.";
            }
            if (!$error) {
                $grupo_datos = array(
                    'grupo_nombre' => $nombre,
                    'grupo_estado' => $estado
                );
                $where = array(
                    "grupo_id" => $grupo_id
                );
                $this->_model->updateGrupo($grupo_datos, $where);
                session::set("estado", "Grupo Modificado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        view::admintemplate("header", $data);
        view::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function acceso($grupo_nombre) {
        $data["title"] = $this->_archivo["acceso"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_url"];
        $data["url"] = $this->_archivo["acceso"]["componente_url"];
        $data["grupo"] = $grupo_nombre;
        $data["componentes"] = $this->_componente->permisosComponentes($grupo_nombre);

        view::admintemplate("header", $data);
        view::render($this->_archivo["acceso"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function cambiarPermisosGrupo($componente) {
        $this->_componente->cambiarPermisosGrupo($grupo, $componente, $estado);
    }

    public function delete($id) {
        $datos = array("grupo_id" => $id);
        $this->_model->deleteGrupo($datos);
        session::set("estado", "Grupo Eliminado");
        url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

    function generaError($error, $mensaje) {
        $error[] = "$mensaje";
        return 0;
    }

}
