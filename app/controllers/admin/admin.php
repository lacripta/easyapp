<?php

namespace controllers\admin;

use \helpers\Session,
    \helpers\Url,
    \core\View;

class Admin extends \core\Controller
{

    private $_componente;
    private $_archivoNombre;
    private $_model;
    private $_archivo;

    public function __construct()
    {
        $this->_componente = new \models\admin\Componente();
        $this->_model = new \models\admin\auth();

        $this->clase = "admin";
        $this->_archivoNombre = "admin.php";
        $this->_archivo["raiz"]["componente_archivo"] = $this->_archivoNombre;
        $this->_archivo["raiz"]["componente_enlace"] = ADMIN . "admin";
        $this->_archivo["raiz"]["componente_url"] = DIR . ADMIN;
        $this->_archivo["raiz"]["componente_nombre"] = "Panel de Control del Sistema";
        $this->_archivo["raiz"]["componente_slug"] = Url::generateSafeSlug($this->_archivo["raiz"]["componente_nombre"]);

        $this->_componente->controlAcceso();
    }

    public function index()
    {
        foreach ($this->_archivo as $componente)
        {
            $this->_componente->createComponente($componente["componente_nombre"], $componente["componente_enlace"], $componente["componente_url"], $componente);
        }
        $data["title"] = $this->_archivo["raiz"]["componente_nombre"];
        $data["usuarios"] = $this->_componente->getEnlace("admin/usuario");
        $data["articulos"] = $this->_componente->getEnlace("admin/articulo");

        View::admintemplate("header", $data);
        View::render($this->_archivo["raiz"]["componente_enlace"], $data);
        View::admintemplate("footer", $data);
    }

}
