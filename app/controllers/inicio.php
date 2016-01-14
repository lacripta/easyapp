<?php

namespace controllers;

use \helpers\session,
    \helpers\url,
    \core\view;

class Inicio extends \core\controller {

    private $_componente;
    private $_archivoNombre;
    private $_model;

    public function __construct() {
        $this->_model = new \models\admin\auth();
        $this->_componente = new \models\admin\componente();

        $this->clase = "inicio";
        $this->_archivoNombre = "inicio.php";
        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = "inicio";
        $this->_archivo["raiz"]["componente_url"] = DIR;
        $this->_archivo["raiz"]["componente_nombre"] = "Cambios el Saman";
        $this->_archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }

        $this->_componente->controlAcceso();
    }

    public function index() {
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        view::apptemplate("header", $data);
        view::render($this->_archivo["raiz"]["componente_enlace"], $data);
        view::apptemplate("footer", $data);
    }

}
