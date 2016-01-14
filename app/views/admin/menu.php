<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . $data["raiz"]; ?>">Menu</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\session::pull("estado") . "</h3>"; ?>
<a href="<?php echo DIR . $data["raiz"]; ?>/add" class="btn btn-info">Crear Nuevo</a>
<a href="<?php echo DIR . $data["raiz"]; ?>/add/clase" class="btn btn-info">Crear Clase</a>
<a href="<?php echo DIR . $data["raiz"]; ?>/add/grupo" class="btn btn-info">Crear Grupo</a>
<p><br></p>
<?php
$archivos [] = array();
$listas = array();
$tmp = "";
foreach ($data["menus"] as $archivo) {
    if (!in_array($archivo->menu_clase, $archivos)) {
        $archivos[] = $archivo->menu_clase;
        $listas["$archivo->menu_clase"] = "";
    }
}
foreach ($archivos as $file) {
    if (is_string($file)) {
        $nombre = ucfirst(str_replace(".php", "", $file));
        $listas["$file"] .= "<div class='panel-group' role='tablist'>"
                . "<div class='panel panel-default'>"
                . "<div class='panel-heading' role='tab' id='h$nombre'>"
                . "<h4 class='panel-title' id='-collapsible-list-group-'>"
                . "<a class='' data-toggle='collapse' href='#$nombre' aria-controls='$nombre'>"
                . "$nombre"
                . "</a>"
                . "<a class='anchorjs-link' href='#-collapsible-list-group-'><span class='anchorjs-icon'></span></a></h4>"
                . "</div>"
                . "<div id='$nombre' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='h$nombre'>"
                . "<ul class='list-group'>";

        foreach ($data["menus"] as $elemento) {
            if ($elemento->menu_clase == $file) {
                $listas["$file"] .= "<li class = 'list-group-item'>"
                        . "<div class='row'>"
                        . "<div class='col-sm-1' style='font-size:12px'>$elemento->menu_id</div>"
                        . "<div class='col-sm-3' style='font-size:12px'>$elemento->menu_titulo</div>"
                        . "<div class='col-sm-4'><a href='" . $elemento->componente_url . "' target='blank'>$elemento->componente_enlace</a></div>";
                $checked = $elemento->componente_estado ? "glyphicon glyphicon-ok-circle text-success" : "glyphicon glyphicon-remove-circle text-danger";
                $listas["$file"] .= "<div class='col-sm-1'><span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span></div>";
                if ($elemento->permisos_usuario_estado) {
                    $checked = "checked";
                    $active = "btn-success";
                } else {
                    $checked = "";
                    $active = "btn-warning";
                }
                $listas["$file"] .= "<div class='col-sm-3'>"
                        . "<div class='checkbox'>"
                        . "<label>"
                        . "<div class='btn-group'>"
                        . "<a class='btn btn-sm btn-success' href='$data[editar]..$elemento->menu_titulo'>Editar</a>"
                        . "<a class='btn btn-sm btn-danger' onclick='borrar_menu(\"$elemento->menu_id\", \"$elemento->menu_titulo\");'>Quitar</a>"
                        . "</div>"
                        . "</label>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</li>";
            }
        }

        $listas["$file"] .= "</ul>"
                . "<div class='panel-footer'></div>"
                . "</div>"
                . "</div>"
                . "</div>";
    }
}
foreach ($archivos as $vistas) {
    if (is_string($vistas)) {
        if ($vistas == $archivos[1]) {
            $primero = "active";
        } else {
            $primero = "";
        }
        $nombre = ucfirst(str_replace(".php", "", $vistas));
        $nombre = str_replace(" ", "_", $nombre);
        $tablist .= "<li role='presentation' class='$primero'>"
                . "<a href='#t$nombre' aria-controls='t$nombre' role='tab' data-toggle='tab'>"
                . "$nombre"
                . "</a>"
                . "</li>";
        $tabpanel .= "<div role='tabpanel' class='tab-pane $primero' id='t$nombre'>"
                . $listas["$vistas"]
                . "</div>";
    }
}
?>
    <div role='tabpanel' class='well container'>
        <ul class='nav nav-pills nav-stacked col-sm-3' role='tablist'>
            <?php echo $tablist; ?>
        </ul>
        <div class='tab-content col-sm-9'>
            <?php echo $tabpanel; ?>
        </div>
    </div>
