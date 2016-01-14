<?php

namespace controllers\admin;

use helpers\password,
    \helpers\session,
    helpers\url,
    core\view;

class Auth extends \core\controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {

        $this->clase = "auth";
        $this->_archivoNombre = "auth.php";

        $this->_model = new \models\admin\auth();
        $this->_componente = new \models\admin\componente();

        $this->_archivo["login"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["login"]["componente_enlace"] = ADMINLOGIN;
        $this->_archivo["login"]["componente_url"] = DIR . "admin/login";
        $this->_archivo["login"]["componente_nombre"] = "Control de Inicio de Sesion";
        $this->_archivo["login"]["componente_slug"] = url::generateSafeSlug($this->_archivo["login"]["componente_nombre"]);

        $this->_archivo["logout"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["logout"]["componente_enlace"] = ADMINLOGOUT;
        $this->_archivo["logout"]["componente_url"] = DIR . "admin/logout";
        $this->_archivo["logout"]["componente_nombre"] = "Cierre de Sesion";
        $this->_archivo["logout"]["componente_slug"] = url::generateSafeSlug($this->_archivo["logout"]["componente_nombre"]);
    }

    public function login() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data['title'] = $this->_archivo["login"]["componente_nombre"];

        if (session::get("autenticado")) {
            url::redirect(ADMIN);
        }
        if (null != filter_input(INPUT_POST, "submit")) {
            $usuario = filter_input(INPUT_POST, "usuario");
            $clave = filter_input(INPUT_POST, "clave");
            $userData = $this->_model->getClaveHash($usuario);
            if ($usuario === "") {
                $error[] = "El usuario no puede estar en blanco.";
            }
            if ($clave === "") {
                $error[] = "La clave no puede estar en blanco.";
            }

            if ($usuario == "" || $clave == "") {
                $error[] = "No pueden haber campos en blanco.";
            } else if ($userData[0]->usuario_estado != "1") {
                $error[] = "Esa cuenta fue deshabilitada por el Administrador.";
            } else if ($usuario != "" && $clave != "" && password::verify($clave, $userData[0]->usuario_clave)) {
                session::set("autenticado", true);
                session::set("usuario", $userData[0]->usuario_sid);
                session::set("grupo", $userData[0]->usuario_grupo);
                session::set("nombre", $userData[0]->usuario_nombre . " " . $userData[0]->usuario_apellido);
                session::set("email", $userData[0]->usuario_email);
                session::set("estado", $userData[0]->usuario_estado);
                url::redirect(ADMIN);
            } else {
                $error[] = "Credenciales de Acceso incorrectas.";
            }
        }
        view::admintemplate("header", $data);
        view::render(ADMINLOGIN, $data, $error);
        view::admintemplate("footer", $data);
    }

    public function logout() {
        session::destroy("autenticado");
        session::destroy("usuario");
        url::redirect(ADMINLOGIN);
    }

}
