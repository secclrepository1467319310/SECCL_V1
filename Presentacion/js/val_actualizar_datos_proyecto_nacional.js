jQuery.validator.addMethod("pattern", function(value, element, param) {
    if (this.optional(element)) {
        return 'Campo obligatorio';
    }
    if (typeof param === 'string') {
        param = new RegExp('^(?:' + param + ')$');
    }
    return param.test(value);
}, "Invalid format.");



$(document).ready(function() {
    $('#frmProyectoNacional').validate({
        //ignore: [],
        rules: {
            "nombre_contacto": {
                required: true,
                maxlength:200
            },
            "telefono_contacto": {
                required: true,
                maxlength:100
            },            
            "celular_contacto": {
                required: true,
                maxlength:100
            },            
            "email_contacto": {
                required: true,
                email:true,
                maxlength:360
            },            
            "presupuesto_sena": {
                required: true,
                number:true
            },            
            "presupuesto_entidad": {
                required: true,
                number:true
            },            
            "numero_total_candidatos": {
                required: true,
                number:true
            }
        },
        messages: {
            
        }
    });
});