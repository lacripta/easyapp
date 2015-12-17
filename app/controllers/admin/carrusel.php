<?php

namespace controllers\admin;

use \helpers\Url,
    \core\View;

class Carrusel extends \core\Controller
{

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct()
    {
        $this->componente = new \models\admin\Componente();
        $this->model = new \models\admin\Carrusel();

        $this->clase = "carrusel";
        $this->archivoNombre = "carrusel.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "carrusel";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "carrusel";
        $this->archivo["raiz"]["componente_nombre"] = "Administrador de Imagenes del Carrusel";
        $this->archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        $this->archivo["elementos"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["elementos"]["componente_enlace"] = ADMIN . "elementos";
        $this->archivo["elementos"]["componente_url"] = DIR . ADMIN . "carrusel/elementos";
        $this->archivo["elementos"]["componente_nombre"] = "Lista de elementos del carrusel";
        $this->archivo["elementos"]["componente_slug"] = Url::generateSafeSlug($this->archivo["elementos"]["componente_nombre"]);

        $this->archivo["nuevo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["nuevo"]["componente_enlace"] = ADMIN . "elemento_nuevo";
        $this->archivo["nuevo"]["componente_url"] = DIR . ADMIN . "carrusel/elemento_nuevo";
        $this->archivo["nuevo"]["componente_nombre"] = "Agregar elemento al carrusel";
        $this->archivo["nuevo"]["componente_slug"] = Url::generateSafeSlug($this->archivo["nuevo"]["componente_nombre"]);

        $this->archivo["editar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["editar"]["componente_enlace"] = ADMIN . "elemento_editar";
        $this->archivo["editar"]["componente_url"] = DIR . ADMIN . "carrusel/elemento_editar";
        $this->archivo["editar"]["componente_nombre"] = "Editar elemento al carrusel";
        $this->archivo["editar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["editar"]["componente_nombre"]);

        $this->archivo["borrar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["borrar"]["componente_enlace"] = ADMIN . "elemento_borrar";
        $this->archivo["borrar"]["componente_url"] = DIR . ADMIN . "carrusel/elemento_borrar";
        $this->archivo["borrar"]["componente_nombre"] = "Borrar elemento al carrusel";
        $this->archivo["borrar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["borrar"]["componente_nombre"]);

        $this->archivo["publicar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["publicar"]["componente_enlace"] = ADMIN . "elemento_publicar";
        $this->archivo["publicar"]["componente_url"] = DIR . ADMIN . "carrusel/elemento_publicar";
        $this->archivo["publicar"]["componente_nombre"] = "Publicar elemento al carrusel";
        $this->archivo["publicar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["publicar"]["componente_nombre"]);

        foreach ($this->archivo as $componente)
        {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index()
    {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["usuarios"] = $this->componente->getEnlace("admin/usuario");
        $data["articulos"] = $this->componente->getEnlace("admin/articulo");

        View::admintemplate("header", $data);
        View::render($this->archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
    }

    public function elementos()
    {
        echo $this->model->elementos();
    }

    public function elemento_nuevo()
    {
        $galeria_descripcion = filter_input(INPUT_POST, "galeria_descripcion");
        $galeria_titulo = filter_input(INPUT_POST, "galeria_titulo");
        $galeria_nombre = filter_input(INPUT_POST, "galeria_nombre");
        $galeria_url = $this->componente->subir_imagen("image_file", "carrusel");
        //echo $galeria_descripcion . $galeria_titulo . $galeria_nombre . $galeria_url["estado"];
        if ($galeria_descripcion != "" && $galeria_titulo != "" && $galeria_nombre != "" && $galeria_url["estado"])
        {
            $datos = [
                "galeria_descripcion" => $galeria_descripcion,
                "galeria_titulo" => $galeria_titulo,
                "galeria_nombre" => $galeria_nombre,
                "galeria_url" => $galeria_url["url"]
            ];
            echo $this->model->elemento_nuevo($datos);
        }
    }

    public function elemento_editar()
    {
        $galeria_id = filter_input(INPUT_POST, "galeria_id");
        $galeria_descripcion = filter_input(INPUT_POST, "galeria_descripcion");
        $galeria_titulo = filter_input(INPUT_POST, "galeria_titulo");
        $galeria_nombre = filter_input(INPUT_POST, "galeria_nombre");
        $galeria_url = $this->componente->subir_imagen("image_file", "carrusel");
        if ($galeria_descripcion != "" && $galeria_titulo != "" && $galeria_nombre != "")
        {
            $datos = [
                "galeria_descripcion" => $galeria_descripcion,
                "galeria_titulo" => $galeria_titulo,
                "galeria_nombre" => $galeria_nombre
            ];
            //echo "estado " . print_r($galeria_url);
            if ($galeria_url["estado"] == "1")
            {
                $datos["galeria_url"] = $galeria_url["url"];
            }
            echo $datos["galeria_url"] . $galeria_id;
            $this->model->elemento_editar($datos, ["galeria_id" => $galeria_id]);
        }
    }

    public function elemento_borrar()
    {
        $galeria_id = filter_input(INPUT_POST, "galeria_id");
        echo $this->model->elemento_borrar(["galeria_id" => $galeria_id]);
    }

    public function elemento_publicar()
    {
        $galeria_id = filter_input(INPUT_POST, "galeria_id");
        $galeria_estado = filter_input(INPUT_POST, "galeria_estado") == "0" ? "1" : "0";
        $update = $this->model->elemento_editar(["galeria_estado" => $galeria_estado], ["galeria_id" => $galeria_id]);
        echo "{\"galeria_estado\":\"$galeria_estado\", \"update\":\"$update\"}";
    }

}
