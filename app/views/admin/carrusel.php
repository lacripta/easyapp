<ol class="breadcrumb">
    <li><a href="<?php echo $data["usuarios"]; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["articulos"]; ?>">Articulos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<p>
    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#jcartModal" onclick="nuevo()">Nuevo Elemento</a>
</p>
<p><br></p>
<table id="myTable" class="stripe hover row-border cell-border order-column compact"></table>
<div class="modal fade" id="jcartModal" tabindex="-1" role="dialog" aria-labelledby="jcartModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="jcartModalLabel">Nuevo Elemento a la Galeria</h4>
            </div>
            <div class="modal-body">
                <div class="well col-sm-12">
                    <div align="center">
                        <h3 id="FormTitulo">Informacion de la imagen para el Carrusel</h3>
                        <div class="label label-default">Formatos Permitidos: Jpeg, Jpg, Png, Gif. | Tamaño maximo 1 MB</div>
                        <form action="/easyapp/admin/carrusel/elemento_nuevo" onsubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
                            <input name="image_file" id="imageInput" type="file">
                            <img src="" class="img-responsive img-thumbnail" id="loading-img">

                            <div id="progressbox" style="display: block;">
                                <div id="progressbar" style="width: 100%;"></div>
                                <div id="statustxt" style="color: rgb(255, 255, 255);">
                                    100%
                                </div>
                            </div>
                            <div id="output">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Nombre del banner" name="galeria_nombre" id="galeria_nombre">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Titulo del Banner" name="galeria_titulo" id="galeria_titulo">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Descripcion del contenido" name="galeria_descripcion" id="galeria_descripcion">
                            </div>
                            <input type="submit" id="submit-btn" class="btn btn-info" value="Guardar" onclick="$('#jcartModal').modal('hide');">
                            <input type="hidden" id="galeria_id" name="galeria_id" value="">
                            <input type="hidden" id="galeria_estado" name="galeria_estado" value="">
                            <input type="hidden" id="galeria_fecha" name="galeria_fecha" value="">
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="control_editar">
                <div class="btn-group">
                    <input type="hidden" id="ignorar_vacio" value="1">
                    <a href="#" class="btn btn-warning" id="elemento_borrar" onclick="borrar()">Borrar</a>
                    <a href="#" class="btn btn-default" id="elemento_publicar" onclick="publicar()">Publicado</a>
                </div>
                <span class="toggle"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function nuevo() {
        $("#loading-img").attr('src', '');
        $("#ignorar_vacio").val("0");
        document.getElementById("MyUploadForm").reset();
        $("#jcartModalLabel").html("Nuevo Elemento a la Galeria");
        $("#output").html("");
        $("#FormTitulo").html("Informacion de la imagen para el Carrusel");
        $('#control_editar').hide();
        $('#MyUploadForm').attr('action', '/easyapp/admin/carrusel/elemento_nuevo');
    }
    function detalles(data) {
        $('#loading-img').show();
        $("#ignorar_vacio").val("1");
        $('#MyUploadForm').attr('action', '/easyapp/admin/carrusel/elemento_editar');
        $('#jcartModal').modal('show');
        $("#control_editar").show();
        $("#loading-img").attr('src', data.galeria_url);
        $("#galeria_nombre").val(data.galeria_nombre);
        $("#galeria_descripcion").val(data.galeria_descripcion);
        $("#galeria_titulo").val(data.galeria_titulo);
        $("#galeria_estado").val(data.galeria_estado);
        $("#galeria_id").val(data.galeria_id);
        $("#galeria_fecha").val(data.galeria_fecha);
        $("#jcartModalLabel").html("Editar la informacion de " + data.galeria_titulo);
        $("#FormTitulo").html("Detalles del Elemento");
        $("#output").html("");
        $("#elemento_publicar").removeClass("btn-default btn-danger btn-success");
        if (data.galeria_estado === "1") {
            $("#elemento_publicar").addClass("btn-success");
        } else {
            $("#elemento_publicar").addClass("btn-danger");
        }

    }

    function publicar() {
        var cambio = getJson('/easyapp/admin/carrusel/elemento_publicar', {"galeria_id": $("#galeria_id").val(), "galeria_estado": $("#galeria_estado").val()});
        if (cambio.update == "1") {
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
        }
    }

    function borrar() {
        getJson('/easyapp/admin/carrusel/elemento_borrar', {"galeria_id": $("#galeria_id").val()});
        $('#jcartModal').modal('hide');
        $('#myTable').dataTable().fnDestroy();
        construir();
    }

    function construir() {
        //var data = getJson('/easyapp/admin/carrusel/elementos', {});
        $('#myTable').DataTable({
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).on('click', function () {
                    detalles(aData);
                });
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'
            },
            "responsive": true,
            select: true,
            autoWidth: false,
            data: getJson('/easyapp/admin/carrusel/elementos', {}),
            columns: [
                {data: "galeria_id", visible: false, title: "ID"},
                {data: "galeria_nombre", visible: true, title: "Nombre"},
                {data: "galeria_titulo", visible: true, title: "Título"},
                {data: "galeria_descripcion", visible: false, title: "Descripción"},
                {data: "galeria_url", visible: false, title: "URL"},
                {data: "galeria_fecha", visible: true, title: "Fecha"},
                {data: "galeria_estado", visible: true, title: "Estado", render: function (data, type, full, meta) {
                        if (data == 1) {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-ok-circle text-success' aria-hidden='true'></span>";
                        } else {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-remove-circle text-danger' aria-hidden='true'></span>";
                        }
                    }}
            ]
        });
    }
    $(document).ready(function () {
        construir();
        $('#MyUploadForm').submit(function () {
            $(this).ajaxSubmit(options);
            $('#myTable').dataTable().fnDestroy();
            construir();
            return false;
        });
        $("#imageInput").change(function () {
            readURL(this);
        });

    });
</script>

