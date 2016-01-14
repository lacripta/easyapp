<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
    <head>

        <!-- Site meta -->
        <meta charset="utf-8">
        <title><?php echo $data['title'] . ' - ' . SITETITLE; //SITETITLE defined in app/core/config.php                                                                         ?></title>

        <!-- CSS -->
        <?php
        $menu = new models\admin\menu();
        $dropdowns;
        $elementos = array();
        $grupo = "";
        if (null != \helpers\session::get("usuario")) {
            foreach ($menu->getMenus(\helpers\session::get("usuario")) as $header) {
                if ($grupo == "") {
                    $grupo = $header->menu_grupo;
                    $elementos["$header->menu_clase"] .= "<li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                    //echo "blanco:$header->menu_clase: <li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                } else if ($grupo != $header->menu_grupo) {
                    $grupo = $header->menu_grupo;
                    //echo "distinto:$header->menu_clase: <li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                    $elementos["$header->menu_clase"].="<li class='divider'></li>";
                    $elementos["$header->menu_clase"] .= "<li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                } else if (($grupo == $header->menu_grupo)) {
                    //echo "igual:$header->menu_clase: <li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                    $elementos["$header->menu_clase"] .= "<li><a href='$header->menu_enlace'>$header->menu_titulo</a></li>";
                }
            }
            foreach ($menu->getClases() as $menu) {
                if (array_key_exists($menu->menu_clase_nombre, $elementos) && count($elementos["$menu->menu_clase_nombre"]) > 0) {
                    $dropdowns.="<li class='dropdown'>"
                            . "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>"
                            . "$menu->menu_clase_nombre"
                            . "<span class='caret'></span></a>"
                            . "<ul class='dropdown-menu' role='menu'>"
                            . $elementos["$menu->menu_clase_nombre"]
                            . "</ul>"
                            . "</li>";
                }
            }
        }
        helpers\assets::css(array(
            helpers\url::app_template_path() . 'css/bootstrap.min.css',
            helpers\url::app_template_path() . 'css/style.css',
            helpers\url::app_template_path() . 'css/jquery.auto-complete.css',
            helpers\url::app_template_path() . 'css/jquery.timepicker.css',
            helpers\url::app_template_path() . 'css/jsgrid.min.css',
            helpers\url::app_template_path() . 'css/roboto.min.css',
            helpers\url::app_template_path() . 'css/jsgrid-theme.min.css'
        ))
        ?>

    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-default navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#elementos-menu">
                            <span class="sr-only">Navegación</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo DIR; ?>"><img height="100%" src="/saman/img/logo.png"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="elementos-menu">
                        <ul class="nav navbar-nav">
                            <?php echo $dropdowns; ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                            if (null != \helpers\session::get("usuario")) {
                                echo "<li><a href=\"" . DIR . ADMINLOGOUT . "\">Cerrar Sesion</a></li>";
                            }
                            ?>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>