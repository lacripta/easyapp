<?php

namespace controllers\admin;

use helpers\url,
    \helpers\session,
    core\view;

class Articulo extends \core\controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {
        $this->_componente = new \models\admin\componente();
        $this->_model = new \models\admin\articulo();

        $this->clase = "articulo";
        $this->_archivoNombre = "articulo.php";

        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/articulo";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestor de Articulos";
        $this->_archivo["raiz"]["componente_slug"] = url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "articulo_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/articulo/add";
        $this->_archivo["crear"]["componente_nombre"] = "Agregar Articulo";
        $this->_archivo["crear"]["componente_slug"] = url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "articulo_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/articulo/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Modificar Articulo";
        $this->_archivo["editar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/articulo/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Articulo";
        $this->_archivo["borrar"]["componente_slug"] = url::generateSafeSlug($this->_archivo["borrar"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["articulos"] = $this->_model->getArticulos();
        $data["js"] = "
            <script>
                function borrar_articulo(id, titulo) {
                    if (confirm('Seguro que va a eliminar el articulo ' + titulo)){
                        window.location.href = '" . $this->_archivo["borrar"]["componente_url"] . "..' + id;
                    }
                }
            </script>";

        view::admintemplate("header", $data);
        view::render($this->_archivo["raiz"]["componente_enlace"], $data);
        view::admintemplate("footer", $data);
    }

    public function add() {
        $data["js"] = "<script type='text/javascript'>"
                . "bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });"
                . "</script>";
        $data["title"] = $this->_archivo["crear"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;

        if (null != filter_input(INPUT_POST, "submit")) {
            $titulo = filter_input(INPUT_POST, "titulo");
            $contenido = filter_input(INPUT_POST, "contenido");
            $descripcion = filter_input(INPUT_POST, "descripcion");
            $fecha = filter_input(INPUT_POST, "fecha");
            $publicado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            $favorito = filter_input(INPUT_POST, "especial") ? 1 : 0;
            $autor = session::get("usuario");
            if ($titulo === "") {
                $error[] = "$publicado";
            }
            $allowedExts = array("gif", "jpeg", "jpg", "png", "svg");
            $temp = explode(".", $_FILES["image"]["name"]);
            $extension = strtolower(end($temp));
            if ($_FILES["image"]["size"] > 0 && !in_array($extension, $allowedExts)) {
                $error[] = "Tipo de imagen no Soportado.";
            }
            if (!$error) {
                $slug = url::generateSafeSlug($titulo);
                $articulo_datos = array(
                    'articulo_titulo' => $titulo,
                    'articulo_contenido' => $contenido,
                    'articulo_descripcion' => $descripcion,
                    'articulo_fecha' => $fecha,
                    'articulo_estado' => $publicado,
                    'articulo_especial' => $favorito,
                    'articulo_autor' => $autor,
                    'articulo_slug' => $slug
                );
                if ($_FILES["image"]["size"] > 0) {
                    $file = ARTICULOIMG . $_FILES["image"]["name"];
                    move_uploaded_file($_FILES["image"]["tmp_name"], $file);
                    $articulo_datos["articulo_image"] = $file;
                }
                $this->_model->addArticulo($articulo_datos);
                session::set("estado", "Articulo Creado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["crear"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function edit($id) {
        $data["title"] = $this->_archivo["editar"]["componente_nombre"];
        $data["raiz"] = $this->_archivo["raiz"]["componente_enlace"];
        $data["clase"] = $this->clase;
        $data["articulo"] = $this->_model->getArticulo($id);
        $data["js"] = "<script type='text/javascript'>"
                . "bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });"
                . "</script>";

        if (null != filter_input(INPUT_POST, "submit")) {
            $titulo = filter_input(INPUT_POST, "titulo");
            $contenido = filter_input(INPUT_POST, "contenido");
            $descripcion = filter_input(INPUT_POST, "descripcion");
            $fecha = filter_input(INPUT_POST, "fecha");
            $publicado = filter_input(INPUT_POST, "estado") ? 1 : 0;
            $favorito = filter_input(INPUT_POST, "especial") ? 1 : 0;
            $autor = session::get("usuario");
            if ($titulo === "") {
                $error[] = "$publicado";
            }
            $allowedExts = array("gif", "jpeg", "jpg", "png", "svg");
            $temp = explode(".", $_FILES["image"]["name"]);
            $extension = strtolower(end($temp));
            if ($_FILES["image"]["size"] > 0 && !in_array($extension, $allowedExts)) {
                $error[] = "Tipo de imagen no Soportado.";
            }
            if ($_FILES["image"]["size"] / 1024 > 500) {
                $error[] = "Archivo de imagen mayor a 500 KB.";
            }
            if (!$error) {
                $slug = url::generateSafeSlug($titulo);
                $articulo_datos = array(
                    'articulo_titulo' => $titulo,
                    'articulo_contenido' => $contenido,
                    'articulo_descripcion' => $descripcion,
                    'articulo_fecha' => $fecha,
                    'articulo_estado' => $publicado,
                    'articulo_especial' => $favorito,
                    'articulo_autor' => $autor,
                    'articulo_slug' => $slug
                );
                if ($_FILES["image"]["size"] > 0) {
                    $file = ARTICULOIMG . $_FILES["image"]["name"];
                    move_uploaded_file($_FILES["image"]["tmp_name"], $file);
                    $articulo_datos["articulo_image"] = $file;
                }
                $where = array(
                    "articulo_id" => $id
                );
                $this->_model->updateArticulo($articulo_datos, $where);
                session::set("estado", "Articulo Modificado");
                url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        view::admintemplate("header", $data);
        view::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        view::admintemplate("footer", $data);
    }

    public function delete($id) {
        $data["title"] = $this->_archivo["borrar"]["componente_nombre"];
        $datos = array("articulo_id" => $id);
        $this->_model->deleteArticulo($datos);
        session::set("estado", "Articulo Eliminado");
        url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

}
