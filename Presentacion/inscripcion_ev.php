<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
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
                        <li class="top"><a href="../Presentacion/menuevaluador.php" class="top_link"><span>Inicio</span></a>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Ejecución</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/induccion_ev.php">Inducción</a></li>
                                <li><a href="../Presentacion/plan_evidencias_ev.php">Plan Evidencias</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Consulta</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/consultar_p_ev.php">Mi Portafolio</a></li>
                                <li><a href="../Presentacion/misdatos_ev.php">Mis Datos</a></li>
                                <li><a href="../Presentacion/misdatos_c_ev.php">Datos Candidato</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedorcito">
            <?php
            include("../Clase/conectar.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);

            $query4 = ("SELECT documento FROM usuario where usuario_id =  '$id'");
            $statement4 = oci_parse($connection, $query4);
            $resp4 = oci_execute($statement4);
            $doceva = oci_fetch_array($statement4, OCI_BOTH);

            $query3 = ("SELECT id_centro FROM centro_usuario where id_usuario =  '$id'");
            $statement3 = oci_parse($connection, $query3);
            $resp3 = oci_execute($statement3);
            $idc = oci_fetch_array($statement3, OCI_BOTH);

            $query1 = ("SELECT codigo_regional FROM centro where id_centro =  '$idc[0]'");
            $statement1 = oci_parse($connection, $query1);
            $resp1 = oci_execute($statement1);
            $reg = oci_fetch_array($statement1, OCI_BOTH);

            $query2 = ("SELECT codigo_centro FROM centro where id_centro =  '$idc[0]'");
            $statement2 = oci_parse($connection, $query2);
            $resp2 = oci_execute($statement2);
            $cen = oci_fetch_array($statement2, OCI_BOTH);
            ?>


            <center>
                <br>
                <center><?php echo '<font><strong> Proyectos Generados </strong></font>'; ?></center>
                </br>
                <form>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <table id="demotable1" >
                            <thead><tr>
                                    <th>Radicado PROYECTO</th>
                                    <th>Fecha y Hora Elaboración</th>
                                    <th>Empresa</th>
                                    <th>Normas que Atiende el Proyecto</th>
                                    <th>Detalles PROYECTO</th>
                                    <th>Portafolio Inscripción</th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $fecha = date('Y');

                            $q2 = "select unique id_proyecto from evaluador_proyecto where id_evaluador=$doceva[0]";
                            $sta2 = oci_parse($connection, $q2);
                            oci_execute($sta2);
                            $num = 0;
                            while ($row2 = oci_fetch_array($sta2, OCI_BOTH)) {

                                $query = "SELECT ID_PROYECTO,FECHA_ELABORACION,NIT_EMPRESA,ID_PLAN FROM PROYECTO where ID_PROYECTO='$row2[ID_PROYECTO]'";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement);
                                $numero = 0;
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {

                                    $query4 = ("SELECT nombre_empresa FROM empresas_sistema where nit_empresa =  '$row[NIT_EMPRESA]'");
                                    $statement4 = oci_parse($connection, $query4);
                                    $resp4 = oci_execute($statement4);
                                    $empresa = oci_fetch_array($statement4, OCI_BOTH);
                                    
                                    

                                    if ($row["ID_ESTADO_PROYECTO"] == 1) {
                                        echo "<td width=\"15%\"><font face=\"verdana\">" .
                                        $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . "</font></td>";
                                    } else {
                                        echo "<td width=\"15%\"><font face=\"verdana\">" .
                                        $fecha . '-' . $reg[0] . '-' . $cen[0] . '-' . $row["ID_PLAN"] . '-P' . $row["ID_PROYECTO"] . "</font></td>";
                                    }

                                    if ($empresa[0] == null) {

                                        $e = "Demanda Social";
                                    } else {

                                        $e = $empresa[0];
                                    }

                                    echo "<td width=\"20%\"><font face=\"verdana\">" .
                                    $row["FECHA_ELABORACION"] . "</font></td>";
                                    echo "<td width=\"\"><font face=\"verdana\">" .
                                    $e . "</font></td>";

                                    echo "<td width=\"\"><a href=\"./cons_normas_proyecto_c.php?proyecto=" . $row["ID_PROYECTO"] . "\" TARGET=\"_blank\">
                                Consultar</a></td>";
                                    echo "<td width=\"\"><a href=\"./verdetalles_proyecto_c.php?proyecto=" . $row["ID_PROYECTO"] . "\" TARGET=\"_blank\">
                                Consultar</a></td>";
//                                    echo "<td width=\"\"><a href=\"./gen_induccion.php?proyecto=" . $row["ID_PROYECTO"] . "\" TARGET=\"_blank\">
//                                Generar</a></td>";
                                    echo "<td width=\"\"><a href=\"./subir_inscripcion_ev.php?proyecto=" . $row["ID_PROYECTO"] . "\" >
                                Soportes Inscripción</a></td></tr>";


                                    $numero++;
                                }
                                $num++;
                            }

                            oci_close($connection);
                            ?>
                        </table>


                    </center><br></br>
                </form>
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