<ol class="breadcrumb">
    <li><a href="<?php echo $data["inicio"]; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["producto"]; ?>">Productos</a></li>
    <li><?php echo $data["title"]; ?></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>

<div class="well">
    <b class="text-info">ID:</b> <span id="producto_id"></span><?php echo $data["elemento"]->producto_id; ?>&Tab;|
    <b class="text-info">Estado:</b> <span id="producto_estado"><?php echo $data["elemento"]->producto_estado; ?></span>&Tab;|
    <b class="text-info">Fecha:</b> <span id="producto_fecha"><?php echo $data["elemento"]->producto_fecha; ?></span>&Tab;|
    <b class="text-info">Nombre:</b> <span id="producto_nombre"><?php echo $data["elemento"]->producto_nombre; ?></span>&Tab;|
    <b class="text-info">Grupo:</b> <span id="producto_grupo"><?php echo $data["elemento"]->producto_grupo; ?></span>&Tab;|
    <b class="text-info">Categoria:</b> <span id="producto_categoria"><?php echo $data["elemento"]->producto_categoria; ?></span><br>
    <b class="text-info">Descripción:</b> <span id="producto_descripcion"><?php echo $data["elemento"]->producto_descripcion; ?></span>&Tab;|
    <b class="text-info">Cant:</b> <span id="producto_existencias"><?php echo $data["elemento"]->producto_existencias; ?></span>&Tab;|
    <b class="text-info">Precio:</b> <span id="producto_precio"><?php echo $data["elemento"]->producto_precio; ?></span>
</div>

<div class="col-sm-12" style="background-color: #ffffff">
    <div align="center" class="col-sm-6">
        <h3 id="FormTitulo">Informacion de la imagen para el Carrusel</h3>
        <div class="label label-default">Formatos Permitidos: Jpeg, Jpg, Png, Gif. | Tamaño maximo 1 MB</div>
        <form action="/easyapp/admin/producto/imagenes/agregar_imagen" onsubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
            <input name="image_file" id="imageInput" type="file">
            <div id="progressbox" style="display: block;">
                <div id="progressbar" style="width: 100%;"></div>
                <div id="statustxt" style="color: rgb(255, 255, 255);">
                    100%
                </div>
            </div>
            <div id="output">
            </div>
            <div class="form-group">
                <input type="text" class="form-control floating-label" placeholder="Nombre" name="producto_imagen_nombre" id="producto_imagen_nombre">
            </div>
            <div class="form-group">
                <input type="text" class="form-control floating-label" placeholder="Titulo" name="producto_imagen_descripcion" id="producto_imagen_descripcion">
            </div>
            <div class="form-group">
                <input type="text" class="form-control floating-label" placeholder="Descripcion" name="producto_imagen_titulo" id="producto_imagen_titulo">
            </div>
            <input type="submit" id="submit-btn" class="btn btn-info" value="Guardar" onclick="$('#jcartModal').modal('hide');">
            <input type="hidden" id="producto_imagen_id" name="producto_imagen_id" value="" >
            <input type="hidden" id="producto_imagen_id" name="producto_imagen_producto" value="<?php echo $data["elemento"]->producto_id; ?>">
            <input type="hidden" id="producto_imagen_fecha" name="producto_imagen_fecha" value="">
            <input type="hidden" id="producto_imagen_estado" name="producto_imagen_estado" value="">
        </form>
    </div>
    <div align="center" class="col-sm-6">
        <img src="" class="img-responsive img-thumbnail" id="loading-img">
    </div>
</div>

<?php
foreach ($data["imagenes"] as $imagen)
{
    ?>
    <!--<div class="col-xs-3">
        <div class="hovereffect">
            <img id="" class="img-responsive thumbnail" src="<?php echo $imagen->producto_imagen_url; ?>" alt="<?php echo $imagen->producto_imagen_descripcion; ?>" width="100%">
            <div class="overlay">
                <h2 id="control-nombre-<?php echo $imagen->producto_id; ?>">
    <?php echo $imagen->producto_imagen_nombre; ?>
                    <span id="estado-visible-<?php echo $imagen->producto_id; ?>" style='font-size: 16px' class='glyphicon glyphicon-eye-open <?php echo $imagen->producto_estado ? "text-success" : "text-danger"; ?>' aria-hidden='true'></span>
                </h2>
                <a id="control-borrar-<?php echo $imagen->producto_id; ?>" class="info btn btn-warning" href="/easy/app/admin/producto/imagenes/borrar/..<?php echo $imagen->producto_imagen_id; ?>">Borrar</a>
                <a id="control-visible-<?php echo $imagen->producto_id; ?>" class="info btn btn-success" href="/easy/app/admin/producto/imagenes/imagen_estado/..<?php echo $imagen->producto_imagen_id; ?>,<?php echo $imagen->producto_imagen_estado; ?>">Visible</a>
            </div>
        </div>
    </div>-->
    <div class="col-md-4 portfolio-item">
        <a href="#">
            <img class="img-responsive" src="<?php echo $imagen->producto_imagen_url; ?>" alt="<?php echo $imagen->producto_imagen_titulo; ?>" width="100%">
        </a>
        <h3>
            <a href="#"><?php echo $imagen->producto_imagen_nombre; ?></a>
        </h3>
        <span id="estado-visible-<?php echo $imagen->producto_id; ?>" style='font-size: 16px' class='glyphicon glyphicon-eye-open <?php echo $imagen->producto_imagen_estado ? "text-success" : "text-danger"; ?>' aria-hidden='true'></span>
        <p><?php echo $imagen->producto_imagen_descripcion; ?></p>
        <button id="control-borrar-<?php echo $imagen->producto_id; ?>" class="info btn btn-warning" onclick="borrar('/easyapp/admin/producto/imagenes/borrar/..<?php echo $imagen->producto_imagen_id; ?>')">Borrar</button>
        <button id="control-visible-<?php echo $imagen->producto_id; ?>" class="info btn btn-success" onclick="publicar('/easyapp/admin/producto/imagenes/publicar_imagen',<?php echo $imagen->producto_imagen_id; ?>, <?php echo $imagen->producto_imagen_estado; ?>)">Visible</button>
    </div>
<?php } ?>



<script type="text/javascript">
    function borrar(url) {
        getJson(url, {});
        location.reload();
    }
    function publicar(url, id, estado) {
        getJson(url, {producto_imagen_id: id, producto_imagen_estado: estado});
        location.reload();
    }
    $(document).ready(function () {
        $('#producto_categoria').autoComplete({
            minChars: 0,
            source: function (term, response) {
                data = getJson('/easyapp/admin/producto/producto_categoria', {dato: term});
                response(data);
            },
            renderItem: function (item, search) {
                return '<div class=\"autocomplete-suggestion\" data-langname=\"' + item.producto_categoria_nombre + '\" data-lang=\"' + item.producto_categoria_nombre + '\" data-val=\"' + item.producto_categoria_nombre + '\">' + item.producto_categoria_nombre + '</div>';
            },
            onSelect: function (e, term, item) {
                //console.log(item.data('lang'));
            }
        });
        $('#producto_grupo').autoComplete({
            minChars: 0,
            source: function (term, response) {
                data = getJson('/easyapp/admin/producto/producto_grupo', {dato: term});
                response(data);
            },
            renderItem: function (item, search) {
                return '<div class=\"autocomplete-suggestion\" data-langname=\"' + item.producto_grupo_nombre + '\" data-lang=\"' + item.producto_grupo_nombre + '\" data-val=\"' + item.producto_grupo_nombre + '\">' + item.producto_grupo_nombre + '</div>';
            },
            onSelect: function (e, term, item) {
                //console.log(item.data('lang'));
            }
        });
        $('#MyUploadForm').submit(function () {
            tinyMCE.triggerSave();
            $(this).ajaxSubmit(options);
            return false;
        });
        $("#imageInput").change(function () {
            readURL(this);
        });
    });
</script>