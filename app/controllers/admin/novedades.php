<?php

namespace controllers\admin;

use \helpers\url,
    \helpers\session,
    \core\view;

class Novedades extends \core\controller {

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct() {
        $this->componente = new \models\admin\componente();
        $this->model = new \models\admin\novedades();

        $this->clase = "novedades";
        $this->archivoNombre = "novedades.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "novedades";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "novedades";
        $this->archivo["raiz"]["componente_nombre"] = "Publicación de Novedades";
        $this->archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        $this->archivo["lista"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["lista"]["componente_enlace"] = ADMIN . "novedades_lista";
        $this->archivo["lista"]["componente_url"] = DIR . ADMIN . "novedades/elementos";
        $this->archivo["lista"]["componente_nombre"] = "Lista de Novedades";
        $this->archivo["lista"]["componente_slug"] = url::generateSafeSlug($this->archivo["lista"]["componente_nombre"]);

        $this->archivo["nuevo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["nuevo"]["componente_enlace"] = ADMIN . "novedades_agregar";
        $this->archivo["nuevo"]["componente_url"] = DIR . ADMIN . "novedades/elemento_nuevo";
        $this->archivo["nuevo"]["componente_nombre"] = "Nueva Novedad";
        $this->archivo["nuevo"]["componente_slug"] = url::generateSafeSlug($this->archivo["nuevo"]["componente_nombre"]);

        $this->archivo["editar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["editar"]["componente_enlace"] = ADMIN . "novedades_editar";
        $this->archivo["editar"]["componente_url"] = DIR . ADMIN . "novedades/elemento_editar";
        $this->archivo["editar"]["componente_nombre"] = "Editar Novedad";
        $this->archivo["editar"]["componente_slug"] = url::generateSafeSlug($this->archivo["editar"]["componente_nombre"]);

        $this->archivo["borrar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["borrar"]["componente_enlace"] = ADMIN . "novedades_borrar";
        $this->archivo["borrar"]["componente_url"] = DIR . ADMIN . "novedades/elemento_borrar";
        $this->archivo["borrar"]["componente_nombre"] = "Borrar Novedad";
        $this->archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->archivo["borrar"]["componente_nombre"]);

        $this->archivo["publicar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["publicar"]["componente_enlace"] = ADMIN . "novedades_publicar";
        $this->archivo["publicar"]["componente_url"] = DIR . ADMIN . "novedades/elemento_publicar";
        $this->archivo["publicar"]["componente_nombre"] = "Publicar Novedad";
        $this->archivo["publicar"]["componente_slug"] = url::generateSafeSlug($this->archivo["publicar"]["componente_nombre"]);

        $this->archivo["destacar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["destacar"]["componente_enlace"] = ADMIN . "novedades_destcar";
        $this->archivo["destacar"]["componente_url"] = DIR . ADMIN . "novedades/elemento_destacar";
        $this->archivo["destacar"]["componente_nombre"] = "Destacar Novedad";
        $this->archivo["destacar"]["componente_slug"] = url::generateSafeSlug($this->archivo["destacar"]["componente_nombre"]);

        foreach ($this->archivo as $componente) {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    /**
     *
     */
    public function index() {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];

        view::admintemplate("header", $data);
        view::render($this->archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    /**
     *
     */
    public function elementos() {
        echo json_encode($this->model->getnovedades());
    }

    /**
     *
     */
    public function add() {
        $novedades_titulo = filter_input(INPUT_POST, "novedades_titulo");
        $novedades_resumen = filter_input(INPUT_POST, "novedades_resumen");
        $novedades_contenido = filter_input(INPUT_POST, "novedades_contenido");
        $novedades_imagen_url = $this->componente->subir_imagen("novedades_imagen_url", "novedades");
        $novedades_fecha = date("Y-m-d H:i:s");
        $novedades_autor = session::get("usuario");
        $novedades_estado = filter_input(INPUT_POST, "novedades_estado");
        $novedades_destacado = filter_input(INPUT_POST, "novedades_destacado");

        if ($novedades_titulo != "" && $novedades_resumen != "" && $novedades_contenido != "" && $novedades_imagen_url["estado"]) {
            $datos = [
                "novedades_titulo" => $novedades_titulo,
                "novedades_resumen" => $novedades_resumen,
                "novedades_contenido" => $novedades_contenido,
                "novedades_imagen_url" => $novedades_imagen_url["url"],
                "novedades_fecha" => $novedades_fecha,
                "novedades_autor" => $novedades_autor,
                "novedades_estado" => $novedades_estado,
                "novedades_destacado" => $novedades_destacado
            ];
            echo $this->model->addNovedad($datos);
        }
    }

    /**
     *
     */
    public function edit() {
        $novedades_id = filter_input(INPUT_POST, "novedades_id");
        $novedades_titulo = filter_input(INPUT_POST, "novedades_titulo");
        $novedades_resumen = filter_input(INPUT_POST, "novedades_resumen");
        $novedades_contenido = filter_input(INPUT_POST, "novedades_contenido");
        $novedades_imagen_url = $this->componente->subir_imagen("novedades_imagen_url", "novedades");

        if ($novedades_titulo != "" && $novedades_resumen != "" && $novedades_contenido != "") {
            $datos = [
                "novedades_titulo" => $novedades_titulo,
                "novedades_resumen" => $novedades_resumen,
                "novedades_contenido" => $novedades_contenido
            ];
            if ($novedades_imagen_url["estado"] == "1") {
                $datos["novedades_imagen_url"] = $novedades_imagen_url["url"];
            }
            echo $datos["novedades_imagen_url"] . $novedades_id;
            echo $this->model->editNovedad($datos, ["novedades_id" => $novedades_id]);
        }
    }

    /**
     *
     */
    public function delete() {
        $novedades_id = filter_input(INPUT_POST, "novedades_id");
        echo $this->model->deleteNovedad(["novedades_id" => $novedades_id]);
    }

    /**
     *
     */
    public function publicar() {
        $novedades_id = filter_input(INPUT_POST, "novedades_id");
        $novedades_estado = filter_input(INPUT_POST, "novedades_estado") == "0" ? "1" : "0";
        $update = $this->model->editNovedad(["novedades_estado" => $novedades_estado], ["novedades_id" => $novedades_id]);
        echo "{\"novedades_estado\":\"$novedades_estado\", \"update\":\"$update\"}";
    }

    /**
     *
     */
    public function destacar() {
        $novedades_destacado = filter_input(INPUT_POST, "novedades_destacado") == "0" ? "1" : "0";
        $update = $this->model->editNovedad(["novedades_destacado" => $novedades_destacado], ["novedades_id" => filter_input(INPUT_POST, "novedades_id")]);
        echo "{\"novedades_destacado\":\"$novedades_destacado\", \"update\":\"$update\"}";
    }

}
