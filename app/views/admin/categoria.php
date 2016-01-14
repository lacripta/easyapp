<ol class="breadcrumb">
    <li><a href="<?php echo DIR; ?>admin/">Inicio</a></li>
    <li><a href="<?php echo DIR; ?>admin/categoria">Categorias</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\session::pull("estado") . "</h3>"; ?>
<a href="<?php echo DIR; ?>admin/categoria/add" class="btn btn-info">Crear Nuevo</a>
<p><br></p>
<table class="table table-striped table-hover table-bordered responsive">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Secuencia</th>
        <th>Acción</th>
    </tr>
    <?php
    if ($data["categorias"]) {
        foreach ($data["categorias"] as $registro) {
            echo "<tr>";
            echo "<td>$registro->documento_tipo_id</td>";
            echo "<td>$registro->documento_tipo_nombre</td>";
            echo "<td>$registro->documento_tipo_secuencia</td>";
            echo "<td>"
            . "<div class='btn-group btn-group btn-group-sm'>"
            . "<a class='btn btn-success' href='" . DIR . "admin/categoria/edit/..$registro->documento_tipo_id'>Editar</a> "
            . "<a class='btn btn-primary' href='javascript:borrar_categoria(\"$registro->documento_tipo_id\",\"$registro->documento_tipo_nombre\");'>Borrar</a>"
            . "</div>"
            . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>