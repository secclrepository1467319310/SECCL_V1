$(document).ajaxComplete(function() {
    jQuery.validator.addMethod("pattern", function(value, element, param) {
        if (this.optional(element)) {
            return 'Campo obligatorio';
        }
        if (typeof param === 'string') {
            param = new RegExp('^(?:' + param + ')$');
        }
        return param.test(value);
    }, "Invalid format.");

    $('#frmProyectoNacional').validate({
        rules: {
            ddlLienaAtencion: {
                required: true,
                pattern: /^[1-2]*$/
            },
            nit_empresa: {
                required: true,
                pattern: /^[0-9]*$/
            },
            nombre_contacto: {
                required: true,
                pattern: /^[a-zA-ZñáéíóúÑÁÉÍÓÚ ]*$/
            },
            telefono_contacto: {
                required: true,
                pattern: /^[a-zA-Z0-9ñáéíóúÑÁÉÍÓÚ ]*$/
            },
            celular_contacto: {
                required: true,
                pattern: /^[0-9]*$/
            },
            email_contacto: {
                required: true,
                email: true
            },
            presupuesto_sena: {
                required: true,
                pattern: /^[0-9]*$/
            },
            presupuesto_entidad: {
                required: true,
                pattern: /^[0-9]*$/
            },
            descripcion: {
                required: true,
                pattern: /^[\wñáéíóúüÑÁÉÍÓÚÜ,;\.:\s]*$/
            },
            numero_total_candidatos: {
                required: true,
                pattern: /^[0-9]*$/
            },
            desc_pro_regional: {
                required: true,
                pattern: /^[\wñáéíóúüÑÁÉÍÓÚÜ,;\.:\s]*$/
            },
            txt: {
                pattern: /^[\wñáéíóúüÑÁÉÍÓÚÜ,;\.:\s]*$/
            }
        },
        messages: {
            ddlLienaAtencion: {
                required: 'Campo obligatorio',
                pattern: 'Debe escoger una alineación para el proyecto'
            },
            nit_empresa: {
                required: 'Campo obligatorio',
                pattern: 'Solo digite numeros'
            },
            nombre_contacto: {
                required: 'Campo obligatorio',
                pattern: 'El nombre contiene caracteres inválidos'
            },
            telefono_contacto: {
                required: 'Campo obligatorio',
                pattern: 'El número de teléfono contiene caracteres inválidos'
            },
            celular_contacto: {
                required: 'Campo obligatorio',
                pattern: 'El número de celular contiene caracteres inválidos'
            },
            email_contacto: {
                required: 'Campo obligatorio',
                email: 'El email es inválido'
            },
            presupuesto_sena: {
                required: 'Campo obligatorio',
                pattern: 'El presupuesto contiene caracteres inválidos'
            },
            presupuesto_entidad: {
                required: 'Campo obligatorio',
                pattern: 'El presupuesto contiene caracteres inválidos'
            },
            descripcion: {
                required: 'Campo obligatorio',
                pattern: 'La descripción contiene caracteres inválidos'
            },
            numero_total_candidatos: {
                required: 'Campo obligatorio',
                pattern: 'El numero total de candidatos contiene caracteres inválidos'
            },
            desc_pro_regional: {
                required: 'Campo obligatorio',
                pattern: 'La descripción contiene caracteres inválidos'
            },
            txt: {
                pattern: 'La observación contiene caracteres inválidos'
            }
        }
    });
});

$(document).ready(function() {
    $('#btnGuardar').click(function(ev) {
        ev.preventDefault();
        if ($('[name*=chkMesa]:checked').length <= 0) {
            $('.valError').empty();
            $('.valError').text('Debe seleccionar al menos una mesa');
        } else if ($('[name*=codigo]:checked').length <= 0) {
            $('.valError').empty();
            $('.valError').text('Debe seleccionar al menos una Norma');
        } else {
            $('.valError').empty();
            $('#frmProyectoNacional').submit();
        }
    });
});