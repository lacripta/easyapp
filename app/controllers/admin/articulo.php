<?php

namespace controllers\admin;

use helpers\Url,
    helpers\Session,
    core\View;

class Articulo extends \core\Controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {
        $this->_componente = new \models\admin\Componente();
        $this->_model = new \models\admin\articulo();

        $this->clase = "articulo";
        $this->_archivoNombre = "articulo.php";

        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . $this->clase;
        $this->_archivo["raiz"]["componente_url"] = DIR . "admin/articulo";
        $this->_archivo["raiz"]["componente_nombre"] = "Gestor de Articulos";
        $this->_archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_archivo["crear"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["crear"]["componente_enlace"] = ADMIN . "articulo_crear";
        $this->_archivo["crear"]["componente_url"] = DIR . "admin/articulo/add";
        $this->_archivo["crear"]["componente_nombre"] = "Agregar Articulo";
        $this->_archivo["crear"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["crear"]["componente_nombre"]);

        $this->_archivo["editar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["editar"]["componente_enlace"] = ADMIN . "articulo_editar";
        $this->_archivo["editar"]["componente_url"] = DIR . "admin/articulo/edit/";
        $this->_archivo["editar"]["componente_nombre"] = "Modificar Articulo";
        $this->_archivo["editar"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["editar"]["componente_nombre"]);

        $this->_archivo["borrar"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["borrar"]["componente_enlace"] = ADMIN . $this->clase . "/delete";
        $this->_archivo["borrar"]["componente_url"] = DIR . "admin/articulo/delete/";
        $this->_archivo["borrar"]["componente_nombre"] = "Eliminar Articulo";
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
        $data["articulos"] = $this->_model->getArticulos();
        $data["js"] = "
            <script>
                function borrar_articulo(id, titulo) {
                    if (confirm('Seguro que va a eliminar el articulo ' + titulo)){
                        window.location.href = '" . $this->_archivo["borrar"]["componente_url"] . "..' + id;
                    }
                }
            </script>";

        View::admintemplate("header", $data);
        View::render($this->_archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
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
            $autor = Session::get("usuario");
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
                $slug = Url::generateSafeSlug($titulo);
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
                Session::set("estado", "Articulo Creado");
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
            $autor = Session::get("usuario");
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
                $slug = Url::generateSafeSlug($titulo);
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
                Session::set("estado", "Articulo Modificado");
                Url::redirect($this->_archivo["raiz"]["componente_enlace"]);
            }
        }

        View::admintemplate("header", $data);
        View::render($this->_archivo["editar"]["componente_enlace"], $data, $error);
        View::admintemplate("footer", $data);
    }

    public function delete($id) {
        $data["title"] = $this->_archivo["borrar"]["componente_nombre"];
        $datos = array("articulo_id" => $id);
        $this->_model->deleteArticulo($datos);
        Session::set("estado", "Articulo Eliminado");
        Url::redirect($this->_archivo["raiz"]["componente_enlace"]);
    }

}
