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

//create alias for Router
use core\Router,
    helpers\Url;

Router::any('', '\controllers\inicio@index');

//Panel Administrador
Router::any('admin', '\controllers\admin\admin@index');
Router::any('admin/login', '\controllers\admin\auth@login');
Router::any('admin/logout', '\controllers\admin\auth@logout');

//Administrar Usuarios
Router::any('admin/usuario', '\controllers\admin\usuario@index');
Router::any('admin/usuario/add', '\controllers\admin\usuario@add');
Router::any('admin/usuario/edit/..(:num)', '\controllers\admin\usuario@edit');
Router::any('admin/usuario/delete/..(:num)', '\controllers\admin\usuario@delete');
Router::any('admin/usuario/acceso/..(:any),(:any)', '\controllers\admin\usuario@acceso');

//Administrar Grupos
Router::any('admin/grupo', '\controllers\admin\grupo@index');
Router::any('admin/grupo/add', '\controllers\admin\grupo@add');
Router::any('admin/grupo/edit/..(:num)', '\controllers\admin\grupo@edit');
Router::any('admin/grupo/delete/..(:num)', '\controllers\admin\grupo@delete');
Router::any('admin/grupo/acceso/..(:any)', '\controllers\admin\grupo@acceso');

//Administrar Articulos
Router::any('admin/articulo', '\controllers\admin\articulo@index');
Router::any('admin/articulo/add', '\controllers\admin\articulo@add');
Router::any('admin/articulo/edit/..(:num)', '\controllers\admin\articulo@edit');
Router::any('admin/articulo/delete/..(:num)', '\controllers\admin\articulo@delete');

//Administrar Categorias
Router::any('admin/categoria', '\controllers\admin\categoria@index');
Router::any('admin/categoria/add', '\controllers\admin\categoria@add');
Router::any('admin/categoria/edit/..(:num)', '\controllers\admin\categoria@edit');
Router::any('admin/categoria/delete/..(:num)', '\controllers\admin\categoria@delete');

//Administrar Permisos
Router::any('admin/permisos', '\controllers\admin\permisos@index');
Router::any('admin/permisos/add', '\controllers\admin\permisos@add');
Router::any('admin/permisos/edit/..(:num)', '\controllers\admin\permisos@edit');
Router::any('admin/permisos/delete/..(:num)', '\controllers\admin\permisos@delete');

//Administrar Menu
Router::any('admin/menu', '\controllers\admin\menu@index');
Router::any('admin/menu/add', '\controllers\admin\menu@add');
Router::any('admin/menu/edit/..(:all)', '\controllers\admin\menu@edit');
Router::any('admin/menu/delete/..(:num)', '\controllers\admin\menu@delete');
Router::any('admin/menu/add/clase', '\controllers\admin\menu@clase');
Router::any('admin/menu/add/grupo', '\controllers\admin\menu@grupo');

//Administrador del carrusel de imagenes
Router::any('admin/carrusel', '\controllers\admin\carrusel@index');
Router::any('admin/carrusel/elementos', '\controllers\admin\carrusel@elementos');
Router::any('admin/carrusel/elemento_nuevo', '\controllers\admin\carrusel@elemento_nuevo');
Router::any('admin/carrusel/elemento_editar', '\controllers\admin\carrusel@elemento_editar');
Router::any('admin/carrusel/elemento_borrar', '\controllers\admin\carrusel@elemento_borrar');
Router::any('admin/carrusel/elemento_publicar', '\controllers\admin\carrusel@elemento_publicar');
//administrador de productos
Router::any('admin/producto', '\controllers\admin\producto@index');
Router::any('admin/producto/producto_grupo', '\controllers\admin\producto@producto_grupo');
Router::any('admin/producto/producto_categoria', '\controllers\admin\producto@producto_categoria');
Router::any('admin/producto/elementos', '\controllers\admin\producto@elementos');
Router::any('admin/producto/elemento_nuevo', '\controllers\admin\producto@elemento_nuevo');
Router::any('admin/producto/elemento_editar', '\controllers\admin\producto@elemento_editar');
Router::any('admin/producto/elemento_borrar', '\controllers\admin\producto@elemento_borrar');
Router::any('admin/producto/elemento_publicar', '\controllers\admin\producto@elemento_publicar');
Router::any('admin/producto/elemento_destacar', '\controllers\admin\producto@elemento_destacado');
Router::any('admin/producto/imagenes/..(:num)', '\controllers\admin\producto_imagen@index');
Router::any('admin/producto/imagenes/agregar_imagen', '\controllers\admin\producto_imagen@agregar_imagen');
Router::any('admin/producto/imagenes/imagenes_producto', '\controllers\admin\producto_imagen@imagenes');
Router::any('admin/producto/imagenes/publicar_imagen', '\controllers\admin\producto_imagen@imagen_publicar');
Router::any('admin/producto/imagenes/borrar/..(:num)', '\controllers\admin\producto_imagen@imagen_borrar');
//administrador de novedades
Router::any('admin/novedades', '\controllers\admin\novedades@index');
Router::any('admin/novedades/elementos', '\controllers\admin\novedades@elementos');
Router::any('admin/novedades/elemento_nuevo', '\controllers\admin\novedades@add');
Router::any('admin/novedades/elemento_editar', '\controllers\admin\novedades@edit');
Router::any('admin/novedades/elemento_publicar', '\controllers\admin\novedades@publicar');
Router::any('admin/novedades/elemento_destacar', '\controllers\admin\novedades@destacar');
Router::any('admin/novedades/elemento_borrar', '\controllers\admin\novedades@delete');
//DATA FEED DE EASYART
Router::any('admin/producto/lista', '\controllers\admin\data_feed@productos');
Router::any('admin/producto/lista_orden', '\controllers\admin\data_feed@productos_ordenados');
Router::any('admin/producto/categorias', '\controllers\admin\data_feed@categorias');
Router::any('admin/producto/grupos', '\controllers\admin\data_feed@grupos');
Router::any('admin/producto/filtro_productos', '\controllers\admin\data_feed@filtro_productos');
Router::any('admin/producto/productos_categoria', '\controllers\admin\data_feed@productos_categoria');
Router::any('admin/producto/detalles_producto', '\controllers\admin\data_feed@detalles_producto');
Router::any('admin/producto/carrusel', '\controllers\admin\data_feed@galeria');
Router::any('admin/novedades/publicas', '\controllers\admin\data_feed@novedades');


//if no route found
Router::error('\core\error@index');
//crear los permisos de administrador para el primer uso del sistema
Router::any('instalacion/administrador', '\controllers\admin\iniciar@index');
Router::any('pdf', '\controllers\pdf@index');
Router::any('mpdf', '\controllers\pdf@mensual');
//turn on old style routing
Router::$fallback = false;

//execute matched routes
Router::dispatch();

