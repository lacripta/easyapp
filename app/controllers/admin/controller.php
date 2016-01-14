<?php

namespace controllers\admin;

use \helpers\url,
    \core\view;

class Controller extends \core\controller {

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct() {
        $this->componente = new \models\admin\componente();
        $this->model = new \models\admin\producto();

        $this->clase = "producto";
        $this->archivoNombre = "producto.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "producto";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "producto";
        $this->archivo["raiz"]["componente_nombre"] = "Administrador de Productos";
        $this->archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        foreach ($this->archivo as $componente) {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index() {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["usuarios"] = $this->componente->getEnlace("admin/usuario");
        $data["articulos"] = $this->componente->getEnlace("admin/articulo");

        view::admintemplate("header", $data);
        view::render($this->archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

}
