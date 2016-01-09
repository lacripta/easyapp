<?php

namespace controllers\admin;

use \helpers\Session,
    \helpers\Url,
    \core\View;

class Data_Feed extends \core\Controller {

    private $componente;
    private $carrusel;
    private $producto;
    private $producto_imagen;

    public function __construct() {
        $this->componente = new \models\admin\Componente();
        $this->carrusel = new \models\admin\Carrusel();
        $this->producto = new \models\admin\Producto();
        $this->producto_imagen = new \models\admin\Producto_Imagen();
    }

    public function productos() {
        echo $this->producto->productos_lista();
    }

    public function productos_ordenados() {
        echo $this->producto->productos_lista_ordenada();
    }

    public function categorias() {
        echo $this->producto->producto_categorias();
    }

    public function grupos() {
        echo $this->producto->producto_grupos(filter_input(INPUT_POST, "producto_categoria"));
    }

    public function filtro_productos() {
        echo $this->producto->filtro_productos(filter_input(INPUT_POST, "producto_categoria"), filter_input(INPUT_POST, "producto_grupo"));
    }

    public function productos_categoria() {
        echo $this->producto->productos_categoria(filter_input(INPUT_POST, "producto_categoria"));
    }

    public function detalles_producto() {
        $producto_id = filter_input(INPUT_POST, "producto_id");
        $resultado = $this->producto->producto($producto_id);
        $resultado->imagenes = $this->producto->producto_imagenes($producto_id);
        echo json_encode($resultado);
    }

    public function galeria() {
        echo $this->producto->elementos_pagina();
    }

}
