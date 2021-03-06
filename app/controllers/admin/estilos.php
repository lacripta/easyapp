<?php

namespace controllers\admin;

use \helpers\url,
    \core\view;

class Estilos extends \core\controller {

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct() {
        $this->componente = new \models\admin\componente();
        $this->model = new \models\admin\estilos();

        $this->clase = "estilos";
        $this->archivoNombre = "estilos.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "estilos";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "estilos";
        $this->archivo["raiz"]["componente_nombre"] = "Estilos de la Pagina";
        $this->archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        $this->archivo["cambiar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["cambiar"]["componente_enlace"] = ADMIN . "estilos_cambiar";
        $this->archivo["cambiar"]["componente_url"] = DIR . ADMIN . "estilos/cambiar";
        $this->archivo["cambiar"]["componente_nombre"] = "Modificar Estilos de la Pagina";
        $this->archivo["cambiar"]["componente_slug"] = url::generateSafeSlug($this->archivo["cambiar"]["componente_nombre"]);

        foreach ($this->archivo as $componente) {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index() {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["color"] = $this->model->getPropiedad("background-color");
        $data["fondo"] = $this->model->getPropiedad("background-image");

        view::admintemplate("header", $data);
        view::render($this->archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function cambiar() {
        $color = "#" . filter_input(INPUT_POST, "color");
        $datos = [
            "estilo_valor" => $color
        ];
        $where = [
            "estilo_nombre" => "background-color"
        ];
        echo $this->model->editar($datos, $where);
        $galeria_url = $this->componente->subir_imagen("fondo", "bg");
        if ($galeria_url["estado"] == "1") {
            echo $this->model->editar(["estilo_valor" => $galeria_url["url"]], ["estilo_nombre" => "background-image"]);
        }
    }

}
