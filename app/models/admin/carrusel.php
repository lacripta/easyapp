<?php

namespace models\admin;

class Carrusel extends \core\Model
{

    public function elementos()
    {
        return json_encode($this->_db->select("SELECT * FROM galeria order by galeria_fecha, galeria_estado", []));
    }

    public function elemento_nuevo($datos)
    {
        return $this->_db->insert("galeria", $datos);
    }

    public function elemento_editar($datos, $where)
    {
        return $this->_db->update("galeria", $datos, $where);
    }

    public function elemento_borrar($datos)
    {
        return $this->_db->delete("galeria", $datos);
    }

}
