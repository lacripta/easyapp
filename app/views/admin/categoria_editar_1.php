<?php echo \core\error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . $data["raiz"]; ?>">Categorias</a></li>
    <li>Editar Categoria</li>
</ol>
<div class="well col-xs-12 col-md-5">   
    <form class="form-horizontal" method="post" action="">
        <legend><h3>Editar Categoria <b class="text-primary"><?php echo $data["categoria"][0]->categoria_nombre; ?></b></h3></legend>        
        <div class="form-group">
            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre de la categoria" name="nombre" type="text" value="<?php echo $data["categoria"][0]->categoria_nombre; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="orden" class="col-sm-2 control-label">Orden</label>
            <div class="col-sm-10">
                <input name="orden" class="form-control" type="number" value="<?php echo $data["categoria"][0]->categoria_orden; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="grupo" class="col-sm-2 control-label">Grupo:</label>
            <div class="col-sm-10">
                <select class="form-control" name="grupo">
                    <?php
                    foreach ($data["grupos"] as $elemento_grupo) {
                        if ($data["categoria"][0]->categoria_grupo == $elemento_grupo->grupo_nombre) {
                            $elegido = "selected";
                        } else {
                            $elegido = "";
                        }
                        echo "<option " . $elegido . " value='$elemento_grupo->grupo_nombre'>$elemento_grupo->grupo_nombre</option>";
                    }
                    ?>                
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="propietario" class="col-sm-2 control-label">Autor:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="propietario" placeholder="Nombre del Propietario" value="<?php echo $data["categoria"][0]->categoria_propietario; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <div class="btn-group" data-toggle="buttons">
                            <?php
                            if ($data["categoria"][0]->categoria_estado) {
                                $checked = "checked";
                                $active = "active";
                            } else {
                                $checked = "";
                                $active = "";
                            }
                            ?>
                            <label class="btn btn-success <?php echo $active; ?>">                                
                                <input <?php echo $checked; ?> name="estado" type="checkbox" autocomplete="off"> Visible
                            </label>
                        </div>
                    </label>
                </div>
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

