<?php

namespace models\admin;

class Grupo extends \core\Model {

    public function getGrupos() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "grupo ORDER BY grupo_fecha");
    }

    public function getGrupo($id) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "grupo where grupo_id = :id", array(':id' => $id));
    }

    public function addGrupo($grupo_datos) {
        $this->_db->insert(PREFIX . "grupo", $grupo_datos);
    }

    public function updateGrupo($grupo_datos, $where) {
        $this->_db->update(PREFIX . "grupo", $grupo_datos, $where);
    }
    public function deleteGrupo($campo) {
        $this->_db->delete(PREFIX."grupo", $campo);
    }
    public function verificarGrupo($nombre) {
        return $this->_db->select("SELECT grupo_nombre FROM " . PREFIX . "grupo where grupo_nombre = :nombre", array(':nombre' => $nombre));
    }

}
