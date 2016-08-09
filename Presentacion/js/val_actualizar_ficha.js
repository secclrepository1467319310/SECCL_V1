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
    $('#formmapa').validate({
        //ignore: [],
        rules: {
            "tipodoc": {
                required: true              
            },
            "documento": {
                required: true,
                maxlength:20            
            },
            "expedicion": {
                required: true,
                maxlength:100              
            },
            "papellido": {
                required: true,
                maxlength:100           
            },
            "sapellido": {                
                maxlength:100          
            },
            "nombre": {
                required: true,
                maxlength:100          
            },
            "fnacimiento": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]19[0-9][0-9]$",
                maxlength:10
            },
            "deptonac": {
                required: true              
            },
            "sexo": {
                required: true              
            },
            "sangre": {
                required: true              
            },
            "deptodom": {
                required: true              
            },
            "barrio": {
                required: true,
                maxlength:150             
            },
            "domicilio": {
                required: true,
                maxlength:150            
            },
            "telefono": {                
                maxlength:50        
            },
            "celular": {
                required: true,
                pattern:"^[0-9]+$",
                maxlength:20          
            },
            "estado": {
                required: true              
            },
            "estrato": {
                required: true              
            },
            "escolaridad": {
                required: true              
            },
            "email": {
                required: true,
                email:true,
                maxlength:100           
            },
            "cpapellido": {                
                maxlength:50
            },
            "csapellido": {                
                maxlength:50             
            },
            "cnombre": {                
                maxlength:100              
            },
            "cresidencia": {                
                maxlength:100             
            },ctelefono:{
                number:true,
            },ccelular:{
                number:true,
                
            },
            "cemail": {                
                email:true,
                maxlength:150            
            },
            "cparentesco": {                
                maxlength:50          
            },
            "claboral": {
                required: true              
            },
	    "nit_empresa":{
		number:true
   	    }
         },
        messages: {
            "tipodoc": {
                required: 'Campo obligatorio'                
            },
            "documento": {
                required: 'Campo obligatorio'
                
            },
            "expedicion": {
                required: 'Campo obligatorio'              
            },
            "papellido": {
                required: 'Campo obligatorio'                
            },
            "sapellido": {
                required: 'Campo obligatorio'                
            },
            "nombre": {
                required: 'Campo obligatorio'                
            },
            "fnacimiento": {
                required: 'Campo obligatorio' ,
                pattern:"Fecha no valida"               
            },
            "deptonac": {
                required: 'Campo obligatorio'                
            },
            "sexo": {
                required: 'Campo obligatorio'                
            },
            "sangre": {
                required: 'Campo obligatorio'                
            },
            "deptodom": {
                required: 'Campo obligatorio'                
            },
            "barrio": {
                required: 'Campo obligatorio'                
            },
            "domicilio": {
                required: 'Campo obligatorio'                
            },
            "telefono": {
                required: 'Campo obligatorio'                
            },
            "celular": {
                required: 'Campo obligatorio',
                pattern:"Solo números"                
            },
            "estado": {
                required: 'Campo obligatorio'                
            },
            "estrato": {
                required: 'Campo obligatorio'                
            },
            "escolaridad": {
                required: 'Campo obligatorio'                
            },
            "email":{
                required:"Campo obligatorio",
                email:"Email no valido"
            },
            "cpapellido": {
                required: 'Campo obligatorio'                
            },
            "csapellido": {
                required: 'Campo obligatorio'                
            },
            "cnombre": {
                required: 'Campo obligatorio'                
            },
            "cresidencia": {
                required: 'Campo obligatorio'                
            },
            "ctelefono": {
                
                required: 'Campo obligatorio'                
            },
            "ccelular": {
                required: 'Campo obligatorio'                
            },
            "cemail":{
                required:"Campo obligatorio",
                email:"Email no valido"
            },
            "cparentesco": {
                required: 'Campo obligatorio'                
            },
            "claboral": {
                required: 'Campo obligatorio'                
            }
        }
    });
});
