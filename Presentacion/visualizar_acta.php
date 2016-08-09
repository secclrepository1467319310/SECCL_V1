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
extract($_GET);
extract($_POST);

$query = "SELECT * FROM T_ACTA WHERE T_ID_ACTA = $id_acta";
$statement = oci_parse($connection, $query);
oci_execute($statement);
$row = oci_fetch_array($statement, OCI_BOTH);
$fecha = $row['FECHA'];
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="../jquery/jquery.validate.js" type="text/javascript"></script>
        <script src="actas.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {


                // Initialise Plugin
                var options1 = {
                    clearFiltersControls: [$('#cleanfilters')],
                    matchingRow: function(state, tr, textTokens) {
                        if (!state || !state.id) {
                            return true;
                        }
                        var val = tr.children('td:eq(2)').text();
                        switch (state.id) {
                            case 'onlyyes':
                                return state.value !== 'true' || val === 'yes';
                            case 'onlyno':
                                return state.value !== 'true' || val === 'no';
                            default:
                                return true;
                        }
                    }
                };

                $('#demotable1').tableFilter(options1);

                var grid2 = $('#demotable2');
                var options2 = {
                    filteringRows: function(filterStates) {
                        grid2.addClass('filtering');
                    },
                    filteredRows: function(filterStates) {
                        grid2.removeClass('filtering');
                        setRowCountOnGrid2();
                    }
                };
                function setRowCountOnGrid2() {
                    var rowcount = grid2.find('tbody tr:not(:hidden)').length;
                    $('#rowcount').text('(Rows ' + rowcount + ')');
                }

                grid2.tableFilter(options2); // No additional filters			
                setRowCountOnGrid2();
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
                <div id="menu">
                    <ul id="nav">
                        <li class="top"><a href="../Presentacion/menumisional.php" class="top_link"><span>Inicio</span></a>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Indicadores</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/indicadores_areas_claves.php">Áreas Claves</a></li>
                                <li><a href="../Presentacion/indicadores_metas.php">Metas Centros</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <center>
                <?php if ($mensaje == 1) { ?>
                    <div class="mensaje">La actualización se realizo correctamente</div>
                <?php } ?>
                <input type="hidden" name="opcion" value="2">
                <input type="hidden" name="id_acta" value="<?php echo $id_acta ?>">
                <table>
                    <tr>
                        <th colspan="4">
                            ACTA No. <?php echo $id_acta ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">
                            NOMBRE DEL COMITÉ O DE LA REUNIÓN
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <?php echo $row['NOMBRE'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            FECHA
                        </th>
                        <th>
                            CIUDAD:
                        </th>
                        <th>
                            HORA DE INICIO:
                        </th>
                        <th>
                            HORA FIN:
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $fecha ?>
                        </td>
                        <td>
                            <?php echo $row['CIUDAD'] ?>
                        </td>
                        <td>
                            <?php
                            echo $row['HORA_INICIO']
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $row['HORA_FIN']
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>

                        </th>
                        <th colspan="3">
                            DIRECCIÓN GENERAL / REGIONAL / CENTRO
                        </th>
                    </tr>
                    <tr>
                        <td>
                            LUGAR:
                        </td>
                        <td colspan="3">
                            <?php echo $row['LUGAR'] ?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            TEMAS:
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <textarea disabled="disabled" style="width: 99%; " name="temas" id="temas" cols="85"><?php echo $row['TEMA'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            OBJETIVOS DE LA REUNIÓN:
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <textarea style="width: 99%; " name="objetivos" id="objetivos" disabled="disabled"><?php echo $row['OBJETIVO'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            DESARROLLO DE LA REUNIÓN:
                        </th>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <textarea name="desarrollo" style="width: 99%; " id="desarrollo" disabled="disabled"><?php echo $row['DESARROLLO'] ?></textarea><br><br>
                            <table style="width: 100%; font-size: 10px;">
                                <tr>
                                    <th>
                                        CENTRO
                                    </th>
                                    <th>
                                        MESA
                                    </th>
                                </tr>
                                <?php
                                $queryAreas = "SELECT * FROM T_AREAS_CLAVES_ACTAS INNER JOIN AREAS_CLAVES_CENTRO ON T_AREAS_CLAVES_ACTAS.ID_AREA_CENTRO = AREAS_CLAVES_CENTRO.ID_AREAS_CENTRO "
                                        . "INNER JOIN AREAS_CLAVES ON AREAS_CLAVES_CENTRO.ID_AREA_CLAVE = AREAS_CLAVES.ID_AREA_CLAVE "
                                        . "INNER JOIN MESA ON AREAS_CLAVES_CENTRO.ID_MESA = MESA.CODIGO_MESA "
                                        . "INNER JOIN CENTRO ON AREAS_CLAVES.CODIGO_CENTRO = CENTRO.CODIGO_CENTRO "
                                        . "WHERE T_AREAS_CLAVES_ACTAS.ID_ACTA = $id_acta AND AREAS_CLAVES_CENTRO.PERIODO = 2016 ORDER BY NOMBRE_CENTRO ASC";
                                $statementAreas = oci_parse($connection, $queryAreas);
                                oci_execute($statementAreas);
                                $i = 1;
                                while ($areas = oci_fetch_array($statementAreas, OCI_BOTH)) {
                                    if ($i == 1) {
                                        echo "<strong> AREAS CLAVE ASOCIADAS </strong><br><br>";
                                    }
                                    ?>
                                    <?php
                                    echo "<tr> <td>" . utf8_encode($areas['NOMBRE_CENTRO'] . " </td><td> " . $areas['NOMBRE_MESA']) . "</td></tr>";
                                    ?>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="4">
                            CONCLUSIONES
                        </th>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <textarea style="width: 99%; " name="concluciones" id="concluciones" cols="85" disabled="disabled"><?php echo $row['CONCLUSIONES'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="4">
                            COMPROMISOS
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            ACTIVIDAD
                        </th>
                        <th>
                            RESPONSABLE
                        </th>
                        <th>
                            FECHA
                        </th>
                        
                    </tr>
                    <?php
                    $queryCompromisos = ("SELECT * FROM T_COMPROMISOS_ACTA WHERE ID_ACTA = $id_acta");
                    $statementCompromisos = oci_parse($connection, $queryCompromisos);
                    oci_execute($statementCompromisos);
                    while ($compromisos = oci_fetch_array($statementCompromisos, OCI_BOTH)) {
                        ?>
                        <tr class="contenedorCompromisos">
                            <td colspan="2">
                                <input type="text" name="actividad[]" value="<?php echo $compromisos['ACTIVIDAD'] ?>" style="width: 99%; ">
                            </td>
                            <td>
                                <input type="text" name="responsable[]" value="<?php echo $compromisos['RESPONSABLE'] ?>" style="width: 99%; ">
                            </td>
                            <td>
                                <?php
                                echo $compromisos['FECHA_COMPROMISO'];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="4">
                            ASISTENTES
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">
                            NOMBRE
                        </th>
                        <th colspan="2">
                            CARGO/DEPENDENCIA/ENTIDAD
                        </th>
                    </tr>
                    <?php
                    $queryAsistentes = ("SELECT * FROM T_ASISTENTE_ACTA WHERE ID_ACTA = $id_acta");
                    $statementAsistentes = oci_parse($connection, $queryAsistentes);
                    oci_execute($statementAsistentes);
                    while ($asistentes = oci_fetch_array($statementAsistentes, OCI_BOTH)) {
                        ?>
                        <tr class="contenedorAsistentes">
                            <td colspan="2">
                                <?php echo $asistentes['NOMBRE'] ?>
                            </td>
                            <td colspan="2">
                                <?php echo $asistentes['CARGO'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="4">
                            INVITADOS (Opcional)
                        </th>
                    </tr>
                    <tr>
                        <th>
                            NOMBRE
                        </th>
                        <th>
                            CARGO
                        </th>
                        <th colspan="2">
                            ENTIDAD
                        </th>
                    </tr>
                    <?php
                    $queryInvitados = ("SELECT * FROM T_INVITADOS_ACTA WHERE ID_ACTA = $id_acta");
                    $statementInvitados = oci_parse($connection, $queryInvitados);
                    oci_execute($statementInvitados);
                    while ($invitados = oci_fetch_array($statementInvitados, OCI_BOTH)) {
                        ?>
                        <tr class="contenedorInvitados">
                            <td>
                                <input type="text" name="nombre_invitado[]" value="<?php echo $invitados['NOMBRE'] ?>" style="width: 99%; "/>
                            </td>
                            <td>
                                <input type="text" name="cargo_invitado[]" value="<?php echo $invitados['CARGO'] ?>" style="width: 99%; "/>
                            </td>   
                            <td colspan="2">
                                <input type="text" name="entidad_invitado[]" value="<?php echo $invitados['ENTIDAD'] ?>" style="width: 99%; "/>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </center>
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

