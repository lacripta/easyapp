<?php echo \core\error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["raiz"]; ?>">Grupos</a></li>
    <li>Editar Grupo</li>
</ol>
<div class="well col-xs-12 col-md-5">
    <form class="form-horizontal" method="post" action="">
        <legend><h3>Editar Grupo: <b><?php echo $data["grupo"][0]->grupo_nombre; ?></b></h3></legend>
        <div class="form-group">
            <label for="fecha" class="col-sm-2 control-label">Fecha creación:</label>
            <div class="col-sm-10">
                <input readonly type="datetime" class="form-control" name="fecha" placeholder="Fecha creación" value="<?php echo $data["grupo"][0]->grupo_fecha; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="nombre" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre del grupo" value="<?php echo $data["grupo"][0]->grupo_nombre; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <?php
                        if ($data["grupo"][0]->grupo_estado) {
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
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input class="btn btn-success" name="submit" type="submit" value="Guardar">
                <a href="<?php echo $data["raiz"]; ?>" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </form>
</div>