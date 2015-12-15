<?php

namespace controllers;

use \helpers\Session,
    \helpers\Url,
    \core\View;

class Inicio extends \core\Controller {

    private $_componente;
    private $_archivoNombre;
    private $_model;

    public function __construct() {
        $this->_model = new \models\admin\auth();
        $this->_componente = new \models\admin\Componente();

        $this->clase = "inicio";
        $this->_archivoNombre = "inicio.php";
        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = "inicio";
        $this->_archivo["raiz"]["componente_url"] = DIR;
        $this->_archivo["raiz"]["componente_nombre"] = "Cambios el Saman";
        $this->_archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }

        $this->_componente->controlAcceso();
    }

    public function index() {
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        View::apptemplate("header", $data);
        View::render($this->_archivo["raiz"]["componente_enlace"], $data);
        View::apptemplate("footer", $data);
    }

}
