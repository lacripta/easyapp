<?php

namespace models\admin;

class Auth extends \core\model {

    public function getClaveHash($usuario) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "usuario WHERE usuario_sid = :usuario", array(':usuario' => $usuario));
    }

}
