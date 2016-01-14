<?php

namespace controllers\admin;

use \helpers\url,
    \helpers\session,
    \core\view;

class Menu extends \core\controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {
        $this->_componente = new \models\admin\componente();
        $this->_model = new \models\admin\menu();

        $this->clase = "menu";
        $this->_archivoNombre = "menu.php";
        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/menu";
        $this->_archivo["raiz"]["componente_nombre"] = "Creador de Menu";
        $this->_archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "menu_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/menu/add";
        $this->_archivo["crear"]["componente_nombre"] = "Crear Acceso en Menu";
        $this->_archivo["crear"]["componente_slug"] = url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "menu_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/menu/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Editar Accesos en Menu";
        $this->_archivo["editar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/menu/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Quitar del Menu";
        $this->_archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_archivo["acceso"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["acceso"]["componente_enlace"] = ADMIN . "menu_acceso";
        $this->_archivo["acceso"]["componente_url"] = DIR . "admin/menu/acceso/";
        $this->_archivo["acceso"]["componente_nombre"] = "Permisos de Acceso al Menu";
        $this->_archivo["acceso"]["componente_slug"] = url::generateSafeSlug($this->_archivo["acceso"]["componente_nombre"]);

        $this->_archivo["clase"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["clase"]["componente_enlace"] = ADMIN . "menu_clase";
        $this->_archivo["clase"]["componente_url"] = DIR . "admin/menu/add/clase";
        $this->_archivo["clase"]["componente_nombre"] = "Crear Clase de Elementos";
        $this->_archivo["clase"]["componente_slug"] = url::generateSafeSlug($this->_archivo["clase"]["componente_nombre"]);

        $this->_archivo["grupo"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["grupo"]["componente_enlace"] = ADMIN . "menu_grupo";
        $this->_archivo["grupo"]["componente_url"] = DIR . "admin/menu/add/grupo";
        $this->_archivo["grupo"]["componente_nombre"] = "Crear Grupo de Elementos";
        $this->_archivo["grupo"]["componente_slug"] = url::generateSafeSlug($this->_archivo["grupo"]["componente_nombre"]);
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $this->_componente->controlAcceso();
    }

    public function index() {

        $dropdowns = "";
        $elementos = "";
        $grupo = "";

        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["editar"] = $this->_archivo["editar"]["componente_url"];
        $data["clases"] = $this->_model->getClases();
        $data["grupos"] = $this->_model->getGrupos();
        $data["menus"] = $this->_model->getMenus(session::get("usuario"));
        $data["js"] = "
            <script>
                function borrar_menu(id, titulo) {
                    if (confirm('Seguro de eliminar el Acceso a ' + titulo)){
                        window.location.href = '" . $this->_archivo["borrar"]["componente_url"] . "..' + id;
                    }
                }
            </script>";
        view::admintemplate("header", $data);
        view::render($this->_archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function add() {
        $data["title"] = $this->_archivo["crear"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["clases"] = $this->_model->getClases();
        $data["grupos"] = $this->_model->getGrupos();
        $data["componentes"] = $this->_componente->getComponentes();

        if (null != filter_input(INPUT_POST, "submit")) {
            $clase = filter_input(INPUT_POST, "clase");
            $grupo = filter_input(INPUT_POST, "grupo");
            $titulo = filter_input(INPUT_POST, "titulo");
            $orden = filter_input(INPUT_POST, "orden");
            $componente = split("---", filter_input(INPUT_POST, "componente"));
            $comp_id = $componente[0];
            $comp_enlace = $componente[1];
            if ($clase === "") {
                $error[] = "Debe especificar una clase.";
            }
            if ($grupo === "") {
                $error[] = "Debe elegir un grupo.";
            }
            if ($titulo === "") {
                $error[] = "Nombre de elemento requerido.";
            }
            if ($componente === "") {
                $error[] = "Debe elegir un componente.";
            }
            if (!$error) {
                $menu_datos = array(
                    'menu_clase' => trim($clase),
                    'menu_grupo' => trim($grupo),
                    'menu_titulo' => trim($titulo),
                    'menu_enlace' => trim($comp_enlace),
                    'menu_orden' => trim($orden),
                    'menu_componente' => trim($comp_id)
                );
                $id = $this->_model->crearMenu($menu_datos);
                session::set("estado", "Enlace Creado, $id");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["crear"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function edit($elemento) {
        $data["title"] = $this->_archivo["editar"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["editar"] = $this->_archivo["editar"]["componente_url"];
        $data["clase"] = $this->clase;

        $data["clases"] = $this->_model->getClases();
        $data["grupos"] = $this->_model->getGrupos();
        $data["componentes"] = $this->_componente->getComponentes();
        $data["elemento"] = $this->_componente->getElementoMenu(urldecode($elemento));

        if (null != filter_input(INPUT_POST, "submit")) {
            $clase = filter_input(INPUT_POST, "clase");
            $grupo = filter_input(INPUT_POST, "grupo");
            $titulo = filter_input(INPUT_POST, "titulo");
            $orden = filter_input(INPUT_POST, "orden");
            $componente = split("---", filter_input(INPUT_POST, "componente"));
            $comp_id = $componente[0];
            $comp_enlace = $componente[1];
            if ($clase === "") {
                $error[] = "Debe especificar una clase.";
            }
            if ($grupo === "") {
                $error[] = "Debe elegir un grupo.";
            }
            if ($titulo === "") {
                $error[] = "Nombre de elemento requerido.";
            }
            if ($componente === "") {
                $error[] = "Debe elegir un componente.";
            }
            if (!$error) {
                $menu_datos = array(
                    'menu_clase' => trim($clase),
                    'menu_grupo' => trim($grupo),
                    'menu_titulo' => trim($titulo),
                    'menu_enlace' => trim($comp_enlace),
                    'menu_orden' => trim($orden),
                    'menu_componente' => trim($comp_id)
                );
                $this->_model->editarMenu($menu_datos, array('menu_titulo' => $titulo));
                session::set("estado", "Enlace Modificado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        view::admintemplate("header", $data);
        view::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function delete($id) {
        $datos = array("menu_id" => $id);
        $this->_model->deleteMenu($datos);
        session::set("estado", "Elemento Eliminado");
        url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

    public function acceso($sid) {
        $data["title"] = $this->_archivo["clase"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["url"] = $this->_archivo["clase"]["componente_url"];
        $data["componentes"] = $this->_componente->permisosUsuario($sid);
        $data["sid"] = $sid;

        view::admintemplate("header", $data);
        view::render($this->_archivo["clase"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function clase() {
        $data["title"] = $this->_archivo["clase"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["url"] = $this->_archivo["clase"]["componente_url"];


        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $fecha = filter_input(INPUT_POST, "fecha");
            $estado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            if ($nombre === "") {
                $error[] = "Nombre de clase requerido.";
            }
            if (!$error) {
                $clase_datos = array(
                    'menu_clase_nombre' => $nombre,
                    'menu_clase_fecha' => $fecha,
                    'menu_clase_estado' => $estado
                );
                $this->_model->crearClase($clase_datos);
                session::set("estado", "Clase Creada");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["clase"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function grupo() {
        $data["title"] = $this->_archivo["grupo"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["url"] = $this->_archivo["grupo"]["componente_url"];


        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");
            $fecha = filter_input(INPUT_POST, "fecha");
            if ($nombre === "") {
                $error[] = "Nombre de grupo requerido.";
            }
            if (!$error) {
                $grupo_datos = array(
                    'menu_grupo_nombre' => $nombre,
                    'menu_grupo_fecha' => $fecha
                );
                $this->_model->crearGrupo($grupo_datos);
                session::set("estado", "Clase Creada");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["grupo"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    function generaError($error, $mensaje) {
        $error[] = "$mensaje";
        return 0;
    }

}
