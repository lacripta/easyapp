<ol class="breadcrumb">
    <li><a href="<?php echo $data["usuarios"]; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["articulos"]; ?>">Articulos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<p>
    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#jcartModal" onclick="nuevo()">Nueva Publicaci&oacute;n</a>
</p>
<p><br></p>
<table id="myTable" class="stripe hover row-border cell-border order-column compact"></table>
<div class="modal fade" id="jcartModal" tabindex="-1" role="dialog" aria-labelledby="jcartModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="jcartModalLabel">Nueva Publicaci&oacute;n</h4>
            </div>
            <div class="modal-body">
                <div class="well col-sm-12">
                    <div align="center">
                        <form action="/easyapp/admin/novedades/elemento_nuevo" onsubmit="return false"  method="post" enctype="multipart/form-data" id="MyUploadForm">
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Titulo" name="novedades_titulo" id="novedades_titulo" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Resumen" name="novedades_resumen" id="novedades_resumen" required="">
                            </div>
                            <div class="form-group">
                                <textarea style="width: 100%;" name="novedades_contenido" id="novedades_contenido"></textarea>
                            </div>
                            <div class="form-group">
                                <input name="novedades_imagen_url" id="imageInput" type="file">
                                <img src="" class="img-responsive img-thumbnail" id="loading-img">

                                <div id="progressbox" style="display: block;">
                                    <div id="progressbar" style="width: 100%;"></div>
                                    <div id="statustxt" style="color: rgb(255, 255, 255);">
                                        100%
                                    </div>
                                </div>
                                <div id="output">
                                </div>
                            </div>
                            <input type="submit" id="submit-btn" class="btn btn-info" value="Guardar" onclick="">
                            <input type="hidden" id="novedades_id" name="novedades_id" value="">
                            <input type="hidden" id="novedades_estado" name="novedades_estado" value="">
                            <input type="hidden" id="novedades_destacado" name="novedades_destacado" value="">
                            <input type="hidden" id="novedades_fecha" name="novedades_fecha" value="">
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="control_editar">
                <div class="btn-group">
                    <input type="hidden" id="ignorar_vacio" value="1">
                    <a href="#" class="btn btn-warning" id="elemento_borrar" onclick="borrar()">Borrar</a>
                    <a href="#" class="btn btn-default" id="elemento_publicar" onclick="publicar()">Publicado</a>
                    <a href="#" class="btn btn-info" id="elemento_destacar" onclick="destacar()">Destacado</a>
                    <a href="#" class="btn btn-primary" id="elemento_imagenes">Imágenes</a>
                </div>
                <span class="toggle"></span>
            </div>
        </div>
    </div>
</div>
<script>
    function nuevo() {
        tinyMCE.activeEditor.setContent("");
        $('#producto_existencias').filter_input({regex: '[0-9]'});
        $('#producto_precio').filter_input({regex: '[0-9]'});
        $("#loading-img").attr('src', '');
        $("#ignorar_vacio").val("0");
        document.getElementById("MyUploadForm").reset();
        $("#jcartModalLabel").html("Nueva Publicaci&oacute;n");
        $("#FormTitulo").html("Informaci&oacute;n de la Publicaci&oacute;n");
        $('#control_editar').hide();
        $('#MyUploadForm').attr('action', '/easyapp/admin/novedades/elemento_nuevo');
    }
    function detalles(data) {
        tinyMCE.activeEditor.setContent(data.novedades_contenido);
        $('#MyUploadForm').attr('action', '/easyapp/admin/novedades/elemento_editar');
        $('#jcartModal').modal('show');
        $('#loading-img').show();
        $("#loading-img").attr('src', data.novedades_imagen_url);
        $("#ignorar_vacio").val("1");
        $("#control_editar").show();
        $("#novedades_titulo").val(data.novedades_titulo);
        $("#novedades_resumen").val(data.novedades_resumen);
        $("#novedades_id").val(data.novedades_id);
        $("#novedades_fecha").val(data.novedades_fecha);
        $("#novedades_estado").val(data.novedades_estado);
        $("#novedades_destacado").val(data.novedades_destacado);
        $("#jcartModalLabel").html("Editar la informaci&oacute;n de " + data.novedades_titulo);
        $("#FormTitulo").html("Detalles de la Publicaci&oacute;n");
        $("#elemento_publicar").removeClass("btn-default btn-danger btn-success");
        if (data.novedades_estado === "1") {
            $("#elemento_publicar").addClass("btn-success");
        } else {
            $("#elemento_publicar").addClass("btn-danger");
        }

        $("#elemento_destacar").removeClass("btn-default btn-danger btn-info");
        if (data.novedades_destacado === "1") {
            $("#elemento_destacar").addClass("btn-info");
        } else {
            $("#elemento_destacar").addClass("btn-danger");
        }
    }
    function publicar() {
        var cambio = getJson('/easyapp/admin/novedades/elemento_publicar', {"novedades_id": $("#novedades_id").val(), "novedades_estado": $("#novedades_estado").val()});
        if (cambio.update == "1") {
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
        }
    }
    function destacar() {
        var cambio = getJson('/easyapp/admin/novedades/elemento_destacar', {"novedades_id": $("#novedades_id").val(), "novedades_destacado": $("#novedades_destacado").val()});
        if (cambio.update == "1") {
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
        }
    }
    function borrar() {
        getJson('/easyapp/admin/novedades/elemento_borrar', {"novedades_id": $("#novedades_id").val()});
        $('#jcartModal').modal('hide');
        $('#myTable').dataTable().fnDestroy();
        construir();
    }
    function construir() {
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
            select: false,
            autoWidth: false,
            data: getJson('/easyapp/admin/novedades/elementos', {}),
            columns: [
                {data: "novedades_id", visible: false, title: "ID"},
                {data: "novedades_titulo", visible: true, title: "Título"},
                {data: "novedades_resumen", visible: true, title: "Resumen", sClass: "text-center"},
                {data: "novedades_contenido", visible: false, title: "Contenido", sClass: "text-center"},
                {data: "novedades_imagen_url", visible: false, title: "Imagen", sClass: "text-center"},
                {data: "novedades_fecha", visible: true, title: "Fecha"},
                {data: "novedades_autor", visible: true, title: "Autor", sClass: "text-center"},
                {data: "novedades_estado", visible: true, title: "Estado", sClass: "text-center", render: function (data, type, full, meta) {
                        if (data == 1) {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-eye-open text-success' aria-hidden='true'></span>";
                        } else {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-eye-close text-danger' aria-hidden='true'></span>";
                        }
                    }},
                {data: "novedades_destacado", visible: true, title: "Destacado", sClass: "text-center", render: function (data, type, full, meta) {
                        if (data == 1) {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-star text-warning' aria-hidden='true'></span>";
                        } else {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-star-empty text-danger' aria-hidden='true'></span>";
                        }
                    }}
            ]
        });
    }
    $(function () {
        tinymce.init({selector: 'textarea'});
        construir();
        $('#MyUploadForm').submit(function () {
            tinyMCE.triggerSave();
            $(this).ajaxSubmit(options);
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
            return false;
        });
    });


    $("#imageInput").change(function () {
        readURL(this);
    });
</script>