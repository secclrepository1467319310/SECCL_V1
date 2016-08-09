<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrés Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
última actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="./images/iconos/favicon.ico" />
        <!--<script type="text/javascript" src="js/jquery.js"></script>-->
        <script type="text/javascript" src="js/jquery-easing-1.3.pack.js"></script>
        <script type="text/javascript" src="js/jquery-easing-compatibility.1.2.pack.js"></script>
        <script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="jquery/jquery.validate.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript" src="scripts/jflow.plus.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" type="text/css" href="css/menu.css" />
        <link rel="stylesheet" type="text/css" href="css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="css/ventana.css" />
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <link href="css/jimgMenu.css" rel="stylesheet" type="text/css" />
        

        <link href="styles2/jflow.style.css" type="text/css" rel="stylesheet"/>
        
<link type='text/css' href='css/osx.css' rel='stylesheet' media='screen' />
<script language="JavaScript" type="text/javascript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=600,top=85,left=140";
window.open(pagina,"",opciones);
}
</script>

        <script type="text/javascript">

            $(document).ready(function() {

                $("#myController").jFlow({
                    controller: ".jFlowControl", // must be class, use . sign

                    slideWrapper: "#jFlowSlider", // must be id, use # sign

                    slides: "#mySlides", // the div where all your sliding divs are nested in

                    selectedWrapper: "jFlowSelected", // just pure text, no sign

                    effect: "flow", //this is the slide effect (rewind or flow)

                    width: "940px", // this is the width for the content-slider

                    height: "300px", // this is the height for the content-slider

                    duration: 400, // time in milliseconds to transition one slide

                    pause: 5000, //time between transitions

                    prev: ".jFlowPrev", // must be class, use . sign

                    next: ".jFlowNext", // must be class, use . sign

                    auto: true

                });

            });

        </script>

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
                $("#formulario2").validate({
                    rules: {
                        nombre: {required: true, minlength: 2},
                        apellido: {required: true, minlength: 2},
                        documento: {required: true, minlength: 6, maxlength: 12},
                        direccion: {required: true, minlength: 6, maxlength: 100},
                        telefono: {required: true, minlength: 1, maxlength: 15},
                        email: {required: true, email: true},
                        contra: {required: true, minlength: 6, maxlength: 20},
                        acepto: {required: true, acepto: true},
                    },
                    messages: {
                        nombre: "El campo es obligatorio.",
                        apellido: "El campo es obligatorio.",
                        documento: "El campo Documento no contiene un formato correcto.",
                        direccion: "El campo direccion es obligatorio.",
                        telefono: "El campo telefono es obligatorio (si no posee uno, indique 0).",
                        email: "El campo es obligatorio y debe tener formato de email correcto.",
                        contra: "La contraseña es Obligatoria y debe tener un tamaño entre 6-20 caracteres.",
                        acepto: "Debe Aceptar las condiciones de registro.",
                    }
                });
            });</script>
        <script>
            function aMayusculas(obj, id) {
                obj = obj.toUpperCase();
                document.getElementById(id).value = obj;
            }
        </script>
        <script language="JavaScript">

            function habilita() {
                document.formulario2.nit_empresa.disabled = true;
                document.formulario2.valnit.disabled = true;
                document.formulario2.nombre_empresa.disabled = true;
                document.formulario2.cargo.disabled = true;
            }

            function deshabilita() {

                document.formulario2.nit_empresa.disabled = false;
                document.formulario2.valnit.disabled = false;
                document.formulario2.nombre_empresa.disabled = false;
                document.formulario2.cargo.disabled = false;

            }
        </script>
        <script language="javascript">
            function validar() {
                var key = window.event.keyCode;
                if (key < 48 || key > 57) {
                    window.event.keyCode = 0;
                }
            }
        </script>
        <script>
 function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8,37,39,46];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}

        </script>
        <script type="text/javascript">
            $(document).ready(function() {

                // find the elements to be eased and hook the hover event
                $('div.jimgMenu ul li a').hover(function() {

                    // if the element is currently being animated (to a easeOut)...
                    if ($(this).is(':animated')) {
                        $(this).stop().animate({width: "310px"}, {duration: 450, easing: "easeOutQuad"});
                    } else {
                        // ease in quickly
                        $(this).stop().animate({width: "310px"}, {duration: 400, easing: "easeOutQuad"});
                    }
                }, function() {
                    // on hovering out, ease the element out
                    if ($(this).is(':animated')) {
                        $(this).stop().animate({width: "78px"}, {duration: 400, easing: "easeInOutQuad"})
                    } else {
                        // ease out slowly
                        $(this).stop('animated:').animate({width: "78px"}, {duration: 450, easing: "easeInOutQuad"});
                    }
                });
            });
        </script>
    </head>
    <!--//Abrir_ventana('pagina.php'):-->
    <body onload="Abrir_ventana('mensaje.php')">
        <div id="flotante">
            <input type="button" value="X" onclick="cerrar('flotante')"
                   class="boton_verde2"></input> Se recomienda el uso de Google Chrome
            para una correcta visualizaci&oacute;n. Para descargarlo haga clic <a
                href="https://www.google.com/intl/es/chrome/browser/?hl=es"
                target="_blank">aqu&iacute;</a>
        </div>
        <div id="top">
            <div class="total" style="background:url(_img/bck.header.jpg) no-repeat; height:40px;">
                <div class="min_space">&nbsp;</div>
                <script>
                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    var f = new Date();
                    document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                </script>
                <div class="float_right" style="margin-right:20px;">
                    <a href="https://twitter.com/senacomunica" rel="external"><img src="_img/rs.twitter.jpg" alt="SENA en Twiiter" /></a>&nbsp;
                    <a href="http://www.facebook.com/sena.general" rel="external"><img src="_img/rs.facebook.jpg" alt="SENA en Facebook" /></a>&nbsp;
                    <a href="https://plus.google.com/111618152086006296623/posts" rel="external"><img src="_img/rs.googleplus.jpg" alt="SENA en Google+" /></a>&nbsp;
                    <a href="http://pinterest.com/SENAComunica/" rel="external"><img src="_img/rs.pinterest.jpg" alt="SENA en Pinterest" /></a>&nbsp;
                </div>		
            </div>
        </div>
        <div id="header" class="bck_lightgray">
            <div class="total">
                <a href="index.php"><img src="_img/header.jpg"/></a>
                <div class="total" style="background-image:url(_img/bck.header2.jpg); height:3px;"></div>
                <div id="menu">
                    <ul id="nav">
                        <li class="top"><a href="./index.php" class="top_link"><span>Inicio</span></a></li>
                        <li class="top"><a href="./Presentacion/que.php" class="top_link"><span>¿Qué es CCL?</span></a></li>
                        <li class="top"><a href="./Presentacion/principios.php" class="top_link top_link"><span>Principios y Características ECCL</span></a></li>
                        <li class="top"><a href="./Presentacion/normatividad.php" class="top_link top_link"><span>Normatividad </span></a></li>
                        <li class="top"><a href="./Presentacion/instrumentos.php" class="top_link top_link"><span>Catálogo de Instrumentos</span></a></li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Consultar</span></a>
                        <ul class="sub">
                                        <li><a href="./Presentacion/oferta.php">Oferta</a></li>
                                        <li><a href="http://certificados.sena.edu.co" target="blank">Certificados</a></li>
                                        <li><a href="./Presentacion/memorias.php">Documentos</a></li>
                                        <li><a href="./Presentacion/resultados.php">Encuestas</a></li>
                                        <li><a href="./Presentacion/indicadores.php">Indicadores</a></li>
                        </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Atención al Ciudadano</span></a>
                            <ul class="sub">
                                <li><a href="http://sciudadanos.sena.edu.co/SolicitudIndex.aspx" target="blank">PQRSF</a></li>
                                <li><a href="./Presentacion/contacto.php">Contáctenos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="sliderContainer">
            <div id="mySlides">
                <div id="slide1" class="slide"> <img src="imagess/jflow-sample-slide1.jpg" alt="Slide 1 jFlow Plus" />
                    <div class="slideContent">
                        <h3>Certifica tu Competencia Laboral</h3>
                        <p>El SENA te brinda la oportunidad de certificar tus conocimientos y aptitudes aplicados al campo laboral.</p>
                    </div>
                </div>
                <div id="slide2" class="slide"> <img src="imagess/jflow-sample-slide2.jpg" alt="Slide 2 jFlow Plus" />
                    <div class="slideContent">
                        <h3>Certifica tu Competencia Laboral</h3>
                        <p>El SENA te brinda la oportunidad de certificar tus conocimientos y aptitudes aplicados al campo laboral.</p>
                    </div>
                </div>
                <div id="slide3" class="slide"> <img src="imagess/jflow-sample-slide3.jpg" alt="Slide 3 jFlow Plus" />
                    <div class="slideContent">
                        <h3>Certifica tu Competencia Laboral</h3>
                        <p>El SENA te brinda la oportunidad de certificar tus conocimientos y aptitudes aplicados al campo laboral.</p>
                    </div>
                </div>
                <div id="slide4" class="slide"> <img src="imagess/jflow-sample-slide4.jpg" alt="Slide 3 jFlow Plus" />
                    <div class="slideContent">
                        <h3>Certifica tu Competencia Laboral</h3>
                        <p>El SENA te brinda la oportunidad de certificar tus conocimientos y aptitudes aplicados al campo laboral.</p>
                    </div>
                </div>
            </div>
            <div id="myController"> 
                <span class="jFlowControl"></span> 
                <span class="jFlowControl"></span> 
                <span class="jFlowControl"></span> 
                <span class="jFlowControl"></span> 
            </div>
            <div class="jFlowPrev"></div>
            <div class="jFlowNext"></div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div class="triple_space">&nbsp;</div>
        <div class="total" style="height: 680px;">
            <div id="loginContainer">
                <a href="#" id="loginButton"><span>Ingrese</span><em></em></a>
                <div style="clear:both"></div>
                <div id="loginBox">                
                    <form id="loginForm" method="post" action="Sesion/sesionlogin.php" name="form1" onSubmit="return validar()">
                        <fieldset id="body">
                            <fieldset>
                                <label for="user">Usuario</label>
                                <input type="text" name="user" />
                            </fieldset>
                            <fieldset>
                                <label for="pass">Contraseña</label>
                                <input type="password" name="pass"  />
                            </fieldset>
                            <input type="submit" value="Acceder" />
                            <!--<label for="checkbox"><input type="checkbox" id="checkbox" />Remember me</label>-->
                        </fieldset>
                        <!--<span><a href="#">Forgot your password?</a></span>-->
                    </form>
                </div>
            </div>
            <div class="columna"  style="width:780px; ">
                <br><h1><strong>Certificación de Competencias Laborales</strong></h1></br>
                <p align="justify"><br />
                    El Servicio Nacional de Aprendizaje SENA, mediante Decreto 249 de 2004 Articulo 12, es el responsable en Colombia de evaluar y certificar la competencia laboral de los 
                    colombianos; y a través del Decreto 933 de 2003 en su Artículo 19 Certificación de Competencias Laborales, es autorizado para Evaluar y Certificar la competencia 
                    Laboral, y dice textualmente: "El Servicio Nacional de Aprendizaje-SENA regulará, diseñará, normalizará y certificará las competencias laborales”. Este procedimiento 
                    se diseña a través dela Dirección del Sistema Nacional de Formación para el Trabajo DSNFT y se ejecuta en los Centros, tomando como base los esquemas de evaluación y 
                    certificación y  normas de competencia laboral, insumo para que el sector productivo defina e implemente políticas y estrategias para el desarrollo y gestión del 
                    talento humano.<br></br>
                    Colombia adelanta la Evaluación y  Certificación de las Competencias Laborales (ECCL) del talento humano del país, a partir de las normas de competencia laboral 
                    definidas por el sector productivo, mediante las Mesas Sectoriales. El SENA y otros Organismos Certificadores acreditados por el Organismo Nacional de Acreditación - 
                    ONAC, prestan en la actualidad el servicio de certificación de personas. Estos parámetros nacionales, son una herramienta para la valoración de las competencias de los 
                    trabajadores, que incluye la demostración de evidencias de conocimiento, producto y desempeño por parte de los candidatos sin importar cómo ni cuándo éstos se hayan 
                    adquirido. Así mismo, facilitan la medición, mejoramiento de la calidad, productividad de las empresas y de conglomerados de empresas, cadenas productivas, sectores y 
                    regiones.
                </p></div>
            <div class="espacio">&nbsp;</div>
            <br></br>
            <form id="formulario2" method="post" action="Presentacion/registrar_usuario.php" 
                  name="formulario2" onSubmit="return validar()" >


                <table width="200" color="#F57A38" align="right">
                    <th colspan="2">Registrar Nuevo Usuario</th>
                    <tr>
                        <th colspan="2">Si ya se Registró, haga clic en "ingrese" con su usuario y contraseña</th>    
                    </tr>
                    <tr>
                        <td><label>Tipo de Usuario</label></td>
                        <td>
                            <input type="radio" value="9" name="tusu" disabled="disabled" onclick="deshabilita()"></input>Empresario
                            <input type="radio" value="10" name="tusu" checked onclick="habilita()"></input>Aspirante</td>
                    </tr>
                    <tr>
                        <td>Nit de Empresa</td>
                        <td><input name="nit_empresa" disabled="disabled"  id="nit_empresa" maxlength="9" onKeyPress="return validar()" type="text" value="<?php echo $_GET[nit] ?>">
                            </input>
                            <input type="button"  disabled="disabled" id="valnit" value="Validar nit" onkeypress="validar();" class="botones" onClick="window.location = './Presentacion/val_nit.php?nit=' + document.getElementById('nit_empresa').value"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre de  la Empresa</td>
                        <td>
                            <input name="nombre_empresa" disabled="disabled" type="text" readonly value="<?php echo $_GET[empresa] ?>"></input>
                            <?php
                            if ($_GET["empresa"] == 'Empresa no Registrada') {
                                ?>
                                <a href="Presentacion/reg_empresa_gral.php?nit=<?php echo $_GET["nit"] ?>">Registrar empresa</a>
                                <?php
                            } else {
                                ?>
                                Empresa Registrada
                            <?php }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Cargo en la empresa</label></td>
                        <td><input type="text" id="cargo" name="cargo" disabled="disabled" onkeypress="aMayusculas(this.value, this.id)"></input></td>
                    </tr>
                    <tr>
                        <td><label>Nombre(s)</label></td>
                        <td><input type="text" id="nombre" onkeypress="aMayusculas(this.value, this.id)" name="nombre" maxlength="125" /></td>
                    </tr>
                    <tr>
                        <td><label>Primer Apellido</label></td>
                        <td><input type="text" id="apellido" onkeypress="aMayusculas(this.value, this.id)" name="apellido" maxlength="125" /></td>
                    </tr>
                    <tr>
                        <td><label>Segundo Apellido</label></td>
                        <td><input type="text" id="segapellido" onkeypress="aMayusculas(this.value, this.id)" name="segapellido" maxlength="125" /></td>
                    </tr>
                    <tr>
                        <td><label>Tipo Documento</label></td>
                        <td>
                            <Select Name="t_doc" >

                                <?PHP
                                include("./Clase/conectar.php");
                                $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
                                $query2 = ("SELECT * FROM tipo_doc");
                                $statement2 = oci_parse($connection, $query2);
                                oci_execute($statement2);
                                while ($row = oci_fetch_array($statement2, OCI_BOTH)) {
                                    $id_td = $row["ID_TIPO_DOC"];
                                    $doc = $row["DESCRIPCION"];
                                    
                                    if($id_td == 2){
                                        $seleccion = "selected='selected'";
                                    }else{
                                        $seleccion = "";
                                    }

                                    echo "<OPTION value=" . $id_td . " $seleccion >", utf8_encode($doc), "</OPTION>";
                                }
                                ?>

                            </Select>

                        </td>
                    </tr>
                    <tr>
                        <td><label>Documento</label></td>
                        <td><input type="documento" id="documento" name="documento" maxlength="12" /></td>
                    </tr>
                    <tr>
                        <td><label>Dirección Domicilio</label></td>
                        <td><input type="text" id="direccion" name="direccion" maxlength="100" /></td>
                    </tr>
                    <tr>
                        <td><label>telefono</label></td>
                        <td><input type="text" id="telefono" name="telefono" onkeypress="return numeros(event)" maxlength="15" /></td>
                    </tr>
                    <tr>
                        <td><label>Correo Electrónico</label></td>
                        <td><input type="text" id="email" name="email" maxlength="225" /></td>
                    </tr>
                    <tr>
                        <td><label>Contraseña (para ingresar al Sistema)</label></td>
                        <td><input type="password" id="contra" name="contra" maxlength="20" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="#example" class="openModal">Términos y Condiciones</a>
                            <aside id="example" class="modal">
                                <div>
                                    <h2>Términos y Condiciones</h2>
                                    <p>Este aplicativo SECCL y su contenido son de propiedad del SENA.  
                                        Está prohibida su reproducción total o parcial, su traducción, 
                                        inclusión, transmisión, almacenamiento o acceso a través de medios 
                                        analógicos, digitales o de cualquier otro sistema o tecnología 
                                        creada o por crearse, sin autorización previa y escrita del SENA.<br></br>
                                        <strong>Al aceptar los términos y condiciones plasmadas en esta ventana usted se compromete a:</strong><br></br>

                                        • Registrar información verídica, real y confiable relacionada con sus datos personales.</br>
                                        • Registrar  usuario y contraseña el cual será de carácter intransferibles, 
                                        de uso personal y sólo puede ser modificado por el usuario titular.</br>
                                        • Hacer buen uso de la información a que tenga acceso.</br>
                                        • Ser responsable por cualquier actividad que se lleve acabo bajo su registro.</br>
                                        • Ser responsable de la seguridad de su contraseña.</br>
                                        • No abusar, acosar, amenazar o intimidar a otros usuarios del aplicativo ya sea a través 
                                        de los chats, foros, bloggs o cualquier otro espacio de participación. </br>
                                        • No usar ésta página como medio para desarrollar actividades ilegales
                                        o no autorizadas tanto en Colombia, como en cualquier otro país. </br>
                                        • Ser el único responsable por su conducta y por el contenido de 
                                        textos, gráficos, fotos, videos o cualquier otro tipo de información 
                                        de la cual haga uso o incluya en este aplicativo.</br>
                                        • Utilizar la página única y exclusivamente para uso personal. 
                                        Cualquier uso para beneficio corporativo o colectivo esta prohibido. </br>
                                        • Abstenerse de enviar correo electrónico no deseado (SPAM) a otros
                                        Usuarios de esta página, así como también le está prohibido
                                        transmitir virus o cualquier código de naturaleza destructiva. </br>
                                        • Canalizar sus quejas, reclamos y denuncias a través del 
                                        siguiente link <a href="http://sciudadanos.sena.edu.co/SolicitudIndex.aspx">PQRSF SENA</a> <br></br>

                                        <strong>El SENA se compromete a: </strong><br></br>

                                        • Guardar protección de la privacidad de la información personal del Usuario 
                                        obtenida a través de esta página, comprometiéndose a adoptar una política 
                                        de confidencialidad y solo hará uso de la misma para la ejecución de 
                                        la Evaluación y Certificación de Competencias Laborales y requerimientos de entes de control.</br>

                                    </p>
                                    <a href="#close" title="Close">Cerrar</a>
                                </div>
                            </aside></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="checkbox" name="acepto" value="1">Acepto Términos y Condiciones</input></td>
                    </tr>
                </table>
                <center><input type="submit"  value="Registrar"/></center>
            </form>
        </div>
        <div class="space">&nbsp;</div>
        <div class="total"><div class="linea_horizontal">&nbsp;</div></div>
        <div class="space">&nbsp;</div>
        <div class="min_space">&nbsp;</div>
        <div class="total" style="border-top: 2px solid #888;">
            <table align="right">
                <tr class="font14 bold">
                    <td rowspan="2">
                        <a href="http://wsp.presidencia.gov.co" title="Gobierno de Colombia" rel="external"><img src="_img/links/gobierno.jpg" alt="logo Gobierno de Colombia" /></a> &nbsp; 
                    </td>
                    <td>
                        <a href="http://mintrabajo.gov.co/" title="Ministerio de Trabajo" rel="external"><img src="_img/links/mintrabajo.jpg" alt="logo Ministerio de Trabajo" /></a> &nbsp; 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.mintic.gov.co/" title="Ministerio de Tecnologías de la Información y las Comunicaciones" rel="external"><img src="_img/links/mintic.jpg" alt="logo Ministerio de Tecnologías de la Información y las Comunicaciones" /></a>
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
                <a href="#top"><img src="_img/top.gif" alt="Subir" title="Subir" /></a> &nbsp;
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