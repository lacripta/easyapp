<?php

namespace models\admin;

class Producto_Imagen extends \core\Model
{

    public function elementos()
    {
        return json_encode($this->_db->select("SELECT * FROM galeria", []));
    }

    public function imagenes($producto)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_imagen where producto_imagen_producto = :producto", [":producto" => $producto]));
    }

    public function agregar_imagen($datos)
    {
        return $this->_db->insert("producto_imagen", $datos);
    }

    public function producto($producto)
    {
        return $this->_db->select("SELECT * FROM producto where producto_id = :producto", [":producto" => $producto]);
    }

}
