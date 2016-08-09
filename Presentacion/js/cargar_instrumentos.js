$(document).ready(function() {
    
    $('#divNormas').hide();
    
    $.ajax({
        beforeSend: function() {
            console.log("Enviando");
        },
        url: 'consultar_mesa_proyecto_nacional.php',
        type: 'post',
        success: function(resp) {
            $('#tblMesa').html(resp);
        },
        error: function(jqXHR, estado, error) {
            console.log(estado);
            console.log(error);
        },
        complete: function(jqXHR, estado) {
            console.log(estado);
            console.log('ajaxComplete');
        }
    });

    $('#btnInsertar').click(function() {
        $('#divMesas').hide();
        $('#divNormas').show();
        $.ajax({
            beforeSend: function() {
                console.log("Enviando");
            },
            url: 'instrumentos_banco.php',
            type: 'post',
            data: $('form').serialize(),
            success: function(resp) {
                $('#tblNormas').html(resp);
            },
            error: function(jqXHR, estado, error) {
                console.log(estado);
                console.log(error);
            },
            complete: function(jqXHR, estado) {
                console.log(estado);
                console.log('ajaxComplete');
                
            }
        });
    });
    
    $('#btnRegresar').click(function (){
        $('#divMesas').show();
        $('#tblNormas').empty();
        $('#divNormas').hide();
    });
    
});