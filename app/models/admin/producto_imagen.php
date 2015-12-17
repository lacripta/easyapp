<?php

namespace models\admin;

class Producto_Imagen extends \core\Model
{

    public function elementos()
    {
        return json_encode($this->_db->select("SELECT * FROM galeria", []));
    }

    public function producto($producto)
    {
        return $this->_db->select("SELECT * FROM producto where producto_id = :producto", [":producto" => $producto]);
    }

    public function elemento_nuevo($datos)
    {
        return $this->_db->insert("producto_imagen", $datos);
    }

    public function imagenes($producto)
    {
        return $this->_db->select("SELECT * FROM producto_imagen where producto_imagen_producto = :producto", [":producto" => $producto]);
    }

    public function agregar_imagen($datos)
    {
        return $this->_db->insert("producto_imagen", $datos);
    }

    public function imagen_editar($datos, $where)
    {
        return $this->_db->update("producto_imagen", $datos, $where);
    }

    public function borrar_imagen($datos)
    {
        return $this->_db->delete("producto_imagen", $datos);
    }

}
