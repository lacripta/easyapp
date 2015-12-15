<?php echo \core\Error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . ADMIN . $data["clase"]; ?>">Usuarios</a></li>
    <li>Editar Usuario</li>
</ol>
<div class="well col-xs-12 col-md-4">
    <form action="" method ="post">
        <legend><h3>Modificar datos de <b class="text-primary"><?php echo $data["usuario"][0]->usuario_sid; ?></b></h3></legend>
        <div class="form-group">
            <label for="grupo">Grupo:</label>
            <select class="form-control" name="grupo">
                <?php
                foreach ($data["grupos"] as $elemento_grupo) {
                    if ($elemento_grupo->grupo_nombre === $data["usuario"][0]->usuario_grupo) {
                        $actual = "selected";
                    } else {
                        $actual = "";
                    }
                    echo "<option $actual value='$elemento_grupo->grupo_nombre'>$elemento_grupo->grupo_nombre</option>";
                }
                ?>
            </select>
        </div>
        <p>Nombre:<br>
            <input class="form-control" name="nombre" type="text" value="<?php echo $data["usuario"][0]->usuario_nombre; ?>"></p>
        <p>Apellido:<br>
            <input class="form-control" name="apellido" type="text" value="<?php echo $data["usuario"][0]->usuario_apellido; ?>"></p>
        <p>E-Mail:<br>
            <input class="form-control" name="email" type="text" value="<?php echo $data["usuario"][0]->usuario_email; ?>"></p>
        <p>Nombre de Usuario:<br>
            <input class="form-control" name="usuario" type="text" value="<?php echo $data["usuario"][0]->usuario_sid; ?>"></p>
        <p>Clave:<br>
            <input class="form-control" name="clave" type="password" value="">
        </p>
        <?php
        if ($data["usuario"][0]->usuario_estado) {
            $checked = "checked";
            $active = "active";
        } else {
            $active = "";
            $checked = "";
        }
        ?>
        <div class="checkbox">
            <label>
                <input <?php echo $checked; ?> type="checkbox" name="estado" > Activo
            </label>
        </div>
        <p><br></p>
        <p>
            <input class="btn btn-success" name="submit" type="submit" value="Modificar">
            <a href="<?php echo DIR . ADMIN . $data["clase"]; ?>" class="btn btn-primary">Volver</a>
        </p>
    </form>
</div>