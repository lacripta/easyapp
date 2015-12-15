<?php

namespace models\admin;

class Producto extends \core\Model
{

    public function productos()
    {
        return json_encode($this->_db->select("SELECT * FROM producto", []));
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
