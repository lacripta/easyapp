<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["raiz"]; ?>">Grupos</a></li>
    <li><?php echo $data["title"]; ?></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\Session::pull("estado") . "</h3>"; ?>
<p><br></p>
<?php
$archivos [] = array();
$listas = array();
$tmp = "";
foreach ($data["componentes"] as $archivo) {
    if (!in_array($archivo->componente_archivo, $archivos)) {
        $archivos[] = $archivo->componente_archivo;
        $listas["$archivo->componente_archivo"] = "";
    }
}
foreach ($archivos as $file) {
    if (is_string($file)) {
        $nombre = ucfirst(str_replace(".php", "", $file));
        $listas["$file"] .= "<div class='panel-group col-sm-12' role='tablist'>"
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

        foreach ($data["componentes"] as $elemento) {
            if ($elemento->componente_archivo == $file) {
                $listas["$file"] .= "<li class = 'list-group-item'>"
                        . "<div class='row'>"
                        . "<div class='col-md-1 col-sm-1' style='font-size:12px'>$elemento->componente_id</div>"
                        . "<div class='col-md-4 col-sm-4' style='font-size:12px'>$elemento->componente_nombre</div>"
                        . "<div class='col-md-4 col-sm-4'><a href='" . $elemento->componente_url . "' target='blank'>$elemento->componente_enlace</a></div>";
                $checked = $elemento->componente_estado ? "glyphicon glyphicon-ok-circle text-success" : "glyphicon glyphicon-remove-circle text-danger";
                $listas["$file"] .= "<div class='col-md-1 col-sm-1'><span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span></div>";
                if ($elemento->permisos_grupo_estado) {
                    $checked = "checked";
                    $active = "btn-success";
                } else {
                    $checked = "";
                    $active = "btn-warning";
                }
                $listas["$file"] .= ""
                        . "<div class='col-md-2 col-sm-2'>"
                        . "<div class='togglebutton'>
                            <label>
                                <input $checked type='checkbox' name='estado' onchange='cambiar_estado(this, $elemento->componente_id);'>
                            </label>
                        </div>"
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
<div class='well'>
    <div class='container'>
        <div role='tabpanel'>
            <ul class='nav nav-pills nav-stacked col-sm-4' role='tablist'>
                <?php echo $tablist; ?>
            </ul>
            <div class='tab-content col-sm-8'>
                <?php echo $tabpanel; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function cambiar_estado(obj, id) {
        if (obj.checked) {
            $.ajax({
                async: true,
                cache: false,
                url: '<?php echo DIR . ADMIN; ?>permisos/edit/..' + id,
                data: {
                    grupo: '<?php echo $data["grupo"]; ?>',
                    estado: 1
                },
                type: "POST",
                dataType: 'text',
                success: function (json, status, xhr) {
                    $(obj).removeClass("btn-warning");
                    $(obj).addClass("btn-success");
                }
            });
        } else if (!obj.checked) {
            $.ajax({
                async: true,
                cache: false,
                url: '<?php echo DIR . ADMIN; ?>permisos/edit/..' + id,
                data: {
                    grupo: '<?php echo $data["grupo"]; ?>',
                    estado: 0
                },
                type: "POST",
                dataType: 'text',
                success: function (json, status, xhr) {
                    $(obj).removeClass("btn-success");
                    $(obj).addClass("btn-warning");
                }
            });
        }
    }
</script>
