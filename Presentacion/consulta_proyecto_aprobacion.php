<?php
session_start();
if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
$id_proyecto = $_GET['proyecto'];
$queryProyecto = ("SELECT PT.ID_ESTADO_PROYECTO, PT.ID_PROYECTO, PT.FECHA_ELABORACION, RG.NOMBRE_REGIONAL, RG.CODIGO_REGIONAL, CE.CODIGO_CENTRO, CE.NOMBRE_CENTRO FROM PROYECTO PT INNER JOIN REGIONAL RG ON PT.ID_REGIONAL = RG.CODIGO_REGIONAL INNER JOIN CENTRO CE ON PT.ID_CENTRO = CE.CODIGO_CENTRO WHERE ID_PROYECTO='$id_proyecto'");
$statementProyecto = oci_parse($connection, $queryProyecto);
oci_execute($statementProyecto);
$proyecto = oci_fetch_array($statementProyecto, OCI_BOTH);
?>
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
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />
    </head>
    <body>
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
        <div id="contenedorcito" >
            <div class="space">&nbsp;</div>
            <div class="space">&nbsp;</div>
            <form style="text-align: left" method="GET" action="consulta_proyecto_aprobacion.php">
                <fieldset> 
                    <legend>
                        Buscar proyecto
                    </legend>

                    Codigo Proyecto: <input type="text" id="proyecto" name="proyecto" />
                    <input type="submit" value="Buscar">
                </fieldset>
            </form>
            <br><br>
            <?php if ($proyecto) { ?>
                <table>
                    <tr>
                        <th>
                            Id Proyecto
                        </th>
                        <td>
                            <?php echo $proyecto['ID_PROYECTO'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Fecha Elaboración Proyecto
                        </th>
                        <td>
                            <?php echo $proyecto['FECHA_ELABORACION'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Regional
                        </th>
                        <td>
                            <?php echo utf8_encode($proyecto['NOMBRE_REGIONAL']) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Codigo Regional
                        </th>
                        <td>
                            <?php echo $proyecto['CODIGO_REGIONAL'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Codigo Centro
                        </th>
                        <td>
                            <?php echo $proyecto['CODIGO_CENTRO'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Centro
                        </th>
                        <td>
                            <?php echo utf8_encode($proyecto['NOMBRE_CENTRO']) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Estado
                        </th>
                        <td>
                            <?php echo $proyecto['ID_ESTADO_PROYECTO'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Cambiar Estado
                        </th>
                        <td>
                            <form method="POST" action="guardar_estado_proyecto.php">
                                <input type="hidden" name="proyecto" id="proyecto" value="<?php echo $proyecto['ID_PROYECTO'] ?>" /> 
                                <input type="submit" value="Cambiar" />
                            </form>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </div>

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