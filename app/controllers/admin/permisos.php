<?php

namespace controllers\admin;

use \helpers\Url,
    core\View,
    \helpers\Session;

class Permisos extends \core\Controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase_grupo;

    public function __construct() {
        $this->_componente = new \models\admin\Componente();
        $this->_model = new \models\admin\grupo();

        $this->clase_grupo = "permisos";
        $this->_archivoNombre = "permisos.php";

        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase_grupo;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/permisos";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestor de Permisos";
        $this->_archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "permisos_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/permisos/add";
        $this->_archivo["crear"]["componente_nombre"] = "Agregar Permisos";
        $this->_archivo["crear"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "permisos_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/permisos/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Modificar Permisos";
        $this->_archivo["editar"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase_grupo . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/permisos/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Permisos";
        $this->_archivo["borrar"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
    }

    public function add() {

    }

    public function edit($componente) {
        if (null != filter_input(INPUT_POST, "grupo")) {
            echo "grupo";
            echo $this->_componente->cambiarPermisosGrupo(filter_input(INPUT_POST, "grupo"), $componente, filter_input(INPUT_POST, "estado"));
        } else if (null != filter_input(INPUT_POST, "sid")) {
            echo "usuario " . filter_input(INPUT_POST, "sid") . " c " . $componente . " e " . filter_input(INPUT_POST, "estado");
            echo $this->_componente->cambiarPermisosUsuario(filter_input(INPUT_POST, "sid"), $componente, filter_input(INPUT_POST, "estado"));
        }
    }

    public function delete($id) {

    }

}
