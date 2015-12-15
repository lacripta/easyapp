<ol class="breadcrumb">
    <li><a href="<?php echo DIR; ?>admin/">Inicio</a></li>
    <li><a href="<?php echo DIR; ?>admin/categoria">Categorias</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\Session::pull("estado") . "</h3>"; ?>
<a href="<?php echo DIR; ?>admin/categoria/add" class="btn btn-info">Crear Nuevo</a>
<p><br></p>
<table class="table table-striped table-hover table-bordered responsive">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Orden</th>
        <th>Visible</th>
        <th>Grupo</th>
        <th>Propietario</th>
        <th>Acción</th>
    </tr>
    <?php
    if ($data["categorias"]) {
        foreach ($data["categorias"] as $registro) {
            echo "<tr>";
            echo "<td>$registro->categoria_id</td>";
            echo "<td>$registro->categoria_nombre</td>";
            echo "<td>$registro->categoria_orden</td>";
            $checked = $registro->categoria_estado ? "glyphicon glyphicon-ok-circle text-success" : "glyphicon glyphicon-remove-circle text-danger";
            echo "<td align='center'>"
            . "<span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span>"
            . "</td>";
            echo "<td>$registro->categoria_grupo</td>";
            echo "<td>$registro->categoria_propietario</td>";
            echo "<td>"
            . "<div class='btn-group btn-group btn-group-sm'>"
            . "<a class='btn btn-success' href='" . DIR . "admin/categoria/edit/..$registro->categoria_id'>Editar</a> "
            . "<a class='btn btn-primary' href='javascript:borrar_categoria(\"$registro->categoria_id\",\"$registro->categoria_nombre\");'>Borrar</a>"
            . "</div>"
            . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>