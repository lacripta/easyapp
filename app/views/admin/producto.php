<ol class="breadcrumb">
    <li><a href="<?php echo $data["usuarios"]; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["articulos"]; ?>">Articulos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<p>
    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#jcartModal" onclick="nuevo()">Nuevo producto</a>
</p>
<p><br></p>
<table id="myTable" class="stripe hover row-border cell-border order-column compact"></table>
<div class="modal fade" id="jcartModal" tabindex="-1" role="dialog" aria-labelledby="jcartModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="jcartModalLabel">Nuevo Producto</h4>
            </div>
            <div class="modal-body">
                <div class="well col-sm-12">
                    <div align="center">
                        <form action="/easyapp/admin/producto/elemento_nuevo" onsubmit="return false" method="post" id="MyUploadForm">
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Nombre del Producto" name="producto_nombre" id="producto_nombre">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Resumen del producto" name="producto_resumen" id="producto_resumen">
                            </div>
                            <div class="form-group">
                                <textarea style="width: 100%;" name="producto_descripcion" id="producto_descripcion"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Categoria de producto" name="producto_categoria" id="producto_categoria">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Grupo de producto" name="producto_grupo" id="producto_grupo">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Existencias en Inventario" name="producto_existencias" id="producto_existencias">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Precio del producto" name="producto_precio" id="producto_precio">
                            </div>
                            <input type="submit" id="submit-btn" class="btn btn-info" value="Guardar" onclick="$('#jcartModal').modal('hide');">
                            <input type="hidden" id="producto_id" name="producto_id" value="">
                            <input type="hidden" id="producto_estado" name="producto_estado" value="">
                            <input type="hidden" id="producto_destacado" name="producto_destacado" value="">
                            <input type="hidden" id="producto_fecha" name="producto_fecha" value="">
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
<script type="text/javascript">
    function nuevo() {
        tinyMCE.activeEditor.setContent("");
        $('#producto_existencias').filter_input({regex: '[0-9]'});
        $('#producto_precio').filter_input({regex: '[0-9]'});
        document.getElementById("MyUploadForm").reset();
        $("#jcartModalLabel").html("Nuevo Producto");
        $("#FormTitulo").html("Información del producto");
        $('#control_editar').hide();
        $('#MyUploadForm').attr('action', '/easyapp/admin/producto/elemento_nuevo');
    }
    function detalles(data) {
        tinyMCE.activeEditor.setContent(data.producto_descripcion);
        $('#producto_existencias').filter_input({regex: '[0-9]'});
        $('#producto_precio').filter_input({regex: '[0-9]'});
        $('#MyUploadForm').attr('action', '/easyapp/admin/producto/elemento_editar');
        $('#jcartModal').modal('show');
        $("#control_editar").show();
        $("#producto_nombre").val(data.producto_nombre);
        $("#producto_resumen").val(data.producto_resumen);
        $('#elemento_imagenes').attr('href', '/easyapp/admin/producto/imagenes/..' + data.producto_id);
        $("#producto_grupo").val(data.producto_grupo);
        $("#producto_categoria").val(data.producto_categoria);
        $("#producto_id").val(data.producto_id);
        $("#producto_fecha").val(data.producto_fecha);
        $("#producto_precio").val(data.producto_precio);
        $("#producto_estado").val(data.producto_estado);
        $("#producto_destacado").val(data.producto_destacado);
        $("#producto_existencias").val(data.producto_existencias);
        $("#jcartModalLabel").html("Editar la informacion de " + data.producto_nombre);
        $("#FormTitulo").html("Detalles del Producto");
        $("#elemento_publicar").removeClass("btn-default btn-danger btn-success");
        if (data.producto_estado === "1") {
            $("#elemento_publicar").addClass("btn-success");
        } else {
            $("#elemento_publicar").addClass("btn-danger");
        }

        $("#elemento_destacar").removeClass("btn-default btn-danger btn-info");
        if (data.producto_destacado === "1") {
            $("#elemento_destacar").addClass("btn-info");
        } else {
            $("#elemento_destacar").addClass("btn-danger");
        }

    }

    function publicar() {
        var cambio = getJson('/easyapp/admin/producto/elemento_publicar', {"producto_id": $("#producto_id").val(), "producto_estado": $("#producto_estado").val()});
        if (cambio.update == "1") {
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
        }
    }

    function destacar() {
        var cambio = getJson('/easyapp/admin/producto/elemento_destacar', {"producto_id": $("#producto_id").val(), "producto_destacado": $("#producto_destacado").val()});
        if (cambio.update == "1") {
            $('#jcartModal').modal('hide');
            $('#myTable').dataTable().fnDestroy();
            construir();
        }
    }

    function borrar() {
        getJson('/easyapp/admin/producto/elemento_borrar', {"producto_id": $("#producto_id").val()});
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
            select: false,
            autoWidth: false,
            data: getJson('/easyapp/admin/producto/elementos', {}),
            columns: [
                {data: "producto_id", visible: false, title: "ID"},
                {data: "producto_nombre", visible: true, title: "Nombre"},
                {data: "producto_descripcion", visible: false, title: "Descripción", sClass: "text-center"},
                {data: "producto_grupo", visible: true, title: "Grupo", sClass: "text-center"},
                {data: "producto_categoria", visible: false, title: "Categoria", sClass: "text-center"},
                {data: "producto_fecha", visible: true, title: "Fecha"},
                {data: "producto_existencias", visible: true, title: "Cant", sClass: "text-center", render: function (data, type, full, meta) {
                        var estilo = "";
                        data <= 3 ? estilo = "text-warning" : data > 3 ? estilo = "text-info" : data == 0 ? estilo = "text-danger" : "";
                        return "<b class='text-center " + estilo + "'>" + data + "</b>";
                    }},
                {data: "producto_precio", visible: true, title: "Precio", render: function (data, type, full, meta) {
                        return accounting.formatMoney(data, "$ ", 0);
                    }},
                {data: "producto_estado", visible: true, title: "Estado", sClass: "text-center", render: function (data, type, full, meta) {
                        if (data == 1) {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-eye-open text-success' aria-hidden='true'></span>";
                        } else {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-eye-close text-danger' aria-hidden='true'></span>";
                        }
                    }},
                {data: "producto_destacado", visible: true, title: "Destacado", sClass: "text-center", render: function (data, type, full, meta) {
                        if (data == 1) {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-star text-warning' aria-hidden='true'></span>";
                        } else {
                            return "<span style='font-size: 16px' class='glyphicon glyphicon-star-empty text-danger' aria-hidden='true'></span>";
                        }
                    }}
            ]
        });
    }

    $(document).ready(function () {
        tinymce.init({selector: 'textarea'});
        construir();
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
                data = getJson('/easyapp/admin/producto/producto_grupo', {dato: term, producto_categoria: $("#producto_categoria").val()});
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
            $('#myTable').dataTable().fnDestroy();
            construir();
            return false;
        });
    });

</script>

