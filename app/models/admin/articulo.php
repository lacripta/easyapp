<?php

namespace models\admin;

class Articulo extends \core\Model {

    public function getArticulos() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "articulo ORDER BY articulo_fecha");
    }

    public function getArticulo($id) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "articulo where articulo_id = :id", array(':id' => $id));
    }

    public function addArticulo($articulo_datos) {
        $this->_db->insert(PREFIX . "articulo", $articulo_datos);
    }

    public function updateArticulo($articulo_datos, $where) {
        $this->_db->update(PREFIX . "articulo", $articulo_datos, $where);
    }
    
    public function deleteArticulo($campo) {
        $this->_db->delete(PREFIX."articulo", $campo);
    }

}

