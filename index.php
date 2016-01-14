<?php

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

if (!is_readable('app/core/config.php')) {
    die('No config.php found, configure and rename config.example.php to config.php in app/core.');
}

/*
 * ---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 * ---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
define('ENVIRONMENT', 'development');
/*
 * ---------------------------------------------------------------
 * ERROR REPORTING
 * ---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */

if (defined('ENVIRONMENT')) {

    switch (ENVIRONMENT) {
        case 'development':
            error_reporting(E_ALL);
            break;

        case 'production':
            error_reporting(0);
            break;

        default:
            exit('The application environment is not set correctly.');
    }
}

//initiate config
new \core\config();

//create alias for router
use core\router,
    helpers\url;

router::any('', '\controllers\inicio@index');

//Panel Administrador
router::any('admin', '\controllers\admin\admin@index');
router::any('admin/login', '\controllers\admin\auth@login');
router::any('admin/logout', '\controllers\admin\auth@logout');

//Administrar Usuarios
router::any('admin/usuario', '\controllers\admin\usuario@index');
router::any('admin/usuario/add', '\controllers\admin\usuario@add');
router::any('admin/usuario/edit/..(:num)', '\controllers\admin\usuario@edit');
router::any('admin/usuario/delete/..(:num)', '\controllers\admin\usuario@delete');
router::any('admin/usuario/acceso/..(:any),(:any)', '\controllers\admin\usuario@acceso');

//Administrar Grupos
router::any('admin/grupo', '\controllers\admin\grupo@index');
router::any('admin/grupo/add', '\controllers\admin\grupo@add');
router::any('admin/grupo/edit/..(:num)', '\controllers\admin\grupo@edit');
router::any('admin/grupo/delete/..(:num)', '\controllers\admin\grupo@delete');
router::any('admin/grupo/acceso/..(:any)', '\controllers\admin\grupo@acceso');

//Administrar Articulos
router::any('admin/articulo', '\controllers\admin\articulo@index');
router::any('admin/articulo/add', '\controllers\admin\articulo@add');
router::any('admin/articulo/edit/..(:num)', '\controllers\admin\articulo@edit');
router::any('admin/articulo/delete/..(:num)', '\controllers\admin\articulo@delete');

//Administrar Categorias
router::any('admin/categoria', '\controllers\admin\categoria@index');
router::any('admin/categoria/add', '\controllers\admin\categoria@add');
router::any('admin/categoria/edit/..(:num)', '\controllers\admin\categoria@edit');
router::any('admin/categoria/delete/..(:num)', '\controllers\admin\categoria@delete');

//Administrar Permisos
router::any('admin/permisos', '\controllers\admin\permisos@index');
router::any('admin/permisos/add', '\controllers\admin\permisos@add');
router::any('admin/permisos/edit/..(:num)', '\controllers\admin\permisos@edit');
router::any('admin/permisos/delete/..(:num)', '\controllers\admin\permisos@delete');

//Administrar Menu
router::any('admin/menu', '\controllers\admin\menu@index');
router::any('admin/menu/add', '\controllers\admin\menu@add');
router::any('admin/menu/edit/..(:all)', '\controllers\admin\menu@edit');
router::any('admin/menu/delete/..(:num)', '\controllers\admin\menu@delete');
router::any('admin/menu/add/clase', '\controllers\admin\menu@clase');
router::any('admin/menu/add/grupo', '\controllers\admin\menu@grupo');

//Administrador del carrusel de imagenes
router::any('admin/carrusel', '\controllers\admin\carrusel@index');
router::any('admin/carrusel/elementos', '\controllers\admin\carrusel@elementos');
router::any('admin/carrusel/elemento_nuevo', '\controllers\admin\carrusel@elemento_nuevo');
router::any('admin/carrusel/elemento_editar', '\controllers\admin\carrusel@elemento_editar');
router::any('admin/carrusel/elemento_borrar', '\controllers\admin\carrusel@elemento_borrar');
router::any('admin/carrusel/elemento_publicar', '\controllers\admin\carrusel@elemento_publicar');
//administrador de productos
router::any('admin/producto', '\controllers\admin\producto@index');
router::any('admin/producto/producto_grupo', '\controllers\admin\producto@producto_grupo');
router::any('admin/producto/producto_categoria', '\controllers\admin\producto@producto_categoria');
router::any('admin/producto/elementos', '\controllers\admin\producto@elementos');
router::any('admin/producto/elemento_nuevo', '\controllers\admin\producto@elemento_nuevo');
router::any('admin/producto/elemento_editar', '\controllers\admin\producto@elemento_editar');
router::any('admin/producto/elemento_borrar', '\controllers\admin\producto@elemento_borrar');
router::any('admin/producto/elemento_publicar', '\controllers\admin\producto@elemento_publicar');
router::any('admin/producto/elemento_destacar', '\controllers\admin\producto@elemento_destacado');
router::any('admin/producto/imagenes/..(:num)', '\controllers\admin\producto_imagen@index');
router::any('admin/producto/imagenes/agregar_imagen', '\controllers\admin\producto_imagen@agregar_imagen');
router::any('admin/producto/imagenes/imagenes_producto', '\controllers\admin\producto_imagen@imagenes');
router::any('admin/producto/imagenes/publicar_imagen', '\controllers\admin\producto_imagen@imagen_publicar');
router::any('admin/producto/imagenes/borrar/..(:num)', '\controllers\admin\producto_imagen@imagen_borrar');
//administrador de novedades
router::any('admin/novedades', '\controllers\admin\novedades@index');
router::any('admin/novedades/elementos', '\controllers\admin\novedades@elementos');
router::any('admin/novedades/elemento_nuevo', '\controllers\admin\novedades@add');
router::any('admin/novedades/elemento_editar', '\controllers\admin\novedades@edit');
router::any('admin/novedades/elemento_publicar', '\controllers\admin\novedades@publicar');
router::any('admin/novedades/elemento_destacar', '\controllers\admin\novedades@destacar');
router::any('admin/novedades/elemento_borrar', '\controllers\admin\novedades@delete');
//estilos de la pagina principal
router::any('admin/estilos', '\controllers\admin\estilos@index');
router::any('admin/estilos/cambiar', '\controllers\admin\estilos@cambiar');

//DATA FEED DE EASYART
router::any('admin/producto/lista', '\controllers\admin\data_feed@productos');
router::any('admin/producto/lista_orden', '\controllers\admin\data_feed@productos_ordenados');
router::any('admin/producto/categorias', '\controllers\admin\data_feed@categorias');
router::any('admin/producto/grupos', '\controllers\admin\data_feed@grupos');
router::any('admin/producto/filtro_productos', '\controllers\admin\data_feed@filtro_productos');
router::any('admin/producto/productos_categoria', '\controllers\admin\data_feed@productos_categoria');
router::any('admin/producto/detalles_producto', '\controllers\admin\data_feed@detalles_producto');
router::any('admin/producto/carrusel', '\controllers\admin\data_feed@galeria');
router::any('admin/novedades/publicas', '\controllers\admin\data_feed@novedades');
router::any('admin/estilos/actual', '\controllers\admin\data_feed@estilos');


//if no route found
router::error('\core\error@index');
//crear los permisos de administrador para el primer uso del sistema
router::any('instalacion/administrador', '\controllers\admin\iniciar@index');
router::any('pdf', '\controllers\pdf@index');
router::any('mpdf', '\controllers\pdf@mensual');
//turn on old style routing
router::$fallback = false;

//execute matched routes
router::dispatch();

