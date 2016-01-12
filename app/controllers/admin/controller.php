<?php

namespace controllers\admin;

use \helpers\Url,
    \core\View;

class Controller extends \core\Controller {

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct() {
        $this->componente = new \models\admin\Componente();
        $this->model = new \models\admin\Producto();

        $this->clase = "producto";
        $this->archivoNombre = "producto.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "producto";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "producto";
        $this->archivo["raiz"]["componente_nombre"] = "Administrador de Productos";
        $this->archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        foreach ($this->archivo as $componente) {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index() {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["usuarios"] = $this->componente->getEnlace("admin/usuario");
        $data["articulos"] = $this->componente->getEnlace("admin/articulo");

        View::admintemplate("header", $data);
        View::render($this->archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
    }

}
