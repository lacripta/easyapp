<?php echo \core\Error::display($error); ?>
<ol class="breadcrumb">
    <li><a href="<?php echo DIR; ?>admin/">Inicio</a></li>
    <li><a href="<?php echo DIR; ?>admin/articulo">Articulos</a></li>
    <li>Crear Articulo</li>
</ol>
<div class="well col-xs-12 col-md-8">  
    <form action="" method ="post" enctype="multipart/form-data">
        <legend><h3>Crear Nuevo Articulo</h3></legend>
        <div class="form-group">
            <label for="fecha">Fecha creación:</label>
            <input type="datetime" class="form-control" name="fecha" placeholder="Fecha de creación" value="<?php echo date("Y/m/d H:i:s"); ?>" readonly>
        </div>
        <div class="form-group">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary <?php echo $active; ?>">
                    <input <?php echo $checked; ?> name="estado" type="checkbox" autocomplete="off"> Publicado
                </label>
                <label class="btn btn-info <?php echo $active; ?>">
                    <input <?php echo $checked; ?> name="especial" type="checkbox" autocomplete="off"> Favorito
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="autor">Autor:</label>
            <input type="text" class="form-control" name="autor" placeholder="Nombre del Autor" value="<?php echo \helpers\session::get("usuario"); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="titulo">Titulo:</label>
            <input type="text" class="form-control" name="titulo" placeholder="Titulo del articulo" value="<?php
            if (isset($error)) {
                echo filter_input(INPUT_POST, "titulo");
            }
            ?>">
        </div>
        <div class="form-group">
            <label for="descripcion"></label>
            <textarea name="descripcion" rows="4" class="col-md-12 form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="contenido"></label>
            <textarea name="contenido" rows="10" class="col-md-12 form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Imagen</label>
            <input type="file" name="image">
            <p class="help-block">
                archivo de imagen que representa el articulo. 
                <br>Archivos soportados "gif", "jpeg", "jpg", "png", "svg"
            </p>
        </div>
        <input class="btn btn-success" name="submit" type="submit" value="Guardar">
        <a href="<?php echo DIR; ?>admin/articulo" class="btn btn-primary">Volver</a>
    </form>
</div>



