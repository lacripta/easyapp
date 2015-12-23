<?php

namespace controllers\admin;

use \helpers\Url,
    \core\View;

class Producto extends \core\Controller
{

    private $componente;
    private $archivoNombre;
    private $model;
    private $archivo;

    public function __construct()
    {
        $this->componente = new \models\admin\Componente();
        $this->model = new \models\admin\Producto();

        $this->clase = "producto";
        $this->archivoNombre = "producto.php";

        $this->archivo["raiz"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["raiz"]["componente_enlace"] = ADMIN . "producto";
        $this->archivo["raiz"]["componente_url"] = DIR . ADMIN . "producto";
        $this->archivo["raiz"]["componente_nombre"] = "Administrador de Productos";
        $this->archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->archivo["raiz"]["componente_nombre"]);

        $this->archivo["elementos"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["elementos"]["componente_enlace"] = ADMIN . "elementos";
        $this->archivo["elementos"]["componente_url"] = DIR . ADMIN . "producto/elementos";
        $this->archivo["elementos"]["componente_nombre"] = "Lista de productos";
        $this->archivo["elementos"]["componente_slug"] = Url::generateSafeSlug($this->archivo["elementos"]["componente_nombre"]);

        $this->archivo["nuevo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["nuevo"]["componente_enlace"] = ADMIN . "elemento_nuevo";
        $this->archivo["nuevo"]["componente_url"] = DIR . ADMIN . "producto/elemento_nuevo";
        $this->archivo["nuevo"]["componente_nombre"] = "Agregar producto";
        $this->archivo["nuevo"]["componente_slug"] = Url::generateSafeSlug($this->archivo["nuevo"]["componente_nombre"]);

        $this->archivo["editar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["editar"]["componente_enlace"] = ADMIN . "elemento_editar";
        $this->archivo["editar"]["componente_url"] = DIR . ADMIN . "producto/elemento_editar";
        $this->archivo["editar"]["componente_nombre"] = "Editar producto";
        $this->archivo["editar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["editar"]["componente_nombre"]);

        $this->archivo["borrar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["borrar"]["componente_enlace"] = ADMIN . "elemento_borrar";
        $this->archivo["borrar"]["componente_url"] = DIR . ADMIN . "producto/elemento_borrar";
        $this->archivo["borrar"]["componente_nombre"] = "Borrar producto";
        $this->archivo["borrar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["borrar"]["componente_nombre"]);

        $this->archivo["publicar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["publicar"]["componente_enlace"] = ADMIN . "elemento_publicar";
        $this->archivo["publicar"]["componente_url"] = DIR . ADMIN . "producto/elemento_publicar";
        $this->archivo["publicar"]["componente_nombre"] = "Publicar producto";
        $this->archivo["publicar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["publicar"]["componente_nombre"]);

        $this->archivo["destacar"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["destacar"]["componente_enlace"] = ADMIN . "elemento_destacar";
        $this->archivo["destacar"]["componente_url"] = DIR . ADMIN . "producto/elemento_destacar";
        $this->archivo["destacar"]["componente_nombre"] = "Destacar producto";
        $this->archivo["destacar"]["componente_slug"] = Url::generateSafeSlug($this->archivo["destacar"]["componente_nombre"]);

        $this->archivo["grupo"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["grupo"]["componente_enlace"] = ADMIN . "producto_grupo";
        $this->archivo["grupo"]["componente_url"] = DIR . ADMIN . "producto/producto_grupo";
        $this->archivo["grupo"]["componente_nombre"] = "Grupos de productos";
        $this->archivo["grupo"]["componente_slug"] = Url::generateSafeSlug($this->archivo["grupo"]["componente_nombre"]);

        $this->archivo["categoria"]["componente_archivo"] = $this->archivoNombre;
        $this->archivo["categoria"]["componente_enlace"] = ADMIN . "producto_categoria";
        $this->archivo["categoria"]["componente_url"] = DIR . ADMIN . "producto/producto_categoria";
        $this->archivo["categoria"]["componente_nombre"] = "Categorias de producto";
        $this->archivo["categoria"]["componente_slug"] = Url::generateSafeSlug($this->archivo["categoria"]["componente_nombre"]);

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
        echo $this->model->productos();
    }

    public function producto_grupo()
    {
        echo $this->model->producto_grupo(filter_input(INPUT_POST, "dato"), filter_input(INPUT_POST, "producto_categoria"));
    }

    public function producto_categoria()
    {
        echo $this->model->producto_categoria(filter_input(INPUT_POST, "dato"));
    }

    public function elemento_nuevo()
    {
        $producto_categoria = filter_input(INPUT_POST, "producto_categoria");
        $producto_descripcion = filter_input(INPUT_POST, "producto_descripcion");
        $producto_existencias = filter_input(INPUT_POST, "producto_existencias");
        $producto_grupo = filter_input(INPUT_POST, "producto_grupo");
        $producto_nombre = filter_input(INPUT_POST, "producto_nombre");
        $producto_resumen = filter_input(INPUT_POST, "producto_resumen");
        $producto_precio = filter_input(INPUT_POST, "producto_precio");

        if ($producto_categoria != "" && $producto_descripcion != "" && $producto_existencias != "" && $producto_grupo != "" && $producto_nombre != "" && $producto_precio != "")
        {
            $datos = [
                "producto_categoria" => $producto_categoria,
                "producto_descripcion" => $producto_descripcion,
                "producto_existencias" => $producto_existencias,
                "producto_grupo" => $producto_grupo,
                "producto_nombre" => $producto_nombre,
                "producto_resumen" => $producto_resumen,
                "producto_precio" => $producto_precio
            ];
            echo $this->model->producto_nuevo($datos);
        }
    }

    public function elemento_editar()
    {
        $producto_categoria = filter_input(INPUT_POST, "producto_categoria");
        $producto_descripcion = filter_input(INPUT_POST, "producto_descripcion");
        $producto_existencias = filter_input(INPUT_POST, "producto_existencias");
        $producto_grupo = filter_input(INPUT_POST, "producto_grupo");
        $producto_nombre = filter_input(INPUT_POST, "producto_nombre");
        $producto_resumen = filter_input(INPUT_POST, "producto_resumen");
        $producto_precio = filter_input(INPUT_POST, "producto_precio");

        if ($producto_categoria != "" && $producto_descripcion != "" && $producto_existencias != "" && $producto_grupo != "" && $producto_nombre != "" && $producto_precio != "")
        {
            $datos = [
                "producto_categoria" => $producto_categoria,
                "producto_descripcion" => $producto_descripcion,
                "producto_existencias" => $producto_existencias,
                "producto_grupo" => $producto_grupo,
                "producto_nombre" => $producto_nombre,
                "producto_resumen" => $producto_resumen,
                "producto_precio" => $producto_precio
            ];
//print_r($datos);
//print_r(filter_input(INPUT_POST, "producto_id"));
            echo $this->model->producto_editar($datos, ["producto_id" => filter_input(INPUT_POST, "producto_id")]);
        }
    }

    public function elemento_borrar()
    {
        echo $this->model->producto_borrar(["producto_id" => filter_input(INPUT_POST, "producto_id")]);
    }

    public function elemento_publicar()
    {
        $producto_estado = filter_input(INPUT_POST, "producto_estado") == "0" ? "1" : "0";
        $update = $this->model->producto_editar(["producto_estado" => $producto_estado], ["producto_id" => filter_input(INPUT_POST, "producto_id")]);
        echo "{\"producto_estado\":\"$producto_estado\", \"update\":\"$update\"}";
    }

    public function elemento_destacado()
    {
        $producto_destacado = filter_input(INPUT_POST, "producto_destacado") == "0" ? "1" : "0";
        $update = $this->model->producto_editar(["producto_destacado" => $producto_destacado], ["producto_id" => filter_input(INPUT_POST, "producto_id")]);
        echo "{\"producto_destacado\":\"$producto_destacado\", \"update\":\"$update\"}";
    }

}
