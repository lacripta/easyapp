<?php

namespace controllers\admin;

use helpers\Url,
    helpers\Session,
    core\View;

class Categoria extends \core\Controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {
        $this->_componente = new \models\admin\Componente();

        $this->_model = new \models\admin\categoria();
        $this->clase = "categoria";
        $this->_archivoNombre = "categoria.php";
        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/categoria";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestór de Categorias";
        $this->_archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "categoria_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/categoria/add";
        $this->_archivo["crear"]["componente_nombre"] = "Crear Categoria";
        $this->_archivo["crear"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "categoria_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/categoria/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Editar Categoria";
        $this->_archivo["editar"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/categoria/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Categoria";
        $this->_archivo["borrar"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["categorias"] = $this->_model->getCategorias();
        $data["js"] = "
            <script>
                function borrar_categoria(id, nombre) {
                    if (confirm('Seguro de eliminar la categoria ' + nombre)){
                        window.location.href = '" . DIR . $this->_archivo["borrar"]["componente_enlace"] . "/..' + id;
                    }
                }
            </script>";
        View::admintemplate("header", $data);
        View::render($this->_archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
    }

    public function add() {
        $data["title"] = $this->_archivo["crear"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["grupos"] = $this->_model->getGrupos();

        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre") == "" ? $error[] = "El nombre de la categoria no pueda estar vacio" : filter_input(INPUT_POST, "nombre");

            if (!$error) {
                $datos_categoria = array(
                    "documento_tipo_nombre" => $nombre
                );
                $this->_model->addCategoria($datos_categoria);
                Session::set("estado", "Se ha creado la categoria");
                Url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        View::admintemplate("header", $data);
        View::render($this->_archivo["crear"]["componente_enlace"], $data, $error);
        View::admintemplate("footer", $data);
    }

    public function edit($id) {
        $data["title"] = $this->_archivo["editar"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["grupos"] = $this->_model->getGrupos();
        $data["categoria"] = $this->_model->getCategoria($id);

        if (null != filter_input(INPUT_POST, "submit")) {
            $nombre = filter_input(INPUT_POST, "nombre");

            $nombre == "" ? $error[] = "Nombre de categoria requerido." : NULL;

            if (!$error) {
                $datos_categoria = array(
                    "documento_tipo_nombre" => $nombre
                );
                $where = array("documento_tipo_id" => $id);
                $this->_model->updateCategoria($datos_categoria, $where);
                Session::set("estado", "Se ha modificado la categoria");
                Url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }
        View::admintemplate("header", $data);
        View::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        View::admintemplate("footer", $data);
    }

    public function delete($id) {
        $data["title"] = $this->_archivo["borrar"]["componente_nombre"];
        $this->_model->deleteCategoria(array("documento_tipo_id" => $id));
        Session::set("estado", "Categoria Eliminada");
        Url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

}
