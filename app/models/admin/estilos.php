<?php

namespace models\admin;

class Estilos extends \core\model {

    /**
     *
     * @param type $prop
     * @return type
     */
    public function getPropiedad($prop) {
        return $this->_db->select("SELECT estilo_nombre, estilo_valor FROM estilo where estilo_nombre = :prop", array(':prop' => $prop))[0];
    }

    public function actuales() {
        return json_encode($this->_db->select("SELECT estilo_nombre, estilo_valor FROM estilo", []));
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
    public function editar($menu_datos, $where) {
        $this->_db->update("estilo", $menu_datos, $where);
    }

    /**
     *
     * @param INT $campo señal de estado del borrado del registro
     */
    public function deleteMenu($campo) {
        $this->_db->delete(PREFIX . "menu", $campo);
    }

}
