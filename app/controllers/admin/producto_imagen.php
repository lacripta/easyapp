<?php

namespace controllers\admin;

use \helpers\Url,
    \core\View;

class Producto_Imagen extends \core\Controller
{

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct()
    {
        $this->componente = new \models\admin\Componente();
        $this->model = new \models\admin\Producto_Imagen();

        $this->clase = "producto_imagen";
        $this->archivoNombre = "producto_imagen.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "producto_imagen";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "producto/imagenes";
        $this->archivo["raiz"]["componente_nombre"] = "Imagenes del producto";
        $this->archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->archivo["imagenes"]["componente_nombre"]);

        $this->archivo["imagenes_producto"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["imagenes_producto"]["componente_enlace"] = ADMIN . "imagenes/imagenes_producto";
        $this->archivo["imagenes_producto"]["componente_url"] = DIR . ADMIN . "producto/imagenes/imagenes_producto";
        $this->archivo["imagenes_producto"]["componente_nombre"] = "Lista de Imagenes del producto";
        $this->archivo["imagenes_producto"]["componente_slug"] = Url::generateSafeSlug($this->archivo["imagenes_producto"]["componente_nombre"]);

        $this->archivo["nuevo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["nuevo"]["componente_enlace"] = ADMIN . "imagenes/agregar";
        $this->archivo["nuevo"]["componente_url"] = DIR . ADMIN . "imagenes/agregar";
        $this->archivo["nuevo"]["componente_nombre"] = "Agregar iamgen del producto";
        $this->archivo["nuevo"]["componente_slug"] = Url::generateSafeSlug($this->archivo["nuevo"]["componente_nombre"]);

        foreach ($this->archivo as $componente)
        {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index($id)
    {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["inicio"] = $this->componente->getEnlace("admin/inicio");
        $data["producto"] = $this->componente->getEnlace("admin/producto");
        $data["elemento"] = $this->model->producto($id)[0];

        View::admintemplate("header", $data);
        View::render($this->archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
    }

    public function agregar_imagen()
    {
        $producto_imagen_nombre = filter_input(INPUT_POST, "producto_imagen_nombre");
        $producto_imagen_titulo = filter_input(INPUT_POST, "producto_imagen_titulo");
        $producto_imagen_descripcion = filter_input(INPUT_POST, "producto_imagen_descripcion");
        $producto_url = $this->componente->subir_imagen("image_file", "producto");
        if ($producto_imagen_nombre != "" && $producto_imagen_titulo != "" && $producto_imagen_descripcion != "" && $producto_url["estado"])
        {
            $datos = [
                "producto_imagen_nombre" => $producto_imagen_nombre,
                "producto_imagen_titulo" => $producto_imagen_titulo,
                "producto_imagen_descripcion" => $producto_imagen_descripcion,
                "producto_imagen_url" => $producto_url["url"]
            ];
            echo $this->model->elemento_nuevo($datos);
        }
    }

    public function imagenes()
    {
        echo $this->model->imagenes(filter_input(INPUT_POST, "producto_id"));
    }

}
