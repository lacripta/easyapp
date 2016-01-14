<?php

namespace core;

/*
 * config - an example for setting up system settings
 * When you are done editing, rename this file to 'config.php'
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.1
 * @date June 27, 2014
 */

class Config {

    public function __construct() {

        //turn on output buffering
        ob_start();

        //site address
        define('DIR', 'http://easyart.com.co/easyapp/');

        //set default controller and method for legacy calls
        define('DEFAULT_CONTROLLER', 'inicio');
        define('DEFAULT_METHOD', 'index');

        //set a default language
        define('LANGUAGE_CODE', 'en');

        //database details ONLY NEEDED IF USING A DATABASE
        define('DB_TYPE', 'mysql');
        define('DB_HOST', 'mysql.hostinger.co');
        define('DB_NAME', 'u555867697_ea');
        define('DB_USER', 'u555867697_ea');
        define('DB_PASS', 'julylau2015');
        define('PREFIX', 'gd_');

        //set prefix for sessions
        define('SESSION_PREFIX', 'gd_');

        //optionall create a constant for the name of the site
        define('SITETITLE', 'EasyArt');
        define('ARTICULOIMG', 'img/posts/');
        define('ADMINLOGIN', 'admin/login');
        define('ADMINLOGOUT', 'admin/logout');
        define('ADMIN', 'admin/');
        define('APP', 'app/');

        //turn on custom error handling
        set_exception_handler('core\logger::exception_handler');
        set_error_handler('core\logger::error_handler');

        //set timezone
        date_default_timezone_set('America/Bogota');

        //start sessions
        \helpers\session::init();

        //set the default template
        \helpers\session::set('template', 'default');
    }

}
