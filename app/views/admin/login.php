<?php echo \core\error::display($error); ?>
<div class="well col-xs-12 col-md-5">
    <form class="form-horizontal" action="" method ="post">
        <legend><?php echo $data["title"]; ?></legend>
        <div class="form-group">
            <label for="usuario" class="col-sm-2 control-label">Usuario:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control floating-label" name="usuario" placeholder="Usuario">
            </div>
        </div>
        <div class="form-group">
            <label for="clave" class="col-sm-2 control-label">Clave:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control floating-label" name="clave" placeholder="Contraseña">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="submit" value="Ingresar" class="btn btn-default btn-success">Ingresar</button>
            </div>
        </div>
    </form>
</div>