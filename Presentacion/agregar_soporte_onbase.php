<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrés Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
última actualización Diciembre /2013
!-->
    <head>
        <meta charset="charset=ISO-8859-1">
        <title>Sistema de Evaluacion y Certificacion de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html;"/>
        <script type="text/javascript" src="../jquery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="../jquery/jquery.validate.js"></script>
        <script src="ajax.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
        <script language="JavaScript" src="calendario/javascripts.js"></script>
        
        <script>

            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;



            function inicio() {

                if (is_chrome) {
                    /*var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
                     var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
                     //Comprobar version
                     ver_chrome = parseFloat(ver_chrome);
                     alert('Su navegador es Google Chrome, Version: ' + ver_chrome);*/
                    document.getElementById("flotante")
                            .style.display = 'none';
                }
                else {
                    document.getElementById("flotante")
                            .style.display = '';
                }

            }
            function cerrar() {
                document.getElementById("flotante")
                        .style.display = 'none';
            }
        </script>
        <script>$().ready(function() {
                $("#formmapa").validate({
                    rules: {
                        regional :{required:true},
                        centro : {required:true},
                        documento: {required: true, minlength: 6, maxlength: 10},
                        priapellido: {required: true, minlength: 3},
//                        segapellido: {required: true, minlength: 3},
                        nombres: {required: true, minlength: 2},
                        email: {required: true, email: true},
                        pass: {required: true, minlength: 6, maxlength: 10},
                        fn :{required:true},
                        lugarn :{required: true, minlength: 3},
                        fe :{required:true},
                        lugare :{required: true, minlength: 3},
                        archivo: {required:true}
                    },
                    messages: {
                        regional: "Seleccione Regional",
                        centro:"Seleccione Centro",
                        documento: "El campo Documento no contiene un formato correcto.",
                        priapellido: "Digite Primer Apellido",
//                        segapellido: "Digite Segundo Apellido",
                        nombres: "Digite el Nombre",
                        email: "El campo es obligatorio y debe tener formato de email correcto.",
                        pass: "El Password es Obligatorio y debe tener un tamaño entre 6-10 caracteres.",
                        fn: "Ingrese la Fecha de Nacimiento",
                        lugarn: "Indique el Lugar de Nacimiento",
                        fe: "Ingrese la Fecha de Expedicion del Documento de ID",
                        lugare: "Indique el Lugar de Expedicion del Documento",
                        archivo: "Por favor cargue su hoja de vida con los soportes",
                    }
                });
            });</script>
        <script>
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
//       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       letras = "0123456789";
//       especiales = [8,37,39,46];
       especiales = [8,37,39];
       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
</script>
    </head>
    <body onload="inicio()">
        <div id="flotante">
            <input type="button" value="X" onclick="cerrar('flotante')"
                   class="boton_verde2"></input> Se recomienda el uso de Google Chrome
            para una correcta visualizaci&oacute;n. Para descargarlo haga clic <a
                href="https://www.google.com/intl/es/chrome/browser/?hl=es"
                target="_blank">aqu&iacute;</a>
        </div>
        <div id="top">
            <div class="total" style="background:url(../_img/bck.header.jpg) no-repeat; height:40px;">
                <div class="min_space">&nbsp;</div>
                <script>
                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    var f = new Date();
                    document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                </script>
                <div class="float_right" style="margin-right:20px;">
                    <a href="https://twitter.com/senacomunica" rel="external"><img src="../_img/rs.twitter.jpg" alt="SENA en Twiiter" /></a>&nbsp;
                    <a href="http://www.facebook.com/sena.general" rel="external"><img src="../_img/rs.facebook.jpg" alt="SENA en Facebook" /></a>&nbsp;
                    <a href="https://plus.google.com/111618152086006296623/posts" rel="external"><img src="../_img/rs.googleplus.jpg" alt="SENA en Google+" /></a>&nbsp;
                    <a href="http://pinterest.com/SENAComunica/" rel="external"><img src="../_img/rs.pinterest.jpg" alt="SENA en Pinterest" /></a>&nbsp;
                </div>		
            </div>
        </div>
        <div id="header" class="bck_lightgray">
            <div class="total">
                <a href="index.php"><img src="../_img/header.jpg"/></a>
                <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedor">
            <center><h2>Cargar Soporte Onbase</h2>
            <br></br>
            <form name="formmapa" id="formmapa" action="guardar_soporte_onbase.php?centro=<?php echo $_GET['centro'] ?>" 
                  method="post" accept-charset="ISO-8859-1" enctype="multipart/form-data" >
                <table>
                    <tr><td><strong><label>Id</label></strong></td>
                        <td><input type="text" readonly="readonly" name="id" value="<?php echo $_GET['idarea']; ?>"></input></td></tr>
                <tr><td><strong><label>Cargar Soporte Onbase</label></strong></td>
                    <td><input type="file" name="archivo"></input></td>
                         <input type="hidden" name="action" value="upload"></input></tr>
                </table>
                <p><label>
                  <br></br>
                  <input type = "submit" name = "insertar" id = "insertar" value = "Cargar Soporte" accesskey = "I" />
                </label></p>
            </form>
            </center>
            <br></br>
        </div>
        <div class="space">&nbsp;</div>
        <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
        <div class="space">&nbsp;</div>
        <div class="min_space">&nbsp;</div>
        <div class="total" style="border-top: 2px solid #888;">
            <table align="right">
                <tr class="font14 bold">
                    <td rowspan="2">
                        <a href="http://wsp.presidencia.gov.co" title="Gobierno de Colombia" rel="external"><img src="../_img/links/gobierno.jpg" alt="logo Gobierno de Colombia" /></a> &nbsp; 
                    </td>
                    <td>
                        <a href="http://mintrabajo.gov.co/" title="Ministerio de Trabajo" rel="external"><img src="../_img/links/mintrabajo.jpg" alt="logo Ministerio de Trabajo" /></a> &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.mintic.gov.co/" title="Ministerio de Tecnologías de la Información y las Comunicaciones" rel="external"><img src="../_img/links/mintic.jpg" alt="logo Ministerio de Tecnologías de la Información y las Comunicaciones" /></a>
                    </td>
                </tr>
            </table>
            <div class="space">&nbsp;</div>
        </div>

        <div class="bck_orange">
            <div class="space">&nbsp;</div>
            <div class="total center white">
                Última modificación 08/04/2013 4:00 PM<br /><br />
                .:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
                Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
                Horario de atención: lunes a viernes de 8:00 am a 5:30 pm                        <br />
                <span class="font13 white">Correo electrónico para notificaciones judiciales: <a href="mailto:notificacionesjudiciales@sena.edu.co" class="bold white" rel="external">notificacionesjudiciales@sena.edu.co</a></span> <br />
                Todos los derechos reservados © 2012 ::.
            </div>
            <div class="total right">
                <a href="#top"><img src="../_img/top.gif" alt="Subir" title="Subir" /></a> &nbsp;
            </div>
            <!--<div class="space">&nbsp;</div>-->
        </div>

        <map name="Map2">
            <area shape="rect" coords="1,1,217,59" href="https://www.e-collect.com/customers/PagosSenaLogin.htm" target="_blank" alt="Pagos en línea" title="Pagos en línea">
            <area shape="rect" coords="3,63,216,119" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/PQRS.aspx" target="_blank" alt="PQESF" title="PQRSF">
            <area shape="rect" coords="2,124,217,179" href="http://www.sena.edu.co/Servicio%20al%20ciudadano/Pages/Contactenos.aspx" target="_blank" alt="Contáctenos" title="Cóntactenos">
        </map>
    </body>
</html>