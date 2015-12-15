<?php echo \core\Error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . ADMIN . $data["clase"]; ?>">Usuarios</a></li>
    <li>Crear Usuario</li>
</ol>
<div class="well col-xs-12 col-md-4">
    <form action="" method ="post">
        <legend><h1>Crear Nuevo Usuario</h1></legend>
        <div class="form-group">
            <label for="grupo">Grupo:</label>
            <select class="form-control" name="grupo">
                <?php
                foreach ($data["grupos"] as $elemento_grupo) {
                    echo "<option value='$elemento_grupo->grupo_nombre'>$elemento_grupo->grupo_nombre</option>";
                }
                ?>
            </select>
        </div>
        <p>Nombres:<br>
            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "nombre");
            }
            ?>"></p>
        <p>Apellidos:<br>
            <input class="form-control" id="apellido" name="apellido" type="text" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "apelllido");
            }
            ?>"></p>
        <p>E-Mail:<br>
            <input class="form-control" name="email" type="text" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "email");
            }
            ?>"></p>
        <p>Nombre de Usuario:<br>
            <input class="form-control" name="usuario" type="text" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "usuario");
            }
            ?>"></p>
        <p>Clave:<br>
            <input class="form-control" name="clave" type="password" value=""></p>
        <p>
            <input class="btn btn-success" name="submit" type="submit" value="Guardar">
            <a href="<?php echo DIR . ADMIN . $data["clase"]; ?>" class="btn btn-primary">Volver</a>
        </p>
    </form>
</div>
