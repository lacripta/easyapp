<?php

namespace models\admin;

class Usuario extends \core\model {

    public function getUsuarios() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "usuario ORDER BY usuario_fecha");
    }

    public function getUsuario($id) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "usuario where usuario_id = :id", array(':id' => $id));
    }
    
    public function getGrupos() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "grupo ORDER BY grupo_nombre");
    }

    public function addUsuario($usuario_datos) {
        $this->_db->insert(PREFIX . "usuario", $usuario_datos);
    }

    public function updateUsuario($usuario_datos, $where) {
        $this->_db->update(PREFIX . "usuario", $usuario_datos, $where);
    }
    public function deleteUsuario($campo) {
        $this->_db->delete(PREFIX."usuario", $campo);
    }

}
