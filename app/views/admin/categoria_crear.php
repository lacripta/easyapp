<?php echo \core\Error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . $data["raiz"]; ?>">Categorias</a></li>
    <li>Crear Categoria</li>
</ol>
<div class="well col-xs-12 col-md-5">
    <form class="form-horizontal" method="post" action="">
        <legend><h3>Crear Categoria</h3></legend>
        <div class="form-group">
            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre de la categoria" name="nombre" type="text" value="<?php
                if (isset($error)) {
                    echo filter_input(INPUT_POST, "nombre");
                }
                ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="grupo" class="col-sm-2 control-label">Grupo:</label>
            <div class="col-sm-10">
                <select class="form-control" name="grupo">
                    <?php
                    foreach ($data["grupos"] as $elemento_grupo) {
                        echo "<option value='$elemento_grupo->grupo_nombre'>$elemento_grupo->grupo_nombre</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="propietario" class="col-sm-2 control-label">Autor:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="propietario" placeholder="Nombre del Propietario" value="<?php echo \helpers\Session::get("usuario"); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input class="btn btn-success" name="submit" type="submit" value="Guardar">
                <a href="<?php echo DIR . $data["raiz"]; ?>" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </form>
</div>
