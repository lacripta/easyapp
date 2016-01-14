<?php echo \core\error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . ADMIN . $data["clase"]; ?>">Menus</a></li>
    <li>Crear Elemento</li>
</ol>
<div class="well col-xs-12 col-md-4">
    <form action="" method ="post">
        <legend><h1>Crear Nuevo Elemento</h1></legend>
        <div class="form-group">
            <label for="clase">Clase:</label>
            <select class="form-control" name="clase">
                <?php
                foreach ($data["clases"] as $elemento_grupo) {
                    echo "<option value='$elemento_grupo->menu_clase_nombre'>$elemento_grupo->menu_clase_nombre</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="grupo">Grupo:</label>
            <select class="form-control" name="grupo">
                <?php
                foreach ($data["grupos"] as $elemento_grupo) {
                    echo "<option value='$elemento_grupo->menu_grupo_nombre'>$elemento_grupo->menu_grupo_nombre</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="titulo">Titulo:</label>
            <input class="form-control" name="titulo" placeholder="Nombre para mostrar" type="text" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "nombre");
            }
            ?>">
        </div>
        <div class="form-group">
            <label for="componente">Componentes:</label>
            <select class="form-control" name="componente">
                <?php
                foreach ($data["componentes"] as $elemento_grupo) {
                    echo "<option value='$elemento_grupo->componente_nombre --- $elemento_grupo->componente_url'>$elemento_grupo->componente_nombre</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="orden">Orden:</label>
            <input class="form-control" name="orden" type="number" value="<?php
            if (isset($error)) {

                echo filter_input(INPUT_POST, "orden");
            } else {
                echo "0";
            }
            ?>">
        </div>
        <div class="form-group">
            <input class="btn btn-success" name="submit" type="submit" value="Guardar">
            <a href="<?php echo DIR . $data["raiz"]; ?>" class="btn btn-primary">Volver</a>
        </div>
    </form>
</div>