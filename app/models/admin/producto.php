<?php

namespace models\admin;

class Producto extends \core\Model
{

    public function productos()
    {
        return json_encode($this->_db->select("SELECT * FROM producto", []));
    }

    public function producto($producto)
    {
        return $this->_db->select("SELECT * FROM producto where producto_id = :producto", [":producto" => $producto]);
    }

    public function producto_grupo($dato)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_grupo where producto_grupo_nombre like :grupo", [":grupo" => "%" . $dato . "%"]));
    }

    public function producto_categoria($dato)
    {
        return json_encode($this->_db->select("SELECT * FROM producto_categoria where producto_categoria_nombre like :categoria", [":categoria" => "%" . $dato . "%"]));
    }

    public function producto_nuevo($datos)
    {
        return $this->_db->insert("producto", $datos);
    }

    public function producto_editar($datos, $where)
    {
        return $this->_db->update("producto", $datos, $where);
    }

    public function producto_borrar($datos)
    {
        return $this->_db->delete("producto", $datos);
    }

}
