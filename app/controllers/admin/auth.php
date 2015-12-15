<?php

namespace controllers\admin;

use helpers\Password,
    helpers\Session,
    helpers\Url,
    core\View;

class Auth extends \core\Controller {

    private $_model;
    private $_componente;
    private $_archivo;
    private $_archivoNombre;
    public $clase;

    public function __construct() {

        $this->clase = "auth";
        $this->_archivoNombre = "auth.php";

        $this->_model = new \models\admin\auth();
        $this->_componente = new \models\admin\Componente();

        $this->_archivo["login"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["login"]["componente_enlace"] = ADMINLOGIN;
        $this->_archivo["login"]["componente_url"] = DIR . "admin/login";
        $this->_archivo["login"]["componente_nombre"] = "Control de Inicio de Sesion";
        $this->_archivo["login"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["login"]["componente_nombre"]);

        $this->_archivo["logout"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["logout"]["componente_enlace"] = ADMINLOGOUT;
        $this->_archivo["logout"]["componente_url"] = DIR . "admin/logout";
        $this->_archivo["logout"]["componente_nombre"] = "Cierre de Sesion";
        $this->_archivo["logout"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["logout"]["componente_nombre"]);
    }

    public function login() {
        foreach ($this->_archivo as $componente) {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data['title'] = $this->_archivo["login"]["componente_nombre"];

        if (Session::get("autenticado")) {
            Url::redirect(ADMIN);
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
            } else if ($usuario != "" && $clave != "" && Password::verify($clave, $userData[0]->usuario_clave)) {
                Session::set("autenticado", true);
                Session::set("usuario", $userData[0]->usuario_sid);
                Session::set("grupo", $userData[0]->usuario_grupo);
                Session::set("nombre", $userData[0]->usuario_nombre . " " . $userData[0]->usuario_apellido);
                Session::set("email", $userData[0]->usuario_email);
                Session::set("estado", $userData[0]->usuario_estado);
                Url::redirect(ADMIN);
            } else {
                $error[] = "Credenciales de Acceso incorrectas.";
            }
        }
        View::admintemplate("header", $data);
        View::render(ADMINLOGIN, $data, $error);
        View::admintemplate("footer", $data);
    }

    public function logout() {
        Session::destroy("autenticado");
        Session::destroy("usuario");
        Url::redirect(ADMINLOGIN);
    }

}
