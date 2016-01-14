<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . ADMIN . $data["clase"]; ?>">Articulos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<?php echo "<h3 class='text-danger'>" . \helpers\session::pull("estado") . "</h3>"; ?>
<p>
    <a href="<?php echo DIR . $data["raiz"]; ?>/add" class="btn btn-info">Agregar Articulo</a>
</p>
<p><br></p>
<table class="table table-striped table-hover table-bordered responsive">
    <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Fecha</th>
        <th>Publicado</th>
        <th>Autor</th>
        <th>Favorito</th>
        <th>Accion</th>
    </tr>
    <?php
    if ($data["articulos"]) {
        foreach ($data["articulos"] as $registro) {

            echo "<tr>";
            echo "<td>$registro->articulo_id</td>";
            echo "<td>$registro->articulo_titulo</td>";
            echo "<td>" . date("jS M Y H:i:s", strtotime($registro->articulo_fecha)) . "</td>";
            $checked = $registro->articulo_estado ? "glyphicon glyphicon-eye-open text-success" : "glyphicon text-danger glyphicon-eye-close";
            echo "<td align='center'>"
            . "<span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span>"
            . "</td>";
            echo "<td>$registro->articulo_autor</td>";
            $checked = $registro->articulo_especial ? "glyphicon glyphicon-star" : "glyphicon glyphicon-star-empty";
            echo "<td align='center'>"
            . "<span style='font-size: 24px' class='" . $checked . "' aria-hidden='true'></span>"
            . "</td>";
            echo "<td>"
            . "<div class='btn-group btn-group btn-group-sm'>"
            . "<a class='btn btn-success' href='" . DIR . $data["raiz"] . "/edit/..$registro->articulo_id'>Editar</a> "
            . "<a class='btn btn-primary' href='javascript:borrar_articulo(\"$registro->articulo_id\",\"$registro->articulo_titulo\");'>Borrar</a>"
            . "</div>"
            . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>


