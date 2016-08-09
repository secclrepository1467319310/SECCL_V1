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
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />


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
            function aMayusculas(obj, id) {
                obj = obj.toUpperCase();
                document.getElementById(id).value = obj;
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
                <a href="../index.php"><img src="../_img/header.jpg"/></a>
                <div class="total" style="background-image:url(../_img/bck.header2.jpg); height:3px;"></div>
                <div id="menu">
                    <ul id="nav">
                        <li class="top"><a href="../index.php" class="top_link"><span>Inicio</span></a></li>
                        <li class="top"><a href="./que.php" class="top_link"><span>¿Qué es CCL?</span></a></li>
                        <li class="top"><a href="./principios.php" class="top_link top_link"><span>Principios y Características ECCL</span></a></li>
                        <li class="top"><a href="./normatividad.php" class="top_link top_link"><span>Normatividad </span></a></li>
                        <li class="top"><a href="./instrumentos.php" class="top_link top_link"><span>Catálogo de Instrumentos</span></a></li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Consultar</span></a>
                            <ul class="sub">
                                <li><a href="./oferta.php">Oferta</a></li>
                                <li><a href="http://certificados.sena.edu.co" target="blank">Certificados</a></li>
                                <li><a href="./memorias.php">Documentos</a></li>
                            </ul>
                        </li>
                        <li class="top"><a href="#" class="top_link top_link"><span>Atención al Ciudadano</span></a>
                            <ul class="sub">
                                <li><a href="http://sciudadanos.sena.edu.co/SolicitudIndex.aspx" target="blank">PQRSF</a></li>
                                <li><a href="./contacto.php">Contáctenos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div></div>
        </div>
        <div class="triple_space">&nbsp;</div>
        <div id="contenedor" style="height:600px;width:1050px;overflow:scroll;">

            <br>
            <?php
            include("../Clase/conectar.php");
            include("../Clase/Norma.php");
            $connection = conectar($bd_host, $bd_usuario, $bd_pwd);
            $ob = New Norma();
            ?>
            <center>
                <br>
                <strong>
                    <?php
                    //
                    $qFechaCorteInstrumentos = "SELECT * FROM MENSAJE WHERE DIRIGIDO_A='F_CORTE_INSTRUMENTOS' AND ESTADO='1' ";
                    $sFechaCorteInstrumentos = oci_parse($connection, $qFechaCorteInstrumentos);
                    oci_execute($sFechaCorteInstrumentos);
                    $rFechaCorteInstrumentos = oci_fetch_array($sFechaCorteInstrumentos, OCI_ASSOC);
                    echo $rFechaCorteInstrumentos[TEXTO];
                    ?>

                </strong>
                </br>
                <form>
                    <br>
                    <a id="cleanfilters" href="#">Limpiar Filtros</a>
                    <br></br>
                    <center>
                        <table id="demotable1" >
                            <thead><tr>
                                    <th><strong>Mesa Sectorial</strong></th>
                                    <th><strong>Código NCL</strong></th>
                                    <th><strong>Versión</strong></th>
                                    <th><strong>Título</strong></th>
                                    <th><strong>Expiración</strong></th>
                                    <th><strong>Disponibilidad Instrumentos</strong></th>
                                    <th><strong>Alerta</strong></th>
                                </tr></thead>
                            <tbody>
                            </tbody>

                            <?php
                            $query2 = "SELECT
                                                    ME.NOMBRE_MESA,
                                                    NR.CODIGO_MESA,
                                                    NR.VERSION_NORMA,
                                                    NR.TITULO_NORMA,
                                                    NR.CODIGO_NORMA,
                                                    TO_CHAR (NR.EXPIRACION_NORMA, 'dd/mm/yyyy') as expiracion_norma,
                                                    MONTHS_BETWEEN(TO_DATE(NR.EXPIRACION_NORMA,'dd/mm/yyyy'),TO_DATE(sysdate,'DD/MM/YYYY')) AS MESES,
                                                    observaciones
                                                    FROM INSTRUMENTOS INS LEFT JOIN NORMA NR 
                                                    ON INS.ID_NORMA = NR.CODIGO_NORMA AND INS.VRS = NR.VERSION_NORMA AND nr.activa='1'
                                                    LEFT JOIN MESA ME 
                                                    ON NR.CODIGO_MESA = ME.CODIGO_MESA";
                            $statement2 = oci_parse($connection, $query2);
                            oci_execute($statement2);

                            $numero = 0;
                            while ($row2 = oci_fetch_array($statement2, OCI_BOTH)) {


                                echo "<tr><td width=\"3%\"><font face=\"verdana\"><center>" .
                                utf8_encode($row2["NOMBRE_MESA"]) . "</center></font></td>";
                                echo "<td width=\"3%\"><font face=\"verdana\"><center>" .
                                $row2["CODIGO_NORMA"] . "</center></font></td>";
                                echo "<td width=\"1%\"><font face=\"verdana\"><center>" .
                                $row2["VERSION_NORMA"] . "</center></font></td>";
                                echo "<td width=\"25%\"><font face=\"verdana\"><center>" .
                                utf8_encode($row2["TITULO_NORMA"]) . "</center></font></td>";
                                echo "<td width=\"2%\"><font face=\"verdana\"><center>" .
                                $row2["EXPIRACION_NORMA"] . "</center></font></td>";
                                echo "<td width=\"2%\"><font face=\"verdana\"><center>" .
                                $row2["OBSERVACIONES"] . "</center></font></td>";

                                if ($row2["MESES"] > 3) {
                                    echo "<td width=\"10%\" ><center><img src=\"../images/verde.png\" width=\"20\" height=\"20\"  ><center> NCL Disponible </img></center></td></tr>";
                                } else if ($row["MESES"] <= 3) {
                                    echo "<td width=\"10%\" ><center><img src=\"../images/roja.png\" width=\"20\" height=\"20\" > NCL Próxima a Vencer </img></center></td></tr>";
                                }

                                $numero++;
                            }

                            oci_close($connection);
                            ?>
                        </table>
                    </center>
                </form>
        </div>
        <div class="espacio">&nbsp;</div>
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