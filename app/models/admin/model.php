<?php

namespace models\admin;

class Model extends \core\Model {

    /**
     *
     * @param type $id
     * @return type
     */
    public function getMenu($id) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "menu where menu_id = :id", array(':id' => $id));
    }

    /**
     *
     * @param ARRAY $menu_datos datos a insertar en la tabla menu
     * @return INT id del registro insertado
     */
    public function crearMenu($menu_datos) {
        return $this->_db->insert(PREFIX . "menu", $menu_datos);
    }

    /**
     *
     * @param type $menu_datos
     * @param type $where
     */
    public function editarMenu($menu_datos, $where) {
        $this->_db->update(PREFIX . "menu", $menu_datos, $where);
    }

    /**
     *
     * @param INT $campo señal de estado del borrado del registro
     */
    public function deleteMenu($campo) {
        $this->_db->delete(PREFIX . "menu", $campo);
    }

}
