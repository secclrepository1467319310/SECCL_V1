$(document).ready(function() {
    
    $('[class*=textoValidar] .cantidad').text(500);
//    $('[class*=textoValidar] .cantidad').text($(this).prev('textarea').attr("maxlength"));
    $("textarea").keyup(function() {
        var limit = 500;
        var value = $(this).val();
        var current = value.length;
        var id = $(this).attr("id");
//        alert(id);
        $(this).prev('.cantidad').text(limit - current);

        if (limit < current) {
            $(this).val(value.substring(0, limit));
        }
    });
    var valor = $('input:radio[name=historia]:checked').val();
    if (valor == 1) {
        $('#contenedorHistoria').show();
    } else {
        $('#contenedorHistoria').hide();
    }
    $(".historia").click(function() {
        var valor = $('input:radio[name=historia]:checked').val();
        if (valor == 1) {
            $('#contenedorHistoria').show();
        } else {
            $('#contenedorHistoria').hide();
        }
    });
});

$(document).ready(function() {
    $('#form_informe_cualitativo').validate({
        rules: {
            fort_conocimiento: {
                required: true
            },
            deb_conocimiento: {
                required: true
            },
            fort_desempeno: {
                required: true
            },
            deb_desempeno: {
                required: true
            },
            fort_producto: {
                required: true
            },
            deb_producto: {
                required: true
            },
            opor_mejor_produc: {
                required: true
            },
            asp_resal_produc: {
                required: true
            },
        },
        messages: {
            fort_conocimiento: {
                required: 'Campo obligatorio'
            },
            deb_conocimiento: {
                required: 'Campo obligatorio'
            },
            fort_desempeno: {
                required: 'Campo obligatorio'
            },
            deb_desempeno: {
                required: 'Campo obligatorio'
            },
            fort_producto: {
                required: 'Campo obligatorio'
            },
            deb_producto: {
                required: 'Campo obligatorio'
            },
            opor_mejor_produc: {
                required: 'Campo obligatorio'
            },
            asp_resal_produc: {
                required: 'Campo obligatorio'
            },
        }
//        errorPlacement: function(error, element) {
//            if (element.attr('name') === 'codigo[]') {
//                error.insertAfter("#cantidad");
//            } else {
//                error.insertAfter(element);
//            }
//        }
    });
});