<?php

namespace controllers\admin;

use \helpers\url,
    \core\view;

class Producto_Imagen extends \core\controller {

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct() {
        $this->componente = new \models\admin\componente();
        $this->model = new \models\admin\producto_imagen();

        $this->clase = "producto_imagen";
        $this->archivoNombre = "producto_imagen.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "producto_imagen";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "producto/imagenes";
        $this->archivo["raiz"]["componente_nombre"] = "Imagenes del producto";
        $this->archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        $this->archivo["imagenes_producto"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["imagenes_producto"]["componente_enlace"] = ADMIN . "producto/imagenes/imagenes_producto";
        $this->archivo["imagenes_producto"]["componente_url"] = DIR . ADMIN . "producto/imagenes/imagenes_producto";
        $this->archivo["imagenes_producto"]["componente_nombre"] = "Lista de Imagenes del producto";
        $this->archivo["imagenes_producto"]["componente_slug"] = url::generateSafeSlug($this->archivo["imagenes_producto"]["componente_nombre"]);

        $this->archivo["nuevo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["nuevo"]["componente_enlace"] = ADMIN . "producto/imagenes/agregar_imagen";
        $this->archivo["nuevo"]["componente_url"] = DIR . ADMIN . "producto/imagenes/agregar_imagen";
        $this->archivo["nuevo"]["componente_nombre"] = "Agregar imagen del producto";
        $this->archivo["nuevo"]["componente_slug"] = url::generateSafeSlug($this->archivo["nuevo"]["componente_nombre"]);

        $this->archivo["borrar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["borrar"]["componente_enlace"] = ADMIN . "producto/imagenes/borrar_imagen";
        $this->archivo["borrar"]["componente_url"] = DIR . ADMIN . "producto/imagenes/borrar";
        $this->archivo["borrar"]["componente_nombre"] = "Borrar imagen del producto";
        $this->archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->archivo["borrar"]["componente_nombre"]);

        $this->archivo["publicar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["publicar"]["componente_enlace"] = ADMIN . "producto/imagenes/publicar_imagen";
        $this->archivo["publicar"]["componente_url"] = DIR . ADMIN . "producto/imagenes/publicar_imagen";
        $this->archivo["publicar"]["componente_nombre"] = "publicar imagen del producto";

        foreach ($this->archivo as $componente) {
            $this->componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->componente->controlAcceso();
    }

    public function index($id) {
        $data["title"] = $this->archivo["raiz"]["componente_nombre"];
        $data["inicio"] = $this->componente->getEnlace("admin/inicio");
        $data["producto"] = $this->componente->getEnlace("admin/producto");
        $data["elemento"] = $this->model->producto($id)[0];
        $data["imagenes"] = $this->model->imagenes($id);

        view::admintemplate("header", $data);
        view::render($this->archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function agregar_imagen() {
        $producto_imagen_nombre = filter_input(INPUT_POST, "producto_imagen_nombre");
        $producto_imagen_titulo = filter_input(INPUT_POST, "producto_imagen_nombre");
        $producto_imagen_descripcion = filter_input(INPUT_POST, "producto_imagen_nombre");
        $producto_url = $this->componente->subir_imagen("image_file", "productos");
        if ($producto_imagen_nombre != "" && $producto_imagen_titulo != "" && $producto_imagen_descripcion != "" && $producto_url["estado"]) {
            $datos = [
                "producto_imagen_nombre" => $producto_imagen_nombre,
                "producto_imagen_producto" => filter_input(INPUT_POST, "producto_imagen_producto"),
                "producto_imagen_titulo" => $producto_imagen_titulo,
                "producto_imagen_descripcion" => $producto_imagen_descripcion,
                "producto_imagen_url" => $producto_url["url"]
            ];
            echo $this->model->elemento_nuevo($datos);
        }
    }

    public function imagenes() {
        echo json_encode($this->model->imagenes(filter_input(INPUT_POST, "producto_id")));
    }

    public function imagen_borrar($id) {
        echo $this->model->borrar_imagen(["producto_imagen_id" => $id]);
    }

    public function imagen_publicar() {
        echo $this->model->imagen_editar(["producto_imagen_estado" => filter_input(INPUT_POST, "producto_imagen_estado") == "0" ? "1" : "0"], ["producto_imagen_id" => filter_input(INPUT_POST, "producto_imagen_id")]);
    }

}
