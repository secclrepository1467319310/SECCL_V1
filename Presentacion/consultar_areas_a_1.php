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
        <link rel="stylesheet" type="text/css" href="../css/tab.css" />
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
                        <li class="top"><a href="../Presentacion/menuasesor.php" class="top_link"><span>Inicio</span></a>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Planeación</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/cons_areas_n.php">Áreas Claves</a></li>
                                <li><a href="../Presentacion/registrar_poa_n.php">Mi Programación</a></li>
                                <li><a href="../Presentacion/ver_poa_n.php">Programacion Nal</a></li>
                                <li><a href="../Presentacion/ver_poa_c_n.php">Programación Cen</a></li>
                                <li><a href="../Presentacion/verproyectos_n.php">Proyectos Nal</a></li>
                                <li><a href="../Presentacion/verproyectos_c_n.php">Proyectos Cen</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Empresas</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/ficha_empresa_n.php">Registrar</a></li>
                                <li><a href="../Presentacion/ver_empresa_n.php">Consultar</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link"><span class="down">Evaluador</span></a>
                            <ul class="sub">
                                <li><a href="../Presentacion/cons_proyecto_n.php">Consultar</a></li>
                            </ul>
                        </li>
                        <li class="top">
                            <a class="top_link" href="#">
                                <span>Reportes</span>
                            </a>
                            <ul class="sub" style="width: 165px">
                                <li>
                                    <a target="_blank" href="../Presentacion/reporteregionales_ins_cert.php">Inscritos y Certificados Regional</a>
                                </li>
                            </ul>
                        </li>
                        <li class="top">
                            <a class="top_link" href="#">
                                <span>Áreas Claves</span>
                            </a>
                            <ul class="sub" style="width: 165px">
                                <li>
                                    <a target="_blank" href="../Presentacion/cons_areas_a.php">Aprobación</a>
                                </li>
                            </ul>
                        </li>
                        <li class="top"><a href="../Logout.php" class="top_link"><span>Salir</span></a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <?php
        include("../Clase/conectar.php");
        $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
        $centro = $_GET['centro'];
        $periodo = $_GET['periodo'];
        
        $query7 = ("SELECT ID_AREA_CLAVE FROM AREAS_CLAVES WHERE CODIGO_CENTRO='$centro'");
        $statement7 = oci_parse($connection, $query7);
        $resp7 = oci_execute($statement7);
        $idarea = oci_fetch_array($statement7, OCI_BOTH);
        
        $queryCentro = "SELECT * FROM CENTRO CEN "
                . "INNER JOIN REGIONAL REG "
                . "ON CEN.CODIGO_REGIONAL = REG.CODIGO_REGIONAL "
                . "WHERE CODIGO_CENTRO='$centro'";
        $statementCentro = oci_parse($connection, $queryCentro);
        oci_execute($statementCentro);
        $centro = oci_fetch_array($statementCentro, OCI_BOTH);
        ?>
        <div> 
            <center>
                <strong>ÁREAS CLAVES <?php echo $periodo ?> <br> 
                    <?php echo utf8_encode($centro['CODIGO_CENTRO'] . " - " . $centro['NOMBRE_CENTRO']) ?><br>
                    <?php echo utf8_encode($centro['CODIGO_REGIONAL'] . " - " . $centro['NOMBRE_REGIONAL']) ?>
                </strong>
            </center>
            <center>
                <form>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <a href="cons_areas_a.php"><strong>Volver</strong></a>
                        <table id="demotable1" style="width:1000px">
                            <thead><tr>
                                    <th style="width:2%"><strong>Id</strong></th>
                                    <th style="width:2%"><strong>Código Mesa</strong></th>
                                    <th style="width:10%"><strong>Nombre Mesa</strong></th>
                                    <th style="width:10%"><strong>Estado</strong></th>
                                    <th style="width:60%"><strong>Observaciones Asesor</strong></th>
                                    <th style="width:8%"><strong>Editar Aprobación</strong></th>
                                    <th style="width:8%"><strong>Normas</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $query2 = "select
                                    id_areas_centro,
                                    id_mesa,
                                    nombre_mesa,
                                    aprobado_asesor,
                                    obs_misional,
                                    obs_asesor
                                    from areas_claves_centro ac
                                    inner join mesa m
                                    on ac.id_mesa=m.codigo_mesa
                                    where ac.id_area_clave='$idarea[0]' and periodo = $periodo";

                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);

                            $num = 0;
                            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {

                                if ($row2["APROBADO_ASESOR"] == 0) {
                                    $estado = "No Aprobado";
                                } else if ($row2["APROBADO_ASESOR"] == 1) {
                                    $estado = "Aprobado";
                                } else if ($row2["APROBADO_ASESOR"] == 2) {
                                    $estado = "Transitoriamente Aprobado";
                                } else {
                                    $estado = "Por Aprobar";
                                }
                                ?>

                                <tr>
                                    <td>
                                        <center> 
                                            <?php echo $row2["ID_AREAS_CENTRO"] ?> 
                                        </center>
                                    </td>
                                    <td>
                                        <center> 
                                            <?php echo $row2["ID_MESA"] ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo utf8_encode($row2["NOMBRE_MESA"]) ?> 
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $estado ?>
                                        </center>
                                    </td>
                                    <td>
                                        <textarea readonly  style="resize:none; width:99%; height: 70px"><?php echo $row2[OBS_ASESOR] ?></textarea>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="aprobar_area_a.php?id_area_centro=<?php echo $row2[ID_AREAS_CENTRO] ?>"><img src="../images/editar.png" alt="20" width="20"></a>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a href="asociar_normas_centro_a.php?id_area_centro=<?php echo $row2[ID_AREAS_CENTRO] ?>">Consultar</a>
                                        </center>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
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