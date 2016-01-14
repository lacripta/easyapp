<?php echo \core\error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo DIR . $data["raiz"]; ?>">Categorias</a></li>
    <li>Editar Categoria</li>
</ol>
<div class="well col-xs-12 col-md-5">
    <form class="form-horizontal" method="post" action="">
        <legend><h3>Editar Categoria <b class="text-primary"><?php echo $data["categoria"][0]->documento_tipo_nombre; ?></b></h3></legend>
        <div class="form-group">
            <label for="nombre" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre de la categoria" name="nombre" type="text" value="<?php echo $data["categoria"][0]->documento_tipo_nombre; ?>">
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

