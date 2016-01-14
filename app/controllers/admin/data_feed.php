<?php

namespace controllers\admin;

use \helpers\session,
    \helpers\url,
    \core\view;

class Data_Feed extends \core\controller {

    private $componente;
    private $carrusel;
    private $producto;
    private $novedades;
    private $estilos;
    private $producto_imagen;

    public function __construct() {
        $this->componente = new \models\admin\componente();
        $this->carrusel = new \models\admin\carrusel();
        $this->producto = new \models\admin\producto();
        $this->novedades = new \models\admin\novedades();
        $this->estilos = new \models\admin\estilos();
        $this->producto_imagen = new \models\admin\producto_imagen();
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

    public function novedades() {
        echo $this->novedades->novedades();
    }

    public function estilos() {
        echo $this->estilos->actuales();
    }

}
