<?php

namespace models\admin;

class Menu extends \core\Model {

    /**
     * metodo utilizado para obtener los permisos de cada usuario registrado
     * @param STRING $sid nombre de usuario para filtrar los permisos
     * @return OBJ result de la consulta realizada
     */
    public function getMenus($sid) {
        return $this->_db->select("SELECT * FROM " . PREFIX . "permisos_usuario join (select * from " . PREFIX . "componente join " . PREFIX . "menu on componente_nombre = menu_componente) as elementos on permisos_usuario_sid = :sid and permisos_usuario_componente = elementos.componente_id and permisos_usuario_estado = 1 join gd_menu_clase on menu_clase_nombre = menu_clase
join gd_menu_grupo on menu_grupo_nombre = menu_grupo
order by menu_clase_orden, menu_grupo_orden, menu_orden ", array(':sid' => $sid));
    }

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
     * @return type
     */
    public function getGrupos() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "menu_grupo ORDER BY menu_grupo_orden");
    }

    /**
     *
     * @return type
     */
    public function getClases() {
        return $this->_db->select("SELECT * FROM " . PREFIX . "menu_clase ORDER BY menu_clase_orden");
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
     * @param type $menu_datos
     */
    public function crearClase($menu_datos) {
        $this->_db->insert(PREFIX . "menu_clase", $menu_datos);
    }

    /**
     *
     * @param type $grupo_datos
     */
    public function crearGrupo($grupo_datos) {
        $this->_db->insert(PREFIX . "menu_grupo", $grupo_datos);
    }

    /**
     *
     * @param ARRAY[campo]=dato $menu_datos
     * @param ARRAY[campo]=dato $where
     */
    public function updateMenu($menu_datos, $where) {
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
