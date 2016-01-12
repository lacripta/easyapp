<?php

namespace models\admin;

class Novedades extends \core\Model {

    /**
     *
     * @param type $id
     * @return type
     */
    public function getNovedades() {
        return $this->_db->select("SELECT * FROM novedades", []);
    }

    /**
     * metodo de acceso para la presentacion de las novedades en la pagina principal, este metodo filtro las publicaciones de acuerdo a su estado y las organiza por fecha y luego por prioridad que la da el valor destacado
     * @return JSON lista de elementos visibles de las novedades
     */
    public function novedades() {
        return json_encode($this->_db->select("SELECT * FROM novedades where novedades_estado = 1 order by novedades_fecha, novedades_destacado", []));
    }

    /**
     *
     * @param ARRAY $menu_datos datos a insertar en la tabla menu
     * @return INT id del registro insertado
     */
    public function addNovedad($menu_datos) {
        return $this->_db->insert("novedades", $menu_datos);
    }

    /**
     * metodo para actualizar la informacion de una tabla deseada
     * @param array $menu_datos lista de campos con sus respectivos valores a ser actualizados en la tabla
     * @param array $where lista de identificadores con sus respectivos valores para actualizar la tabla
     */
    public function editNovedad($menu_datos, $where) {
        return $this->_db->update("novedades", $menu_datos, $where);
    }

    /**
     *
     * @param INT $campo señal de estado del borrado del registro
     */
    public function deleteNovedad($campo) {
        return $this->_db->delete("novedades", $campo);
    }

}
