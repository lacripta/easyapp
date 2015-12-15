function getJson(url, data) {
    return JSON.parse($.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        global: false,
        async: false,
        data: data,
        success: function (json) {
            return json;
        },
        error: function (error) {
            return error;
        }
    }).responseText);
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#loading-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
var progressbox = $('#progressbox');
var progressbar = $('#progressbar');
var statustxt = $('#statustxt');
var completed = '0%';
var options = {
    target: '#output',
    beforeSubmit: beforeSubmit,
    uploadProgress: OnProgress,
    success: afterSuccess,
    resetForm: true
};
function OnProgress(event, position, total, percentComplete)
{
    progressbar.width(percentComplete + '%') //update progressbar percent complete
    statustxt.html(percentComplete + '%'); //update status text
    if (percentComplete > 50)
    {
        statustxt.css('color', '#fff'); //change status text to white after 50%
    }
}

function afterSuccess()
{
    $('#submit-btn').show(); //hide submit button
    $('#loading-img').hide(); //hide submit button

}

function beforeSubmit() {
    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        if ($('#ignorar_vacio').val() == "1") {

        } else {
            if (!$('#imageInput').val()) //check empty input filed
            {
                $("#output").html("No hay imagen seleccionada!");
                return false
            }
            var fsize = $('#imageInput')[0].files[0].size; //get file size
            var ftype = $('#imageInput')[0].files[0].type; // get file type
            switch (ftype)
            {
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                    break;
                default:
                    $("#output").html("<b>" + ftype + "</b> Formato no soportado!");
                    return false
            }
            //Allowed file size is less than 1 MB (1048576)
            if (fsize > 1048576)
            {
                $("#output").html("<b>" + bytesToSize(fsize) + "</b> Imagen muy grande! <br />Reduzca el tamaño de la imagen usando un editor de imagenes.");
                return false
            }
            //Progress bar
            progressbox.show();
            progressbar.width(completed);
            statustxt.html(completed);
            statustxt.css('color', '#000');


            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");
        }
    } else
    {
        $("#output").html("Debe utilizar un navegador mas actualizado!");
        return false;
    }
}

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0)
        return '0 Bytes';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}