<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . $data["raiz"]; ?>">Usuarios</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\Session::pull("estado") . "</h3>"; ?>
<a href="<?php echo DIR . $data["raiz"]; ?>/add" class="btn btn-info">Crear Nuevo</a>
<p><br></p>
<table class="table table-striped table-hover table-bordered responsive">
    <tr>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>E-Mail</th>
        <th>Grupo</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>
    <?php
    if ($data["usuarios"]) {
        foreach ($data["usuarios"] as $registro) {
            echo "<tr>";
            echo "<td>$registro->usuario_sid</td>";
            echo "<td>$registro->usuario_nombre $registro->usuario_apellido</td>";
            echo "<td>$registro->usuario_email</td>";
            echo "<td>$registro->usuario_grupo</td>";
            $checked = $registro->usuario_estado ? "glyphicon glyphicon-ok-circle text-success" : "glyphicon glyphicon-remove-circle text-danger";
            echo "<td align='center'>"
            . "<span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span>"
            . "</td>";
            echo "<td>"
            . "<div class='btn-group btn-group btn-group-sm'>"
            . "<a class='btn btn-success' href='" . DIR . $data["raiz"] . "/edit/..$registro->usuario_id'>Editar</a> "
            . "<a class='btn btn-warning' href='" . DIR . $data["raiz"] . "/acceso/..$registro->usuario_sid,$registro->usuario_grupo'>Permisos</a> "
            . "<a class='btn btn-primary' href='javascript:borrar_usuario(\"$registro->usuario_id\",\"$registro->usuario_sid\");'>Borrar</a>"
            . "</div>"
            . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
