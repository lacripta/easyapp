<ol class="breadcrumb">
    <li><a href="<?php echo DIR . ADMIN; ?>">Inicio</a></li>
    <li><a href="<?php echo $data["raiz"]; ?>">Grupos</a></li>
</ol>
<legend><h3><?php echo $data["title"]; ?></h3></legend>
<p><br></p>
<form method="post" onsubmit="return false" action="/easyapp/admin/estilos/cambiar" id="estilos1" name="form1">
    Color de las barras de menu y pie de pagina<br>
    <input class="jscolor {onFineChange:'update(this)'}" value="<?php echo $data["color"]->estilo_valor; ?>" id="color_picker" name="color">
    <div class="navbar navbar-default" id="color" style="<?php echo $data["color"]->estilo_nombre; ?>:<?php echo $data["color"]->estilo_valor; ?>"></div>
    <input type="submit" class="btn btn-default" value="Guardar">
</form>
<form method="post" onsubmit="return false" action="/easyapp/admin/estilos/cambiar" id="estilos" enctype="multipart/form-data" name="form2">
    Imagen de Fondo de la pagina<br>
    <input type="file" name="fondo" id="imageInput"><br>
    <input type="submit" class="btn btn-default" value="Guardar">
</form>
<script>
    function update(jscolor) {
        // 'jscolor' instance can be used as a string
        document.getElementById('color').style.backgroundColor = '#' + jscolor
    }
    $(function () {
        $("#imageInput").change(function () {
            readURL(this);
        });
        $('#estilos').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
        $('#estilos1').submit(function () {
            $(this).ajaxSubmit();
            return false;
        });
    });

</script>