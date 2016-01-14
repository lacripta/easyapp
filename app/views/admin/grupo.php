<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["raiz"]; ?>">Grupos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\session::pull("estado") . "</h3>"; ?>
<a href="<?php echo $data["crear"]; ?>" class="btn btn-info">Crear Nuevo</a>
<p><br></p>
<table class="table table-striped table-hover table-bordered responsive">
    <tr>
        <th>SID</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Accion</th>
    </tr>
    <?php
    if ($data["grupos"]) {
        foreach ($data["grupos"] as $registro) {
            echo "<tr>";
            echo "<td>$registro->grupo_id</td>";
            echo "<td>$registro->grupo_nombre</td>";
            echo "<td>$registro->grupo_fecha</td>";
            $checked = $registro->grupo_estado ? "glyphicon glyphicon-ok-circle text-success" : "glyphicon glyphicon-remove-circle text-danger";
            echo "<td align='center'>"
            . "<span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span>"
            . "</td>";
            echo "<td>"
            . "<div class='btn-group btn-group btn-group-sm'>"
            . "<a class='btn btn-success' href='" . $data["raiz"] . "/edit/..$registro->grupo_id'>Editar</a> "
            . "<a class='btn btn-warning' href='" . $data["raiz"] . "/acceso/..$registro->grupo_nombre'>Permisos</a> "
            . "<a class='btn btn-primary' href='javascript:borrar_grupo(\"$registro->grupo_id\",\"$registro->grupo_nombre\");'>Borrar</a>"
            . "</div>"
            . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

