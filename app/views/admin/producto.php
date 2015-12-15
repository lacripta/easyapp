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
                            <textarea style="width: 100%;" name="producto_descripcion" id="producto_descripcion"></textarea>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Grupo de producto" name="producto_grupo" id="producto_grupo">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control floating-label" placeholder="Categoria de producto" name="producto_categoria" id="producto_categoria">
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
        $('#MyUploadForm').attr('action', '/easyapp/admin/producto/elemento_nuevo');
    }
    function detalles(data) {
        $('#loading-img').show();
        $("#ignorar_vacio").val("1");
        $('#MyUploadForm').attr('action', '/easyapp/admin/producto/elemento_editar');
        $('#jcartModal').modal('show');
        $("#control_editar").show();
        $("#producto_nombre").val(data.producto_nombre);
        $("#producto_descripcion").val(data.producto_descripcion);
        $("#producto_grupo").val(data.producto_grupo);
        $("#producto_categoria").val(data.producto_categoria);
        $("#producto_id").val(data.producto_id);
        $("#producto_fecha").val(data.producto_fecha);
        $("#producto_precio").val(data.producto_precio);
        $("#producto_estado").val(data.producto_estado);
        $("#producto_existencias").val(data.producto_existencias);
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
        var cambio = getJson('/easyapp/admin/producto/elemento_publicar', {"galeria_id": $("#galeria_id").val(), "galeria_estado": $("#galeria_estado").val()});
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
            data: getJson('/easyapp/admin/producto/elementos', {}),
            columns: [
                {data: "producto_id", visible: false, title: "ID"},
                {data: "producto_nombre", visible: true, title: "Nombre"},
                {data: "producto_descripcion", visible: false, title: "Descripción"},
                {data: "producto_grupo", visible: true, title: "Grupo"},
                {data: "producto_categoria", visible: false, title: "Categoria"},
                {data: "producto_fecha", visible: true, title: "Fecha"},
                {data: "producto_existencias", visible: true, title: "Existencias"},
                {data: "producto_precio", visible: true, title: "Precio", render: function (data, type, full, meta) {
                        return accounting.formatMoney(data, "$ ", 0);
                    }},
                {data: "producto_estado", visible: false, title: "Estado"}
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
    });
</script>

