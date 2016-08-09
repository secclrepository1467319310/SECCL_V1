<?php
require_once('../Clase/class.phpmailer.php');
$mail = new PHPMailer();
//indico a la clase que use SMTP
$mail->IsSMTP();
//permite modo debug para ver mensajes de las cosas que van ocurriendo
$mail->AMTPDwbug = 2;
//Debo de hacer autenticación SMTP
$mail->SMTPAuth = true; //por si necesita auentificación

$mail->SMTPSecure = "ssl";
//indico el servidor de Gmail para SMTP

$mail->Host = "smtp.gmail.com";

//indico el puerto que usa Gmail
$mail->Port = 465;
//tipo de utf
$mail->CharSet = 'UTF-8';

//indico un usuario / clave de un usuario de gmail
$mail->Username = "certicompetencias@gmail.com";
$mail->Password = "Cronaldo7";

$mail->SetFrom('certicompetencias@gmail.com', 'Sistema de Evaluación y Certificación de Competencias Laborales - SECCL');
//$mail­>AddReplyTo("tu_correo_electronico_gmail@gmail.com","Nombre completo");
$mail->Subject = "Nueva Empresa Registrada";
//$mail->MsgHTML("Hola que tal, esto es el cuerpo del mensaje!");
//-------------
$plan = $_GET["plan"];
$nit = $_GET["nit"];
$nombre = $_GET["nombre"];
$sigla = $_GET["sigla"];


$cuerpo ='﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >



    <head>
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />

        <style type="text/css">
            
            ﻿body {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
	background:#fff  no-repeat left top;  
	font: 12px Arial, Helvetica, sans-serif;
	color: #000;
        
}
#contenedor{
    width: 950px;
    margin: auto;
}
#contenedorcito{
    width: 950px;
    margin: auto;
    border-color:blue;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 9pt;
    text-align: center;
}

#centro{
    background-color: gainsboro;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 9pt;
    max-height: 100%;
    border:#999999 solid 1px;
    width: 100%;
}

#ads {
	margin-top: 33px;
	width: 730px;
	height: 90px;
	float:right;
}

.bot_redes {
	float: right;
	height: 26px;
	width: auto;
}

#goog
{
	background-color: #FFFFFF;
	
	height: 30px;
	width: 100%;
	}

#header{
	
	background:#fff url("../images/bg.gif") repeat-x left top;
	
	height: 170px;
	width: 100%;
}
#header_contenedor{
	width: 1002px !important;
	width: 1016px;
	margin: 0 auto;
	padding: 20px 0 0 0;
}
#logo 
{
	width: 240px;
	height: 170px;
	float: left;
        color: #FFF;
        font-size: 15pt;
}
#menu {
	height:26px;
	width: 1002px !important;
	width: 1016px;
	background:url("../images/menu_bck.jpg") no-repeat;
	margin-bottom: 30px;
}


.total {
	width: 1002px !important;
	width: 1016px;
	margin: 0 auto;
}

#footer_links {
	height: auto;
	width: 100%;
	margin: 10px auto;
	padding-bottom: 20px;
}

.center {	text-align:center;	}

#footer_info {
	background-color: #999;
	height: auto;
	width: 100%;
	margin: 10px 0;
	padding: 10px 0;
	font-size: 10px;
}


#detalle_productividad, #detalle_transferencia, #detalle_inclusion, #detalle_gris, #detallegt_productividad, #detallegt_transferencia, #detallegt_inclusion, #detallegt_gris, #detallegt_resol1, #detallegt_resol2 {
	float: left;
	height: 4px;
	width: 336px;
	margin-bottom:10px;
	background-color: #FFF;
	background-image: url("../images/detalle_transferencia.jpg");
}
#detalle_transferencia {
	background-image: url("../images/detalle_transferencia.jpg");
}

#detallegt_transferencia {
	width: 676px;
	background-image: url("../images/detalle_transferencia.jpg");
}

.font9 {	font-size: 9px;		}
.font10 {	font-size: 10px;	}
.font11 {	font-size: 11px;	}
.font12 {	font-size: 12px;	}
.font13 {	font-size: 13px;	}
.font14 {	font-size: 14px;	}
.font16 {	font-size: 16px;	}
.font18 {	font-size: 18px;	}
.font20 {	font-size: 20px;	}
.font22 {	font-size: 22px;	}
.font26 {	font-size: 26px;	}

.margen_lados {	margin: 0 10px;	}


.der {
	float: right;
	width: 318px;
}

#detallegt_resol1 {
	width: 676px;
	background-image: url("../images/detalle_productividad.jpg");
}

#detallegt_resol2 {
	width: 676px;
	background-image: url("../images/detalle_gris.jpg");
}
#formulario { font:11px arial; width:300px; float: left;}
#formulario2 { font:11px arial; width:300px; float: left;}

#nav {
	padding:0;
	margin:0;
	list-style:none;
	height:36px;
	z-index:500;
	font-family:arial, verdana, sans-serif;
	z-index:500;
	float: left;
	width: 860px;
}
#nav li.top {display:block; float:left;}
#nav li a.top_link {display:block; float:left; height:36px; line-height:27px; color:#fff; text-decoration:none; font-size:11px; font-weight:bold; padding:0 0 0 12px; cursor:pointer;background: url(../images/blank.gif);}
#nav li a.top_linkd {display:block; float:left; height:36px; line-height:27px; color:#fff; text-decoration:none; font-size:11px; font-weight:bold; padding:0 0 0 12px; cursor:pointer;background: url(../images/blank.gif);}
#nav li a.top_linke {display:block; float:left; height:36px; line-height:27px; color:#fff; text-decoration:none; font-size:11px; font-weight:bold; padding:0 0 0 12px; cursor:pointer;background: url(../images/blank.gif);}
#nav li a.top_link span {float:left; display:block; padding:0 24px 0 12px; height:36px;background:url(../images/blank.gif) right top;}
#nav li a.top_linkd span {float:left; display:block; padding:0 24px 0 12px; height:36px;background:url(../images/blank.gif) right top;}
#nav li a.top_linke span {float:left; display:block; padding:0 24px 0 12px; height:36px;background:url(../images/blank.gif) right top;}
#nav li a.top_link span.down {float:left; display:block; padding:0 24px 0 12px; height:36px; background:url(../images/blank.gif) no-repeat right top;}
#nav li a.top_linkd span.down {float:left; display:block; padding:0 24px 0 12px; height:36px; background:url(../images/blank.gif) no-repeat right top;}
#nav li a.top_linke span.down {float:left; display:block; padding:0 24px 0 12px; height:36px; background:url(../images/blank.gif) no-repeat right top;}
#nav li a.top_link:hover {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li a.top_linkd:hover {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li a.top_linke:hover {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li a.top_link:hover span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li a.top_linkd:hover span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li a.top_linke:hover span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li a.top_link:hover span.down {background:url(../images/blank_overa.gif) no-repeat right top;}
#nav li a.top_linkd:hover span.down {background:url(../images/blank_overa.gif) no-repeat right top;}
#nav li a.top_linke:hover span.down {background:url(../images/blank_overa.gif) no-repeat right top;}

#nav li:hover > a.top_link {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li:hover > a.top_linkd {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li:hover > a.top_linke {color:#fff; background: url(../images/blank_over.gif) no-repeat;}
#nav li:hover > a.top_link span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li:hover > a.top_linkd span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li:hover > a.top_linke span {background:url(../images/blank_over.gif) no-repeat right top;}
#nav li:hover > a.top_link span.down {background:url(../images/blank_overa.gif) no-repeat right top;}
#nav li:hover > a.top_linkd span.down {background:url(../images/blank_overa.gif) no-repeat right top;}
#nav li:hover > a.top_linke span.down {background:url(../images/blank_overa.gif) no-repeat right top;}

/* Default list styling */

#nav li:hover {position:relative; z-index:200;}


#nav ul, 
#nav li:hover ul ul,
#nav li:hover ul li:hover ul ul,
#nav li:hover ul li:hover ul li:hover ul ul,
#nav li:hover ul li:hover ul li:hover ul li:hover ul ul
{position:absolute; left:-9999px; top:-9999px; width:0; height:0; margin:0; padding:0; list-style:none;}

#nav li:hover ul.sub
{left:0; top:31px; background: #fff; padding:3px; border:1px solid #258176; white-space:nowrap; width:90px; height:auto; z-index:300;}
#nav li:hover ul.sub li
{display:block; height:20px; position:relative; float:left; width:90px; font-weight:normal;}
#nav li:hover ul.sub li a
{display:block; font-size:11px; height:20px; width:90px; line-height:20px; text-indent:5px; color:#000; text-decoration:none;}
#nav li ul.sub li a.fly
{background:#fff url(../images/arrow.gif) 80px 7px no-repeat;}
#nav li:hover ul.sub li a:hover 
{background:#238276; color:#fff;}
#nav li:hover ul.sub li a.fly:hover
{background:#238276 url(../images/arrow_over.gif) 80px 7px no-repeat; color:#fff;}

#nav li:hover ul li:hover > a.fly {background:#3a93d2 url(../images/arrow_over.gif) 80px 7px no-repeat; color:#fff;} 

#nav li:hover ul li:hover ul,
#nav li:hover ul li:hover ul li:hover ul,
#nav li:hover ul li:hover ul li:hover ul li:hover ul,
#nav li:hover ul li:hover ul li:hover ul li:hover ul li:hover ul
{left:90px; top:-4px; background: #fff; padding:3px; border:1px solid #3a93d2; white-space:nowrap; width:90px; z-index:400; height:auto;}


        </style>

    </head>
    <body>

        <div id="">
            <br></br>
            <img src="../images/logos/sena.jpg" align="left" ></img>
            <strong>SISTEMA DE EVALUACIÓN Y CERTIFICACIÓN DE COMPETENCIAS LABORALES - SECCL</strong><br></br>
            <strong> Registro de Empresa</strong><br></br>
            <br></br>
             

            <br></br>

        </div>

            <!-- CONTINUA -->
            <center><strong>NOTA: Este es un correo automático, por favor no responder.</strong></center>
            <div class="total margen" style="margin-top:10px; height: 50px;">
                <div class="izq">
                    <div class="cuadro">

                        <div id="detallegt_transferencia">&nbsp;</div>

                        <div class="der" style="height: 180px">    
                            <div class="margen_lados">

                            </div>

                        </div>
                        <div class="font18 jade bold margen_lados verdana"><img src="../images/transferencia.jpg" alt="Certificado Digital" /> Registro de Empresa</div>

                        <div class="font14 margen" style="margin-right:10px;">
                            <br />
                            <br>
                            <strong>Señor(a) Asesor, se ha registrado la siguiente empresa:</strong>
                            </br>
                            <strong>Nombre :</strong>'.$nombre.'<br>
                            <strong>Nit :</strong> '.$nit.' <br></br>
                            <strong>El SECCL solicita su colaboración para que a través del  siguiente link xxxxxx y 
                            diligencie la “Ficha de Empresa” con la totalidad de datos que esta demande, 
                            con el fin de contar con información completa, fiable y segura de nuestros clientes.</strong>
                            <br></br>
                        </div>

                    </div>

                    <!-- aqui empiezo -->
                    <!-- fin -->
                </div>




            </div> <!-- fin de total margen -->

            <div style="clear:both; "></div>


            <!-- pie de pagina -->
            <div class="total right">

            </div>
            <div id="footer_info" class="center">
                <p>.:: Servicio Nacional de Aprendizaje SENA – Dirección General Calle 57 No. 8-69, Bogotá D.C - PBX (57 1) 5461500<br />
                    Línea gratuita de atención al ciudadano Bogotá 5925555 – Resto del país 018000 910270<br />
                    Horario de atención: lunes a viernes de 8:00 am a 5:30 pm<br />
                    Todos los derechos reservados © 2012 ::.
                    <br />
                    <br />
                </p>

            </div>

            <div style="clear:both; "></div>

            <div id="footer_links" class="center">
                <a href="http://www.sena.edu.co" title="Portal SENA" target="_blank"><img src="../images/logos/sena.jpg" width="77" height="58" alt="logo SENA" border="0" /></a> &nbsp; 
                <a href="http://wsp.presidencia.gov.co" title="Presidencia de la Rep&uacute;blica" target="_blank"><img src="../images/logos/presidencia.jpg" width="167" height="58" alt="logo Presidencia de la Rep&uacute;blica" border="0" /></a> &nbsp; 
                <a href="http://www.gobiernoenlinea.gov.co" title="Gobierno en l&iacute;nea" target="_blank"><img src="../images/logos/gel.jpg" width="121" height="58" alt="logo Gobierno en l&iacute;nea" border="0"/></a> &nbsp; 
                <a href="http://www.mintrabajo.gov.co" title="Ministerio del Trabajo" target="_blank"><img src="../images/logos/mintrabajo.jpg" width="114" height="58" alt="logo Ministerio del Trabajo" border="0"/></a> &nbsp;  
                <a href="http://www.sigob.gov.co" title="SIGOB" target="_blank"><img src="../images/logos/sigob.jpg" width="102" height="58" alt="logo SIGOB" border="0"/></a>
            </div>
            <div id="footer_ads" class="center">
                    <!-- <img src="http://periodico.sena.edu.co/_img/footer_ads.png" width="1050" height="30" /> -->
            </div>


    </body>
</html>
'; 

$mail->MsgHTML($cuerpo);


//----------
//indico destinatario
$address = "dhahmad@sena.edu.co";
$mail->AddAddress($address, "$address");
if(!$mail->Send()) {
echo "Error al enviar: " . $mail->ErrorInfo;
} else {
echo "Mensaje enviado!";
}
?>
<script type="text/javascript">
    window.location = "../Presentacion/asociar_ncl.php?sigla=<?php echo $sigla  ?>&empresa=<?php echo $nombre ?>&nit=<?php echo $nit?>&plan=<?php echo $plan?>";
</script>