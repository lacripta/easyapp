<?php

namespace models\admin;

class Categoria extends \core\Model {

    public function getCategorias() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "documento_tipo;");
    }

    public function getGrupos() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "grupo ORDER BY grupo_nombre;");
    }

    public function getCategoria($id) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "documento_tipo where documento_tipo_id = :id", array(":id" => $id));
    }

    public function addCategoria($datos_categoria) {
        $this->_db->insert(PREFIX . "documento_tipo", $datos_categoria);
    }

    public function updateCategoria($datos_categoria, $where) {
        $this->_db->update(PREFIX . "documento_tipo", $datos_categoria, $where);
    }

    public function deleteCategoria($id) {
        $this->_db->delete(PREFIX . "documento_tipo", $id);
    }

}
